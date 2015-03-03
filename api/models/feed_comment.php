<?php

class feedCommentModel
{
    public $id;
    public $userid;
    public $feedid;
    public $comment;
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
        if (!isset($this->feedid) || !isset($this->comment) ){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        $this->id = $this->app->db->insert("feed_comments", $this->toArray());
        
    }
    
    public function update()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("feed_comments", $this->toArray(), ["id" => $this->id]);
    }    
    
    
    public function delete()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("feed_comments", ["id" => $this->id]);
 
    }    
    
    public function get()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to get");}
        return $this->app->db->select("feed_comments", "*", ["id" => $this->id]); 
    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}