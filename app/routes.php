<?php



$app->get("/", "HomeController:home")->setName("home");


$app->group("/auth", function ($container) use ($app) {


	$app->get("/login", "AuthController:login")->setName("login");
	$app->post("/login", "AuthController:postLogin");


	$app->get("/register", "AuthController:register")->setName("register");
	$app->post("/register", "AuthController:postRegister");


})->add(new App\Middleware\GhostMiddleware($container));



$app->group("/user", function ($container) use ($app) {


	$app->get("/changepw", "UserController:changePassword")->setName("changepw");
	$app->post("/changepw", "UserController:postChangePassword");

	// exemplo de requisição AJAX
	$app->get("/ajax", "UserController:ajaxExample")->setName("ajax");

	$app->post("/ajax/create", "UserController:ajaxCreate")->setName("ajax.create");
	$app->get("/ajax/delete/{id}", "UserController:ajaxDelete")->setName("ajax.delete");


	// logout
	$app->get("/logout", "AuthController:logout")->setName("logout");


})->add(new App\Middleware\AuthMiddleware($container));

