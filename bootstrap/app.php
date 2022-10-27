<?php

// inicia a sessão do app
session_start();


require __DIR__ . "/../vendor/autoload.php";



$config = [
	"settings" => [
		"displayErrorDetails" => true,


		// database Settings
		"db" => [
			"driver" => "mysql",
			"host" => "localhost",
			"database" => "phpreturn",
			"username" => "root",
			"password" => "",
			"charset" => "utf8",
			"collation" => "utf8_unicode_ci",
			"prefix" => ""
		]
	]
];

$app = new \Slim\App($config);


$container = $app->getContainer();


$container["view"] = function ($container) use ($app) {

	$config = $container->get("settings");
	$view = new \Slim\Views\Twig(__DIR__ . "/../resources/views", [
		"cache" => __DIR__ . "/../cache/twig",
		"debug" => true,
		"auto_reload" => true
	]);

	$view->addExtension(new \Slim\Views\TwigExtension(
		$container->get("router"),
		$container->get("request")->getUri()
	));

	return $view;

};

$container["HomeController"] = function ($container) {
	return new App\Controllers\HomeController($container);
};
$container["AuthController"] = function ($container) {
	return new App\Controllers\AuthController($container);
};


// rotas da aplicação
require __DIR__ . "/../app/routes.php";