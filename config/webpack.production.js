/**
 *
 * @file webpack.production.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */

const glob = require('glob');
const path = require('path');

const merge  = require('webpack-merge');
const common = require('./webpack.common.js');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CompressionPlugin = require('compression-webpack-plugin');
const PurgecssPlugin = require('purgecss-webpack-plugin');

module.exports = merge(
	common,
	{
		output: {
			filename: 'js/[name].[chunkhash:8].js'
		},
		mode: 'production',
		devtool: false,
		watch: false,
		module: {
			rules: [{
				test: /\.scss$/,
				exclude: /node_modules/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							publicPath: '../'
						}
					},
					{
						loader: 'css-loader',
						options: {
							sourceMap: false
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: false
						}
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: false
						}
					}
				]
			}],
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: 'css/main.[chunkhash:8].css'
			}),
			new CompressionPlugin(),
			new PurgecssPlugin({
				paths: glob.sync(path.join(__dirname, '..', 'views/**/*.html.twig')),
				whitelist: [
					'Archive',
					'Front-page',
					'Single-residence',
					'Single',
					'Jobs-page',
					'is-disabled',
					'is-off',
					'is-focus',
					'is-current',
					'is-selected',
					'is-loading',
					'menu--is-open',
					'Unsolicited-application--is-open',
					'Apply--is-open',
					'Alert--success',
					'ajax-loader',
					'Facebook',
					'page-template-default',
					'error404',
					'iframe',
			   		'object',
			   		'embed'
				],
				whitelistPatternsChildren: [/^leaflet-/, /^wp-block-/, /^flickity-/, /^wpcf7-/, /^Socials/, /^slick/]
			}),
		]
	},
);