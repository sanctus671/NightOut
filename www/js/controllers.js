angular.module('main.controllers', [])

.controller('LoginCtrl', function($scope, $rootScope, $window, $location, $ionicModal, authenticate, user) {

    $scope.init = function(){

        $scope.user = {
            'username' : '',
            'password' : ''
        };
        $scope.login.error = '';
        
        //$scope.login('onlytocheckif', 'userisalreadyloggedin');
        
        $scope.register.error = '';       
        $scope.newUser = {
            'username':'',
            'email' : '',
            'password' : '',
            'password2':''
        };              
        
    };
    
    $scope.login = function(){ 
        authenticate.login($scope.user.username, $scope.user.password)
        .then(
        function(response){
            //success
            $scope.error = '';
            $location.path( "/home" );
            $window.location.reload();	
            
        },
        function(error){
            
            if (error.error === "Already logged in"){
                $location.path( "/home" );
                $window.location.reload();

            }
            $scope.login.error = error.error;
        });
    };
    

    $scope.register = function(){
        if ($scope.newUser.password !== $scope.newUser.password2){
            $scope.register.error = "Passwords didn't match";
            return;
        }
        user.register($scope.newUser)
        .then(
        function(response){
            //success
            $scope.modal.hide();
            $scope.register.error = '';
            $scope.newUser = {
            'username':'',
            'email' : '',
            'password' : '',
            'password2':''
            };  
            $location.path( "/home" );
            $window.location.reload();
            
        },
        function(error){
            $scope.register.error = error.error;
        });
    }; 
    



    $ionicModal.fromTemplateUrl('templates/register.html', 
    {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    }).then(function(modal) {
        $scope.modal = modal;
    });
    
    
    
    $scope.init();
  }) 
  

  
.controller('HomeCtrl', function($scope, $cordovaCamera, $rootScope, $ionicModal, feed) {
    
    $scope.init = function(){
        $scope.feeds = [];
        feed.all().then(
                function(response){
                    $scope.feeds = response.data;
                    for (var index in $scope.feeds){
                        for (var index2 in $scope.feeds[index]["likes"]){
  
                            if ($scope.feeds[index]["likes"][index2]["userid"] === $scope.user.id){
                                $scope.feeds[index]["liked"] = true;
                            }
                        }
                    }
                    
            });        
        $scope.newFeed = {
            text: "",
            image: ""
        };
    };

        
    $rootScope.$on('userRetrieved', function(event, args) {
        $scope.user = args;
    });      
    
    $rootScope.$on("feedsChanged", function(event, args) {
        $scope.refresh();
    });          
        

    $scope.refresh = function(){
        feed.all().then(
            function(response){
                $scope.feeds = response.data;
                for (var index in $scope.feeds){
                    for (var index2 in $scope.feeds[index]["likes"]){
                        if ($scope.feeds[index]["likes"][index2]["userid"] === $scope.user.id){
                            $scope.feeds[index]["liked"] = true;
                        }
                    }
                }                
        });

        //$scope.feed = feed.all();
        $scope.$broadcast("scroll.refreshComplete");
    };    

    $scope.addFeed = function(){
        feed.insert($scope.newFeed).then(
            function(response){
                $scope.refresh();
        });
    };    
    
    
    $scope.likeFeed = function(id){
        feed.like(id).then(
            function(response){
                $scope.refresh();
        });
    };
    
    $scope.unlikeFeed = function(id){
        feed.unlike(id).then(
            function(response){
                $scope.refresh();
        });
    };   
    
    
    
    
    $scope.takePicture = function(){

        var options = {
          quality: 50,
          destinationType: Camera.DestinationType.DATA_URL,
          sourceType: Camera.PictureSourceType.CAMERA,
          allowEdit: true,
          encodingType: Camera.EncodingType.JPEG,
          targetWidth: 300,
          targetHeight: 300,
          popoverOptions: CameraPopoverOptions,
          saveToPhotoAlbum: false
        };

        $cordovaCamera.getPicture(options).then(function(imageData) {
          $scope.newFeed.image = "data:image/jpeg;base64," + imageData;
        }, function(err) {
          // error
        });

      }
      

    
    $scope.init();
    
    
      
    
})

