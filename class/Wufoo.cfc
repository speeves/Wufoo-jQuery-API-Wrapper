 <cfcomponent name="Wufoo"
	     displayname="Wufoo"
	     hint="Main init config for Wufoo libraries

		   @author Shannon Eric Peevey  speeves@stolaf.edu  '11
		   @author Nick Blackhawk  blackhan@stolaf.edu  '11                  
           ">

    <cffunction name="init"  
		access="public"
                output="no"
                hint="  
                      Create instance of wufoo object with defaults
                      @param     subdomain                 string             subdomain for our wufoo acct (default: stolaf)
                      @param     apiKey                    string             api key for wufoo api (default: the key)
		      ">
      <cfset variables.subdomain = 'stolaf' />
      <cfset variables.apiKey = 'MH13-8NQA-H5D7-KKZ7' />

     <cfreturn this />
    </cffunction>
</cfcomponent>
