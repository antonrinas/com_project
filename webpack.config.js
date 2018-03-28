var path = require('path');
var webpack = require('webpack');
var ExtractTextPlugin = require("extract-text-webpack-plugin");

module.exports = {
    entry: './resources/js/app.js', 
    output: {
        path: path.resolve(__dirname, './public/application'),
        publicPath: '/application/',
        filename: 'build.js'
    },
    //watch: true,
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                }
            },
            {
                test:/\.vue$/,
                loader:'vue-loader',
                options: {
                    loaders: {
                        css: ExtractTextPlugin.extract({
                            use: 'css-loader',
                            fallback: 'vue-style-loader' // <- это внутренняя часть vue-loader, поэтому нет необходимости его устанавливать через NPM
                        })
                    },
                }
            },
            {
                // см. https://stackoverflow.com/questions/33058964/configure-webpack-to-output-images-fonts-in-a-separate-subfolders
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: 'images/[name].[ext]?[hash]'
                }
            },
        ]
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.js',
        }
    },
	plugins: [
        new webpack.ProvidePlugin({
           $: "jquery/dist/jquery.js",
           jQuery: "jquery/dist/jquery.js",
		   'window.jQuery': 'jquery/dist/jquery.js',
			Popper: ['popper.js', 'default'],
            axios: "axios/dist/axios.js",
            _: "lodash/lodash.js"
		}),
        new ExtractTextPlugin("css/style.css"),
    ]
};

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#source-map'
    module.exports.resolve = {
        alias: {
            vue: 'vue/dist/vue.min.js',
        }
    };
    module.exports.plugins = [
        new webpack.ProvidePlugin({
            $: "jquery/dist/jquery.min.js",
            jQuery: "jquery/dist/jquery.min.js",
            'window.jQuery': 'jquery/dist/jquery.min.js',
            Popper: ['popper.js', 'default'],
            axios: "axios/dist/axios.min.js",
            _: "lodash/lodash.min.js"
        }),
        new ExtractTextPlugin("css/style.css"),
    ];
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
                warnings: false,
                drop_console: true,
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true
        })
    ])
}