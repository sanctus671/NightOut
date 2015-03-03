<?php

class productModel
{
    public $id;
    public $profileid;
    public $name;
    public $price;
    public $description;
    public $payment_method;
    public $redemption_method;
    public $image;
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
        if (!isset($this->name) || !isset($this->price)){$this->app->errorJSON($this->app, "Required fields were not set");}
       
        unset($this->id);
        $this->id = $this->app->db->insert("products", $this->toArray());
        
    }
    
    public function update()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to update");}
        $this->app->db->update("products", $this->toArray(), ["id" => $this->id]);
    }    
    
    
    public function delete()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to delete");}
        $this->app->db->delete("products", ["id" => $this->id]);
 
    }    
    
    public function get()
    {
        if (!isset($this->id)){$this->app->errorJSON($this->app, "No ID was selected to get");}
        return $this->app->db->select("products", "*", ["id" => $this->id]); 
    } 
    
    public function toArray(){
        return call_user_func('get_object_vars', $this);
    }
          
    
}
