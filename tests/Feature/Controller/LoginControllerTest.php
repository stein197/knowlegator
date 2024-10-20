<?php
namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('Login', function (): void {

	it('should show an error message when the user does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$response = $this->post('/en/login', ['email' => 'unknown@user.com', 'password' => '1234', 'action' => 'login']);
		$this->assertStringContainsString('User unknown@user.com does not exist', $response->getContent());
		$this->assertGuest();
	});

	it('should show an error message when the password is not correct', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create(['email' => 'new@user.com', 'password' => '12345']);
		$response = $this->post('/en/login', ['email' => $user->email, 'password' => 'qwerty', 'action' => 'login']);
		$this->assertGuest();
		$this->assertStringContainsString('Cannot login as ' . $user->email, $response->getContent());
	});

	it('should show an error message in the form when email has an invalid format', function (): void {
		/** @var \Tests\TestCase $this */
		$response = $this->post('/en/login', ['email' => 'not an email', 'password' => '12345', 'action' => 'login']);
		$response->assertSessionHasErrors(['email']);
		$this->assertGuest();
	});
	
	it('should show an error message in the form when the email is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$response = $this->post('/en/login', ['email' => '', 'password' => '12345', 'action' => 'login']);
		$response->assertSessionHasErrors(['email']);
		$this->assertGuest();
	});
	
	it('should show an error message in the form when the password is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$response = $this->post('/en/login', ['email' => 'new@user.com', 'password' => '', 'action' => 'login']);
		$response->assertSessionHasErrors(['password']);
		$this->assertGuest();
	});

	it('should successfully authenticate when the credentials are correct', function (): void {
		/** @var \Tests\TestCase $this */
		$email = 'new@user.com';
		$password = '12345';
		User::factory()->create(['email' => $email, 'password' => $password]);
		$response = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'login']);
		$response->assertRedirect('/en/account');
		$this->assertAuthenticated();
	});

	it('should remember the user when the "remember me" is checked', function (): void {
		$this->markTestSkipped();
	});
});

describe('Register', function (): void {

	it('should show an error message when the user already exists', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$response = $this->post('/en/login', ['email' => $user->email, 'password' => '12345', 'action' => 'register']);
		$response->assertSessionHasErrors(['email']);
	});

	it('should show an error message when the email is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->post('/en/login', ['email' => '', 'password' => '12345', 'action' => 'register'])->assertSessionHasErrors(['email']);
	});
	
	it('should show an error message when the password is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->post('/en/login', ['email' => 'new@user.com', 'password' => '', 'action' => 'register'])->assertSessionHasErrors(['password']);
	});

	it('should show a success message when the user is successfully created', function (): void {
		/** @var \Tests\TestCase $this */
		$email = 'new@user.com';
		$password = '12345';
		$response = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'register']);
		$this->assertStringContainsString('User new@user.com has been successfully created', $response->getContent());
	});
});

it('should return 404 when the locale for the route route "/{locale}/login" is unknown', function (): void {
	/** @var \Tests\TestCase $this */
	$response = $this->get('/unknown/login');
	$response->assertStatus(404);
});

it('should set the application\'s locale when accessing the route "/{locale}/login" with another locale', function (): void {
	/** @var \Tests\TestCase $this */
	$this->assertSame('en', $this->app->getLocale());
	$this->get('/de/login');
	$this->assertSame('de', $this->app->getLocale());
});

it('should show the footer status bar when accessing a page with APP_ENV=dev', function (): void {
	$this->markTestSkipped('Unable to override environment variables');
});

it('should successfully login after a successfull registration', function (): void {
	/** @var \Tests\TestCase $this */
	$email = 'new@user.com';
	$password = '12345';
	$response = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'register']);
	$this->assertStringContainsString('User new@user.com has been successfully created', $response->getContent());
	$response = $this->post('/en/login', ['email' => $email, 'password' => $password, 'action' => 'login']);
	$this->assertAuthenticated();
	$response->assertRedirect('/en/account');
});
