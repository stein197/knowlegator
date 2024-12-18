import $ from "jquery";
import {Tooltip} from "bootstrap";

$((): void => {
	$("[data-bs-toggle=\"tooltip\"]").each((...[, tooltip]) => void new Tooltip(tooltip));
	$<HTMLFormElement>("form.needs-validation").each((...[, form]): void => {
		form.addEventListener("submit", event => {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();
			}
			form.classList.add("was-validated");
		});
	});
});
