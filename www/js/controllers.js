angular.module('starter.controllers', [])

.controller('HomeCtrl', function($scope, feed) {
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
  
  
  
.controller('NavCtrl', function($scope, $ionicSideMenuDelegate) {
  $scope.toggleLeft = function() {
    $ionicSideMenuDelegate.toggleLeft();
  };
})
