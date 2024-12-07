document.addEventListener("DOMContentLoaded", () => {
	// Tooltips
	[...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(tooltip => new bootstrap.Tooltip(tooltip));

	// Form validations
	[...document.querySelectorAll("form.needs-validation")].forEach(form => {
		form.addEventListener("submit", event => {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			}
			form.classList.add("was-validated");
		});
	});
});
