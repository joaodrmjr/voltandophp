<?php


namespace App\Controllers;


use App\Models\User;

class AuthController extends Controller {


	public function login($request, $response)
	{

		return $this->view->render($response, "auth/login.twig");
	}

	
	public function register($request, $response)
	{

		return $this->view->render($response, "auth/register.twig");
	}




}