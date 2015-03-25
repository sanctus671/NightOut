<?php

class productsController
{

    private $app;
    
    public function __construct ($app)
    {       
        $this->app = $app;
    }    
    
    public function createProduct()
    {
        $model = new productModel($this->app);
        $model->name = $this->app->request->post->name;
        $model->price = $this->app->request->post->price;
        $model->description = $this->app->request->post->description;
        $model->payment_method = $this->app->request->post->payment_method;
        $model->redemption_method = $this->app->request->post->redemption_method;
        $model->image = $this->app->request->post("image");
        $model->save();
        $this->app->outputJSON($this->app, "Product created");
    }
    
    
    public function editProduct($id)
    {
       $model = new productModel($this->app);
        $model->id = $id;   
        $model->name = $this->app->request->put->name;
        $model->price = $this->app->request->put->price;
        $model->description = $this->app->request->put->description;
        $model->payment_method = $this->app->request->put->payment_method;
        $model->redemption_method = $this->app->request->put->redemption_method;
        $model->image = $this->app->request->put->image;
        $model->update();
        $this->app->outputJSON($this->app, "Product updated");
    }  
    
    public function removeProduct($id)
    {
        $model = new productModel($this->app);
        $model->id = $id;
        $model->delete();
        $this->app->outputJSON($this->app, "Product deleted");
    } 
    
    public function getProduct($id)
    {
        $model = new productModel($this->app);
        $model->id = $id;
        $this->app->outputJSON($this->app, $model->get());
    }    
    
    
    public function getProducts($profileid)
    {
        $model = new productModel($this->app);
        $model->profileid = $profileid;
        $this->app->outputJSON($this->app, $model->get());
    }
    
    public function buyProduct($productid)
    {
        $model = new userVoucherModel($this->app);
        $model->productid = $productid;
        $model->save();
        $this->app->outputJSON($this->app, "Product bought");
    }  
    
    
    public function redeemProduct($id)
    {
        $model = new userVoucherModel($this->app);
        $model->id = $id;
        $model->redeemed = 1;
        $model->update();
        $this->app->outputJSON($this->app, "Product redeemed");
    }     
    
 
    
}