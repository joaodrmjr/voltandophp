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


$app->get("/", function ($request, $response) {
	echo "Home";
});