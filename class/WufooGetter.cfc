<cfcomponent name="WufooGetter"
	     displayname="WufooGetter"
	     hint="Utility class for sending Wufoo API requests to wufoo
		   @author Shannon Eric Peevey  speeves@stolaf.edu  '11
           ">

    <cffunction name="getFieldNames"  
		access="public"
                returnType="query"
                output="no"
                hint=" 
                      Wufoo asks us to make a second query to the Fields API to acquire the field names for a given form
                      
                      This function:
                      1. takes the name of a form, and calls the Fields API.
                      2. converts the JSON response into a Coldfusion object
                      3. loops through the array of fields, checking for subfields, and then creates a 
                         flat query object so that we can match rows in a query of queries in makeCall()
                         (allowing us to remove the Field1, Field2 business, and return an actual field
                         title/label with the value)

		      ">
    
      <cfargument name="formName" type="string" required="true" hint="name of the form" />  

      <cfset newJson = '' />
      <cfset newQuery = queryNew( "id, title") />
      <cfset u = 'https://#variables.subdomain#.#variables.domain#/#variables.formPath##formName#/fields.json' />


      <!--- get the field names for formName --->
      <cfhttp method="get" url="#u#" username="#variables.apikey#" result="fields" password="test" throwOnError="yes" />

      <cftry> 
        <!--- convert the fieldnames response into a CF object --->
        <cfset newJson = DeserializeJSON( fields.FileContent.toString("UTF-8") ) />

        <!--- loop through each field entry --->
        <cfloop array="#newJson.Fields#" index="f">
          
          <!--- it is possible that we have subfields, (for fancy pants fields) --->
          <cfif IsDefined('f.Subfields')>
            <cfloop array="#f.SubFields#" index="s">
              <cfset queryAddRow(newQuery) />
              <cfset querySetCell( newQuery, "id", s.ID) />
              <cfset querySetCell( newQuery, "title", s.LABEL) />
            </cfloop>
          <cfelse>
            <cfset queryAddRow(newQuery) />
            <cfset querySetCell( newQuery, "id", f.ID) />
            <cfset querySetCell( newQuery, "title", f.TITLE) />          
          </cfif>
        </cfloop>
	<cfcatch type="any">
	  <cfset errorMsg = "Call to Wufoo API FAILED. ERROR DETAIL: #fields.errorDetail# URL: #u# " />
          <cflog application="yes" text="#DateFormat(now(),'mm-dd-yyyy')#.#TimeFormat(now(), 'HH:mm:ss')#|#errorMsg#|#CGI.CF_TEMPLATE_PATH#|#CGI.REMOTE_ADDR#|#CGI.SERVER_NAME#|#CGI.HTTP_USER_AGENT#|#CGI.HTTP_REFERER#" />
        </cfcatch> 
      </cftry>
      
      <cfreturn newQuery />
    </cffunction> 

    <cffunction name="makeCall"  
		access="remote"
                output="no"
                hint="  
                      makeCall() combines the entries and fields API calls into 
                      either a coldfusion array of queries, or json
                      
                      This function:
                      1. takes the name of a form, and the desired returntype, (default: json) (cf|json).
                      2. call the entries API.
                      3. call the fields API
                      4. loop through each entries response and convert them into a coldfusion object
                         - Then convert them into a query with the cols (id, fieldValue), so that
                           we can match them against the fields API response
                      5. for each entrie, use the query of queries to match field names with field values.
                      6. append each query of queries result to arrEntries.
                      7. if returntype EQ json, then we change our cf object back into json (an array of (COLUMN, DATA) values)
                      8. return arrEntries

		      ">
    
      <cfargument name="formName" type="string" required="true" hint="name of the form" />  
      <cfargument name="returnType" type="string" required="false" default="json" hint="cf or json" />

      <cfset init() />
      <cfset newJson = '' />
      <cfset j = '' />
      <cfset arrEntries = ArrayNew(1) />
      <cfset u = 'https://#variables.subdomain#.#variables.domain#/#variables.formPath##formName#/entries.json' />

      <!--- get our get our form entries --->
      <cfhttp method="get" url="#u#" username="#variables.apikey#"  result="entries" password="test" throwOnError="yes" />

      <cftry> 
        <!--- get our field names for this form (a query) --->
        <cfset fieldsQuery = getFieldNames( formName ) />

        <!--- convert our entries response to a coldfusion object --->
        <cfset newJson = DeserializeJSON( entries.FileContent.toString("UTF-8") ) />

        <!--- loop through our array of form entries to match field names with values --->
        <cfloop array="#newJson.Entries#" index="e"> 
          <!--- Create a new query and loop over keys in the entry response struct. --->
          <cfset entryQuery = QueryNew( "id, fieldValue" ) />
          <cfloop index="strKey" list="#StructKeyList( e )#" delimiters=",">
            <cfset queryAddRow(entryQuery) />
            <cfset querySetCell( entryQuery, "id", strKey) />
            <cfset querySetCell( entryQuery, "fieldValue", Evaluate( "e.#strKey#" ) ) /> 
          </cfloop>
          
          <!--- join our queries to match field names with values --->
          <cfquery dbtype="query" name="j">
            select fieldsQuery.title, entryQuery.fieldValue from fieldsQuery, entryQuery
            WHERE fieldsQuery.id = entryQuery.id
          </cfquery>

          <!--- append this query object to our return result --->
          <cfset ArrayAppend( arrEntries, j) />

        </cfloop>  
        <!--- if returntype EQ json, we convert arrEntries into json --->
        <cfif returnType NEQ 'cf'>
          <cfset j = SerializeJSON( arrEntries ) />
        </cfif>
        <cfcatch type="any">
	  <cfset errorMsg = "Call to Wufoo API FAILED. ERROR DETAIL: #entries.errorDetail# URL: #u# " />
          <cflog application="yes" text="#DateFormat(now(),'mm-dd-yyyy')#.#TimeFormat(now(), 'HH:mm:ss')#|#errorMsg#|#CGI.CF_TEMPLATE_PATH#|#CGI.REMOTE_ADDR#|#CGI.SERVER_NAME#|#CGI.HTTP_USER_AGENT#|#CGI.HTTP_REFERER#" />
        </cfcatch> 
      </cftry>
      
      <cfreturn arrEntries />
    </cffunction>  
</cfcomponent>
