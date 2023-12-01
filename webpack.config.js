const Encore = require('@symfony/webpack-encore'),
    path = require('path'),
    webpack = require('webpack'),
    { VuetifyPlugin } = require('webpack-plugin-vuetify');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')

    .addEntry('app', './resources/app.ts')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableIntegrityHashes(Encore.isProduction())

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .enableTypeScriptLoader()
    .enableVueLoader(() => {}, {
        runtimeCompilerBuild: false,
        version: 3,
    })
    .enablePostCssLoader((config) => {
        config.postcssOptions = { config: './postcss.config.ts' };
    })

    .addPlugin(new VuetifyPlugin({ autoImport: true }))
    .addPlugin(
        new webpack.DefinePlugin({
            __VUE_PROD_DEVTOOLS__: false,
            __VUE_OPTIONS_API__: true,
        }),
    )

    .addAliases({
        '@': path.resolve(__dirname, 'resources'),
    });

module.exports = Encore.getWebpackConfig();
