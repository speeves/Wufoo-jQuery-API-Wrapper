<!DOCTYPE html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Wufoo API jQuery Plugin | Example: Users</title>
	
	<link rel='stylesheet' type='text/css' href='../css/style.css' />
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type='text/javascript' src='../js/jquery.wufooapi.js'></script>
  <script type='text/javascript'>
    
    $(function() {
      
      function processUsers(data) {
        $("<ol />", {
          "id": "allUsers"
        }).appendTo("#allUsersWrap");
        
        $.each(data.Users, function(usersIndex, usersObject) {
          $("<li />", {
            "text": usersObject.User + " (" + usersObject.Email + ")" // more stuff in the object
          }).appendTo("#allUsers");
        });
      }
      
      $.wufooAPI.getUsers({
       "callback" : processUsers,
       "getterPath": "../"
      });
                  			
    });

  </script>
</head>

<body>
  
  <div id="page-wrap">
    
    <h1>Wufoo jQuery API Wrapper</h1>
    <h2>Example: Users</h2>
    
    <h3>All users on this account:</h3>
    
    <div id="allUsersWrap"></div>

  </div>
  
</body>

</html>