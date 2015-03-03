<?php

class userModel
{
    public $id;
    public $username;
    public $email;
    
    private $password;
    

    public $created_date;
    public $last_logged_in;

    private $app;
    
    public function __construct ($app)
    {
        if (!isset($_SESSION['userid'])){$app->errorJSON($app, "Not authenticated");}
        $this->id = $_SESSION['userid'];
        $this->app = $app;
    }    
    
    public function save($password)
    {
        //need to manually set password when saving. set and unset dummy userid set to bypass authentication
        if (!isset($this->username) || !isset($this->email) || !isset($password) ){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        session_unset();
        
        $this->password = $password;
        
        
        if ($this->app->db->has("users", ["OR" => ["username" => $this->username, "email" => $this->email]])){
            $this->app->errorJSON($this->app, "Username or email already exists");
        }
        
        $user = $this->toArray();
        $user["password"] = password_hash($this->password, PASSWORD_BCRYPT);
        
        $this->id = $this->app->db->insert("users", $user);        
        
        
    }
    
    public function update()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("users", $this->toArray(), ["id" => $this->id]); 
    }    
    
    
    public function delete()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("users", ["id" => $this->id]);
 
    }    
    
    public function get()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to get");}
        
        $fields = array_keys($this->toArray());
        unset($fields[array_search('password', $fields)]); //don't return the password!
        
        return $this->app->db->select("users", $fields, ["id" => $this->id]); 
    } 
    
    public function authenticate($password)
    {
        if (!isset($this->username)){$this->app->errorJSON($this->app, "No username was given");}
        
       unset($this->id);
       session_unset();        
        
        
        $this->password = $password;
        
        $result = $this->app->db->select("users", ["id", "password"], ["username" => $this->username]); 

        if (count($result)){
            $password = $result[0]["password"];
            $userid = $result[0]["id"];
        
            if (password_verify($this->password, $password)){
                $this->app->db->update("users", ["last_logged_in" => date("Y-m-d H:i:s")], ["id" => $userid]); 
                return $userid;
            }
            
        }
        else{
            $this->app->errorJSON($this->app, "User does not exist");
        }
        

        
        $this->app->errorJSON($this->app, "Invalid password");
        
    }    
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}