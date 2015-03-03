<?php

class userLocationModel
{
    public $id;
    public $userid;
    public $location;
    public $GPS;
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
        if (false){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        $this->id = $this->app->db->insert("user_locations", $this->toArray());
     
        
    }
    
    public function update()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("user_locations", $this->toArray(), ["id" => $this->id]);         
    }    
    
    
    public function delete()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("user_locations", ["id" => $this->id]);
 
    }    
    
    public function get()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to get");}
        return $this->app->db->select("user_locations", "*", ["id" => $this->id]); 
    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}