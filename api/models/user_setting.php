<?php

class userSettingsModel
{
    public $id;
    public $userid;
    public $email_preferences;
    public $beacon_preferences;
    public $modified_date;

    private $app;
    
    public function __construct ($app)
    {
        if (!isset($_SESSION['userid'])){$app->errorJSON($app, "Not authenticated");}
        $this->userid = $_SESSION['userid'];
        $this->app = $app;
    }    
    
    public function save()
    {
        if (false){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        $this->id = $this->app->db->insert("user_settings", $this->toArray());
        
    }
    
    public function update()
    {
        if (!isset($this->userid)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("user_settings", $this->toArray(), ["userid" => $this->userid]);  
    }    
    
    
    public function delete()
    {
        if (!isset($this->userid)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("user_settings", ["userid" => $this->userid]);
 
    }    
    
    public function get()
    {
        if (!isset($this->userid)){$this->app->errorJSON($this->app, "No ID was selected to get");}
        return $this->app->db->select("user_settings", "*", ["userid" => $this->userid]); 
    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}