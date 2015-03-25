<?php

$app->post('/product', function () use ($app){
    $controller = new productsController($app);
    $controller->createProduct();
});

$app->put('/product/:id', function ($id) use ($app){
    $controller = new productsController($app);
    $controller->editProduct($id);
});

$app->delete('/product/:id', function ($id) use ($app){
    $controller = new productsController($app);
    $controller->removeProduct($id);
});


$app->get('/product/:id', function ($id) use ($app){
    $controller = new productsController($app);
    $controller->getProduct($id);
});

$app->get('/product', function () use ($app){
    $controller = new productsController($app);
    $controller->getProducts();
});


$app->post('/product/buy/:productid', function ($productid) use ($app){
    $controller = new productsController($app);
    $controller->buyProduct($productid);
});

$app->put('/product/redeem/:id', function ($id) use ($app){
    $controller = new productsController($app);
    $controller->createProduct($id);
});



