<?php
it('The route "/" should redirect to "/en"', function () {
	$response = $this->get('/');
	$response->assertRedirect('/en');
});

it('The route "/{locale}" with an unknown locale should return 404', function () {
	$response = $this->get('/unknown');
	$response->assertStatus(404);
});

it('Accessing the route "/{locale}" with a locale should set the application\'s locale', function () {
	$this->assertSame('en', $this->app->getLocale());
	$this->get('/de');
	$this->assertSame('de', $this->app->getLocale());
});

it('Accessing /<route>/ should redirect to /<route>', function () {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});

it('Accessing a page with APP_ENV=dev will show the footer status bar', function () {
	$this->markTestSkipped('Unable to override environment variables');
});
