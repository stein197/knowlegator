document.addEventListener("DOMContentLoaded", () => {
	const {module, test, assert} = QUnit;
	configure();

	when('/', () => {
		module('Module 1', () => {
			test('Test 1.1', () => {
				assert.equal(1, 1);
			});
			test('Test 1.2', () => {
				assert.equal(1, 1);
			});
		});
		module('Module 2', () => {
			test('Test 2.1', () => {
				assert.equal(1, 1);
			});
			test('Test 2.2', () => {
				assert.equal(1, 1);
			});
		});
		module('Module 3', () => {
			test('Test 3.1', () => {
				assert.equal(1, 1);
			});
			test('Test 3.2', () => {
				assert.equal(1, 1);
			});
		});
	});

	/**
	 * @param {string} url
	 * @param {() => void} f
	 */
	function when(url, f) {
		if (url === '/')
			return f();
		const urlArray = url.split("/");
		const pathArray = location.pathname.split("/");
		if (urlArray.length !== pathArray.length)
			return;
		for (const i in pathArray) {
			const urlItem = urlArray[i];
			const pathItem = pathArray[i];
			if (urlItem !== pathItem && urlItem !== "*")
				return;
		}
		f();
	}

	/**
	 * @returns {void}
	 */
	function configure() {
		QUnit.config = $.extend(QUnit.config, {
			failOnZeroTests: false,
			reporters: {
				console: true,
				html: false
			}
		});
		const result = [];
		QUnit.log(assertion => {
			let module = result.find(m => m.name === assertion.module);
			if (!module) {
				module = {
					name: assertion.module,
					tests: [],
				};
				result.push(module);
			}
			let test = module.tests.find(t => t.name === assertion.name);
			if (!test) {
				test = {
					name: assertion.name,
					assertions: []
				};
				module.tests.push(test);
			}
			test.assertions.push(assertion);
		});
		QUnit.done(() => {
			let totalFailedTests = 0;
			let totalPassedTests = 0;
			let totalFailedAssertions = 0;
			let totalPassedAssertions = 0;
			for (const module of result) {
				const countFailedTests = module.tests.filter(t => t.assertions.filter(a => !a.result).length > 0).length;
				const countPassedTests = module.tests.filter(t => t.assertions.filter(a => !a.result).length === 0).length;
				totalFailedTests += countFailedTests;
				totalPassedTests += countPassedTests;
				const groupMsg = countFailedTests
					? [`%c\u{2716} %c[QUnit]: %c${module.name} (${countPassedTests} / ${countPassedTests + countFailedTests})`, "color: red", "color: #992094", "color: reset"]
					: [`%c\u{2714} %c[QUnit]: %c${module.name} (${countPassedTests} / ${countPassedTests + countFailedTests})`, "color: green", "color: #992094", "color: reset"];
				console.group(...groupMsg);
				for (const test of module.tests) {
					const countFailedAssertions = test.assertions.filter(a => !a.result).length;
					const countPassedAssertions = test.assertions.filter(a => a.result).length;
					totalFailedAssertions += countFailedAssertions;
					totalPassedAssertions += countPassedAssertions;
					const msg = countFailedAssertions
						? [`%c\u{2716} %c${test.name} (${countPassedAssertions} / ${countPassedAssertions + countFailedAssertions})`, "color: red", "color: reset"]
						: [`%c\u{2714} %c${test.name} (${countPassedAssertions} / ${countPassedAssertions + countFailedAssertions})`, "color: green", "color: reset"];
					console.log(...msg);
					test.assertions.forEach(a => !a.result && console.log(`%cexpected: ${JSON.stringify(a.expected)}, actual: ${JSON.stringify(a.actual)} ${a.source}`, "color: red"));
				}
				console.groupEnd();
			}
			console.log(`%c${totalFailedTests ? "\u{2716}" : "\u{2714}"} %c[QUnit]: %ctests: ${totalPassedTests} / ${totalPassedTests + totalFailedTests}, assertions: ${totalPassedAssertions} / ${totalPassedAssertions + totalFailedAssertions}`, `color: ${totalFailedTests ? "red" : "green"}`, "color: #992094", "color: reset");
		});
	}
});
