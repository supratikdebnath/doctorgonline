<?php
require("includes/connection.php");
$globalUtil->destroySessionNow();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin - Panel </title>
<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."noscript.php");?>
<link type="text/css" href="<?php echo ADMIN_CSS_URL;?>main.css" rel="stylesheet" media="screen" />
<script language="javascript" src="<?php echo ADMIN_JS_URL;?>jquery.js"></script>
<script language="javascript" src="<?php echo ADMIN_JS_URL;?>validate/jquery.validate.js"></script>
<script language="javascript" src="<?php echo ADMIN_JS_URL;?>validate/lib/jquery.metadata.js" type="text/javascript"></script>

<script language="javascript">
$(document).ready(function(){
  $("#uname").focus(); // To Focus the username field on page load.

  //For Login Form//	 
  $.metadata.setType("attr", "validate");
  $("#loginForm").validate(); 
  /*$.validator.addMethod("password", function( value, element, param ) {
  return this.optional(element) || value.length >= 6 && /\d/.test(value) && /[a-z]/i.test(value);
	}, "Your password must be at least 6 characters long and contain at least one number and one character.");*/
   //For Login Form// 	
});

</script>
</head>
<body>
    <table width="100%" align="center" class="adminlogin" cellpadding="0" cellspacing="0" >
    	<tr>
        	<td>
            	<form action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_AdminLogin);?>" enctype="multipart/form-data" id="loginForm" name="loginForm" method="post">
            	<table align="center" id="loginform" class="loginform" width="80%">
                	<?php
					
					if($msgInfo->hasMsg('usersessionmsg')){
					?>
                    <tr>
                    	<td align="center" colspan="2"><?php echo $msgInfo->displayMsg('usersessionmsg');?></td>
                    </tr>
                    <?php
					}
					?>
                    <tr>
                        <td class="formheading" width="20%">Username</td>
                        <td class="textboxbg" width="60%"><input type="text" class="textbox" name="uname" id="uname" validate="{required:true,messages:{required:'Please enter user name.'}}"/></td>
        			</tr>
                    <tr>
                    	<td height="10px" colspan="2"></td>
                    </tr>
       			    <tr>
                        <td class="formheading">Password</td>
                        <td class="textboxbg"><input type="password" class="textbox" name="pass" id="pass" validate="{required:true,messages:{required:'Please enter password.'}}"/></td>
        			</tr>
                    <tr>
                        <td colspan="2"><span class="loginbtwns"><input type="button" class="submitbtn" id="resetlogin" name="resetlogin" value="Reset" onclick="$('#loginForm')[0].reset();"/> <input type="submit" class="submitbtn" id="adminlogin" name="adminlogin" value="Login"/></span></td>
        			</tr>
                 </table>
                </form> 
                <iframe name="PleaseWait" id="PleaseWait" frameborder="0"  style="display:none;">
                <table align="center" id="loading" class="loginform" width="50%">
                	<tr>
                        <td class="formheading" colspan="2"><img src="<?php echo ADMIN_IMAGES_URL."loading.gif";?>"/></td>
                    </tr>
                </table>
                </iframe>
                
            </td>
        </tr>
    </table>
    <!--Footer Starts-->
    <table width="100%" cellpadding="0" cellspacing="0">
    	<tr>
        	<td align="center" class="footer">Developed By SamannoyChatterjee.Net</td>
        </tr>
    </table>
    <!--Footer Ends-->
</body>
</html>