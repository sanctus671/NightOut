<?php

$app->get('/login/:username/:password', function ($username, $password) use ($app){
    $controller = new authenticationController($app);
    $controller->login($username, $password);
});


$app->get('/logout', function () use ($app){
    $controller = new authenticationController($app);
    $controller->logout();
});


