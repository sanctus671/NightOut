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
        if (!isset($this->id)){
            $profiles = $this->app->db->select("profiles", "*");
            foreach ($profiles as $index => $profile){
                $profiles[$index]["reviews"] = $this->app->db->query("SELECT * FROM profile_reviews "
                                     . "INNER JOIN users ON users.id = profile_reviews.userid "
                                     . "WHERE profile_reviews.profileid = " . $profile["id"])->fetchAll(); 
                

                $profiles[$index]["products"] = $this->app->db->query("SELECT * FROM products "
                                     . "WHERE products.profileid = " . $profile["id"])->fetchAll(); 
            }
            return $profiles;
            
        }
        
        
        $profile = $this->app->db->select("profiles", "*", ["id" => $this->id])[0];
        
        $profile["reviews"] = $this->app->db->query("SELECT * FROM profile_reviews "
                             . "INNER JOIN users ON users.id = profile_reviews.userid "
                             . "WHERE profile_reviews.profileid = " . $this->id)->fetchAll(); 


        $profile["products"] = $this->app->db->query("SELECT * FROM products "
                             . "WHERE products.profileid = " . $this->id)->fetchAll();  
        
        
        $feeds = $this->app->db->query("SELECT feeds.*, profiles.avatar, profiles.name, profiles.type FROM feeds "
                                 . "INNER JOIN profiles ON feeds.profileid = profiles.id WHERE feeds.profileid = $this->id ORDER BY feeds.created_date DESC LIMIT 5 OFFSET 0 ")->fetchAll(); 
        foreach ($feeds as $index => $feed){
            $feeds[$index]["comments"] = $this->app->db->query("SELECT * FROM feed_comments "
                                 . "INNER JOIN users ON users.id = feed_comments.userid "
                                 . "WHERE feed_comments.feedid = " . $feed["id"])->fetchAll(); 


            $feeds[$index]["likes"] = $this->app->db->query("SELECT * FROM feed_likes "
                                 . "INNER JOIN users ON users.id = feed_likes.userid WHERE feed_likes.feedid = " . $feed["id"])->fetchAll(); 
        } 
        
        $profile["feeds"] = $feeds;
        
        return $profile;
        

    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}
