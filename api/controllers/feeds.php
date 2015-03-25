<?php

class feedsController
{

    private $app;
    
    public function __construct ($app)
    {       
        $this->app = $app;
    }    
    
    public function createFeed()
    {
        $model = new feedModel($this->app);
        $model->image = $this->app->request->post->image;
        $model->text = $this->app->request->post->text;
        $model->save();
        $this->app->outputJSON($this->app, "Feed created");
    }
    
    
    public function editFeed($id)
    {
        $model = new feedModel($this->app);
        $model->id = $id;
        $model->image = $this->app->request->put->image;
        $model->text = $this->app->request->put->text;
        $model->update();
        $this->app->outputJSON($this->app, "Feed updated");
    }  
    
    public function removeFeed($id)
    {
        $model = new feedModel($this->app);
        $model->id = $id;
        $model->delete();
        $this->app->outputJSON($this->app, "Feed deleted");
    } 
    
    public function getFeed($id)
    {
        $model = new feedModel($this->app);
        $model->id = $id;
        $this->app->outputJSON($this->app, $model->get());
    }    
    
    
    public function getFeeds()
    {
        $model = new feedModel($this->app);
        $this->app->outputJSON($this->app, $model->get());
    }  
    
    public function commentFeed()
    {
        $model = new feedCommentModel($this->app);     
        $model->feedid = $this->app->request->post->feedid;
        $model->comment = $this->app->request->post->comment;
        $model->save();
        $this->app->outputJSON($this->app, "Comment added");
    }  
    
    public function editComment($id)
    {
        $model = new feedCommentModel($this->app);     
        $model->id = $id;
        $model->comment = $this->app->request->put->comment;
        $model->update();
        $this->app->outputJSON($this->app, "Comment updated");
    }
    
    public function removeComment($id)
    {
        $model = new feedCommentModel($this->app);     
        $model->id = $id;
        $model->delete();
        $this->app->outputJSON($this->app, "Comment removed");
    }    
    
    public function likeFeed($feedid)
    {
        $model = new feedLikeModel($this->app);     
        $model->feedid = $feedid;
        $model->save();
        $this->app->outputJSON($this->app, "Feed post liked");
    }  
    
    public function unlikeFeed($feedid)
    {
        $model = new feedLikeModel($this->app);     
        $model->feedid = $feedid;
        $model->delete();
        $this->app->outputJSON($this->app, "Feed post unliked");
    }     
 
    
}