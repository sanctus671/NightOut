<?php

class profilesController
{

    private $app;
    
    public function __construct ($app)
    {       
        $this->app = $app;
    }    
    
    public function createProfile()
    {
        $model = new profileModel($this->app);
        $model->email = $this->app->request->post->email;
        $model->website = $this->app->request->post->website;
        $model->facebook = $this->app->request->post->facebook;
        $model->googlep = $this->app->request->post->googlep;
        $model->twitter = $this->app->request->post->twitter;
        $model->type = $this->app->request->post->type;
        $model->location = $this->app->request->post->location;
        $model->GPS = $this->app->request->post->GPS;
        $model->description = $this->app->request->post->description;
        $model->name = $this->app->request->post->name;
        $model->avatar = $this->app->request->post->avatar;

        $model->save();
        $this->app->outputJSON($this->app, "Profile created");
    }
    
    
    public function editProfile($id)
    {
        $model = new profileModel($this->app);
        $model->id = $id;
        $model->email = $this->app->request->put->email;
        $model->website = $this->app->request->put->website;
        $model->facebook = $this->app->request->put->facebook;
        $model->googlep = $this->app->request->put->googlep;
        $model->twitter = $this->app->request->put->twitter;
        $model->type = $this->app->request->put->type;
        $model->location = $this->app->request->put->location;
        $model->GPS = $this->app->request->put->GPS;
        $model->description = $this->app->request->put->description;
        $model->name = $this->app->request->put->name;
        $model->avatar = $this->app->request->put->avatar;

        $model->update();
        $this->app->outputJSON($this->app, "Profile updated");
    }  
    
    public function removeProfile($id)
    {
        $model = new profileModel($this->app);
        $model->id = $id;
        $model->delete();
        $this->app->outputJSON($this->app, "Profile deleted");
    } 
    
    public function getProfile($id)
    {
        $model = new profileModel($this->app);
        $model->id = $id;
        $this->app->outputJSON($this->app, $model->get());
    }    
    
    
    public function getProfiles()
    {
        $model = new profileModel($this->app);
        $this->app->outputJSON($this->app, $model->get());
    }    
    
    public function reviewProfile()
    {
        $model = new profileReviewModel($this->app);
        $model->profileid = $this->app->request->post->profileid;
        $model->image = $this->app->request->post->image;
        $model->rating = $this->app->request->post->rating;
        $model->text = $this->app->request->post->text;

        $model->save();
        $this->app->outputJSON($this->app, "Review added");
    }
    
    public function editReview($id)
    {
        $model = new profileReviewModel($this->app);
        $model->id = $id;
        $model->image = $this->app->request->put->image;
        $model->rating = $this->app->request->put->rating;
        $model->text = $this->app->request->put->text;

        $model->update();
        $this->app->outputJSON($this->app, "Review updated");
    }
    
    public function removeReview($id)
    {
        $model = new profileReviewModel($this->app);
        $model->id = $id;

        $model->delete();
        $this->app->outputJSON($this->app, "Review removed");
    }    
 
    
}