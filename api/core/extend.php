<?php

class extendedSlim extends Slim\Slim {
    function outputJSON($app, $data ) {
        $result = array();
        $result['data'] = $data;
        $response = $app->response;
        $response['Content-Type'] = 'application/json';
        $response->body( json_encode($result) );
        $response->status(200);
        
    }
    
    function errorJSON($app, $error ) {
        $result = array();
        $result['error'] = $error;
        $response = $app->response;
        $response['Content-Type'] = 'application/json';
        $app->halt(400, json_encode($result));

    }  
    
}
