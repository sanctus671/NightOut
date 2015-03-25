<?php
error_reporting(0);
@ini_set('display_errors', 0);

require 'vendor/autoload.php';

include("config.php");

include("core/extend.php");
include("core/setup.php");


foreach (glob("models/*.php") as $filename){include $filename;}
foreach (glob("controllers/*.php") as $filename){include $filename;}
foreach (glob("routes/*.php") as $filename){include $filename;}



$app->run();