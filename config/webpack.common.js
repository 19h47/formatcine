/**
 *
 * @file webpack.common.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

// Node modules
const path = require('path');

// Plugins
const CleanWebpackPlugin = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');
const WebpackNotifierPlugin = require('webpack-notifier');

module.exports = {
	devServer: {
		contentBase: path.resolve(__dirname, '../dist'),
		compress: true,
		port: 9000,
		inline: true,
	},
	resolve: {
		alias: {
			'@': path.join(__dirname, '../src'),

			// js
			Blocks: path.join(__dirname, '../src/blocks'),
			Common: path.join(__dirname, '../src/common'),
			Pages: path.join(__dirname, '../src/pages'),
			Transitions: path.join(__dirname, '../src/transitions'),
			Utils: path.join(__dirname, '../src/utils'),

			// img
			png: path.join(__dirname, '../src/img/png'),
			jpg: path.join(__dirname, '../src/img/jpg'),
			svg: path.join(__dirname, '../src/img/svg'),

			// videos
			videos: path.join(__dirname, '../src/videos'),

			// icons
			icons: path.join(__dirname, '../src/icons'),

			// stylesheets
			stylesheets: path.join(__dirname, '../src/stylesheets')
		}
	},
	module: {
		rules: [{
			enforce: 'pre',
			test: /\.js$/,
			exclude: /node_modules/,
			loader: 'eslint-loader'
		},
		{
			test: /\.js$/,
			exclude: /node_modules/,
			loader: 'babel-loader'
		},
		{
			test: /\.(woff2?|eot|ttf|otf|woff|svg)?$/,
			exclude: [/img/, /icons/],
			use: [{
				loader: 'file-loader',
				options: {
					name: '[name].[ext]',
					outputPath: 'fonts'
				},

			}]
		},
		{
			test: /\.svg$/,
			exclude: [/img/, /fonts/],
			use: [{
				loader: 'svg-sprite-loader',
				options: {
					spriteFilename: 'icons.svg',
					extract: true
				}
			},
			'svg-transform-loader',
			'svgo-loader'
		]},
		{
			test: /\.svg$/,
			exclude: [/fonts/, /icons/],
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/svg'
				}
			},
			{
				loader: 'svgo-loader',
				options: {
					plugins: [{
						removeTitle: true
					},
					{
						convertColors: {
							shorthex: false
						}
					},
					{
						convertPathData: false
					}]
				}
			}]
		},
		{
			test: /\.(gif|png|jpe?g)$/i,
			use: [{
				loader: 'file-loader',
				options: {
					outputPath: 'img/',
					name: '[ext]/[hash].[ext]'
				}
			},
			{
				loader: 'image-webpack-loader',
				options: {
					mozjpeg: {
						progressive: true,
						quality: 65
					},
					optipng: {
						enabled: false
					},
					pngquant: {
						quality: '65-90',
						speed: 4
					},
					gifsicle: {
						interlaced: false
					}
				}
			}]
		}]
	},
	plugins: [
		new CleanWebpackPlugin(['dist']),
		new CopyWebpackPlugin([{
			from: path.resolve(__dirname, '../src/favicons' ),
			to: 'favicons'
	   }]),

		new ManifestPlugin(),

		new SpriteLoaderPlugin({ plainSprite: true }),

		new WebpackNotifierPlugin({
			title: 'Webpack',
			excludeWarnings: true,
			alwaysNotify: true
		}),
	],
};
