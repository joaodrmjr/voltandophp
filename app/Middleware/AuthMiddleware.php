<?php


namespace App\Middleware;


use App\Models\User;

class AuthMiddleware extends Middleware {

	public function __invoke($request, $response, $next)
	{

		if (!$this->container->auth->state()) {
			$this->container->flash->addMessage("error", "Acesso não permitido :/");
			return $response->withRedirect($this->container->router->pathFor("login"));
		}

		return $next($request, $response);

	}

}