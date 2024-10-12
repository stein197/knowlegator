<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MainController extends Controller {

	public function __invoke(Request $request): Response {
		return response('Hello, World!');
	}
}
