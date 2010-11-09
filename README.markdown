### Wufoo jQuery API Plugin

The Wufoo jQuery API plugin is meant to help make working with the Wufoo API easier for jQuery developers. It doesn't do anything that working directly with the API can't do, it just provides an abstraction layer making getting the information you need easier.

### Config

The download comes with a file called config.php. Within this file you'll need to enter your Wufoo username and Wufoo API key. Your username is is the subdomain you have on Wufoo when logged in, like fishbowl.wufoo.com. The API you can find by going under the Forms tab, hovering over a form, clicking the Code button, then clicking the API information button.

This is done because the actual API request is done through the `getter.php` file, so that your API can remain protected. You could use JavaScript AJAX methods to use the API directly, but your API key wouldn't be protected that way.

### Basics

The plugin is a collection of functions each for using a specific API. For example, this is how you would get data on your account's users:

    $.wufooAPI.getUsers({
       "callback" : processUsers
    });
    
At a minimum, each calling the function needs the `callback` parameter. This is a function of your own creation which will deal with the data object it gets back. The data object is essentially the JSON that the API returns. The function below would take that data and loop through each user adding the name and email of it to an unordered list.

    function processUsers(data) {
      
      $("<ol />", {
        "id": "allUsers"
      });
  
      $.each(data.Users, function(i, usersObject) {
        $("<li />", {
          "text": usersObject.User + " (" + usersObject.Email + ")"
        }).appendTo("#allUsers");
      });
      
    }
    
Some APIs need more information to be able to return the information they are supposed to. For example, the Entries API needs to know what form to return data from. Each will be documented below.
    
### Full API Documentation

Available here: http://wufoo.com/docs/api/v3/users/

Each API returns it's own set of specific information which is all documented on Wufoo.com for reference.
    
### Users

Information about all users:

    $.wufooAPI.getUsers({
      "callback"   : processUsers,      // Callback to process data
      "getterPath" : "../"              // Path to getter.php
    });
    
Full documentation: http://wufoo.com/docs/api/v3/users/

### Forms

Information about all forms:

    $.wufooAPI.getForms({
      "callback"   : processForms,      // Callback to process data
      "getterPath" : "../"              // Path to getter.php
    });
    
Information about a specific form:

    $.wufooAPI.getForms({
      "callback"   : processForms,       // Callback to process data
      "getterPath" : "../",              // Path to getter.php
      "formHash"   : "x7x7x7"            // Hash of specific form
    });

Full documentation: http://wufoo.com/docs/api/v3/forms/

### Entries

Entries from a form:

    $.wufooAPI.getEntries({
      "callback"   : processEntries,    // Callback to process data
      "getterPath" : "../",             // Path to getter.php
      "formHash"   : "m7x3r3",          // Hash of specific form
      "system"     : false              // Return system fields or not
    });
        
Entries from a report:

    $.wufooAPI.getEntries({
      "callback"     : processEntries,    // Callback to process data
      "getterPath"   : "../",             // Path to getter.php
      "reportHash"   : "m7x3r3",          // Hash of specific form
      "system"       : false              // Return system fields or not
    });

Full documentation: http://wufoo.com/docs/api/v3/entries/

### Fields

Fields of a form:

    $.wufooAPI.getFields({
      "callback"   : processFields,     // Callback to process data
      "getterPath" : "../",             // Path to getter.php
      "formHash"   : "r7x2s9",          // Hash of specific form
      "system"     : false              // Return system fields or not
    });
    
Fields of a report:

    $.wufooAPI.getFields({
      "callback"   : processFields,     // Callback to process data
      "getterPath" : "../",             // Path to getter.php
      "reportHash" : "m5p7k0",          // Hash of specific report
      "system"     : false              // Return system fields or not
    });

Bear in mind that fields may have `SubFields`, as is the case when using Wufoo-provided fields like Name, which has First and Last as subfields. Testing for SubFields and looping through those within the main loop while processing the data is a good idea.

Full documentation: http://wufoo.com/docs/api/v3/fields/

### Comments

Comments are entered in the Wufoo.com Entry Manager. 

Get the number of comments for a form:

    $.wufooAPI.getComments({
      "callback"            : processCommentCount,     // Callback to process data
      "getterPath"          : "../",                   // Path to getter.php
      "formHash"            : "w7x1p5",                // Hash of a specific form
      "getCommentCount"     : true                     // TRUE will return the comment count only
    });
    
Get comments from a form:

    $.wufooAPI.getComments({
      "callback"   : processComments,     // Callback to process data
      "getterPath" : "../",               // Path to getter.php
      "formHash"   : "w7x1p5",            // Hash of a specific form
      "page"       : [0, 50]              // Array - [#, #] - [pageStart, pageCount] - So [0, 100] means start at the first comment and return 100 
      "entryID"    : 143                  // ID of specific comment to return
    });
    
Full documentation: http://wufoo.com/docs/api/v3/comments/
    
### Reports

Information about all forms:

    $.wufooAPI.getReports({
      "callback"    : processReports,     // Callback to process data
      "getterPath"  : "../"               // Path to getter.php
    });

Information about single form:

    $.wufooAPI.getReports({
      "callback"    : processReports,     // Callback to process data
      "getterPath"  : "../",              // Path to getter.php
      "reportHash"  : "m5p7k0"            // Hash of a specific report
    });
    
Full documentation: http://wufoo.com/docs/api/v3/reports/
    
### To Do

- Suppport POSTing new entries (with uploads?)
- More robust testing
- Web Hooks API
- Log in API (restricted)