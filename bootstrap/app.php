<?php

// inicia a sessão do app
session_start();


require __DIR__ . "/../vendor/autoload.php";


require __DIR__ . "/../app/helpers.php";


$config = require __DIR__ . "/../app/config.php";


$app = new \Slim\App($config);


require __DIR__ . "/../app/dependecies.php";


require __DIR__ . "/../app/midleware.php";


// rotas da aplicação
require __DIR__ . "/../app/routes.php";