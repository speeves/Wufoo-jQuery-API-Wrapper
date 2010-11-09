<!DOCTYPE html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Wufoo API jQuery Plugin | Example: Reports</title>
	
	<link rel='stylesheet' type='text/css' href='../css/style.css' />
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type='text/javascript' src='../js/jquery.wufooapi.js'></script>
  <script type='text/javascript'>
    
    $(function() {
      
      function processReports(data) {
        $("<ol />", {
          "id": "allReports"
        }).appendTo("#page-wrap");
        
        $.each(data.Reports, function(i, reportsObject) {
          $("<li />", {
            "text": reportsObject.Name
          }).appendTo("#allReports");
        });
      }
      
      $.wufooAPI.getReports({
        "callback"    : processReports,
        "getterPath"  : "../"
        // ,
        // "reportHash"  : "m5p7k0"
      });
                  			
    });

  </script>
</head>

<body>
  
  <div id="page-wrap">
    
    <h1>Wufoo jQuery API Wrapper</h1>
    <h2>Example: Reports</h2>
    
    <h3>All reports on this account:</h3>
    
  </div>
  
</body>

</html>