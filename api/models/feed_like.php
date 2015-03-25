<?php

class feedLikeModel
{
    public $id;
    public $userid;
    public $feedid;
    public $created_date;

    private $app;
    
    public function __construct ($app)
    {
        if (!isset($_SESSION['userid'])){$app->errorJSON($app, "Not authenticated");}
        $this->userid = $_SESSION['userid'];
        $this->app = $app;
    }    
    
    public function save()
    {
        if (!isset($this->feedid)){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        $this->id = $this->app->db->insert("feed_likes", $this->toArray());
        
    }
    
    public function update()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("feed_likes", $this->toArray(), ["id" => $this->id]);
    }    
    
    
    public function delete()
    {
        if (!isset($this->feedid)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("feed_likes", ["feedid" => $this->feedid]);
 
    }    
    
    public function get()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to get");}
        return $this->app->db->select("feed_likes", "*", ["id" => $this->id]); 
    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}