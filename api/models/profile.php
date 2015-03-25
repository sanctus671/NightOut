<?php

class profileModel
{
    public $id;
    public $userid;
    public $email;
    public $website;
    public $facebook;
    public $googlep;
    public $twitter;
    public $instagram;
    public $type;
    public $location;
    public $GPS;
    public $description;
    public $name;
    public $avatar;
    public $created_date;
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
        if (!isset($_SESSION['profileid'])){$this->app->errorJSON($this->app, "Not authenticated as business user");}
        $this->id = $_SESSION['profileid'];        
        //will require payment confirmation
        if (!isset($this->email) || !isset($this->type) || !isset($this->location) || !isset($this->description) || !isset($this->name) || !isset($this->avatar)){$this->app->errorJSON($this->app, "Required fields were not set");}

        unset($this->id);
        $this->id = $this->app->db->insert("profiles", $this->toArray());        
    }
    
    public function update()
    {
        if (!isset($_SESSION['profileid'])){$this->app->errorJSON($this->app, "Not authenticated as business user");}
        $this->id = $_SESSION['profileid'];
        
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("profiles", $this->toArray(), ["id" => $this->id]);        
    }    
    
    
    public function delete()
    {
        if (!isset($_SESSION['profileid'])){$this->app->errorJSON($this->app, "Not authenticated as business user");}
        $this->id = $_SESSION['profileid'];
        
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("profiles", ["id" => $this->id]);
 
    }    
    
    public function get()
    {
        if (isset($this->userid)){
            return $this->app->db->select("profiles", "*", ["userid" => $this->userid]);
        }
        else if (!isset($this->id)){
            return $this->app->db->select("profiles", "*");
            
        }
        else {
            return $this->app->db->select("profiles", "*", ["id" => $this->id]);
        }

    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}
