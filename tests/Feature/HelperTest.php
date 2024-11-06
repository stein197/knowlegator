<?php
namespace Tests\Unit;

use function classname;
use function singularize;

describe('lroute()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$app->setLocale('en');
		$this->assertSame('/en/settings/password', lroute('settings.password'));
		$app->setLocale('de');
		$this->assertSame('/de/settings/password', lroute('settings.password'));
		$app->setLocale('ru');
		$this->assertSame('/ru/settings/password', lroute('settings.password'));
	});

	test('should accept parameters', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$app->setLocale('en');
		$uuid = fake()->uuid();
		$this->assertSame("/en/account/tags/{$uuid}", lroute('tags.show', ['tag' => $uuid]));
	});
});

describe('to_lroute()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$app->setLocale('en');
		$this->assertStringEndsWith('/en/settings/password', to_lroute('settings.password')->getTargetUrl());
		$app->setLocale('de');
		$this->assertStringEndsWith('/de/settings/password', to_lroute('settings.password')->getTargetUrl());
		$app->setLocale('ru');
		$this->assertStringEndsWith('/ru/settings/password', to_lroute('settings.password')->getTargetUrl());
	});
});

describe('classname()', function (): void {
	test('should return empty string when there are no arguments', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('', classname());
	});

	test('should accept string varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a b c', classname('a', 'b', 'c'));
	});

	test('should accept null varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('', classname(null, null));
	});

	test('should accept array varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a b c', classname(['a'], ['b', 'c']));
	});

	test('should accept array with nulls varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a b c', classname(['a', null], ['b', 'c']));
	});

	test('should accept map varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a c', classname(['a' => true, 'b' => false, 'c' => true]));
	});

	test('should accept string, array, map and nulls varargs', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a b c', classname('a', null, ['b', null], null, ['c' => true, 'd' => false]));
	});
});

describe('path_split()', function (): void {
	test('should return an empty array when the path is root', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertEmpty(path_split('/'));
	});

	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame(['en'], path_split('/en'));
		$this->assertSame(['en', 'settings'], path_split('/en/settings/'));
	});
});

describe('singularize()', function (): void {
	test('busses -> bus', fn () => $this->assertSame('bus', singularize('busses')));
	test('children -> child', fn () => $this->assertSame('child', singularize('children')));
	test('deer -> deer', fn () => $this->assertSame('deer', singularize('deer')));
	test('feet -> foot', fn () => $this->assertSame('foot', singularize('feet')));
	test('geese -> goose', fn () => $this->assertSame('goose', singularize('geese')));
	test('halos -> halo', fn () => $this->assertSame('halo', singularize('halos')));
	test('indices -> index', fn () => $this->assertSame('index', singularize('indices')));
	test('oxen -> ox', fn () => $this->assertSame('ox', singularize('oxen')));
	test('people -> person', fn () => $this->assertSame('person', singularize('people')));
	test('photos -> photo', fn () => $this->assertSame('photo', singularize('photos')));
	test('pianos -> piano', fn () => $this->assertSame('piano', singularize('pianos')));
	test('matrices -> matrix', fn () => $this->assertSame('matrix', singularize('matrices')));
	test('men -> man', fn () => $this->assertSame('man', singularize('men')));
	test('mice -> mouse', fn () => $this->assertSame('mouse', singularize('mice')));
	test('movies -> movie', fn () => $this->assertSame('movie', singularize('movies')));
	test('news -> news', fn () => $this->assertSame('news', singularize('news')));
	test('series -> series', fn () => $this->assertSame('series', singularize('series')));
	test('sheep -> sheep', fn () => $this->assertSame('sheep', singularize('sheep')));
	test('species -> species', fn () => $this->assertSame('species', singularize('species')));
	test('teeth -> tooth', fn () => $this->assertSame('tooth', singularize('teeth')));
	test('toes -> toe', fn () => $this->assertSame('toe', singularize('toes')));
	test('vertices -> vertex', fn () => $this->assertSame('vertex', singularize('vertices')));
	test('wives -> wife', fn () => $this->assertSame('wife', singularize('wives')));
	test('wolves -> wolf', fn () => $this->assertSame('wolf', singularize('wolves')));
	test('women -> woman', fn () => $this->assertSame('woman', singularize('women')));
	test('-zzes -> -z', fn () => $this->assertSame('fez', singularize('fezzes')));
	test('-sses -> -ss', fn () => $this->assertSame('truss', singularize('trusses')));
	test('-shes -> -sh', fn () => $this->assertSame('marsh', singularize('marshes')));
	test('-ies -> -y', fn () => $this->assertSame('entity', singularize('entities')));
	test('-ays -> -ay', fn () => $this->assertSame('ray', singularize('rays')));
	test('-eys -> -ey', fn () => $this->assertSame('key', singularize('keys')));
	test('-iys -> -iy', fn () => $this->markTestSkipped());
	test('-oys -> -oy', fn () => $this->assertSame('boy', singularize('boys')));
	test('-uys -> -uy', fn () => $this->markTestSkipped());
	test('-oes -> -o', fn () => $this->assertSame('potato', singularize('potatoes')));
	test('-ses -> -s', fn () => $this->assertSame('iris', singularize('irises')));
	test('-xes -> -x', fn () => $this->assertSame('tax', singularize('taxes')));
	test('-zes -> -z', fn () => $this->assertSame('blitz', singularize('blitzes')));
	test('-es -> -is', fn () => $this->markTestSkipped());
	test('-pi -> -us', fn () => $this->assertSame('octopus', singularize('octopi')));
	test('-ti -> -us', fn () => $this->assertSame('cactus', singularize('cacti')));
	test('-ci -> -us', fn () => $this->assertSame('focus', singularize('foci')));
	test('-s ->', fn () => $this->assertSame('tag', singularize('tags')));
	test('-a -> -on', fn () => $this->assertSame('criterion', singularize('criteria')));
	test('should return the same word when the word is not plural', fn () => $this->assertSame('word', singularize('word')));
});
