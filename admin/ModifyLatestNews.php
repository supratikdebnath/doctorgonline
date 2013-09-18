<?php
require("includes/connection.php");
require(PROJECT_DOCUMENT_PATH.CKEDITOR_FOLDER."ckeditor.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Modify Latest News");

$sqlAdminPrivsMaster="SELECT id as value,privilegeName as label FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE privilegeStatus='1'";
$adminPrivsMasterArr=$globalUtil->sqlFetchRowsAssoc($sqlAdminPrivsMaster,2);

$status=array(array("value"=>"1","label"=>"Active"),array("value"=>"0","label"=>"In-Active"));
$action='';
if(isset($_GET['do'])){
$action=$_GET['do'];
}

if($action==""){
	$doaction="add";
	}
else if($action!='' && $action=="edit"){
	$doaction="edit";
	}
	
if($doaction=="add"){
	$pageHeading="Add Latest News";
	$submitValue="Submit";
	}
elseif($doaction=="edit"){
	
	$id=$_GET['id'];
	$pageHeading="Modify Latest News";
	$submitValue="Update";
	
	$lastestNews=new LatestNews;
	$formData=$lastestNews->getLastestNews($globalUtil,"WHERE id='".$id."'");
	$adminUtil->unsetPostFormDataAll();
	
	$adminUtil->setPostFormData($formData['data'][0]);
	//echo $adminUtil->getPostFormData("status");
	}	
		
//$globalUtil->printArray($adminPrivsMasterArr);
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

CKEDITOR.editorConfig = function( config )
{
   config.enableTabKeyTools = true;
};

</script>
<script type="text/javascript" src="<?php echo CKEDITOR_URL;?>ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.editorConfig = function( config )
{
	config.autoParagraph = false;
}
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
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_LatestNews);?>" enctype="multipart/form-data" method="post" class="formstyle1">
                        <?php
                        if($doaction=="edit"){
						?><input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                        <?php }?>
                        <table width="100%" cellpadding="0" cellspacing="0">
							<tr><td class="PageHeading" colspan="3"><?php echo $pageHeading;?></td></tr>
							<tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php
							if($msgInfo->hasMsg('modifylatestnewsmsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('modifylatestnewsmsg');?></td>
                    		</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                   		    <?php
							}
							?>
                            <tr>
								<td class="formlabel">Topic Name</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="topicName" name="topicName" validate="{required:true,messages:{required:'Please enter a topic name.'}}" value="<?php echo $adminUtil->getPostFormData("topicName");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>                            
                            <tr>
								<td class="formlabel">Topic Body</td>
                                <td class="separter">:</td>
                                <td class="forminput">
<textarea class="ckeditor" name="topicBody" id="topicBody"><?php echo $adminUtil->getPostFormData("topicBody");?></textarea></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Status</td>
                                <td class="separter">:</td>
                                <td class="forminput">
<select name="status" id="status" validate="{required:true,messages:{required:'Please select Status.'}}" class="selectbox1">
								<?php echo $globalUtil->htmlOptions($status,$adminUtil->getPostFormData("status"));?>
                                </select></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<tr>
								<td></td>
                                <td></td>
                                <td class="btnposition"><input type="submit" name="Submit" class="submitbtn" value="<?php echo $submitValue;?>" /> &nbsp; <input type="reset" class="submitbtn" value="Reset" onclick="document"/></td>
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