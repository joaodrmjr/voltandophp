<?php



$app->get("/", "HomeController:home")->setName("home");


$app->group("/auth", function ($container) use ($app) {

	
	$app->get("/login", "AuthController:login")->setName("login");
	$app->post("/login", "AuthController:postLogin");


	$app->get("/register", "AuthController:register")->setName("register");
	$app->post("/register", "AuthController:postRegister");


})->add(new App\Middleware\GhostMiddleware($container));
