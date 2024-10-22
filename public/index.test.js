document.addEventListener("DOMContentLoaded", () => {
	const module = QUnit.module;
	const test = QUnit.test;
	const assert = QUnit.assert;

	module('Simple test', () => {
		test('test', () => {
			assert.equal(1, 1)
		});
	});
});
