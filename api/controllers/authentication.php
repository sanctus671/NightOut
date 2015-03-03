<?php

class authenticationController
{

    private $app;
    
    public function __construct ($app)
    {
        $this->app = $app;
    }    
    
    public function login($username, $password)
    {
        if (isset($_SESSION["userid"])){$this->app->errorJSON($this->app, "Already logged in");}


        $_SESSION["userid"] = "Not a real session";

        $model = new userModel($this->app);
        $model->username = $username;
        $userid = $model->authenticate($password);
        if ($userid){
            $_SESSION["userid"] = $userid;
            $this->app->outputJSON($this->app, "Logged in");
        }
        
    }
    
    public function logout()
    {
        if (!isset($_SESSION["userid"])){$this->app->errorJSON($this->app, "Not logged in");}
    
        session_unset(); 

        session_destroy(); 
    
        $this->app->outputJSON($this->app, "Logged out");
        
    }    
    
    
    public function register()
    {
        if (isset($_SESSION["userid"])){$this->app->errorJSON($this->app, "Already logged in");}

        $_SESSION["userid"] = "Not a real session";

        $model = new userModel($this->app);


        $model->username = $this->app->request->post("username");
        $model->email = $this->app->request->post("email");

        $model->save($this->app->request->post("password"));
        
        $this->login($this->app->request->post("username"), $this->app->request->post("password"));
        
        $this->app->outputJSON($this->app, "User registered");
        
        
        

    }  
    
}
    
