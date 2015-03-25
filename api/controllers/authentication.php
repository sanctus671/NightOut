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
        
        
        //check login as user
        $model = new userModel($this->app);
        $model->username = $username;
        $userid = $model->authenticate($password);
        if ($userid){
            $_SESSION["userid"] = $userid;
            
            //check if user is bussiness user
            
            $profileModel = new profileModel($this->app);
            $profileModel->userid = $userid;
            $profile = $profileModel->get();
            
            if (count($profile)){
                $_SESSION["profileid"] = $profile[0]["id"];
            }
            
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
    
  
   
    
}
    
