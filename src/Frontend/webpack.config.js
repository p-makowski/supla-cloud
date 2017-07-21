const path = require('path');
const webpack = require('webpack');
const glob = require('glob');

const entries = {
    'direct-links': './src/direct-links/direct-links.js',
    'iodevice-details': './src/iodevice-details/iodevice-details.js',
    'login-page': './src/login/login-page.js',
    'schedule-form': './src/schedules/schedule-form/schedule-form.js',
    'schedule-list': './src/schedules/schedule-list/schedule-list.js',
    'user-account': './src/user-account/user-account.js',
    'commons': './src/common.js',
};

glob.sync('../SuplaBundle/Resources/translations/messages.*.yml').forEach(translation => {
    const basename = path.basename(translation, '.yml').replace('.', '-');
    entries[`translations/${basename}`] = 'expose-loader?SUPLA_TRANSLATIONS!json-loader!yaml-loader!' + translation;
});

module.exports = {
    entry: entries,
    output: {
        path: path.resolve(__dirname, '../../web/assets/dist'),
        publicPath: '/assets/dist/',
        filename: process.env.NODE_ENV === 'production' ? '[name].[chunkhash].js' : '[name].js'
    },
    plugins: [
        new webpack.optimize.CommonsChunkPlugin({
            filename: process.env.NODE_ENV === 'production' ? '[name].[chunkhash].js' : '[name].js',
            name: "commons"
        }),
        new webpack.ContextReplacementPlugin(/moment[\/\\]locale$/, /pl|ru|de/),
    ],
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    postcss: [require('autoprefixer')],
                    loaders: {
                        'scss': 'vue-style-loader!css-loader!sass-loader',
                    }
                }
            },
            {
                test: /\.css$/,
                loader: "style-loader!css-loader"
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]?[hash]'
                }
            }
        ]
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.common.js',
            'vuex$': 'vuex/dist/vuex.js',
            'jquery': 'jquery/dist/jquery',
            'moment-timezone': 'moment-timezone/builds/moment-timezone-with-data-2012-2022',
        }
    },
    devServer: {
        historyApiFallback: true,
        noInfo: true,
        port: 25787,
        headers: {
            "Access-Control-Allow-Origin": "*",
            "Access-Control-Allow-Methods": "GET, POST, PUT, DELETE, PATCH, OPTIONS",
            "Access-Control-Allow-Headers": "X-Requested-With, content-type, Authorization"
        }
    },
    performance: {
        hints: false
    },
    devtool: '#eval-source-map'
}

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#hidden-source-map'
    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"production"'
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: true,
            compress: {
                warnings: false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true
        }),
        function () {
            // https://webpack.github.io/docs/long-term-caching.html#get-filenames-from-stats
            this.plugin("done", function (stats) {
                var hashes = stats.toJson().assetsByChunkName;
                var phpConfig = "# Config generated automatically by running composer run-script webpack\n\nsupla:\n";
                phpConfig += '  version: ' + (require('./package.json').version) + "\n";
                phpConfig += '  webpack_hashes:\n';
                for (var chunkName in hashes) {
                    phpConfig += `    ${chunkName}: "${hashes[chunkName][0]}"\n`;
                }
                require("fs").writeFileSync(
                    path.join(__dirname, "../../app/config", "config_build.yml"),
                    phpConfig);
            });
        }
    ]);
}
