<?php
namespace Tests\Feature\Providers;

describe('@null', function (): void {
	test('@null ... @endnull when null', function (): void {
		/** @var \Tests\TestCase $this */
		$view = $this->blade('@null(null) IS NULL @endnull');
		$view->assertSee('IS NULL');
	});

	test('@null ... @endnull when not null', function (): void {
		/** @var \Tests\TestCase $this */
		$view = $this->blade('@null(true) IS NULL @endnull');
		$view->assertDontSee('IS NULL');
	});

	test('@null ... @else ... @endnull when null', function (): void {
		/** @var \Tests\TestCase $this */
		$view = $this->blade('@null(null) IS NULL @elsenull IS NOT NULL @endnull');
		$view->assertSee('IS NULL');
		$view->assertDontSee('IS NOT NULL');
	});

	test('@null ... @else ... @endnull when not null', function (): void {
		/** @var \Tests\TestCase $this */
		$view = $this->blade('@null(true) IS NULL @else IS NOT NULL @endnull');
		$view->assertSee('IS NOT NULL');
		$view->assertDontSee('IS NULL');
	});
});
