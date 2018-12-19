/**
 *
 * @file webpack.development.js
 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 */

const merge  = require('webpack-merge');
const common = require('./webpack.common.js');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = merge(
	common,
	{
		output: {
			filename: '[name].js'
		},
		mode: 'development',
		devtool: false,
		watch: true,
		module: {
			rules: [{
				test: /\.scss$/,
				exclude: /node_modules/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							sourceMap: true
						}
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true
						}
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true
						}
					}
				]
			}],
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: 'main.css'
			}),
		]
	},
);
