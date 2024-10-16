import React from "react";
import ReactClient from "react-dom/client";
import App from "app/view/App";

document.addEventListener("DOMContentLoaded", () => {
	const main = document.querySelector("main")!;
	const root = ReactClient.createRoot(main);
	root.render(React.createElement(App));
});
