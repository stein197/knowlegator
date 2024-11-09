document.addEventListener("DOMContentLoaded", () => {
	// Tooltips
	[...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(tooltip => new bootstrap.Tooltip(tooltip));
});
