<?php

class feedModel
{
    public $id;
    public $profileid;
    public $image;
    public $text;
    public $created_date;
    public $modified_date;

    private $app;
    
    public function __construct ($app)
    {
        if (!isset($_SESSION['profileid'])){$app->errorJSON($app, "Not authenticated as business user");}
        $this->profileid = $_SESSION['profileid'];
        $this->app = $app;
    }    
    
    public function save()
    {
        if (!isset($this->text)){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        $this->id = $this->app->db->insert("feeds", $this->toArray());
   
        

        
    }
    
    public function update()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("feeds", $this->toArray(), ["id" => $this->id]);
        

        
        
    }    
    
    
    public function delete()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("feeds", ["id" => $this->id]);
        

    }    
    
    public function get()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to get");}
        return $this->app->db->select("feeds", "*", ["id" => $this->id]); 
        

    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}
