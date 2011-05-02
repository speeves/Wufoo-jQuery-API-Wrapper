<cfcomponent name="WufooGetter"
	     displayname="WufooGetter"
             extends="Wufoo"
	     hint="Utility class for sending Wufoo API requests to wufoo
		   @author Shannon Eric Peevey  speeves@stolaf.edu  '11
		   @author Nick Blackhawk  blackhan@stolaf.edu  '11   
           ">

    <cffunction name="makeCall"  
		access="public"
                output="no"
                hint="  TODO
		      ">
      <cfargument name="responseMsg" type="struct" required="true" />

      <!--- start of EFT/CC HTTP request transactions --->
      <cfhttp method="post" url="#variables.aim_posturl#">
	<!--- Use for test mode --->
	<cfhttpparam name="x_test_request" value="#test_request#" type="formfield" />
	<!--- This is the production login --->
	<cfhttpparam name="x_login" type="formfield" value="#variables.login#" />
	<cfhttpparam name="x_tran_key" type="formfield" value="#variables.tran_key#" /> 
	<!--- transaction settings --->
	<cfhttpparam name="x_method" type="formfield" value="#method#" />
	<cfhttpparam name="x_type" type="formfield" value="#variables.type#" />
	<cfhttpparam name="x_delim_data" type="formfield" value="#variables.delim_data#" />
	<cfhttpparam name="x_delim_char" type="formfield" value="#variables.delim_char#" />
	<!--- transaction information --->
	<cfhttpparam name="x_amount" type="formfield" value="#amount#" />
	<cfhttpparam name="x_first_name" type="formfield" value="#first_name#" />
	<cfhttpparam name="x_last_name" type="formfield" value="#last_name#" />
	<cfhttpparam name="x_address" type="formfield" value="#address#" />
	<cfhttpparam name="x_city" type="formfield" value="#city#" />
	<cfhttpparam name="x_state" type="formfield" value="#state#" />
	<cfhttpparam name="x_zip" type="formfield" value="#zip#" />
	<cfhttpparam name="x_phone" type="formfield" value="#phone#" />
        <cfhttpparam name="x_invoice_num" type="formfield" value="#invoice_num#" />
	<cfhttpparam name="x_description" type="formfield" value="#description#" />
	<!--- differentiate between cc and eft --->
	
        <!--- credit card info --->
        <cfhttpparam name="x_relay_response" type="formfield" value="#variables.relay_response#" />
        <cfhttpparam name="x_card_num" type="formfield" value="#card_num#" />
        <cfhttpparam name="x_exp_date" type="formfield" value="#exp_date#" />
        <cfhttpparam name="x_card_code" type="formfield" value="#card_code#" />
	
        <!--- EFT fields --->
        <cfhttpparam name="x_bank_aba_code" type="formfield" value="#bank_aba_code#" />
        <cfhttpparam name="x_bank_acct_num" type="formfield" value="#bank_acct_num#" />
        <cfhttpparam name="x_bank_acct_type" type="formfield" value="#bank_acct_type#" />
        <cfhttpparam name="x_bank_name" type="formfield" value="#bank_name#" />
        <cfhttpparam name="x_bank_acct_name" type="formfield" value="#bank_acct_name#" />
        <cfhttpparam name="x_echeck_type" type="formfield" value="#variables.echeck_type#" />
	
	<!--- x_recurring_billing is required with x_echeck_type=WEB (we are WEB) --->
	<cfhttpparam name="x_recurring_billing" type="formfield" value="#variables.recurring_billing#" />    
	<cfhttpparam name="x_version" type="formfield" value="#variables.version#" />
      </cfhttp>
      
      <!--- send the HTTP request to authorize.net --->
      <cftry>
	<cfset api_response=cfhttp.fileContent />
	<cfcatch type="any">
	  <cfset errorMessage = "We are unable to complete your transaction at this time.  Please try again later." />
	  <cfset cfcEmail.send( variables.toEmail, variables.fromEmail, 
          "Authorize.Net DOWN", 
          "Authorize.Net  is currently down:

          #now()#

          Transaction Information:
          #first_name# #last_name#
          #address#
          #city#, #state# #zip#
          #phone#

          Amount:
          #amount#

          Environment Variables:
          #CGI.CF_TEMPLATE_PATH#
          #CGI.REMOTE_ADDR#
          #CGI.SERVER_NAME#
          #CGI.HTTP_USER_AGENT#
          #CGI.HTTP_REFERER#

          Error Message:
          #cfcatch.type#
          #cfcatch.message#
          #cfcatch.detail#
          ") />
          <CFLOCATION URL="#errorpage#?message=#errorMessage#" ADDTOKEN="no" /> 
        </cfcatch> 
      </cftry>
      
      <!--- error checking --->
      <cfset errorCheck = checkResponseForError( api_response ) />
      <cfset msg = errorMsg( errorCheck ) />

      <cfreturn msg />
    </cffunction>  


      <cfreturn errorlist />
    </cffunction>
</cfcomponent>
