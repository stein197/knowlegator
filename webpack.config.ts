import path from "path";
import TSConfigPathsWebpackPlugin from "tsconfig-paths-webpack-plugin";

export default {
	entry: {
		index: path.resolve(__dirname, "resources", "js", "index.ts")
	},
	output: {
		filename: "[name].js",
		path: path.resolve(__dirname, "public")
	},
	devtool: "source-map",
	resolve: {
		extensions: [
			".ts",
			".tsx",
			".js"
		],
		modules: [
			path.resolve(__dirname, "node_modules"),
			path.resolve(__dirname, "resources", "js", "src")
		],
		plugins: [
			new TSConfigPathsWebpackPlugin()
		]
	},
	module: {
		rules: [
			{
				test: /\.tsx?$/,
				use: [
					{
						loader: "ts-loader",
					}
				],
				exclude: /node_modules/,
				resolve: {
					fullySpecified: false
				},
			}
		]
	}
};