// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
angular.module('main', ['ionic', 'main.controllers', 'main.services', 'angularMoment', 'monospaced.elastic', 'ngCordova'])

.run(function($ionicPlatform, $rootScope) {
  $rootScope.endPoint = 'http://nightout.local/api/index.php';    
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider, $ionicConfigProvider) {
    $ionicConfigProvider.platform.android.views.transition('ios')
    $ionicConfigProvider.platform.android.tabs.style('standard');
    $ionicConfigProvider.platform.android.tabs.position('bottom');
    $ionicConfigProvider.platform.android.navBar.alignTitle('center');
    
  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  $stateProvider


  .state('login', {
    url: '/login',
          templateUrl: 'templates/login.html',
          controller: 'LoginCtrl'
  })



  .state('home', {
    url: '/home',
    views: {
      'home': {
        templateUrl: 'templates/home.html',
        controller: 'HomeCtrl'
      }
    }
  })

  .state('search', {
      url: '/search',
      views: {
        'search': {
          templateUrl: 'templates/search.html',
          controller: 'SearchCtrl'
        }
      }
    })
    
  .state('profile', {
    url: '/profile/:profileId',
    views: {
      'other': {
        templateUrl: 'templates/profile.html',
        controller: 'ProfileCtrl'
      }
    }
  })     
    
  .state('coupons', {
      url: '/coupons',
      views: {
        'coupons': {
          templateUrl: 'templates/coupons.html',
          controller: 'CouponsCtrl'
        }
      }
    })
    
  .state('coupons-detail', {
      url: '/coupons/:couponId',
      views: {
        'coupons': {
          templateUrl: 'templates/coupons-detail.html',
          controller: 'CouponsDetailCtrl'
        }
      }
    })    
    


  .state('location', {
    url: '/location',
    views: {
      'other': {
        templateUrl: 'templates/location.html',
        controller: 'LocationCtrl'
      }
    }
  })
  
  .state('account', {
    url: '/account',
    views: {
      'other': {
        templateUrl: 'templates/account.html',
        controller: 'AccountCtrl'
      }
    }
  })  
  
  .state('settings', {
    url: '/settings',
    views: {
      'other': {
        templateUrl: 'templates/settings.html',
        controller: 'SettingsCtrl'
      }
    }
  }) 
    
  


  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/login');

});

