 <cfcomponent name="Wufoo"
             extends="WufooGetter"
	     displayname="Wufoo"
	     hint="Main init config for Wufoo libraries

		   @author Shannon Eric Peevey  speeves@stolaf.edu  '11
           ">

    <cffunction name="init"  
		access="public"
                output="no"
                hint="  
					We use this to hide our api key from prying eyes.

					1. Copy this file to your class directory. 
					2. Add your subdomain and api key below

					It will automatically load WufooGetter.cfc.	
				  ">
      <cfset variables.subdomain = 'SUBDOMAIN HERE' />
      <cfset variables.apiKey = 'PUT YOUR API KEY HERE' />
      <cfset variables.domain = 'wufoo.com' />
      <cfset variables.formPath = 'api/v3/forms/' />

     <cfreturn this />
    </cffunction>
</cfcomponent>
