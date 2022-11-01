<?php

namespace App\Controllers;

class UserController extends Controller {



	public function changePassword($request, $response)
	{
		return $this->view->render($response, "user/change_password.twig");
	}


	public function postChangePassword($request, $response)
	{
		if (!$this->auth->toChangePw([
			"npassword" => $request->getParam("npassword"),
			"cpassword" => $request->getParam("cpassword"),
			"password" => $request->getParam("password")
		])) {
			$this->flash->addMessage("error", $this->auth->getError());
			return $response->withRedirect($this->router->pathFor("changepw"));
		}

		$this->flash->addMessage("success", "Senha alterada com sucesso!");
		return $response->withRedirect($this->router->pathFor("home"));
	}

}