.controller('feedCtrl', function($scope, $ionicModal, $rootScope, feed) {
    // Load the modal from the given template URL
    
    $scope.init = function(){
        $scope.feed = [];
        $scope.newComment = {
            feedid:"",
            comment:""
        };
        $scope.showComment = true;
    }
    
    $ionicModal.fromTemplateUrl('templates/comment.html', function($ionicModal) {
        $scope.commentModal = $ionicModal;
    }, {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    }); 
    
    $ionicModal.fromTemplateUrl('templates/edit-feed.html', function($ionicModal) {
        $scope.editModal = $ionicModal;
    }, {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    });  
    
    $ionicModal.fromTemplateUrl('templates/delete-feed.html', function($ionicModal) {
        $scope.deleteModal = $ionicModal;
    }, {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    });  
    
    
    $scope.getFeed = function(id){
        feed.get(id).then(
            function(response){
                $scope.feed = response.data;
                for (var index in $scope.feed["likes"]){
                    if ($scope.feed["likes"][index]["userid"] === $scope.user.id){
                        $scope.feed["liked"] = true;
                    }
                }
                $scope.newComment.feedid = $scope.feed.id;
            }); 
            
    }
    
    $scope.saveFeed = function(){
        feed.update($scope.feed).then(
            function(response){
                $scope.editModal.hide();
            });         
    } 
    
    $scope.deleteFeed = function(id){
        feed.remove($scope.feed.id).then(
            function(response){
                $scope.deleteModal.hide();
            });         
    }  
    
    $scope.saveComment = function(){
        feed.insertComment($scope.newComment).then(
            function(response){
                $scope.refresh();
                //$rootScope.$broadcast("feedsChanged");
                $scope.newComment.comment = "";                
                

            });         
    } 
    
    $scope.updateComment = function(comment){
        feed.updateComment(comment).then(
            function(response){
                $scope.refresh();              
                

            });         
    }   
    $scope.deleteComment = function(id){
        feed.removeComment(id).then(
            function(response){
                $scope.refresh();              
                

            });         
    }    
    $rootScope.$on('userRetrieved', function(event, args) {
        $scope.user = args;
    });     
    
    $scope.$on('modal.hidden', function(event, args) {
        $rootScope.$broadcast("feedsChanged");
    });     
    
    
    $scope.refresh = function(){
        feed.get($scope.feed.id).then(
            function(response){
                $scope.feed = response.data;
                for (var index in $scope.feed["likes"]){
                    if ($scope.feed["likes"][index]["userid"] === $scope.user.id){
                        $scope.feed["liked"] = true;
                    }
                }
            });       
            $scope.$broadcast("scroll.refreshComplete");
    };
    
    
    
    $scope.init();
  })



.controller('SearchCtrl', function($scope) {
  
  $scope.settings = {
    enableFriends: true
  };
  }) 
  
  
.controller('ProfileCtrl', function($scope, $rootScope, $stateParams, $ionicModal, profile, feed, user) {
    
    
    $scope.init = function(){
        
        //get profile data
        $scope.profile = [];
        $scope.feeds = [];
        $scope.reviews = [];
        $scope.products = [];
        
        if (!$scope.user){
            $scope.user = [];
        }
        
        
        $scope.selectedTab = 'feed';
        profile.get($stateParams.profileId).then(
            function(response){
                $scope.profile = response.data;
                console.log($scope.profile);
                $scope.feeds = $scope.profile.feeds;
                $scope.reviews = $scope.profile.reviews;
                $scope.products = $scope.profile.products;
                
                for (var index in $scope.feeds){
                    for (var index2 in $scope.feeds[index]["likes"]){

                        if ($scope.feeds[index]["likes"][index2]["userid"] === $scope.user.id){
                            $scope.feeds[index]["liked"] = true;
                        }
                    }
                }                
            });             
            
    }
    
    
    $rootScope.$on('userRetrieved', function(event, args) {
        
        $scope.user = args;
        console.log("herer");
    });  
    
     
    
    $rootScope.$on("feedsChanged", function(event, args) {
        $scope.refresh();
    });    
    
    
    $scope.refresh = function(){
        profile.get($stateParams.profileId).then(
            function(response){
                $scope.profile = response.data;
                $scope.feeds = $scope.profile.feeds;
                $scope.reviews = $scope.profile.reviews;
                $scope.products = $scope.profile.products;
                
                for (var index in $scope.feeds){
                    for (var index2 in $scope.feeds[index]["likes"]){

                        if ($scope.feeds[index]["likes"][index2]["userid"] === $scope.user.id){
                            $scope.feeds[index]["liked"] = true;
                        }
                    }
                } 
                
                $scope.$broadcast("scroll.refreshComplete");
            });         
      
    };
    

    
    $scope.likeFeed = function(id){
        feed.like(id).then(
            function(response){
                $scope.refresh();
        });
    };
    
    $scope.unlikeFeed = function(id){
        feed.unlike(id).then(
            function(response){
                $scope.refresh();
        });
    };   
    
 

        
    
    
    
    $scope.init();
  
})




