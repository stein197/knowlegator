<?php
namespace Tests\Unit;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\TestCase;
use Tests\TestDOM;

final class TestDOMTest extends TestCase {

	private TestDOM $testDom;

	protected function setUp(): void {
		$this->testDom = $this->dom(<<<'HTML'
			<html lang="en" data-bs-theme="dark">
				<head>
					<meta />
					<meta />
					<title>Title</title>
				</head>
				<body>
					<div class="list">
						<p>Depth 1</p>
						<div class="list">
							<p> Depth 2</p>
							<div class="list">
								<p>Depth 3</p>
							</div>
						</div>
					</div>
					<a href="/link-1"></a>
				</body>
			</html>
		HTML);
	}

	public function testAssertExistsShouldPassWhenElementsExist(): void {
		$this->testDom->assertExists('//title');
		$this->testDom->assertExists('//body//div');
	}

	public function testAssertExistsShouldFailWhenElementsDoNotExist(): void {
		$this->expectException(ExpectationFailedException::class);
		$this->expectExceptionMessage('No elements matching the XPath \'//element\'');
		$this->testDom->assertExists('//element');
	}

	public function testAssertNotExistsShouldPassWhenElementsDoNotExist(): void {
		$this->testDom->assertNotExists('//element');
	}

	public function testAssertNotExistsShouldFailWhenElemenetsExist(): void {
		$this->expectException(ExpectationFailedException::class);
		$this->testDom->assertNotExists('//div');
	}

	public function testAssertTextContextShouldPassWhenRegexIsProvidedAndMatches(): void {
		$this->testDom->assertTextContent('/Depth/', true);
	}

	public function testAssertTextContextShouldPassWhenRegexIsNotProvidedAndMatches(): void {
		$this->markTestSkipped();
	}

	public function testAssertTextContextShouldFailWhenRegexIsProvidedAndDoesNotMatch(): void {
		$this->expectException(AssertionFailedError::class);
		$this->testDom->assertTextContent('/text/', true);
	}

	public function testAssertTextContextShouldFailWhenRegexIsNotProvidedAndDoesNotMatch(): void {
		$this->expectException(AssertionFailedError::class);
		$this->testDom->assertTextContent('Depth');
	}

	public function testAssertExistsShouldPassAfterFindWhenElementsExist(): void {
		$this->testDom->find('//body/*[@class="list"]')->assertExists('//*[@class="list"]');
	}

	public function testAssertNotExistsShouldPassAfterFindWhenElementDoNotExist(): void {
		$this->testDom->find('//body/*[@class]')->assertNotExists('//element');
	}

	public function testAssertTextContextShouldPassAfterFindWhenElementExist(): void {
		$this->testDom->find('//p')->assertTextContent('Depth 1');
		$this->testDom->find('//p')->assertTextContent('/Depth/', true);
	}

	public function testAssertExistsShouldFailAfterFindWhenElementsDoNotExist(): void {
		$this->expectException(ExpectationFailedException::class);
		$this->testDom->find('//span')->assertExists('//div');
	}

	public function testAssertNotExistsShouldFailAfterFindWhenElementExist(): void {
		$this->expectException(ExpectationFailedException::class);
		$this->testDom->find('//div')->assertNotExists('//p');
	}

	public function testAssertTextContextShouldFailAfterFindWhenElementDoNotExist(): void {
		$this->expectException(AssertionFailedError::class);
		$this->testDom->find('//span')->assertTextContent('Depth N');
	}

	public function testAssertLinkExists(): void {
		$this->testDom->assertLinkExists('/link-1');
	}

	public function testAssertAmountFailsWhenAmountDoesntMatch(): void {
		$this->expectException(AssertionFailedError::class);
		$this->expectExceptionMessage('Expected XPath //head/meta to select 1 elements, actual elements: 2');
		$this->testDom->find('//head/meta')->assertAmount(1);
	}

	public function testAssertAmountPassesWhenAmountMatches(): void {
		$this->testDom->find('//head/meta')->assertAmount(2);
	}
}
