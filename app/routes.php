<?php



$app->get("/", "HomeController:home")->setName("home");



$app->get("/login", "AuthController:login")->setName("login");
$app->post("/login", "AuthController:postLogin");


$app->get("/register", "AuthController:register")->setName("register");
$app->post("/register", "AuthController:postRegister");