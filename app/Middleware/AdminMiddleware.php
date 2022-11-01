<?php


namespace App\Middleware;

use App\Auth\Auth;
use App\Models\User;

class AdminMiddleware extends Middleware {

	public function __invoke($request, $response, $next)
	{

		if ($this->container->auth->state() != Auth::ADMIN) {
			$this->container->flash->addMessage("error", "Acesso não permitido :/");
			return $response->withRedirect($this->container->router->pathFor("home"));
		}

		return $next($request, $response);

	}

}