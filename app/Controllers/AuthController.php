<?php


namespace App\Controllers;

use Respect\Validation\Validator as v;
use App\Auth\Auth;

use App\Models\User;

class AuthController extends Controller {


	public function login($request, $response)
	{

		return $this->view->render($response, "auth/login.twig");
	}

	public function postLogin($request, $response)
	{
		if (!$this->auth->tryLogin([
			"username" => $request->getParam("username"),
			"password" => $request->getParam("password"),
			"remember" => $request->getParam("remember")
		])) {
			$this->flash->addMessage("error", $this->auth->getError());
			return $response->withRedirect($this->router->pathFor("login"));
		}

		$this->flash->addMessage("success", "Login realizado com sucesso! Seja bem-vindo ".$this->auth->user()->username);
		return $response->withRedirect($this->router->pathFor("home"));
	}

	
	public function register($request, $response)
	{

		return $this->view->render($response, "auth/register.twig");
	}

	public function postRegister($request, $response)
	{
		$v = $this->validation->validate($request, [
			"username" => v::notEmpty()->usernameAvailable()->alnum()->length(6, 15),
			"email" => v::notEmpty()->email()->emailAvailable(),
			"password" => v::notEmpty()->length(8, null),
			"cpassword" => v::passwdMatch($request->getParam("password"))
		]);

		if ($v->failed()) {
			$this->flash->addMessage("error", $v->first());
			return $response->withRedirect($this->router->pathFor("register"));
		}


		User::create([
			"username" => $request->getParam("username"),
			"email" => $request->getParam("email"),
			"password" => password_hash($request->getParam("password"), PASSWORD_DEFAULT)
		]);

		$this->flash->addMessage("success", "Usuário cadastrado com sucesso! Já pode iniciar sua sessão.");
		return $response->withRedirect($this->router->pathFor("home"));
	}

	public function logout($request, $response)
	{
		$this->flash->addMessage("info", "Sessão encerrada com sucesso! Volte logo " . $this->auth->user()->username);
		$this->auth->logout();
		return $response->withRedirect($this->router->pathFor("login"));
	}


}