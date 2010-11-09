<!DOCTYPE html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Wufoo API jQuery Plugin | Main Combo Example</title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
  	
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
  <script type='text/javascript' src='js/jquery.wufooapi.js'></script>
  <script type='text/javascript'>
    
    // DOM Ready
    $(function() {
      
      var current    = 0,
          i          = 0,
          globalData = "",
          trueIndex  = 0;
          
      function processEntries(data, num) {
        globalData = data; // Set variable to passed data so it can be passed again without lookup
        if (num == undefined) { num = 0; } // if called without specific entry, use the first
        i = 0; 
        
        // This currently doesn't account for the data object being empty (will error)
        
        $.each(globalData.Entries[num], function(fieldID, value) {
            $(".field-row-" + i).append(
              "<td class='data-cell'>" + value + "</td>"
            );
            i++;
        });
                  
        $("#display, .buttons").fadeIn();
      }

      function processFields(data) {

          trueIndex = 0; // Needed because of possibility that Fields have SubFields and requires sub-loop

          $.each(data.Fields, function(fieldsIndex, fieldsObject) {
                        
            if (fieldsObject.SubFields) {
              
                $.each(fieldsObject.SubFields, function(subFieldsIndex, subFieldsObject) {
                                                                          
                  $("<tr />", {
                    "class": "field-row-" + trueIndex
                  }).appendTo("#display");
                                    
                  $("<td />", {
                    "class": "title-cell",
                    "text": subFieldsObject.Label + " " + fieldsObject.Title
                  }).appendTo(".field-row-" + trueIndex);
                  
                  trueIndex++;

                });
                                
            } else {
              
              $("<tr />", {
                "class": "field-row-" + trueIndex
              }).appendTo("#display");
              
              $("<td />", {
                "class": "title-cell",
                "text": fieldsObject.Title
              }).appendTo(".field-row-" + trueIndex);
              
              trueIndex++;

            }

          });
          
          $.wufooAPI.getEntries({
           "formHash"     :    $("#allForms").val(),        
           "callback"     :    processEntries
          });
             
      };

      $(".prev-button").click(function() {
        if (current == 0) {
          alert("You are at the first entry.")
        } else {
          $(".data-cell").remove();
          current--;
          processEntries(globalData, current);
          $(".next-button").css("visibility", "visible");
          if (current == 0) {
            $(".prev-button").css("visibility", "hidden");
          }
        }
      });
      
      $(".next-button").click(function() {
        if (globalData.Entries.length == (current+1)) {
          alert("You are at the last entry.")
        } else {
          $(".data-cell").remove();
          current++;
          processEntries(globalData, current);
          $(".prev-button").css("visibility", "visible");
          if (globalData.Entries.length == (current+1)) {
            $(".next-button").css("visibility", "hidden");
          }
        }
      });
      
      function processForms(data) {
        
        // Fill dropdown will all returned forms
        $.each(data.Forms, function(formsIndex, formsObject) {
          
          $("<option />", {
            "val": formsObject.Hash,
            "text": formsObject.Name
          }).appendTo("#allForms");
          
        });
        
        $("#allForms").change(function() {
          
          // Reset All
          $("#display, .buttons").fadeOut(200, function(){
            $("#display").empty();
            $(".prev-button").css("visibility", "hidden");
            $(".next-button").css("visibility", "visible");
          })
          current = 0; i = 0; globalData = ""; trueIndex  = 0;
          
           // Get and process all fields for chosen form
           $.wufooAPI.getFields({
          		"formHash"     :    $(this).val(),          
          		"callback"     :    processFields   
          	});
        })
                
      }
      
      // Step 1: Get all forms, process (fill dropdown)      
      $.wufooAPI.getForms({
       "callback" : processForms 
      });
                  			
    });

  </script>
</head>

<body>
  
  <div id="page-wrap">
    
    <h1>Wufoo jQuery API Wrapper</h1>
    
    <ol>
        <li>Open config.php and enter your subdomain and API key</li>
        <li>Select a form: <select id="allForms">
          <option val="">Choose</option>
        </select>
    </ol>
    
    <div class="buttons">
      <a href="#" class="button prev-button">&larr; Previous</a>
      <a href="#" class="button next-button">Next &rarr;</a>
  	</div>
    
    <table id="display"> </table>
    
    <div class="buttons">
      <a href="#" class="button prev-button">&larr; Previous</a>
      <a href="#" class="button next-button">Next &rarr;</a>
  	</div>

  </div>
  
</body>

</html>