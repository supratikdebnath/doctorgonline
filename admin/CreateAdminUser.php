<?php
require("includes/connection.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Create Admin User");

$sqlAdminPrivsMaster="SELECT id as value,privilegeName as label FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE privilegeStatus='1'";
//echo $sqlAdminPrivsMaster;
$adminPrivsMasterArr=$globalUtil->sqlFetchRowsAssoc($sqlAdminPrivsMaster,2);
//$globalUtil->printArray($adminPrivsMasterArr);

//$formData=$globalUtil->sqlFetchRowsAssoc("SELECT id,email FROM ".TABLE_ADMIN_USERS." WHERE id='".$_SESSION['adminUserSession']['uid']."' AND status='1'",2);

//$globalUtil->printArray($formData);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Welcome Page</title>
<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."head.php");?>
<script language="javascript" src="<?php echo ADMIN_JS_URL;?>validate/jquery.validate.js"></script>
<script language="javascript" src="<?php echo ADMIN_JS_URL;?>validate/lib/jquery.metadata.js" type="text/javascript"></script>

<script language="javascript">
$(document).ready(function(){
  $("#uname").focus(); // To Focus the username field on page load.

  //For Login Form//	 
  $.metadata.setType("attr", "validate");
  $("#adminformmain").validate(); 
  /*$.validator.addMethod("password", function( value, element, param ) {
  return this.optional(element) || value.length >= 6 && /\d/.test(value) && /[a-z]/i.test(value);
	}, "Your password must be at least 6 characters long and contain at least one number and one character.");*/
   //For Login Form// 	
});

</script>
<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."noscript.php");?>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" id="MainTable" class="MainTable">
	<tr>
		<td>
			<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."header.php");?>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" id="InnerTable" class="InnerTable">
				<tr>
					<td id="leftpanel" class="leftpanel">
						<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."leftmenu.php");?>
					</td>
					<td id="rightpanel" class="rightpanel">
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_AdminCreateUser);?>" enctype="multipart/form-data" method="post" class="formstyle1">
                        <table width="100%" cellpadding="0" cellspacing="0">
							<tr><td class="PageHeading" colspan="3">Create New Admin User </td></tr>
							<tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php
							if($msgInfo->hasMsg('createadminusermsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('createadminusermsg');?></td>
                    		</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                   		    <?php
							}
							?>
                            <tr>
								<td class="formlabel">Full Name</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="fullname" name="fullname" validate="{required:true,messages:{required:'Please enter full name.'}}" value="<?php echo $adminUtil->getPostFormData("fullname");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>                            
                            <tr>
								<td class="formlabel">Username</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="username" name="username" validate="{required:true,messages:{required:'Please enter username.'}}" value="<?php echo $adminUtil->getPostFormData("username");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Email Address</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="email" name="email" validate="{required:true,email:true,messages:{required:'Please enter email address.'}}" value="<?php echo $adminUtil->getPostFormData("email");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Password</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="password" class="formtextbox" id="password" name="password" validate="{required:true,messages:{required:'Please enter  password.'}}" value="<?php echo $adminUtil->getPostFormData("password");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Retype Password</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="password" class="formtextbox" id="repass" name="repass" validate="{required:true,equalTo:'#password',messages:{required:'Please re-enter password.',equalTo:'Password Mismatch'}}"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Privilage</td>
                                <td class="separter">:</td>
                                <td class="forminput"><select name="privilege" id="privilege" validate="{required:true,messages:{required:'Please select Privilage.'}}" class="selectbox1">
								<option value="">Select Privilege</option>
								<?php echo $globalUtil->htmlOptions($adminPrivsMasterArr['data']);?>
                                </select></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<tr>
								<td></td>
                                <td></td>
                                <td class="btnposition"><input type="submit" class="submitbtn" value="Submit" /> &nbsp; <input type="reset" class="submitbtn" value="Reset" onclick="document"/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
						</table>
                        </form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."footer.php");?>
		</td>
	</tr>
</table>
</body>
</html>