<?php
it('should redirect to "/en/login" when accessing "/"', function () {
	$response = $this->get('/');
	$response->assertRedirect('/en/login');
});

it('should return 404 when the locale for the route route "/{locale}/login" is unknown', function () {
	$response = $this->get('/unknown/login');
	$response->assertStatus(404);
});

it('should set the application\'s locale when accessing the route "/{locale}/login" with another locale', function () {
	$this->assertSame('en', $this->app->getLocale());
	$this->get('/de/login');
	$this->assertSame('de', $this->app->getLocale());
});

it('should redirect to "/<route>" when accessing "/<route>/"', function () {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});

it('should show the footer status bar when accessing a page with APP_ENV=dev', function () {
	$this->markTestSkipped('Unable to override environment variables');
});
