angular.module('main.controllers', [])

.controller('LoginCtrl', function($scope, $rootScope, $window, $location, $ionicModal, authenticate, user) {

    $scope.init = function(){

        $scope.user = {
            'username' : '',
            'password' : ''
        }
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
  

  
.controller('HomeCtrl', function($scope, $cordovaCamera, feed) {
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
          $scope.imgURI = "data:image/jpeg;base64," + imageData;
        }, function(err) {
          // error
        });

      }
      
      
    $scope.feed = feed.all();
    
    $scope.refresh = function(){
        feed.insert({
            name: 'New insert',
            lastText: 'Look at my mukluks!',
            face: 'https://pbs.twimg.com/profile_images/491995398135767040/ie2Z_V6e.jpeg'            
        });
        $scope.feed = feed.all();
        $scope.$broadcast("scroll.refreshComplete")
    }
    
    $scope.$on('userRetrieved', function(event, args) {
        $scope.user = args;
    });  
    
    
      
    
})

.controller('SearchCtrl', function($scope) {
  
  $scope.settings = {
    enableFriends: true
  }
  }) 
  
  
.controller('ProfileCtrl', function($scope, $stateParams, feed) {
   
  $scope.chat = feed.get($stateParams.chatId);
  
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
  
.controller('ModalCtrl', function($scope, $ionicModal) {
    // Load the modal from the given template URL
    $ionicModal.fromTemplateUrl('templates/purchase.html', function($ionicModal) {
        $scope.modal = $ionicModal;
    }, {
        // Use our scope for the scope of the modal to keep it simple
        scope: $scope,
        // The animation we want to use for the modal entrance
        animation: 'slide-in-up'
    });   
  })
  
  
  
.controller('NavCtrl', function($scope, $rootScope, $ionicSideMenuDelegate, $location, authenticate, user) {

    $scope.init = function(){
        
        if ($location.path() !== "login"){$scope.login = true;}
        
        $scope.user = {
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
