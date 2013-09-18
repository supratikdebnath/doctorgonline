<?php
require("includes/connection.php");
require(PROJECT_DOCUMENT_PATH.CKEDITOR_FOLDER."ckeditor.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Modify Doctor Clinic");

$sqlAdminPrivsMaster="SELECT id as value,privilegeName as label FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE privilegeStatus='1'";
$adminPrivsMasterArr=$globalUtil->sqlFetchRowsAssoc($sqlAdminPrivsMaster,2);

$doctorObj=new Doctor;
$AreaObj=new Area;

if($_GET['did']!=''){
$did=$_GET['did'];
}
else{
echo 'Invalid Request. Try again. <a href="javascript:window.close();">Close Window</a>'; die();	
}
	
$status=array(array("value"=>"1","label"=>"Active"),array("value"=>"0","label"=>"In-Active"));
$action='';
if(isset($_GET['do'])){
$action=$_GET['do'];
}

if(isset($_GET['id'])){
$id=$_GET['id'];
}

if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_USER_DOCTOR_CLINICS." WHERE id='".$id."' AND did='".$did."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($doctorObj->deleteDoctorClinic($globalUtil,$adminUtil,$id,$did)!=0){
	$msgInfo->setMessage("modifydoctorclinicmsg",SUCCESS_MSG_DOCTOR_DELETE_CLINIC,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("modifydoctorclinicmsg",ERROR_MSG_DOCTOR_DELETE_CLINIC,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctorClinic.php").'?did='.$did);
	
	}
	else{
	$msgInfo->setMessage("modifydoctorclinicmsg",ERROR_MSG_DOCTOR_EXISTS_CLINIC,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctorClinic.php").'?did='.$did);	
	}
}

if($action==""){
	$doaction="add";
	}
else if($action!='' && $action=="edit"){
	$doaction="edit";
	}
	
if($doaction=="add"){
	$pageHeading="Add Doctor Clinic";
	$submitValue="Submit";
	}
elseif($doaction=="edit"){
	$pageHeading="Modify Doctor Clinic";
	$submitValue="Update";
	
	
	$formData=$doctorObj->getDoctorClinic($globalUtil,"WHERE id='".$id."' AND did='".$did."'");
	if($formData['numrows']==0){
		echo 'Invalid Request. No Data Found. <a href="javascript:window.close();">Close Window</a>';
		die();
	}
	//echo "<pre>";print_r($formData);echo "</pre>";//die();
	$adminUtil->unsetPostFormDataAll();
	//echo "<pre>";print_r($formData['data'][0]);echo "</pre>";
	$adminUtil->setPostFormData($formData['data'][0]);
	//echo $adminUtil->getPostFormData("creditCardAccept");
	}	
	
$clinicList=$doctorObj->getDoctorClinic($globalUtil,"WHERE did='".$did."'");	
//echo "<pre>";print_r($clinicList);echo "</pre>";die();		
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
   maxLength($("#clinicAddress")); 
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
			<table width="100%" cellpadding="0" cellspacing="0" id="InnerTable" class="InnerTable">
				<tr>
					<td id="rightpanel" class="rightpanel">
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Doctor_Clinic);?>" enctype="multipart/form-data" method="post" class="formstyle1">
                        <input type="hidden" name="did" id="did" value="<?php echo $did;?>" />
						<?php
                        if($doaction=="edit"){
						?><input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                        <input type="hidden" name="dctid" id="dctid" value="<?php echo $adminUtil->getPostFormData("dctid");?>"/>
                        <?php }?>
                        <table width="100%" cellpadding="0" cellspacing="0">
							<tr><td class="PageHeading" colspan="3"><?php echo $pageHeading;?></td></tr>
							<tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php
							if($msgInfo->hasMsg('modifydoctorclinicmsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('modifydoctorclinicmsg');?></td>
                    		</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                   		    <?php
							}
							?>
                            <tr>
								<td class="formlabel">Clinic Name <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="clinicName" name="clinicName" validate="{required:true,messages:{required:'Please enter a Clinic Name.'}}" value="<?php echo $adminUtil->getPostFormData("clinicName");?>"/></div></td>
							</tr>
                            <tr>
								<td class="formlabel">Clinic Address <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><textarea name="clinicAddress" id="clinicAddress" validate="{required:true,messages:{required:'Please enter a Clinic Address.'}}" style="width: 209px; height: 54px;" maxlength="180"><?php echo $adminUtil->getPostFormData("clinicAddress");?></textarea></td>
							</tr>
                            <tr>
								<td class="formlabel">Clinic Phone Number </td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="clinicPhoneNumber" name="clinicPhoneNumber" validate="{digits:true,messages:{digits:'Please enter a valid clinic number.'}}" value="<?php echo $adminUtil->getPostFormData("clinicPhoneNumber");?>"/></div> Ex : 03312345678</td>
							</tr>
                            <tr>
								<td class="formlabel">Clinic Charges </td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="clinicCharges" name="clinicCharges" validate="{number:true,messages:{number:'Please enter a valid clinic charge.Ex :100.00'}}" value="<?php echo $adminUtil->getPostFormData("clinicCharges");?>"/></div> Ex : 100.00</td>
							</tr>
                            <tr>
                            	<td colspan="3"><table width="100%" cellspacing="0" cellpadding="5" align="center" id="clinicTimings" style="font-size:14px;">

				   <tbody>
	<tr>
                       <th valign="top" height="" align="left" ><strong>Mon</strong></th>
                       <th valign="top" height="" align="left" ><strong>Tue</strong></th>
                       <th valign="top" height="" align="left" ><strong>Wed</strong></th>
                       <th valign="top" height="" align="left" ><strong>Thur</strong></th>
                       <th valign="top" height="" align="left" ><strong>Fri</strong></th>
                       <th valign="top" height="" align="left" ><strong>Sat</strong></th>
                       <th valign="top" height="" align="left" ><strong>Sun</strong></th>
                       <th valign="top" height="" align="left" ><strong>Facilities</strong></th>
    </tr>
	<tr>
        <td valign="top" align="left" > 
            <?php 
			$dayMonMor=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayMonMor"));
			//echo "<pre>";print_r($dayMonMor);echo "</pre>";die();
			?>
            <p>Morning</p>
            From<br />
            <select id="dayMonMorFrom" name="dayMonMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayMonMor[0]);?>
            </select>
            <br />
            To<br />
            <select id="dayMonMorTo" name="dayMonMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayMonMor[1]);?>
            </select>
		</td>
        <td valign="top" align="left" >
        <?php $dayTueMor=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayTueMor"));?>
            <p>Morning</p>
            From<br /> 
            <select id="dayTueMorFrom" name="dayTueMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayTueMor[0]);?>
            </select><br />
            To<br />
            <select id="dayTueMorTo" name="dayTueMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayTueMor[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $dayWedMor=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayWedMor"));?>
            <p>Morning</p>
            From<br />
            <select id="dayWedMorFrom" name="dayWedMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayWedMor[0]);?>
            </select><br />
            To<br />
            <select id="dayWedMorTo" name="dayWedMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayWedMor[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $dayThurMor=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayThurMor"));?>
            <p>Morning</p>
            From<br />
            <select id="dayThurMorFrom" name="dayThurMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayThurMor[0]);?>
            </select><br />
            To<br />
            <select id="dayThurMorTo" name="dayThurMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayThurMor[1]);?>
            </select>
        </td>
        <td  valign="top" align="left" >
        <?php $dayFriMor=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayFriMor"));?>
            <p>Morning</p>
            From <br />
            <select id="dayFriMorFrom" name="dayFriMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayFriMor[0]);?>
            </select><br />
            To<br />
            <select id="dayFriMorTo" name="dayFriMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayFriMor[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $daySatMor=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("daySatMor"));?>
            <p>Morning</p>
            From<br />
            <select id="daySatMorFrom" name="daySatMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySatMor[0]);?>
            </select><br />
            To<br />
            <select id="daySatMorTo" name="daySatMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySatMor[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $daySunMor=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("daySunMor"));?>
            <p>Morning</p>
            From<br />
            <select id="daySunMorFrom" name="daySunMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySunMor[0]);?>
            </select><br />
            To<br />
            <select id="daySunMorTo" name="daySunMor[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySunMor[1]);?>
            </select>
        </td>
        <td valign="top" align="left">
                                <input type="checkbox" name="xray" id="	xray" value="Y" <?php if($adminUtil->getPostFormData("clinicPhoneNumber")=='Y'){ echo 'checked="checked"';}?>>X-Ray
                                <br class="spacer">
                                <input type="checkbox" name="creditCardAccept" id="creditCardAccept" value="Y" <?php if($adminUtil->getPostFormData("creditCardAccept")=='Y'){ echo 'checked="checked"';}?>>Credit Card                               <br class="spacer">
                                <input type="checkbox" name="emergency" id="emergency" value="Y" <?php if($adminUtil->getPostFormData("emergency")=='Y'){ echo 'checked="checked"';}?>>Emergency
                                <br class="spacer">
								<input type="checkbox" name="ownUnit" id="ownUnit" value="Y" <?php if($adminUtil->getPostFormData("ownUnit")=='Y'){ echo 'checked="checked"';}?>>Own Unit
                                <br class="spacer">
                                <?php $homeVisitFormData=$adminUtil->getPostFormData("homeVisit");?>
                                <input type="checkbox" name="homeVisit" id="homeVisit"  value="Y" onclick="javascript:if($(this).is(':checked')){$('#homeVisitChargesDiv').show();}else{$('#homeVisitCharges').val('');$('#homeVisitChargesDiv').hide();}" <?php if($homeVisitFormData=='Y'){ echo 'checked="checked"';}?>>Home Visit
                                <br class="spacer">
                                <div id="homeVisitChargesDiv" <?php if($homeVisitFormData=='Y'){ echo '';} else{echo 'style="display:none;"';}?>>
                                <input type="text" name="homeVisitCharges" id="homeVisitCharges" value="<?php echo $adminUtil->getPostFormData("homeVisitCharges");?>"/>
                                 <br class="spacer">Home Visit Charges 
                                </div>    
                  </td>
    </tr>
	<tr>
	
        <td valign="top" align="left" > 
        <?php $dayMonEve=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayMonEve"));?>
            <p>Evening</p>
            From<br />
            <select id="dayMonEveFrom" name="dayMonEve[]">
            	<option value="">Select</option>
                <?php 
				print $doctorObj->getClinicTimingHTMLOptions($dayMonEve[0]);?>
            </select><br />
            To<br />
            <select id="dayMonEveTo" name="dayMonEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayMonEve[1]);?>
            </select>
		</td>
        <td valign="top" align="left" >
        <?php $dayTueEve=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayTueEve"));?>
            <p>Evening</p>
            From<br />
            <select id="dayTueEveFrom" name="dayTueEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayTueEve[0]);?>
            </select><br />
            To<br />
            <select id="dayTueEveTo" name="dayTueEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayTueEve[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $dayWedEve=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayWedEve"));?>
            <p>Evening</p>
            From<br />
            <select id="dayWedEveFrom" name="dayWedEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayWedEve[0]);?>
            </select><br />
            To<br />
            <select id="dayWedEveTo" name="dayWedEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayWedEve[1]);?>
            </select>
	    </td>
        <td valign="top" align="left" >
        <?php $dayThurEve=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayThurEve"));?>
            <p>Evening</p>
            From<br />
            <select id="dayThurEveFrom" name="dayThurEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayThurEve[0]);?>
            </select><br />
            To<br />
            <select id="dayThurEveTo" name="dayThurEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayThurEve[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $dayFriEve=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("dayFriEve"));?>
	       <p> Evening</p>
    	   From<br />
            <select id="dayFriEveFrom" name="dayFriEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayFriEve[0]);?>
            </select><br />
            To<br />
            <select id="dayFriEveTo" name="dayFriEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($dayFriEve[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $daySatEve=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("daySatEve"));?>
           <p>Evening</p>
           From<br />
            <select id="daySatEveFrom" name="daySatEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySatEve[0]);?>
            </select><br />
            To<br />
            <select id="daySatEveTo" name="daySatEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySatEve[1]);?>
            </select>
        </td>
        <td valign="top" align="left" >
        <?php $daySunEve=$globalUtil->stringtoArr(',',$adminUtil->getPostFormData("daySunEve"));?>
            <p>Evening</p>
            From<br />
            <select id="daySunEveFrom" name="daySunEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySunEve[0]);?>
            </select><br />
            To<br />
            <select id="daySunEveTo" name="daySunEve[]">
            	<option value="">Select</option>
                <?php print $doctorObj->getClinicTimingHTMLOptions($daySunEve[1]);?>
            </select>
        </td>
        <td valign="top" align="left"></td>
	</tr>	  
	      </tbody></table></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
							<tr>
								<td></td>
                                <td></td>
                                <td class="btnposition"><input type="submit" name="Submit" class="submitbtn" value="<?php echo $submitValue;?>" /> &nbsp; <input type="button" class="submitbtn" value="Cancel" onclick="javascript:window.location='<?php echo $globalUtil->base64decode($_GET['returnurl']);?>';"/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
						</table>
                        </form>
                        <br /><br />
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="formstyle1 cliniclisting">   
	 <tbody>
     	<tr style="background-color:#507cd1; color:#fff;">
        	<th><strong>Name</strong></th>
            <th><strong>Contact</strong></th>
            <th><strong>Address</strong></th>
            <th><strong>Mon</strong></th>
            <th><strong>Tue</strong></th>
            <th><strong>Wed</strong></th>
            <th><strong>Thur</strong></th>
            <th><strong>Fri</strong></th>
            <th><strong>Sat</strong></th>
            <th><strong>Sun</strong></th>
            <th><strong>Facilities</strong></th>
            <th><strong>Fees</strong></th>
            <th><strong>Home Visit Fees</strong></th>
            <th><strong>Edit</strong></th>
            <th><strong>Delete</strong></th>
         </tr>
	     <?php 
		 if($clinicList['numrows']>0){
		 for($i=0;$i<count($clinicList['data']);$i++){
 
		 $dayMonMor=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayMonMor']);
		 $dayMonMorTiming= ($dayMonMor[0]=='' || $dayMonMor[1]=='') ? 'NA' : $dayMonMor[0]." to ".$dayMonMor[1];
		 
		 
		 $dayMonEve=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayMonEve']);
		 $dayMonEveTiming= ($dayMonEve[0]=='' || $dayMonEve[1]=='') ? 'NA' : $dayMonEve[0]." to ".$dayMonEve[1];
		 
		 $dayTueMor=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayTueMor']);
		 $dayTueMorTiming= ($dayTueMor[0]=='' || $dayTueMor[1]=='') ? 'NA' : $dayTueMor[0]." to ".$dayTueMor[1];
		 
		 $dayTueEve=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayTueEve']);
		 $dayTueEveTiming= ($dayTueEve[0]=='' || $dayTueEve[1]=='') ? 'NA' : $dayTueEve[0]." to ".$dayTueEve[1];
		 
		 $dayWedMor=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayWedMor']);
		 $dayWedMorTiming= ($dayWedMor[0]=='' || $dayWedMor[1]=='') ? 'NA' : $dayWedMor[0]." to ".$dayWedMor[1];
		 
		 $dayWedEve=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayWedEve']);
		 $dayWedEveTiming= ($dayWedEve[0]=='' || $dayWedEve[1]=='') ? 'NA' : $dayWedEve[0]." to ".$dayWedEve[1];
		 
		 $dayThurMor=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayThurMor']);
		 $dayThurMorTiming= ($dayThurMor[0]=='' || $dayThurMor[1]=='') ? 'NA' : $dayThurMor[0]." to ".$dayThurMor[1];
		 
		 $dayThurEve=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayThurEve']);
		 $dayThurEveTiming= ($dayThurEve[0]=='' || $dayThurEve[1]=='') ? 'NA' : $dayThurEve[0]." to ".$dayThurEve[1];
		 
		 $dayFriMor=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayFriMor']);
		 $dayFriMorTiming= ($dayFriMor[0]=='' || $dayFriMor[1]=='') ? 'NA' : $dayFriMor[0]." to ".$dayFriMor[1];
		 
		 $dayFriEve=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['dayFriEve']);
		 $dayFriEveTiming= ($dayFriEve[0]=='' || $dayFriEve[1]=='') ? 'NA' : $dayFriEve[0]." to ".$dayFriEve[1];
		 
		 $daySatMor=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['daySatMor']);
		 $daySatMorTiming= ($daySatMor[0]=='' || $daySatMor[1]=='') ? 'NA' : $daySatMor[0]." to ".$daySatMor[1];
		 
		 $daySatEve=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['daySatEve']);
		 $daySatEveTiming= ($daySatEve[0]=='' || $daySatEve[1]=='') ? 'NA' : $daySatEve[0]." to ".$daySatEve[1];
		 
		 $daySunMor=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['daySunMor']);
		 $daySunMorTiming= ($daySunMor[0]=='' || $daySunMor[1]=='') ? 'NA' : $daySunMor[0]." to ".$daySunMor[1];
		 
		 $daySunEve=$globalUtil->stringtoArr(',',$clinicList['data'][$i]['daySunEve']);
		 $daySunEveTiming= ($daySunEve[0]=='' || $daySunEve[1]=='') ? 'NA' : $daySunEve[0]." to ".$daySunEve[1];
		 ?>
         <tr>
            <td align="center"><?php echo $clinicList['data'][$i]['clinicName'];?></td>
            <td align="center"><?php echo $clinicList['data'][$i]['clinicPhoneNumber'];?></td>
            <td align="center"><?php echo $clinicList['data'][$i]['clinicAddress'];?></td>
            <td align="center"><b><i>Morn:</i></b> <?php echo $dayMonMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayMonEveTiming;?> </td>
            <td align="center"><b><i>Morn:</i></b> <?php echo $dayTueMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayTueEveTiming;?> </td>
            <td align="center"><b><i>Morn:</i></b> <?php echo $dayWedMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayWedEveTiming;?> </td>
            <td align="center"><b><i>Morn:</i></b> <?php echo $dayThurMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayThurEveTiming;?> </td>
            <td align="center"><b><i>Morn:</i></b> <?php echo $dayFriMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayFriEveTiming;?> </td>
            <td align="center"><b><i>Morn:</i></b> <?php echo $daySatMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $daySatEveTiming;?> </td>
            <td align="center"><b><i>Morn:</i></b> <?php echo $daySunMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $daySunEveTiming;?> </td>
            <td align="center"><?php
            if($clinicList['data'][$i]['xray']=='Y') { echo 'X-Ray<br />';}
			if($clinicList['data'][$i]['creditCardAccept']=='Y') { echo 'Credit Card<br />';}
			if($clinicList['data'][$i]['emergency']=='Y') { echo 'Emergency<br />';}
			if($clinicList['data'][$i]['ownUnit']=='Y') { echo 'Own Unit<br />';}
			if($clinicList['data'][$i]['homeVisit']=='Y') { echo 'Home Visit<br />';}
			
			?></td>
            <td align="center"><?php echo $clinicList['data'][$i]['clinicCharges'];?></td>
            <td align="center"><?php
            if($clinicList['data'][$i]['homeVisit']=='Y') {
				echo $clinicList['data'][$i]['homeVisitCharges']; 
				}
			?></td>
            <td align="center"><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctorClinic.php")."?do=edit&did=".$did."&id=".$clinicList['data'][$i]['doctorClinicid']."&returnurl=".$globalUtil->base64encode($globalUtil->currentUrl());?>"><img src="<?php echo ADMIN_IMAGES_URL;?>icon-edit.png" class="icon1"/></a></td>
            <td align="center"><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctorClinic.php")."?do=del&did=".$did."&id=".$clinicList['data'][$i]['doctorClinicid']."&returnurl=".$globalUtil->base64encode($globalUtil->currentUrl());?>" onclick="javascript:return confirm('Are you sure , Data deleted cannot be retrieved.');"><img src="<?php echo ADMIN_IMAGES_URL;?>icon-delete.png" class="icon1"/></a></td>
		</tr>
         <tr><td colspan="15" height="8px"></td></tr>
         <?php }
		 }
		 else{
		 ?>
         <tr><td colspan="15" height="8px">No records found.</td></tr>
         <?php
		 }
		 ?>	
	</tbody>
</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!--<tr>
		<td>
			<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."footer.php");?>
		</td>
	</tr>-->
</table>
</body>
</html>