.controller('CouponsCtrl', function($scope, feed) {

  $scope.chats = feed.all();
  $scope.remove = function(chat) {
    feed.remove(chat);
  }
})

.controller('CouponsDetailCtrl', function($scope, $stateParams, feed) {

  $scope.chat = feed.get($stateParams.chatId);
})


.controller('LocationCtrl', function($scope) {
  
  $scope.settings = {
    enableFriends: true
  }
  })


.controller('AccountCtrl', function($scope) {
  $scope.settings = {
    enableFriends: true
  }
  })
  

  
  
.controller('SettingsCtrl', function($scope) {
  $scope.settings = {
    enableFriends: true
  }
  })
  
  
.controller('ReviewCtrl', function($scope, $ionicModal) {
 
    
    $ionicModal.fromTemplateUrl('templates/new-review.html', function($ionicModal) {
        $scope.newModal = $ionicModal;
    }, {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    });    
  })  
  
.controller('ProductCtrl', function($scope, $ionicModal) {
    
    
    $scope.init = function(){
        $scope.newProduct = {
            image: '',
            name: '',
            description: '',
            price: '',
            payment_method: 'cash',
            redemption_method: 'display'
           
        };
        
        if (!$scope.user){
            $scope.user = [];
        }        
       
    }    
    
    
    // Load the modal from the given template URL
    $ionicModal.fromTemplateUrl('templates/purchase.html', function($ionicModal) {
        $scope.modal = $ionicModal;
    }, {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    });  
    
    $ionicModal.fromTemplateUrl('templates/new-product.html', function($ionicModal) {
        $scope.newModal = $ionicModal;
    }, {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    });  
    
    
    $scope.$on('userRetrieved', function(event, args) {
        $scope.user = args;
    });  
    
    $scope.init(); 
  })
  
  
  
.controller('NavCtrl', function($scope, $rootScope, $ionicSideMenuDelegate, $location, authenticate, user) {

    $scope.init = function(){
        
        if ($location.path() !== "login"){$scope.login = true;}
        
        $scope.user = {
            'id' : '',
            'username':'',
            'email' : '',
            'password' : '',
            'profileid':''
            
        };  

        if ($scope.login === true){
            $scope.getUser();   
        }
       
    }

    $scope.$on('userRetrieved', function(event, args) {
        $scope.user = args;
    });      
    
    
    $scope.toggleLeft = function() {
    $ionicSideMenuDelegate.toggleLeft();
    };
    
    $scope.getUser = function(){
        user.get()
        .then(
        function(response){
            //success
            $scope.user = response.data[0];
            $rootScope.$broadcast('userRetrieved', $scope.user);          
        },
        function(error){
            console.log(error);
        });
    };  
    
    
    
    $scope.logout = function(){
        authenticate.logout()
        .then(
        function(response){
            //success
            $location.path( "/login" );

        },
        function(error){
            console.log(error);
            $location.path( "/login" );
        });
    }; 
    
    $scope.init();
  
})
