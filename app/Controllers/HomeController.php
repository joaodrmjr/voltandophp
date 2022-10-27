<?php


namespace App\Controllers;


class HomeController extends Controller {


	public function home($require, $response)
	{
		return $this->view->render($response, "home.twig");
	}

}