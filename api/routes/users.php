<?php

$app->post('/user', function () use ($app){
    $controller = new UsersController($app);
    $controller->createUser();
});

$app->get('/user', function () use ($app){
    $controller = new UsersController($app);
    $controller->getUser();
});

$app->put('/user', function () use ($app){
    $controller = new UsersController($app);
    $controller->editUser();
});

$app->delete('/user', function () use ($app){
    $controller = new UsersController($app);
    $controller->removeUser();
});

$app->post('/location', function () use ($app){
    $controller = new UsersController($app);
    $controller->addLocation();
});

$app->delete('/location/:id', function ($id) use ($app){
    $controller = new UsersController($app);
    $controller->removeLocation($id);
});

$app->put('/user/settings', function () use ($app){
    $controller = new UsersController($app);
    $controller->updateSettings();
});

$app->post('/user/social', function () use ($app){
    $controller = new UsersController($app);
    $controller->addSocial();
});

$app->delete('/user/social/:id', function ($id) use ($app){
    $controller = new UsersController($app);
    $controller->removeSocial($id);
});



