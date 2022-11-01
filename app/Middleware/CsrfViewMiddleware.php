<?php
namespace App\Middleware;

class CsrfViewMiddleware extends Middleware {

	public function __invoke($request, $response, $next)
	{
		$this->container->view->getEnvironment()->addGlobal("csrf", [
			"field" => getCsrfCode($this->container->csrf)
		]);
		
		return $next($request, $response);
	}
}