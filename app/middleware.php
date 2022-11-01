<?php

// midlewares


// old input
$app->add(new App\Middleware\OldInputMiddleware($container));

$app->add(new App\Middleware\RememberMiddleware($container));