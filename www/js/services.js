angular.module('main.services', [])


.service('authenticate', function authenticate($http, $q, $rootScope){
    var authenticate = this;
    authenticate.user = {};
    
    authenticate.login = function(username, password){
        var defer = $q.defer();
        
        $http.get($rootScope.endPoint + "/login/" + username + "/" + password)
        .success(function(response){
            authenticate.user = response;
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;
    };
    
    
    authenticate.logout= function(){
        var defer = $q.defer();
        
        $http.get($rootScope.endPoint + "/logout")
        .success(function(response){
            authenticate.user = {};
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;
    }; 
    

    
    
})


.service('user', function authenticate($http, $q, $rootScope){
    
    var user = this;
    user.user = {};
    
    user.register = function(newUser){
        console.log(newUser);
        var defer = $q.defer();
        
        $http.post($rootScope.endPoint + "/user",newUser)
        .success(function(response){
            user.user = response;
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;
    };
    
    user.get = function(){
        var defer = $q.defer();
        
        $http.get($rootScope.endPoint + "/user")
        .success(function(response){
            user.user = response;
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;
    };   
    
    

    
    
})




.factory('feed', function($rootScope, $q, $http) {
  return {
    all: function(){
        var defer = $q.defer();
        
        $http.get($rootScope.endPoint + "/feed")
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;
    },
    like: function(id){
        var defer = $q.defer();
        
        $http.post($rootScope.endPoint + "/feed/like/" + id)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;        
    },
    unlike: function(id){
        var defer = $q.defer();
        
        $http.delete($rootScope.endPoint + "/feed/unlike/" + id)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;        
    },  
    insertComment: function(comment){
      var defer = $q.defer();
        
        $http.post($rootScope.endPoint + "/feed/comment", comment)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;  
    },    
    updateComment: function(comment){
      var defer = $q.defer();     
        $http.put($rootScope.endPoint + "/feed/comment/" + comment.id, comment)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;  
    },  
    removeComment: function(id){
      var defer = $q.defer();

        $http.delete($rootScope.endPoint + "/feed/comment/" + id)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;  
    },     
    insert: function(newFeed){
      var defer = $q.defer();
        
        $http.post($rootScope.endPoint + "/feed", newFeed)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;  
    },
    update: function(feed){
      var defer = $q.defer();
        
        $http.put($rootScope.endPoint + "/feed/" + feed.id, feed)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;  
    },    
    remove: function(id) {
      var defer = $q.defer();
        
        $http.delete($rootScope.endPoint + "/feed/" + id)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;  
    },
    get: function(id) {
        var defer = $q.defer();
        
        $http.get($rootScope.endPoint + "/feed/" + id)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;
    }    
  };
})

/**
 * A simple example service that returns some data.
 */
.factory('profile', function($q, $http, $rootScope) {


  return {
    all: function() {
      return [];
    },
    get: function(id) {
        var defer = $q.defer();
        
        $http.get($rootScope.endPoint + "/profile/" + id)
        .success(function(response){
            defer.resolve(response);
        })
        .error(function(error,status){
            defer.reject(error);
        });
        
        return defer.promise;
    }
    
  }
})


.factory('Coupons', function() {
  // Might use a resource here that returns a JSON array

  // Some fake testing data
  var data = [{
    id: 0,
    name: 'Ben Sparrow',
    notes: 'Enjoys drawing things',
    face: 'https://pbs.twimg.com/profile_images/514549811765211136/9SgAuHeY.png'
  }, {
    id: 1,
    name: 'Max Lynx',
    notes: 'Odd obsession with everything',
    face: 'https://avatars3.githubusercontent.com/u/11214?v=3&s=460'
  }, {
    id: 2,
    name: 'Andrew Jostlen',
    notes: 'Wears a sweet leather Jacket. I\'m a bit jealous',
    face: 'https://pbs.twimg.com/profile_images/491274378181488640/Tti0fFVJ.jpeg'
  }, {
    id: 3,
    name: 'Adam Bradleyson',
    notes: 'I think he needs to buy a boat',
    face: 'https://pbs.twimg.com/profile_images/479090794058379264/84TKj_qa.jpeg'
  }, {
    id: 4,
    name: 'Perry Governor',
    notes: 'Just the nicest guy',
    face: 'https://pbs.twimg.com/profile_images/491995398135767040/ie2Z_V6e.jpeg'
  }];


  return {
    all: function() {
      return data;
    },
    get: function(friendId) {
      // Simple index lookup
      return data[friendId];
    }
  }
});

