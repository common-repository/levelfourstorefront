<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//All Code and Design is copyrighted by Level Four Development, LLC

//Level Four Development, LLC provides this code "as is" without     

//warranty of any kind, either express or implied,       

//including but not limited to the implied warranties    

//of merchantability and/or fitness for a particular     

//purpose.         

//

//Only licnesed users may use this code and storfront for live purposes.

//All other use is prohibited and may be subject to copyright violation laws.

//If you have any questions regarding proper use of this code, please

//contact Level Four Development, LLC prior to use.

//

//All use of this storefront is subject to our terms of agreement found on

// Level Four Development, LLC's official website.

//////////////////////////////////////////////////////////////////////////////////////////////////////////

//Version 8.1.0

?>

<div class="l4store_header">Create An Account For A Faster Checkout</div>

<div class="checkout_form_content">

	<div class="checkout_form_padding">	

        <div class="form_row_checkbox">

            <div class="checkout_form_label">&nbsp;&nbsp;&nbsp;</div>

            <div class="checkout_form_input"><input type="checkbox" name="CreateAccount" id="CreateAccount" onchange="update_show_account_form();" /> Yes, I would like to create an account</div>

        </div>

        <div class="form_row_checkbox" id="CreateAccountMessage">

            <div class="checkout_form_label"></div>

            <div class="checkout_form_input">Password is only required if you choose to create an account with us.</div>

        </div>

        <div id="new_account">

            <div class="form_row">

                <div class="checkout_form_label">Password:</div>

                <div class="checkout_form_input">

                    <input type="password" name="PasswordNew" id="PasswordNew" class="checkout_form_password_input" />

                    <script type="text/javascript">

                        var ValidatePasswordNew = new LiveValidation('PasswordNew',  {validMessage: " "});

                        ValidatePasswordNew.add( Validate.Presence, {failureMessage: " "} );

                        ValidatePasswordNew.add( Validate.Format, {pattern: /((?=.*[a-z])(?=^.{6,12}$))/, failureMessage: "Must Be 6-12 Characters" } );

                    </script> 

                </div>

            </div>

            <div class="form_row">

                <div class="checkout_form_label">Retype Password:</div>

                <div class="checkout_form_input">

                    <input type="password" name="RetypePasswordNew" id="RetypePasswordNew" onkeydown="if(event.keyCode == 13){ checkcreateaccountform(); }" class="checkout_form_password_input" />

                    <script type="text/javascript">

                        var ValidateRetypePasswordNew = new LiveValidation('RetypePasswordNew',  {validMessage: " "});

                        ValidateRetypePasswordNew.add( Validate.Presence, {failureMessage: " "} );

                        ValidateRetypePasswordNew.add( Validate.Format, {pattern: /((?=.*[a-z])(?=^.{6,12}$))/, failureMessage: "Must Be 6-12 Characters" } );

                        ValidateRetypePasswordNew.add( Validate.Confirmation, { match: 'PasswordNew', failureMessage: "Does Not Match" } );

                    </script> 

                </div>

            </div>

            <div class="form_row_checkbox">

                <div class="checkout_form_label">&nbsp;&nbsp;&nbsp;</div>

                <div class="checkout_form_input"><input type="checkbox" name="EmailList" id="EmailList" /> I would like to receive emails and special offers.</div>

            </div>

        </div>

    </div>

</div>



<script>

	document.getElementById('new_account').style.display = "none";

	document.getElementById('CreateAccountMessage').style.display = "none";

</script>