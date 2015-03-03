angular.module('starter.services', [])

.factory('feed', function() {
  // Might use a resource here that returns a JSON array

  // Some fake testing data
  var data = [{
    id: 0,
    name: 'Ben Sparrow',
    lastText: 'You on your way?',
    face: 'https://pbs.twimg.com/profile_images/514549811765211136/9SgAuHeY.png'
  }, {
    id: 1,
    name: 'Max Lynx',
    lastText: 'Hey, it\'s me',
    face: 'https://avatars3.githubusercontent.com/u/11214?v=3&s=460'
  }, {
    id: 2,
    name: 'Andrew Jostlin',
    lastText: 'Did you get the ice cream?',
    face: 'https://pbs.twimg.com/profile_images/491274378181488640/Tti0fFVJ.jpeg'
  }, {
    id: 3,
    name: 'Adam Bradleyson',
    lastText: 'I should buy a boat',
    face: 'https://pbs.twimg.com/profile_images/479090794058379264/84TKj_qa.jpeg'
  }, {
    id: 4,
    name: 'Perry Governor',
    lastText: 'Look at my mukluks!',
    face: 'https://pbs.twimg.com/profile_images/491995398135767040/ie2Z_V6e.jpeg'
  }];

  return {
    all: function() {
      return data.sort(function(a, b){
                var keyA = a.id,
                keyB = b.id;
                // Compare the 2 dates
                if(keyA < keyB) return 1;
                if(keyA > keyB) return -1;
                return 0;
        });
    },
    insert: function(newData){
      var index = data.length;
      data.push({
          id: index,
          name: newData.name,
          lastText: newData.lastText,
          face: newData.face
      })
    },
    remove: function(chat) {
      data.splice(data.indexOf(chat), 1);
    },
    get: function(chatId) {
      for (var i = 0; i < data.length; i++) {
        if (data[i].id === parseInt(chatId)) {
          return data[i];
        }
      }
      return null;
    }    
  };
})

/**
 * A simple example service that returns some data.
 */
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
