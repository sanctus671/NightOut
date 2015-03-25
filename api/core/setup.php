<?php

$app = new extendedSlim(array(
    'mode' => $config['mode'],
    'log.level' => $config['log.level'],
    'log.enabled' => $config['log.enabled'],
    'cookies.encrypt' => $config['cookies.encrypt'],
    'cookies.lifetime' => $config['cookies.lifetime']
));

$app->container->singleton('db', function () use ($config){
    return new medoo(array(
    'database_type' => $config['database_type'],
    'database_name' => $config['database_name'],
    'server' => $config['server'],
    'username' => $config['username'],
    'password' => $config['password']
));
});




$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => $config['expires'],
    'path' => $config['path'],
    'domain' => $config['domain'],
    'secure' => $config['secure'],
    'httponly' => $config['httponly'],
    'name' => $config['name'],
    'secret' => $config['secret'],
    'cipher' => $config['cipher'],
    'cipher_mode' => $config['cipher_mode']
)));


$log = $app->log;

$params = (object)json_decode($app->request()->getBody(),true);

if ($app->request->isPost()){
    $app->request->post = $params;
}
else if ($app->request->isPut()){
    $app->request->put = $params;
}
else if ($app->request->isGet()){
    $app->request->get = $params;
}
else if ($app->request->isDelete()){
    $app->request->delete = $params;
}
//FacebookSession::setDefaultApplication('414561158706027', '15dde6a83e93d1f1716056ebc4485ccf');

