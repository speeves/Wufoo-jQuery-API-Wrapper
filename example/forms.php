<!DOCTYPE html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Wufoo API jQuery Plugin | Example: Forms</title>
	
	<link rel='stylesheet' type='text/css' href='../css/style.css' />
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type='text/javascript' src='../js/jquery.wufooapi.js'></script>
  <script type='text/javascript'>
    
    $(function() {
      
      function processForms(data) {
        $("<ol />", {
          "id": "allForms"
        }).appendTo("#allFormsWrap");
        
        $.each(data.Forms, function(formsIndex, formsObject) {
          $("<li />", {
            "text": formsObject.Name
          }).appendTo("#allForms");
        });
      }
      
      $.wufooAPI.getForms({
        "callback" : processForms,
        "getterPath": "../"
      });
                  			
    });

  </script>
</head>

<body>
  
  <div id="page-wrap">
    
    <h1>Wufoo jQuery API Wrapper</h1>
    <h2>Example: Forms</h2>
    
    <h3>All forms on this account:</h3>
    
    <div id="allFormsWrap"></div>

  </div>
  
</body>

</html>