<?php


namespace App\Controllers;

use App\Models\User;
use App\Models\Lista;

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


	public function ajaxExample($request, $response)
	{
		return $this->view->render($response, "user/ajax.twig", [
			"lista" => Lista::all()
		]);
	}

	public function ajaxCreate($request, $response)
	{
		$listaData = filter_var_array($request->getParams(), FILTER_SANITIZE_STRING);
		if (in_array("", $listaData)) {
			$callback["message"] = "Preencha todos os campos!";
			echo json_encode($callback);
			return;
		}

		$item = Lista::create([
			"name" => $listaData["name"],
			"last_name" => $listaData["lastname"]
		]);

		$callback["message"] = "Usuario cadastrado com sucesso";
		$callback["user"] = $this->view->fetch("user/item.twig", [
			"item" => $item
		]);

		echo json_encode($callback);
	}


	public function ajaxDelete($request, $response, $args)
	{
		if (!isset($args["id"])) {
			return;
		}

		$id = filter_var($args["id"], FILTER_VALIDATE_INT);

		if ($item = Lista::find($id)) {
			$item->delete();
		}

		$callback["remove"] = true;
		return json_encode($callback);
	}

}