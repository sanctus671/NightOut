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
        if (!isset($_SESSION['userid'])){$app->errorJSON($app, "Not authenticated");}
        $this->app = $app;
    }    
    
    public function save()
    {
        if (!isset($_SESSION['profileid'])){$this->app->errorJSON($this->app, "Not authenticated as business user");}
        $this->profileid = $_SESSION['profileid'];   
        
        if (!isset($this->text)){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        $this->id = $this->app->db->insert("feeds", $this->toArray());
   
        

        
    }
    
    public function update()
    {
        if (!isset($_SESSION['profileid'])){$this->app->errorJSON($this->app, "Not authenticated as business user");}
        $this->profileid = $_SESSION['profileid']; 
        
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("feeds", $this->toArray(), ["id" => $this->id]);
        

        
        
    }    
    
    
    public function delete()
    {
        if (!isset($_SESSION['profileid'])){$this->app->errorJSON($this->app, "Not authenticated as business user");}
        $this->profileid = $_SESSION['profileid']; 
        
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("feeds", ["id" => $this->id]);
        

    }    
    
    public function get()
    {
        if (!isset($this->id)){
            //select all

            $feeds = $this->app->db->query("SELECT feeds.*, profiles.avatar, profiles.name, profiles.type FROM feeds "
                                     . "INNER JOIN profiles ON feeds.profileid = profiles.id ORDER BY feeds.created_date DESC LIMIT 5 OFFSET 0 ")->fetchAll(); 
            foreach ($feeds as $index => $feed){
                $feeds[$index]["comments"] = $this->app->db->query("SELECT * FROM feed_comments "
                                     . "INNER JOIN users ON users.id = feed_comments.userid "
                                     . "WHERE feed_comments.feedid = " . $feed["id"])->fetchAll(); 
                

                $feeds[$index]["likes"] = $this->app->db->query("SELECT * FROM feed_likes "
                                     . "INNER JOIN users ON users.id = feed_likes.userid WHERE feed_likes.feedid = " . $feed["id"])->fetchAll(); 
            }
            return $feeds;
            
        }
        //select specific item
        $feed = $this->app->db->select("feeds", "*", ["id" => $this->id])[0];
        $feed["comments"] = $this->app->db->query("SELECT feed_comments.*, users.username FROM feed_comments "
                             . "INNER JOIN users ON users.id = feed_comments.userid "
                             . "WHERE feed_comments.feedid = " . $feed["id"])->fetchAll(); 


        $feed["likes"] = $this->app->db->query("SELECT feed_likes.*, users.username FROM feed_likes "
                             . "INNER JOIN users ON users.id = feed_likes.userid WHERE feed_likes.feedid = " . $feed["id"])->fetchAll(); 
        
        return $feed;
               
            
            
            
            ; 
        

    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}
