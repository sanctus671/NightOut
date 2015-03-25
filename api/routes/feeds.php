<?php

$app->post('/feed', function () use ($app){
    $controller = new feedsController($app);
    $controller->createFeed();
});

$app->put('/feed/:id', function ($id) use ($app){
    $controller = new feedsController($app);
    $controller->editFeed($id);
});

$app->delete('/feed/:id', function ($id) use ($app){
    $controller = new feedsController($app);
    $controller->removeFeed($id);
});

$app->get('/feed/:id', function ($id) use ($app){
    $controller = new feedsController($app);
    $controller->getFeed($id);
});

$app->get('/feed', function () use ($app){
    $controller = new feedsController($app);
    $controller->getFeeds();
});

$app->post('/feed/comment', function () use ($app){
    $controller = new feedsController($app);
    $controller->commentFeed();
});

$app->put('/feed/comment/:id', function ($id) use ($app){
    $controller = new feedsController($app);
    $controller->editComment($id);
});

$app->delete('/feed/comment/:id', function ($id) use ($app){
    $controller = new feedsController($app);
    $controller->removeComment($id);
});

$app->post('/feed/like/:feedid', function ($feedid) use ($app){
    $controller = new feedsController($app);
    $controller->likeFeed($feedid);
});

$app->delete('/feed/unlike/:feedid', function ($feedid) use ($app){
    $controller = new feedsController($app);
    $controller->unlikeFeed($feedid);
});

