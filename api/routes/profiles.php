<?php

$app->post('/profile', function () use ($app){
    $controller = new profilesController($app);
    $controller->createProfile();
});

$app->put('/profile/:id', function ($id) use ($app){
    $controller = new profilesController($app);
    $controller->editProfile($id);
});

$app->delete('/profile/:id', function ($id) use ($app){
    $controller = new profilesController($app);
    $controller->removeProfile($id);
});

$app->get('/profile/:id', function ($id) use ($app){
    $controller = new profilesController($app);
    $controller->getProfile($id);
});

$app->get('/profile', function () use ($app){
    $controller = new profilesController($app);
    $controller->getProfiles();
});

$app->post('/profile/review', function () use ($app){
    $controller = new profilesController($app);
    $controller->reviewProfile();
});

$app->put('/profile/review/:id', function ($id) use ($app){
    $controller = new profilesController($app);
    $controller->editReview($id);
});

$app->delete('/profile/review/:id', function ($id) use ($app){
    $controller = new profilesController($app);
    $controller->removeReview($id);
});



