
function proxy_path( mock ){
  return { proxy: 'mocks/' + mock, contentType: "text", cache: false };
}

// Just an example url callback test
function test_reports(request) {
  if(/sortDirection/.test(request)){
    return proxy_path('reports.reverse.json');
  } else {
    return proxy_path('reports.json');
  }
}

if(live){
  $.wufooAPI.defaultOptions.getterPath = "../";
}

// Setup our fake responses so a server is not needed
// for our tests

$.mockjax(function (request) {
  // Only handle requests from the API and only when
  // not in live mode
  if( request.url === 'getter.php' && !live ) {
    
    var url = request.data.url.replace(/^api\/v\d\//, ''),
    
    // Simulate an error by default
    ret = { responseCode: 404, responseText: "File not found" },
    
    /*
      Urls are a pair of a regex and either a string or function
      [regx, string|function]
      
      If a function, it will be called with one parameter, the request object
      If it is a string, it will be passed to proxy_path    
    */
    urls = [
      [/^users.json/, 'users.json'],
      [/^reports.json/, test_reports ],
      [/^reports\/m5p7k0.json/, 'report.json']
    ];

    $.each(urls, function(i, item) {
      if (item[0].test(url)) {
        if ($.isFunction(item[1])) {
          ret = item[1].call(this, request);
        } else {
          ret = proxy_path(item[1]);
        }
        return false; // Match was found, exit the $.each
      }
    });
    
    return ret;
    
  // Test blank responses
  } else if (/blank/.test(request.url)) {
    return {
      responseText: '',
      responseCode: 200,
      responseTime: 0
    };
    
  // Test invalid JSON
  } else if (/invalid/.test(request.url)) {
    return {
      responseText: '<!DOCTYPE html>',
      responseCode: 200,
      responseTime: 0
    };
  }
});




module('Errors');


  asyncTest('Empty Data should pass a NoDataError', function () {
    $.wufooAPI.getUsers({ getterPath: "blank/"}, function (data, error) {
      start();
      equals(false, data, "Data is false");
      equals(error, $.wufooAPI.errors.NoDataError, "NoDataError is passed.");
    });  
  });
  
  asyncTest('Invalid JSON should pass a InvalidJSON error', function () {
    $.wufooAPI.getUsers({ getterPath: "invalid/"}, function (data, error) {
      start();
      equals(false, data, "Data is false");
      equals(error.type, "InvalidJSON", "InvalidJSON error is passed.");
    });  
  });

module('Users');

  asyncTest('Valid user data returned by call to getUsers', function () {
    $.wufooAPI.getUsers(function (data) {
      start(); // Important for QUnit
      
      ok("Users" in data, "A top level Users key is returned as expected.");
      
      equals( data.Users.length, 2, "Two users returned.");
      equals( data.Users[0].User, "fishbowl", "Username returned");
      equals( data.Users[0].Email, "fishbowl@wufoo.com", "Email returned");
    });
  });
  
module('Reports');  
  
  asyncTest('Report summary is returned when no reportHash is supplied', function () {
    $.wufooAPI.getReports(function (data) {
      start(); // Important for QUnit
      
      ok("Reports" in data, "A top level Reports key is returned as expected.");
      
      equals( data.Reports.length, 2, "Two reports returned.");
      equals( data.Reports[0].Name, "Colors", "Report name returned");
      equals( data.Reports[0].Url, "colors", "Url returned");
      equals( data.Reports[0].Hash, "m5p7k0", "Hash returned");
    });
  });
  
  asyncTest('Report detail is returned when a reportHash is supplied', function () {
    $.wufooAPI.getReports( {reportHash: "m5p7k0"}, function (data) {
      start(); // Important for QUnit
      
      ok("Reports" in data, "A top level Report key is returned as expected.");
      
      equals( data.Reports.length, 1, "One reports returned.");
      
      equals( data.Reports[0].Name, "Colors", "Report name returned");
      equals( data.Reports[0].Url, "colors", "Url returned");
      equals( data.Reports[0].Hash, "m5p7k0", "Hash returned");
    });
  });

  
  