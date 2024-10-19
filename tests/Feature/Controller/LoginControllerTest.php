<?php
it('The route "/" should redirect to "/en/login"', function () {
	$response = $this->get('/');
	$response->assertRedirect('/en/login');
});

it('The route "/{locale}/login" with an unknown locale should return 404', function () {
	$response = $this->get('/unknown/login');
	$response->assertStatus(404);
});

it('Accessing the route "/{locale}/login" with a locale should set the application\'s locale', function () {
	$this->assertSame('en', $this->app->getLocale());
	$this->get('/de/login');
	$this->assertSame('de', $this->app->getLocale());
});

it('Accessing /<route>/ should redirect to /<route>', function () {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});

it('Accessing a page with APP_ENV=dev will show the footer status bar', function () {
	$this->markTestSkipped('Unable to override environment variables');
});
