<?php

$config = array(
      
    //db config
    'database_type' => 'mysql',
    'database_name' => 'nightout',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    
    //logging
    'mode' => 'development',
    'log.level' => \Slim\Log::ERROR,
    'log.enabled' => false,
    
    //cookies   
    'cookies.encrypt' => true,
    'cookies.lifetime' => '30 days',    
    
    //session cookies
    'expires' => '30 days',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'nightout_session',
    'secret' => 'r433dfgjhkhj763fef5yuukjyujk87e',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC    
    
    
    
);



