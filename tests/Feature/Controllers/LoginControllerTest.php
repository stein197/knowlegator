<?php
namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('Login (POST /{locale}/login)', function (): void {
	test('should show an error message when the user does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->post('/en/login', ['email' => 'unknown@user.com', 'password' => '1234', 'action' => 'login'])->getContent();
		$this->dom($content)->find('//p[contains(@class, "alert")]')->assertTextContent('User unknown@user.com does not exist');
		$this->assertGuest();
	});

	test('should show an error message when the password is not correct', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create(['email' => 'new@user.com', 'password' => '12345']);
		$content = $this->post('/en/login', ['email' => $user->email, 'password' => 'qwerty', 'action' => 'login'])->getContent();
		$this->assertGuest();
		$this->dom($content)->find('//p[contains(@class, "alert")]')->assertTextContent("Cannot login as {$user->email}");
	});

	test('should show an error message in the form when email has an invalid format', function (): void {
		/** @var \Tests\TestCase $this */
		$response = $this->post('/en/login', ['email' => 'not an email', 'password' => '12345', 'action' => 'login']);
		$response->assertSessionHasErrors(['email']);
		$this->assertGuest();
	});
	
	test('should show an error message in the form when the email is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$response = $this->post('/en/login', ['email' => '', 'password' => '12345', 'action' => 'login']);
		$response->assertSessionHasErrors(['email']);
		$this->assertGuest();
	});
	
	test('should show an error message in the form when the password is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$response = $this->post('/en/login', ['email' => 'new@user.com', 'password' => '', 'action' => 'login']);
		$response->assertSessionHasErrors(['password']);
		$this->assertGuest();
	});

	test('should successfully authenticate when the credentials are correct', function (): void {
		/** @var \Tests\TestCase $this */
		$email = 'new@user.com';
		$password = '12345';
		User::factory()->create(['email' => $email, 'password' => $password]);
		$response = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'login']);
		$response->assertRedirect('/en/account');
		$this->assertAuthenticated();
	});

	test('should remember the user when the "remember me" is checked', function (): void {
		$this->markTestSkipped();
	});
});

describe('Register (POST /{locale}/login)', function (): void {
	test('should show an error message when the user already exists', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$response = $this->post('/en/login', ['email' => $user->email, 'password' => '12345', 'action' => 'register']);
		$response->assertSessionHasErrors(['email']);
	});

	test('should show an error message when the email is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->post('/en/login', ['email' => '', 'password' => '12345', 'action' => 'register'])->assertSessionHasErrors(['email']);
	});
	
	test('should show an error message when the password is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->post('/en/login', ['email' => 'new@user.com', 'password' => '', 'action' => 'register'])->assertSessionHasErrors(['password']);
	});

	test('should show a success message when the user is successfully created', function (): void {
		/** @var \Tests\TestCase $this */
		$email = 'new@user.com';
		$password = '12345';
		$content = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'register'])->getContent();
		$this->dom($content)->find('//p[contains(@class, "alert")]')->assertTextContent('User new@user.com has been successfully created');
	});
});

test('should return 404 when the locale for the route route "/{locale}/login" is unknown', function (): void {
	/** @var \Tests\TestCase $this */
	$response = $this->get('/unknown/login');
	$response->assertStatus(404);
});

test('should set the application\'s locale when accessing the route "/{locale}/login" with another locale', function (): void {
	/** @var \Tests\TestCase $this */
	$this->assertSame('en', $this->app->getLocale());
	$this->get('/de/login');
	$this->assertSame('de', $this->app->getLocale());
});

test('should show the footer status bar when accessing a page with APP_ENV=dev', function (): void {
	$this->markTestSkipped('Unable to override environment variables');
});

test('should successfully login after a successfull registration', function (): void {
	/** @var \Tests\TestCase $this */
	$email = 'new@user.com';
	$password = '12345';
	$content = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'register'])->getContent();
	$this->dom($content)->find('//p[contains(@class, "alert")]')->assertTextContent('User new@user.com has been successfully created');
	$response = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'login']);
	$this->assertAuthenticated();
	$response->assertRedirect('/en/account');
});
