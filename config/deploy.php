<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default deployment strategy
    |--------------------------------------------------------------------------
    |
    | This option defines which deployment strategy to use by default on all
    | of your hosts. Laravel Deployer provides some strategies out-of-box
    | for you to choose from explained in detail in the documentation.
    |
    | Supported: 'basic', 'firstdeploy', 'local', 'pull'.
    |
    */

    'default' => 'circleci',

    /*
    |--------------------------------------------------------------------------
    | Custom deployment strategies
    |--------------------------------------------------------------------------
    |
    | Here, you can easily set up new custom strategies as a list of tasks.
    | Any key of this array are supported in the `default` option above.
    | Any key matching Laravel Deployer's strategies overrides them.
    |
    */

    'strategies' => [
        'circleci' => [
            'hook:start',
            'deploy:prepare',
            'deploy:lock',
            'deploy:release',
            'upload',
            'deploy:shared',
            'deploy:writable',
            'hook:ready',
            'deploy:symlink',
            'deploy:unlock',
            'cleanup',
            'hook:done',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Hooks
    |--------------------------------------------------------------------------
    |
    | Hooks let you customize your deployments conveniently by pushing tasks
    | into strategic places of your deployment flow. Each of the official
    | strategies invoke hooks in different ways to implement their logic.
    |
    */

    'hooks' => [
        // Right before we start deploying.
        'start' => [
            //
        ],

        // Code and composer vendors are ready but nothing is built.
        'build' => [
            //
        ],

        // Deployment is done but not live yet (before symlink)
        'ready' => [
            'artisan:storage:link',
            // 'app:permissions',
            'artisan:responsecache:clear',
            'artisan:view:clear',
            'artisan:cache:clear',
            'artisan:config:cache',
        ],

        // Deployment is done and live
        'done' => [
            //
        ],

        // Deployment succeeded.
        'success' => [
            //
        ],

        // Deployment failed.
        'fail' => [
            //
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deployment options
    |--------------------------------------------------------------------------
    |
    | Options follow a simple key/value structure and are used within tasks
    | to make them more configurable and reusable. You can use options to
    | configure existing tasks or to use within your own custom tasks.
    |
    */

    'options' => [
        'application' => env('APP_NAME', 'Laravel'),
        'http_user' => 'www-data',
        'app_user' => 'deploy',
        'upload_vendors' => true,
        'upload_options' => [
            'options' => [
                '--exclude=.babelrc',
                '--exclude=.circleci/',
                '--exclude=.editorconfig',
                '--exclude=.env.dusk.local.example',
                '--exclude=.env.dusk.testing',
                '--exclude=.env.example.docker',
                '--exclude=.env.example',
                '--exclude=.env.testing',
                '--exclude=.eslintrc.js',
                '--exclude=.git/',
                '--exclude=.gitattributes',
                '--exclude=.gitignore',
                '--exclude=.styleci.yml',
                '--exclude=.stylelintrc',
                '--exclude=composer.json',
                '--exclude=composer.lock',
                '--exclude=docker-compose.yml',
                '--exclude=docker-sync.yml',
                '--exclude=docs',
                '--exclude=LaravelREADME.md',
                '--exclude=Makefile',
                '--exclude=node_modules/',
                '--exclude=package-lock.json',
                '--exclude=package.json',
                '--exclude=patches',
                '--exclude=phpcs.xml',
                '--exclude=phpunit.xml',
                '--exclude=postcss.config.js',
                '--exclude=README.md',
                '--exclude=server.php',
                '--exclude=storage/',
                '--exclude=tests/',
                '--exclude=traefik.yml',
                '--exclude=webpack.mix.js',
            ],
        ],
        'upload_path' => __DIR__ . '/..',
    ],

    /*
    |--------------------------------------------------------------------------
    | Hosts
    |--------------------------------------------------------------------------
    |
    | Here, you can define any domain or subdomain you want to deploy to.
    | You can provide them with roles and stages to filter them during
    | deployment. Read more about how to configure them in the docs.
    |
    */

    'hosts' => [
        'your-hosts' => [
            'deploy_path' => '/var/www/your-path',
            'user' => 'deploy',
            'stage' => 'production'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Localhost
    |--------------------------------------------------------------------------
    |
    | This localhost option give you the ability to deploy directly on your
    | local machine, without needing any SSH connection. You can use the
    | same configurations used by hosts to configure your localhost.
    |
    */

    'localhost' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Include additional Deployer recipes
    |--------------------------------------------------------------------------
    |
    | Here, you can add any third party recipes to provide additional tasks,
    | options and strategies. Therefore, it also allows you to create and
    | include your own recipes to define more complex deployment flows.
    |
    */

    'include' => [
        'recipe/tasks.php',
    ],

    /*
    |--------------------------------------------------------------------------
    | Use a custom Deployer file
    |--------------------------------------------------------------------------
    |
    | If you know what you are doing and want to take complete control over
    | Deployer's file, you can provide its path here. Note that, without
    | this configuration file, the root's deployer file will be used.
    |
    */

    'custom_deployer_file' => false,

];
