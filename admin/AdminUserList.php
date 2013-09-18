<?php
require("includes/connection.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
require(ADMIN_DOCUMENT_PATH.CONTROLLER_FOLDER.CONTROLLER_AdminUserList);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Admin User List");


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

  $("#DataTable tr:even").addClass("trEven");
  $("#DataTable tr:odd").addClass("trOdd");	    	
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
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_AdminUserList);?>" enctype="multipart/form-data" method="post"></form>
                        <table width="100%" cellpadding="0" cellspacing="0"class="formstyle1">
							<tr><td class="PageHeading" colspan="3">Admin User List</td></tr>
							<tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php
							if($msgInfo->hasMsg('listadminusermsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('listadminusermsg');?></td>
                    		</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                   		    <?php
							}
							?>
                            <tr>
                            	<td colspan="3">
							    <table width="100%" cellpadding="4" cellspacing="0" id="DataTable">
                                	<tr>
                                        <td class="listHeading">Full Name</td>
                                        <td class="listHeading">Username</td>
                                        <td class="listHeading">Email Address</td>
                                        <td class="listHeading">Privilege</td>
                                        <td class="listHeading">Status</td>
                                        <td class="listHeading">Edit</td>
                                        <td class="listHeading">Delete</td>
									</tr>
                                    
                                    <?php
                                    if($allAdminUsers['numrows']>0){
									for($i=0;$i<$allAdminUsers['numrows'];$i++){
									?>
                                    <tr>
                                        <td class="listData"><?php echo $allAdminUsers['data'][$i]['fullname'];?></td>
                                        <td class="listData"><?php echo $allAdminUsers['data'][$i]['username'];?></td>
                                        <td class="listData"><?php echo $allAdminUsers['data'][$i]['email'];?></td>
                                        <td class="listData"><?php echo $adminUtil->getAdminPrivilegeName($globalUtil,$allAdminUsers['data'][$i]['privilege']);?></td>
                                        <td class="listData"><?php echo $globalUtil->getStatusMessage($allAdminUsers['data'][$i]['status']);?></td>
                                        <td class="listData"><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyAdminUser.php")."?uid=".$allAdminUsers['data'][$i]['id']."&returnurl=".$globalUtil->base64encode($globalUtil->currentUrl());?>"><img src="<?php echo ADMIN_IMAGES_URL;?>icon-edit.png" class="icon1"/></a></td>
                                        <td class="listData"><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_AdminUserList)."?do=del&uid=".$allAdminUsers['data'][$i]['id'];?>"><img src="<?php echo ADMIN_IMAGES_URL;?>icon-delete.png" class="icon1"/></a></td>
									</tr>
                                	<?php }
									}
									else{
									?>
                                    <tr>
                                        <td class="listData" align="center" colspan="8">No Records Found.</td>
									</tr>
                                    <?php
									}
									?>
                                </table>
								</td>
							</tr>
                       </table>
                     <td>
    			  </tr></table>
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