(function ($) {

  $.wufooAPI = (function () {
    // Private
    
    var base_url = "api/v3/",
    
    prepare_options = function (options, callback) {
      // If only callback is passed
      if ($.isFunction(options)) {
        options = {callback: options};
      }
      
      options = $.extend({}, $.wufooAPI.defaultOptions, options);
      
      // If both options and callback are passed in
      if ($.isFunction(callback)) {
        options.callback = callback;
      }
      
      return options;
    },
    
    parameters = function (options) {
      var params = {};

      if (options.entryID !== "") {
        params.entryId = options.entryID;
      }

      if (options.sortDirection !== "") {
        params.sort = options.sortID;
        params.sortDirection = options.sortDirection;
      }

      if (options.page !== "") {
        params.pageStart = options.page[0];
        params.pageSize  = options.page[1];
      }

      if (options.filter.length) {
        $.each(options.filter, function (index, values) {
          params["Filter" + (index + 1)] = values.join(' ');
        });
        if (options.match) params["match"] = options.match;
      }

      if (options.system !== "") {
        params.system = options.system;
      }
      
      return $.param(params);
    },
    
    get = function (url, options) {
      
      var params = parameters(options);
      
      url = base_url + url; // Add base prefix
      
      if (params.length) {
        url = [url, params].join('?'); // Add parameters if present
      }
      
      $.get(options.getterPath + 'getter.php', {url: url}, function (data) {
        if (!data) {
          // Wufoo will probably never do this to you
          options.callback(false, $.wufooAPI.errors.NoDataError);
          return;
        }
        
        try {
          options.callback(jQuery.parseJSON(data));
        } catch (e) {
          options.callback(false, new $.wufooAPI.errors.InvalidJSON(e));
        }
      }, "text");
    };
    
    // Public
    
    return {
      defaultOptions: {
        formHash: "",                    // Hash of form - Forms tab, Code button, API Information button
        reportHash: "",                  // Hash of report (KIND OF HARD TO FIND)
        entryID: "",                     // When using an API that needs to refernce a specific entry
        getCommentCount: false,          // TRUE will return comment count when using Comments function / API
        filter: "",                      // Array of arrays. [ ["", "", ""], ["", "", ""] ]
        match: "AND",                    // For filtering, determine if multiple filters should be AND or OR logic-ized
        page: "",                        // Array format, [#, #] = [pageStart, pageSize], [0, 100] = Start at zero, return 100
        sortID : "",                     // Which field to sort by e.g. EntryID, field5, etc
        sortDirection: "",               // Which direction to sort by ASC or DESC
        callback: $.noop(),              // ALWAYS REQUIRED - function to process data object
        system: false,                   // Return system information, e.g. IP addresses
        getterPath: ""                   // Path to file getter.php (relative to location of file calling this plugin)
      },
      
      errors: {
        NoDataError: { type: 'NoDataError', message: "No data was supplied to the callback. Something is wrong!"},
        InvalidJSON: function (data) {
          return {
            type: 'InvalidJSON',
            message: "The information in the config file is probably wrong. The request returned invalid JSON: \n" + data
          };
        }
      },
      
      getUsers: function (options, callback) {
        options = prepare_options(options, callback);
        get('users.json', options);
      },
      
      getReports: function (options, callback) {
        options = prepare_options(options, callback);
        var url = options.reportHash ? "reports/" + options.reportHash + ".json" : 'reports.json';
        
        get(url, options);
      },
      
      getWidgets: function (options, callback) {
        options = prepare_options(options, callback);
        get("reports/" + options.reportHash + "/widgets.json", options);
      },
      
      getComments: function (options, callback) {
        options = prepare_options(options, callback);
        
        var url = "forms/" + options.formHash + "/comments";
        url = url + (options.getCommentCount ? '/count.json' : '.json');
        
        get(url, options);
      },
      
      getEntries: function (options, callback) {
        options = prepare_options(options, callback);
        
        var url = options.reportHash === "" ? 'forms/' + options.formHash : 'reports/' + options.reportHash;
        url = url + "/entries.json";
        
        get(url, options);
      },
      
      getFields: function (options, callback) {
        options = prepare_options(options, callback);
        
        var url = options.formHash === "" ? 'forms' : 'reports';
        url = url + "/" + options.formHash + "/fields.json";
        
        get(url, options);
      },
      
      getForms: function (options, callback) {
        options = prepare_options(options, callback);
        var url = options.formHash === "" ? "forms.json" : "forms/" + options.formHash + ".json";
        
        get(url, options);
      }
    };
  }());
    
}(jQuery));