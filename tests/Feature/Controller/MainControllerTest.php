<?php
it('The route "/" should redirect to "/en"', function () {
	$response = $this->get('/');
	$response->assertRedirect('/en');
});

it('The route "/{locale}" with an unknown locale should redirect to "/en"', function () {
	$response = $this->get('/unknown');
	$response->assertRedirect('/en');
});

it('Accessing the route "/{locale}" with a locale should set the application\'s locale', function () {
	$this->assertSame('en', $this->app->getLocale());
	$this->get('/de');
	$this->assertSame('de', $this->app->getLocale());
});
