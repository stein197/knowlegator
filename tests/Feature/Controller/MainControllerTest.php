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
