<?php
namespace App\Http\Controllers;

use App\Services\ApplicationVersionService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller {

	public function __invoke(Request $request, ApplicationVersionService $version): View{
		return view('main', [
			'version' => $version
		]);
	}
}
