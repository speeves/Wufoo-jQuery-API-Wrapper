<!DOCTYPE html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Wufoo API jQuery Plugin | Example: Entries</title>
	
	<link rel='stylesheet' type='text/css' href='../css/style.css' />
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type='text/javascript' src='../js/jquery.wufooapi.js'></script>
  <script type='text/javascript'>
    
    $(function() {
      
      function processEntries(data) {
        
        $("<table />", {
          "id": "the-entries"
        }).appendTo("#page-wrap");
        $("#the-entries").wrap("<div style='width: 740px; overflow: auto; background: #eee; padding: 10px; margin: 10px 0;'></div>");
        
        $.each(data.Entries, function(entriesIndex, entriesObject) {
                    
          $("<tr />", {
            "id": "field-row-" + entriesIndex
          }).appendTo("#the-entries");
          
          var i = 0;
                              
          $.each(entriesObject, function(fieldID, value) {
              $("#field-row-" + i).append(
                "<td style='padding: 3px;'>" + value + "</td>"
              );
              i++;
          });
          
        });
      };
            
      $.wufooAPI.getEntries({
        "callback"   : processEntries,
        "formHash"   : "w7x1p5",
        "getterPath" : "../"
        
        // FILTER EXAMPLE
        // ,
        // "filter"     : [ 
        //   [ "EntryId", "Is_before", "200"],
        //   [ "Field6", "Does_not_contain", "harpoon"]
        // ]
        // ,
        // "match"      : "OR"
        
        // PAGING EXAMPLE
        // ,
        // "page"      : [2, 10] 
        
        // SORTING EXAMPLE
        // ,
        // "sortID"         : "EntryID",
        // "sortDirection"  : "DESC"
      });
      
      
      // Report Example
      
      // $.wufooAPI.getEntries({
      //   "callback" : processEntries,
      //   "reportHash" : "m5p7k0",
      //   "getterPath": "../"
      // });
                  			
    });

  </script>
</head>

<body>
  
  <div id="page-wrap">
    
    <h1>Wufoo jQuery API Wrapper</h1>
    <h2>Example: Entries</h2>
    <p>In this particular application of the Entries API, you'd probably want to pair it with the Fields API to header the table properly.</p>

  </div>
  
</body>

</html>