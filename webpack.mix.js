const mix = require('laravel-mix');
const StyleLintPlugin = require('stylelint-webpack-plugin');
require('laravel-mix-transpile-node-modules');

const dev = !mix.inProduction();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.copy('resources/images/static', 'public/images', false);
mix.copy('resources/images/favicons', 'public/icons', false);

mix.webpackConfig({
  node: { fs: 'empty' },
  plugins: [
    new StyleLintPlugin({
      files: '**/*.pcss',
      context: 'resources/css',
      configFile: '.stylelintrc',
      formatter: require('stylelint').formatters.verbose,
      lintDirtyModulesOnly: true,
      quiet: true,
    }),
  ],
});

mix.js('resources/js/app.js', 'public/js');
mix.postCss('resources/css/app.pcss', 'public/css', [
  require('autoprefixer'),
  require('postcss-import'),
  require('postcss-nested'),
  require('postcss-color-function'),
  require('postcss-hexrgba'),
  require('postcss-custom-properties'),
  require('postcss-pxtorem')({
    rootValue: 16,
  }),
]);

if (dev) {
  mix.sourceMaps();
  mix.options({
    hmrOptions: {
      host: 'localhost',
      port: 8082,
      compress: true,
    },
  });
}

if (!dev) {
  mix.transpileNodeModules(['bootstrap-vue', 'vue-flickity', 'quick-score', 'vuetensils']);
  // Breaks tranpilation for IE11 for some reason...
  // mix.version();
}

if (process.env.NODE_ENV !== 'test') {
  mix.extract();
}

// Full API
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.override(function (webpackConfig) {}) <-- Will be triggered once the webpack config object has been fully generated by Mix.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
