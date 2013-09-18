<?php
require("includes/connection.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
require(ADMIN_DOCUMENT_PATH.CONTROLLER_FOLDER.CONTROLLER_PathologyList);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Hospital List");


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
<script language="javascript">
function delRecord(val,id)
{
	
	if(val=='0')
	{
		if(window.confirm("Would you like to remove this record ?")==true)
		{
			window.location.href='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php")."?do=del&id=";?>'+id;
		}
	}
	else if(val!='0')
	{
		window.location.href='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php")."?do=del&id=";?>'+id;
	}
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
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER);?>" enctype="multipart/form-data" method="post"></form>
                        <table width="100%" cellpadding="0" cellspacing="0"class="formstyle1">
							<tr>
							  <td class="PageHeading" colspan="3"><span class="listHeading">Pathology Center List</span></td>
							</tr>
							<tr>
                            	<td colspan="3" height="5px" align="center">
                            </tr>
                            <?php
							if($msgInfo->hasMsg('listpathologymsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('listpathologymsg');?></td>
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
                                        <td class="listHeading">Pathology Center  Name</td>
                                        <td class="listHeading">State Name</td>
                                        <td class="listHeading">City Name</td>
                                        <td class="listHeading">Zone Name</td>
                                        <td class="listHeading">Area Name</td>
                                        <td class="listHeading">Created On</td>
                                        <td class="listHeading">Modified On</td>
                                        <td class="listHeading">Status</td>
                                        <td class="listHeading">Edit</td>
                                        <td class="listHeading">Delete</td>
									</tr>
                                    
                                    <?php
                                    if($allPathology['numrows']>0){
									for($i=0;$i<$allPathology['numrows'];$i++){
									?>
                                    <tr>
                                        <td class="listData"><a href="<?php echo $pathologyList->pathologyPublicUrl(array("id"=>$allPathology['data'][$i]['pathologyDetailsid'],"hospitalName"=>$allPathology['data'][$i]['PathologyCenterName ']));?>" target="_blank"><?php echo $allPathology['data'][$i]['pathologycenterName'];?></a></td>
                                        <td class="listData"><?php echo $areaObj->getLocationNameFromId($globalUtil,$allPathology['data'][$i]['sid'],"STATE");?></td>
                                        <td class="listData"><?php echo $areaObj->getLocationNameFromId($globalUtil,$allPathology['data'][$i]['cid'],"CITY");?></td>
                                        <td class="listData"><?php echo $areaObj->getLocationNameFromId($globalUtil,$allPathology['data'][$i]['zid'],"ZONE");?></td>
                                        <td class="listData"><?php echo $areaObj->getLocationNameFromId($globalUtil,$allPathology['data'][$i]['aid'],"AREA");?></td>
                                        <td class="listData"><?php echo $globalUtil->dateFromTime($allPathology['data'][$i]['createDt'],'d-M-Y');?></td>
                                        <td class="listData"><?php echo $globalUtil->dateFromTime($allPathology['data'][$i]['modifyDt'],'d-M-Y');?></td>
                                        <td class="listData"><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php")."?do=status&id=".$allPathology['data'][$i]['pathologyDetailsid'];?>"><?php echo $globalUtil->getStatusMessage($allPathology['data'][$i]['statusPathologyDetails']);?></a></td>
                                        <td class="listData"><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathology.php")."?do=edit&id=".$allPathology['data'][$i]['pathologyDetailsid']."&returnurl=".$globalUtil->base64encode($globalUtil->currentUrl());?>"><img src="<?php echo ADMIN_IMAGES_URL;?>icon-edit.png" class="icon1"/></a></td>
                                        <td class="listData"><a href="javascript:void(0);" onclick="delRecord('<?php echo $allPathology['data'][$i]['statusPathologyDetails'];?>','<?php echo $allPathology['data'][$i]['pathologyDetailsid']; ?>')"><img src="<?php echo ADMIN_IMAGES_URL;?>icon-delete.png" class="icon1"/></a></td>
									</tr>
                                	<?php }
									}
									else{
									?>
                                    <tr>
                                        <td class="listData" align="center" colspan="10">No Records Found.</td>
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