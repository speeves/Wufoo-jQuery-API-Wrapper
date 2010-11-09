<!DOCTYPE html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Wufoo API jQuery Plugin | Example: Fields</title>
	
	<link rel='stylesheet' type='text/css' href='../css/style.css' />
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type='text/javascript' src='../js/jquery.wufooapi.js'></script>
  <script type='text/javascript'>
    
    $(function() {
      
      function processFields(data) {
                
        $("<ol />", {
          "id": "allFields"
        }).appendTo("#page-wrap");
        
        var trueIndex = 0;
        
        $.each(data.Fields, function(i, fieldsObject) {
          
          $("<li />", {
            "text" : fieldsObject.Title,
            "id"   : "field-top-" + trueIndex
          }).appendTo("#allFields");
          
          if (fieldsObject.SubFields) {
            
            $("<ol />", {
              "id"   : "field-bottom-" + trueIndex
            }).appendTo("#field-top-" + trueIndex);
            
            $.each(fieldsObject.SubFields, function(i, subFieldsObject) {
                                                                      
              $("<li />", {
                "class": "title-cell",
                "text": subFieldsObject.Label
              }).appendTo("#field-bottom-" + trueIndex);
              
            });
                              
          } else {
            
            $("<li />", {
              "class": "title-cell",
              "text": fieldsObject.Label
            }).appendTo("#field-bottom-" + trueIndex);
            
          }
          
          trueIndex++;
          
        });
      }
      
      $.wufooAPI.getFields({
        "callback"   : processFields,
        "getterPath" : "../",
        "formHash"   : "w7x1p5"
      });
      
     // Reports Example
     
     // $.wufooAPI.getFields({
     //    "callback"   : processFields,
     //    "getterPath" : "../",
     //    "reportHash" : "m5p7k0"
     //  });
                			
    });

  </script>
</head>

<body>
  
  <div id="page-wrap">
    
    <h1>Wufoo jQuery API Wrapper</h1>
    <h2>Example: Fields</h2>
    
    <h3>All fields on this form:</h3>

  </div>
  
</body>

</html>