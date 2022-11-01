<?php


namespace App\Controllers\Admin;


use App\Controllers\Controller;

class BaseController extends Controller {



	public function home($request, $response)
	{
		return $this->view->render($response, "admin/home.twig");
	}

}