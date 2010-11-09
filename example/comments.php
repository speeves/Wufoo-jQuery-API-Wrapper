<!DOCTYPE html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Wufoo API jQuery Plugin | Example: Comments</title>
	
	<link rel='stylesheet' type='text/css' href='../css/style.css' />
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type='text/javascript' src='../js/jquery.wufooapi.js'></script>
  <script type='text/javascript'>
    
    $(function() {
      
      function processCommentCount(data) {
        $("<p />", {
          text: "There are " + data.Count + " comments."
        }).appendTo("#page-wrap");
      }
      
      function processComments(data) {
        
        $("<ol />", {
          "id": "allComments"
        }).appendTo("#page-wrap");

        $.each(data.Comments, function(i, commentsObject) {
                    
          $("<li />", {
            "text": commentsObject.Text
          }).appendTo("#allComments");
          
        });
      }
      
      $.wufooAPI.getComments({
        "callback"            : processCommentCount,
        "getterPath"          : "../",
        "formHash"            : "w7x1p5",
        "getCommentCount"     : true
      });
            
      $.wufooAPI.getComments({
        "callback"   : processComments,
        "formHash"   : "w7x1p5",
        "getterPath" : "../",
        "page"       : [0, 20] 
        
        // ,
        // "entryID"    : 143
      });
                  			
    });

  </script>
</head>

<body>
  
  <div id="page-wrap">
    
    <h1>Wufoo jQuery API Wrapper</h1>
    <h2>Example: Comments</h2>

  </div>
  
</body>

</html>