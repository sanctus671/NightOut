<?php
require 'vendor/autoload.php';

include("config.php");

include("core/extend.php");
include("core/setup.php");


foreach (glob("models/*.php") as $filename){include $filename;}
foreach (glob("controllers/*.php") as $filename){include $filename;}
foreach (glob("routes/*.php") as $filename){include $filename;}



$app->get('/hello/:name', function ($name) use ($app){
    //echo "Hello, $name";
    $_SESSION["userid"] = 1;

    if (strlen($name) < 2){
        $app->errorJSON($app, "Name not long enough");
    }
    else{
        //print_r($_SESSION);
        $model = new userModel($app);
        $model->id = 1;
        $app->outputJSON($app, $model->get());
        //$testArray = $app->db->query("SELECT * FROM users")->fetchAll();
        //$app->outputJSON($app, $testArray);        
    }

});

$app->get('/user', function () use ($app){
    //echo "Hello, $name";
    print_r($_SESSION);

});





$app->run();