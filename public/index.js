document.addEventListener("DOMContentLoaded", () => {
	// Tooltips
	$("[data-bs-toggle=\"tooltip\"]").each((i, tooltip) => new bootstrap.Tooltip(tooltip));

	// Form validations
	$("form.needs-validation").each((i, form) => {
		form.addEventListener("submit", event => {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			}
			form.classList.add("was-validated");
		});
	});
});
