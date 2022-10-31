<?php


namespace App\Controllers;

use Respect\Validation\Validator as v;


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

	public function postRegister($request, $response)
	{
		$v = $this->validation->validate($request, [
			"username" => v::notEmpty()->alnum()->length(6, 15),
			"email" => v::notEmpty()->email(),
			"password" => v::notEmpty()->length(8, null),
			"cpassword" => v::passwdMatch($request->getParam("password"))
		]);

		if ($v->failed()) {
			$this->flash->addMessage("error", $v->first());
			return $response->withRedirect($this->router->pathFor("register"));
		}
	}


}