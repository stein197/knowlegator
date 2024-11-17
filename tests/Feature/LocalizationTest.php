<?php
namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use Tests\TestCase;
use function array_push;
use function is_dir;
use function is_file;
use function file_get_contents;
use function scandir;
use const DIRECTORY_SEPARATOR;

final class LocalizationTest extends TestCase {

	public function testBladeTemplatesShouldUseExistingTranslations(): void {
		$paths = self::listDirectory(resource_path('views'));
		foreach ($paths as $path) {
			$blade = Blade::compileString(file_get_contents($path));
			$calls = self::findFuncCalls($blade);
			foreach ($calls as $fCall) {
				$translation = $fCall->args[0]->value;
				if (!$translation instanceof String_)
					continue;
				$this->assertLocalizationExists($translation->value, "Translation key \"{$translation->value}\" doesn't exist in file {$path}");
			}
		}
	}

	public function testPhpCodeShouldUseExistingTranslations(): void {
		$paths = self::listDirectory(base_path('app'));
		foreach ($paths as $path) {
			$calls = self::findFuncCalls(file_get_contents($path));
			foreach ($calls as $fCall) {
				$translation = $fCall->args[0]->value;
				if (!$translation instanceof String_)
					continue;
				$this->assertLocalizationExists($translation->value, "Translation key \"{$translation->value}\" doesn't exist in file {$path}");
			}
		}
	}

	/**
	 * @param string $dir
	 * @return string[]
	 */
	private static function listDirectory(string $dir): array {
		$result = [];
		foreach (scandir($dir) as $fName) {
			if ($fName === '.' || $fName === '..')
				continue;
			$path = $dir . DIRECTORY_SEPARATOR . $fName;
			if (is_dir($path))
				array_push($result, ...self::listDirectory($path));
			elseif (is_file($path))
				$result[] = $path;
		}
		return $result;
	}

	/**
	 * @param string $code
	 * @return FuncCall[]
	 */
	private static function findFuncCalls(string $code): array {
		$result = [];
		$parser = (new ParserFactory())->createForNewestSupportedVersion();
		$ast = $parser->parse($code);
		$trav = new NodeTraverser();
		$trav->addVisitor(new class ($result) extends NodeVisitorAbstract {
			public function __construct(private array &$result) {}
			public function enterNode(Node $node): void {
				if ($node instanceof FuncCall && $node->name->name === '__')
					$this->result[] = $node;
			}
		});
		$trav->traverse($ast);
		return $result;
	}
}
