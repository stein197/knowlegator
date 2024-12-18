const path = require("node:path");
const mix = require("laravel-mix");

mix.ts(
	path.resolve(__dirname, "resources/js/index.ts"),
	path.resolve(__dirname, "public/index.min.js")
);
