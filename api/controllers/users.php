<?php

class usersController
{

    private $app;
    
    public function __construct ($app)
    {       
        $this->app = $app;
    }    
    
    public function createUser()
    {
        if (isset($_SESSION["userid"])){$this->app->errorJSON($this->app, "Already logged in");}
        
        $_SESSION["userid"] = "Not a real session";

        $model = new userModel($this->app);


        $model->username = $this->app->request->post->username;
        $model->email = $this->app->request->post->email;

        $model->save($this->app->request->post->password);
        
        $auth = new authenticationController($this->app);
        $auth->login($this->app->request->post("username"), $this->app->request->post("password"));    
        
        $settings = new userSettingsModel($this->app);
        $settings->save();        
        

        
        $this->app->outputJSON($this->app, "User registered");
    }
    
    
    public function editUser()
    {
        $model = new userModel($this->app);
        $model->username = $this->app->request->put->username;
        $model->email = $this->app->request->put->email;
        $model->password = $this->app->request->put->password;
        $this->app->outputJSON($this->app, $model->update());
    }  
    
    public function removeUser()
    {
        $model = new userModel($this->app);
        $model->delete();
        $this->app->outputJSON($this->app, "User deleted");
    } 
    
    public function getUser()
    {
        $model = new userModel($this->app);
        $this->app->outputJSON($this->app, $model->get());
    }    
       
    public function addLocation()
    {
        $model = new userLocationModel($this->app);
        $model->location = $this->app->request->post->location;
        $model->GPS = $this->app->request->post->GPS;
        $model->save();
        $this->app->outputJSON($this->app, "Location added");
    } 
    
    public function removeLocation($id)
    {
        $model = new userLocationModel($this->app);
        $model->id = $id;
        $model->delete();
        $this->app->outputJSON($this->app, "Location removed");
    }
    
    public function updateSettings()
    {
        $model = new userSettingsModel($this->app);
        $model->email_preferences = $this->app->request->put->email_preferences;
        $model->beacon_preferences = $this->app->request->put->beacon_preferences;
        $model->update();
        $this->app->outputJSON($this->app, "Settings updated");
    }  
    
    public function addSocial()
    {
        $model = new userSocialModel($this->app);
        $model->social = $this->app->request->post->social;
        $model->socialid = $this->app->request->post->socialid;
        $model->save();
        $this->app->outputJSON($this->app, "Social network added");
    } 
    
    public function removeSocial($id)
    {
        $model = new userSocialModel($this->app);
        $model->id = $id;
        $model->delete();
        $this->app->outputJSON($this->app, "Social network removed");
    }     
    
}