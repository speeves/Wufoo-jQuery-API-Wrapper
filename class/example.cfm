<!--- 
You can choose to one or both of the following lines:
1. cfset cfcWufooGetter... is used when you want to make the calls using Coldfusion
2. cfajaxproxy is used if you want to use Javascript to get your Wufoo data
 --->
<!--- instantiate our wufoo getter library for CF object if we are using CF to display the data --->
<cfset cfcWufooGetter = CreateObject('component', 'Wufoo').init() />
<!--- setup our CF to JS proxy if we are handling the wufoo data with javascript --->
<cfajaxproxy cfc="Wufoo" jsclassname="w">

<!--- start our HTML --->
<html>
<head>
<!--- load jquery to ease life --->
<script type="text/javascript" src="/js/jquery/jquery-1.5.js"></script>
<script type="text/javascript">
// acquireEntires() is an example of using javascript to get your data 
function acquireEntries() 
{
    // instantiate the js object which proxies back to Wufoo.cfc
    var n = new w();
    // call makeCall() from Wufoo.cfc with the following params:
    //  1. the name or hash of the form you want to access
    //  2. cf or json. 
    //     - cf returns a coldfusion query
    //     - json returns a coldfusion version of json 
    // 
    //  makeCall() returns an array of form entries. 
    var x = n.makeCall( 'z7p8s7', 'json' );

    // Grab our div so that we can add our new data
    var mystring = $('#q');
    // loop through the array of entries, and print an entry header
    for ( var iter=0;iter<x.length;iter=iter+1 ) {
        mystring.append( '<h2>Entry ' + iter + '</h2>');
        // loop through the field title:value pairs for an entry
        for ( var iter2=0;iter2<x[iter].DATA.length;iter2=iter2+1 ) {
            mystring.append( '<strong>' + x[iter].DATA[iter2][0] + ':</strong> ' + x[iter].DATA[iter2][1] + '<br />');
       }
    }

    // push our modified HTML back into the DOM
    $("#q").text( mystring );
}
</script>
</head>
    
<body>
  <!--- This is simply to allow you to click on a button. Feels good, doesn't it?  --->
  <input type="submit" id="clickme" value="clickme" onClick="acquireEntries();" />
  <!--- Here is our empty div which will hold our title:value pairs --->
  <div id="q"></div> 


  <!--- This is simply a call using coldfusion, with a cfdump to show the array of entries --->
  <!--- 
  // call makeCall() from Wufoo.cfc with the following params:
  //  1. the name or hash of the form you want to access
  //  2. cf or json. 
  //     - cf returns a coldfusion query
  //     - json returns a coldfusion version of json 
  // 
  //  makeCall() returns an array of form entries. 
  --->
  <cfset x2 = cfcWufooGetter.makeCall( 'music-camp', 'cf' ) />
  <cfdump var='#x2#' /> 

   </body>
</html>
