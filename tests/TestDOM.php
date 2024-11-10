<?php
namespace Tests;

use DOMDocument;
use DOMNode;
use DOMXPath;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\GeneratorNotSupportedException;
use function array_map;
use function array_reduce;
use function preg_match;

// TODO: assertLength()
// TODO: assertNotTextContent()
/**
 * Provide means to test DOM structure.
 * @package Tests
 */
final readonly class TestDOM {

	private array $nodes;

	public function __construct(
		/** @var string[] */
		private array $source,
		private TestCase $testCase
	) {
		$nodes = [];
		foreach ($source as $src) {
			$domDocument = new DOMDocument();
			$domDocument->recover = true;
			$domDocument->strictErrorChecking = false;
			@$domDocument->loadHTML($src);
			$nodes[] = [
				'document' => $domDocument,
				'xpath' => new DOMXPath($domDocument)
			];
		}
		$this->nodes = $nodes;
	}

	/**
	 * Assert that at least one element exists by the given XPath.
	 * @param string $xpath XPath to test against.
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws GeneratorNotSupportedException
	 * ```php
	 * $this->assertExists('//body'); // Pass
	 * ```
	 */
	public function assertExists(string $xpath): void {
		$this->find($xpath)->assertNotEmpty();
	}

	/**
	 * Assert that no elements match the given XPath.
	 * @param string $xpath XPath to test against.
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws GeneratorNotSupportedException
	 * ```php
	 * $this->assertNotExists('//unknown-element'); Pass
	 * ```
	 */
	public function assertNotExists(string $xpath): void {
		$this->find($xpath)->assertEmpty();
	}

	/**
	 * Assert that there is at least one link with the given href attribute.
	 * @param string $link Link that the link should have.
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws GeneratorNotSupportedException
	 */
	public function assertLinkExists(string $link): void {
		$this->assertExists("//a[@href = \"{$link}\"]");
	}

	/**
	 * Assert that the given document is empty.
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws GeneratorNotSupportedException
	 */
	public function assertEmpty(): void {
		$this->testCase->assertEmpty($this->nodes);
	}

	/**
	 * Assert that the given document is not empty.
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws GeneratorNotSupportedException
	 */
	public function assertNotEmpty(): void {
		$this->testCase->assertNotEmpty($this->nodes);
	}

	/**
	 * Assert that at least one root-level element contains the given string.
	 * @param string $content String or RegExp to test against.
	 * @param bool $regex `true` if the given string is a regular expression.
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws AssertionFailedError
	 */
	public function assertTextContent(string $content, bool $regex = false): void {
		/** @var DOMDocument $document */
		foreach ($this->nodes as ['document' => $document]) {
			if ($regex && preg_match($content, $document->textContent)) {
				$this->testCase->assertMatchesRegularExpression($content, $document->textContent);
				return;
			}
			if (!$regex && $document->textContent === $content) {
				$this->testCase->assertSame($content, $document->textContent);
				return;
			}
		}
		$this->testCase->fail("No elements contain text '$content'");
	}

	/**
	 * Find a set of elements by the given XPath.
	 * @param string $xpath XPath to find elements by.
	 * @return static
	 */
	public function find(string $xpath): static {
		return new static(
			array_reduce(
				$this->nodes,
				fn (array $carry, array $n) => [
					...$carry,
					...array_map(
						fn (DOMNode $node): string => $n['document']->saveHTML($node),
						[...$n['xpath']->query($xpath)]
					)
				],
				[]
			),
			$this->testCase
		);
	}
}
