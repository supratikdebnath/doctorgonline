<?php
require("includes/connection.php");
require(PROJECT_DOCUMENT_PATH.CKEDITOR_FOLDER."ckeditor.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Modify Hospital");

$sqlAdminPrivsMaster="SELECT id as value,privilegeName as label FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE privilegeStatus='1'";
$adminPrivsMasterArr=$globalUtil->sqlFetchRowsAssoc($sqlAdminPrivsMaster,2);

$hospitalObj=new Hospital;
$doctorObj=new Doctor;
$AreaObj=new Area;

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
	$pageHeading="Add Hospital";
	$submitValue="Submit";
	}
elseif($doaction=="edit"){
	
	$id=$_GET['id'];
	$pageHeading="Modify Hospital";
	$submitValue="Update";
	
	
	$formData=$hospitalObj->getHospital($globalUtil,"WHERE id='".$id."'");
	$adminUtil->unsetPostFormDataAll();
	//echo "<pre>";print_r($formData['data'][0]);echo "</pre>";
	$adminUtil->setPostFormData($formData['data'][0]);
	$featured_value=$adminUtil->getPostFormData("featured_value");
	//echo $adminUtil->getPostFormData("creditCardAccept");
	$cityId=$adminUtil->getPostFormData("cid");
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
   jQuery.validator.addMethod("alphanumericspecial", function(value, element) {
        return this.optional(element) || value == value.match(/^[-a-zA-Z0-9_ ]+$/);
        }, "Only letters, Numbers & Space/underscore Allowed.");

    jQuery.validator.addMethod("alpha", function(value, element) {
return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
},"Only Characters Allowed.");

    jQuery.validator.addMethod("alphanumeric", function(value, element) {
return this.optional(element) || value == value.match(/^[a-z0-9A-Z#]+$/);
},"Only Characters, Numbers & Hash Allowed.");
   
   maxLength($("#address")); 	
});
</script>
<script type="text/javascript" src="<?php echo CKEDITOR_URL;?>ckeditor.js"></script>
<script type="text/javascript">
/*CKEDITOR.editorConfig = function( config )
{
	config.autoParagraph = false;
}*/

function availableNumbers(checkboxid,textboxid){
    if($("#"+checkboxid).is(":checked")){
	$('#'+textboxid).removeAttr('disabled');		
	}
	else{
	$('#'+textboxid).val('');	
	$('#'+textboxid).attr('disabled','disabled');
	}
}
///////////////////////////////////////////////////////////// Doctor List Ajax /////////////////////////////////////////////////////////////////////////////////////

function list_doctor(val,id)
{

if(id==1)
{
	if(val!='')
	{
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital);?>';
    name=val;
		
		$.ajax({
		  url: ajaxUrl,
		  data: {id: id, name: name, action:'searchDoctor' },
		  type: 'POST',
		  beforeSend: function(){$('#search_doctor_msg').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Searching doctors...</strong>');},
		  success: function(result) {
			
			if(result=='invaliddata'){
				alert('No doctor Found.');
			}
			if(result=='failed'){
				alert('Contact Person Details adding failed. Try again.');	
			}
			else{ 
			    $('#search_doctor_msg').animate({opacity:0.2}, 1000, function() { $('#search_doctor_msg').html('').animate({opacity:1}),1000  });
				$('#search_doctor_list').html(result)
				
			}
		  }
		});
	
	
      }
}
else if(id==2)
{ 
    if(val!='')
	{
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital);?>';
	pid='<?php echo $id;?>';
    name=val;
		
		$.ajax({
		  url: ajaxUrl,
		  data: {id: id, pid: pid, name: name, action:'searchDoctor' },
		  type: 'POST',
		  beforeSend: function(){$('#search_doctor_msg').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Searching doctors...</strong>');},
		  success: function(result) {
			
			if(result=='invaliddata'){
				alert('No doctor Found.');
			}
			if(result=='failed'){
				alert('Doctor Details adding failed. Try again.');	
			}
			else{ 
			    $('#search_doctor_msg').animate({opacity:1}, 1000, function() { $('#search_doctor_msg').html('').animate({opacity:1}),1000  });
				$('#search_doctor_list').html(result)
				
			}
		  }
		});
	
	
      }
}
}
function chkVal(doctorid,id,count)
{
 if(window.confirm('Would you like to update this doctor?')==true)
 {
 ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital);?>';
	pid='<?php echo $id;?>';
 
		
		$.ajax({
		  url: ajaxUrl,
		  data: {id: id, pid:pid, doctorid: doctorid, name: name, action:'updateDoctorList' },
		  type: 'POST',
		  beforeSend: function(){$('#search_doctor_msg').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Updating Doctor Table...</strong>');},
		  success: function(result) {
			
			if(result=='invaliddata'){
				alert('No doctor Found.');
			}
			if(result=='failed'){
				alert('Contact Person Details adding failed. Try again.');	
			}
			else{ 
			    $('#search_doctor_msg').animate({opacity:0.2}, 1000, function() { $('#search_doctor_msg').html('').animate({opacity:1}),1000  });
				$('#search_update_doctor_list').html(result)
				document.getElementById("did"+id).disabled=true;
			}
		  }
		});
	}
	else
	{
	document.getElementById("did"+id).checked=false;
	
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital);?>" enctype="multipart/form-data" method="post" class="formstyle1">
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
							if($msgInfo->hasMsg('modifyhospitalmsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('modifyhospitalmsg');?></td>
                    		</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                   		    <?php
							}
							?>
                            <tr>
								<td colspan="2" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b>Basic Hospital Information</b></td><td align="right" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;">
                                <?php
                        if($doaction=="edit"){
						?>
                                <a href="javascript:void(0);" onclick="javascript:window.open('<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospitalPathology.php").'?hid='.$id;?>&do=','Manage Hospital Pathology','scrollbars=yes,menubar=no,resizable=no,status=no,toolbar=no,width=960');">Manage Hospital Pathology</a>
                                <?php }?> 
                          </td></tr>
                            <tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Hospital Name <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="hospitalName" name="hospitalName" validate="{required:true,messages:{required:'Please enter a Hospital name.'}}" value="<?php echo $adminUtil->getPostFormData("hospitalName");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
                            <td class="formlabel">Hospital  Profile Image</td>
                                <td class="separter">:</td>
                                <td class="forminput"><input type="file" name="hospitalImg" id="hospitalImg" validate="{accept:'jpeg|jpg|png|gif',messages:{accept:'jpeg,png,gif are allowed file extensions.'}}"/> (Allowed extensions jpeg,jpg,gif,png)</td>
							</tr>
                             <tr>
                           	<td colspan="3" height="5px">                            
                            </tr>
                            <tr>
								<td class="formlabel"><strong>Make the Image Featured</strong></td>
                                <td class="separter">:</td>
                                <td class="forminput"> <input type="checkbox" id="featured_value" name="featured_value" value="1" <?php if($featured_value=='1'){ echo 'checked="checked"';}?>/>   (Optional) </td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <?php 
							$hospitalImg=$adminUtil->getPostFormData("hospitalImg");
							if($hospitalImg!='' && $doaction=="edit"){?>
                            <tr>
								<td class="formlabel">Current Hospital  Profile Image</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <input type="hidden" name="previousHospitalImg" id="previousHospitalImg" value="<?php echo $hospitalImg;?>" />
                                <img src="<?php print HOSPITAL_IMG_URL."medium/".$hospitalImg;?>" height="203" /><br />
                                Remove Image <input type="checkbox" name="removeHospitalImg" id="removeHospitalImg" value="Y" />                                </td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">
                            </tr>   
                            <?php }?>                                 
                            <tr>
								<td class="formlabel">Address <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><textarea name="address" id="address" validate="{required:true,messages:{required:'Please enter a Hospital Address.'}}" style="width: 209px; height: 54px;" maxlength="180"><?php echo $adminUtil->getPostFormData("address");?></textarea></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">State <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getStateOptions($globalUtil,array("id"=>'sid',"name"=>'sid','validate'=>"{required:true,messages:{required:'Select a state.'}}"),$adminUtil->getPostFormData("sid"),"WHERE status='1' AND cid='".$cityId."'");?></td>
							</tr>      
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">City <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php 
								print $AreaObj->getCityOptions($globalUtil,array("id"=>'cid',"name"=>'cid','validate'=>"{required:true,messages:{required:'Select a city.'}}"),$cityId);?></td>
							</tr>      
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Zone <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getZoneOptions($globalUtil,array("id"=>'zid',"name"=>'zid','validate'=>"{required:true,messages:{required:'Select a zone.'}}"),$adminUtil->getPostFormData("zid"),"WHERE status='1'");?></td>
							</tr>      
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Area <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getAreaOptions($globalUtil,array("id"=>'aid',"name"=>'aid','validate'=>"{required:true,messages:{required:'Select a area.'}}"),$adminUtil->getPostFormData("aid"),"WHERE status='1'");?></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Pincode <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="pincode" name="pincode" validate="{required:true,digits:true,messages:{required:'Please enter pincode.'}}" value="<?php echo $adminUtil->getPostFormData("pincode");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Alternate Email Address</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="emailAlternate" name="emailAlternate" validate="{email:true,messages:{email:'Please enter valid email.'}}" value="<?php echo $adminUtil->getPostFormData("emailAlternate");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Website</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="website" name="website" validate="{url:true,messages:{email:'Please enter valid url/website.'}}" value="<?php echo $adminUtil->getPostFormData("website");?>"/></div> Ex: http://doctorgonline.com / http://www.doctorgonline.com</td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Landline No.</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="phoneNo" name="phoneNo" validate="{digits:true,messages:{digits:'Please enter valid phone number.'}}" value="<?php echo $adminUtil->getPostFormData("phoneNo");?>"/></div> Please add STD Code . Ex: 03321234567 </td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Alternate Phone/Mobile No.</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="phoneNoAlternate" name="phoneNoAlternate" validate="{digits:true,messages:{digits:'Please enter valid alternate phone/mobile number.'}}" value="<?php echo $adminUtil->getPostFormData("phoneNoAlternate");?>"/></div> Please add STD Code . Ex: 03321234567 / 9830098300 </td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>  
                            <tr>
								<td class="formlabel">Fax No.</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="fax" name="fax" validate="{digits:true,messages:{digits:'Please enter valid fax number.'}}" value="<?php echo $adminUtil->getPostFormData("fax");?>"/></div> Please add STD Code . Ex: 03321234567</td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Accept Credit Card <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"> 
                                <?php $creditCardAccept=$adminUtil->getPostFormData("creditCardAccept");?>
                                Yes <input type="radio" id="creditCardAccept1" name="creditCardAccept" validate="{required:true,messages:{required:'Please select credit card option'}}" value="Y" <?php if($creditCardAccept=="Y"){?>checked="checked"<?php }?>/> No <input type="radio" id="creditCardAccept2" name="creditCardAccept" validate="{required:true,messages:{required:'Please select credit card option'}}" value="N" <?php if($creditCardAccept=="N"){?>checked="checked"<?php }?>/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">24 Hrs Availability <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $available24Hrs=$adminUtil->getPostFormData("available24Hrs");?>
                                 Yes <input type="radio" id="available24Hrs1" name="available24Hrs" validate="{required:true,messages:{required:'Please select 24 Hrs Availability'}}" value="Y" <?php if($available24Hrs=="Y"){?>checked="checked"<?php }?>/> No <input type="radio" id="available24Hrs2" name="available24Hrs" validate="{required:true,messages:{required:'Please select 24 Hrs Availability'}}" value="N" <?php if($available24Hrs=="N"){?>checked="checked"<?php }?>/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">About <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><textarea name="about" id="about" validate="{required:true,messages:{required:'Please enter about the Hospital.'}}" style="width: 209px; height: 54px;"><?php echo $adminUtil->getPostFormData("about");?></textarea></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Government Registration No <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="registrationNo" name="registrationNo" validate="{required:true,messages:{required:'Please enter valid registration number.'}}" value="<?php echo $adminUtil->getPostFormData("registrationNo");?>"/></div>(If not available type "Not Available")</td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td colspan="3" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b>More Hospital Information</b></td></tr>
                            <tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
								<td class="formlabel">Hospital Type <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $hospitalObj->getHospitalTypeOptions($globalUtil,array("id"=>'htid',"name"=>'htid','validate'=>"{required:true,messages:{required:'Select a hospital type.'}}"),$adminUtil->getPostFormData("htid"),"WHERE status='1'");?></td>
							</tr>      
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Hospital Category <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $hospitalObj->getHospitalCategoryOptions($globalUtil,array("id"=>'hcid',"name"=>'hcid','validate'=>"{required:true,messages:{required:'Select a hospital category.'}}"),$adminUtil->getPostFormData("hcid"),"WHERE status='1'");?></td>
							</tr>      
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Year of Establishment</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="YrofEstablishment" name="YrofEstablishment" validate="{required:true,digits:true,messages:{required:'Please enter year of establishment',digits:'Please enter valid year of establishment.'}}" value="<?php echo $adminUtil->getPostFormData("YrofEstablishment");?>"/></div> Ex: 2012</td>
							</tr>
                            <tr>
								<td class="formlabel">Disciplines</td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $hospitalObj->getDisciplinesOptions($globalUtil,'checkbox',array("id"=>'hdid',"name"=>'hdid[]'),$adminUtil->getPostFormData("hdid"),"WHERE status='1'");?></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Accreditation</td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $hospitalObj->getHospitalAccreditationOptions($globalUtil,array("id"=>'haid',"name"=>'haid'),$adminUtil->getPostFormData("haid"),"WHERE status='1'");?></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>  
                            <tr>
								<td class="formlabel">Authorized for medico-legal cases</td>
                                <td class="separter">:</td>
                                <td class="forminput"> 
                                <?php $medicoLegalCases=$adminUtil->getPostFormData("medicoLegalCases");?>
                                Yes <input type="radio" id="medicoLegalCases1" name="medicoLegalCases" value="Y" <?php if($medicoLegalCases=='Y'){?>checked="checked"<?php }?>/> No <input type="radio" id="medicoLegalCases2" name="medicoLegalCases" value="N" <?php if($medicoLegalCases=='N'){?>checked="checked"<?php }?>/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>  
                            <tr>
								<td class="formlabel">No of Beds</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="noOfBeds" name="noOfBeds" value="<?php echo $adminUtil->getPostFormData("noOfBeds");?>" validate="{digits:true,messages:{digits:'Please enter valid number of beds.'}}"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Other Facility</td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $hospitalObj->getOtherFacilitiesOptions($globalUtil,'checkbox',array("id"=>'hfid',"name"=>'hfid[]'),$adminUtil->getPostFormData("hfid"),"WHERE status='1'");?></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
                            	<td class="formlabel">Other Facility (Others)</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="otherFacility" name="otherFacility" value="<?php echo $adminUtil->getPostFormData("otherFacility");?>"/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
                            	<td class="formlabel">OPD Contact No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $oPDContactNoAvailable = $adminUtil->getPostFormData("oPDContactNoAvailable");?>
                                (Avialable) <input type="checkbox" id="oPDContactNoAvailable" name="oPDContactNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'oPDContactNo');" <?php if($oPDContactNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="oPDContactNo" name="oPDContactNo" value="<?php echo $adminUtil->getPostFormData("oPDContactNo");?>" <?php if($oPDContactNoAvailable=='N' || $oPDContactNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
                            	<td class="formlabel">Blood Bank No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $bloodBankNoAvailable = $adminUtil->getPostFormData("bloodBankNoAvailable");?>
                                (Avialable) <input type="checkbox" id="bloodBankNoAvailable" name="bloodBankNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'bloodBankNo');" <?php if($bloodBankNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="bloodBankNo" name="bloodBankNo" value="<?php echo $adminUtil->getPostFormData("bloodBankNo");?>" <?php if($bloodBankNoAvailable=='N' || $bloodBankNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>   
                            <tr>
                            	<td class="formlabel">Emergency Service No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $emergencyServiceNoAvailable = $adminUtil->getPostFormData("emergencyServiceNoAvailable");?>
                                (Avialable) <input type="checkbox" id="emergencyServiceNoAvailable" name="emergencyServiceNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'emergencyServiceNo');" <?php if($emergencyServiceNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="emergencyServiceNo" name="emergencyServiceNo" value="<?php echo $adminUtil->getPostFormData("emergencyServiceNo");?>" <?php if($emergencyServiceNoAvailable=='N' || $emergencyServiceNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>    
                            <tr>
                            	<td class="formlabel">Eye Bank No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $eyeBankNoAvailable = $adminUtil->getPostFormData("eyeBankNoAvailable");?>
                                (Avialable) <input type="checkbox" id="eyeBankNoAvailable" name="eyeBankNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'eyeBankNo');" <?php if($eyeBankNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="eyeBankNo" name="eyeBankNo" value="<?php echo $adminUtil->getPostFormData("eyeBankNo");?>" <?php if($eyeBankNoAvailable=='N' || $eyeBankNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
                            	<td class="formlabel">Organ Bank No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $organBankNoAvailable = $adminUtil->getPostFormData("organBankNoAvailable");?>
                                (Avialable) <input type="checkbox" id="organBankNoAvailable" name="organBankNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'organBankNo');" <?php if($organBankNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="organBankNo" name="organBankNo" value="<?php echo $adminUtil->getPostFormData("organBankNo");?>" <?php if($organBankNoAvailable=='N' || $organBankNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
                            	<td class="formlabel">Ambulence No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $ambulenceNoAvailable = $adminUtil->getPostFormData("ambulenceNoAvailable");?>
                                (Avialable) <input type="checkbox" id="ambulenceNoAvailable" name="ambulenceNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'ambulenceNo');" <?php if($ambulenceNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="ambulenceNo" name="ambulenceNo" value="<?php echo $adminUtil->getPostFormData("ambulenceNo");?>" <?php if($ambulenceNoAvailable=='N' || $ambulenceNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
                            	<td class="formlabel">Health Insurence Tie Ups No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $healthInsurenceTieUpsNoAvailable = $adminUtil->getPostFormData("healthInsurenceTieUpsNoAvailable");?>
                                (Avialable) <input type="checkbox" id="healthInsurenceTieUpsNoAvailable" name="healthInsurenceTieUpsNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'healthInsurenceTieUpsNo');" <?php if($healthInsurenceTieUpsNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="healthInsurenceTieUpsNo" name="healthInsurenceTieUpsNo" value="<?php echo $adminUtil->getPostFormData("healthInsurenceTieUpsNo");?>" <?php if($healthInsurenceTieUpsNoAvailable=='N' || $healthInsurenceTieUpsNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>  
                            <tr>
                            	<td class="formlabel">Guest House No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $guestHouseNoAvailable = $adminUtil->getPostFormData("guestHouseNoAvailable");?>
                                (Avialable) <input type="checkbox" id="guestHouseNoAvailable" name="guestHouseNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'guestHouseNo');" <?php if($guestHouseNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="guestHouseNo" name="guestHouseNo" value="<?php echo $adminUtil->getPostFormData("guestHouseNo");?>" <?php if($guestHouseNoAvailable=='N' || $guestHouseNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>                 
                            <tr>
								<td class="formlabel">Status <span class="compulsory">*</span></td>
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
							<td colspan="3" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b><?php if($action=='edit'){ ?>Edit Doctor<?php } else {?>Add Doctor<?php } ?></b></td>
							</tr>
							<tr>
                           	<td colspan="3" height="5px"></tr>
							<tr>
								<td class="formlabel">Search Doctors <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg">
								<?php if($action=='edit'){ ?>
								<input type="input" class="formtextbox" id="search" name="search" onkeyup="list_doctor(this.value,2)" />
								<?php } else {?>
								<input type="input" class="formtextbox" id="search" name="search" onkeyup="list_doctor(this.value,1)" />
								<?php } ?>
								</div>
								<?php
								if($action=='edit'){?>
								<span id="search_doctor_msg" style="float: right; margin-top:-18px; padding-right:480px;"></span>
								<?php } else {?>
								<span id="search_doctor_msg" style="float: right; margin-top:-18px; padding-right:500px;"></span>
								<?php } ?>
								</td>
							</tr>
							<tr>
                           	<td colspan="3" height="5px" ></tr>
							<tr>
							<tr>
                           	<td colspan="3" height="5px" ></tr>
							<tr>
                           	<td height="5px" colspan="2" id="search_update_doctor_list">
							<?php 
			       if($action=='edit'){ 
							$strdid=$adminUtil->getPostFormData("did");
							if($strdid!='')
								  {
										$did=explode(",",$strdid);
										$k=0;
										$count=0;
										$tr_class='';
										$checked='';
										
										if(count($did)>0){
								?>
						<table  width="90%" cellspacing="0" cellpadding="0" border="1" align="center"   style="border:#666666; border-width:1px; border-style:solid;position:static;">
						  <tr><td width="1%"><b></b></td><td class="formlabel"><b>List of <u>Selected Doctor name</u></b></td><!--<td width="15%" class="formlabel"><div align="left"><b>View Details</b></div></td>--></tr>
								<?php
								for($i=0;$i<count($did);$i++){
								/*$doctorList= $doctorObj->getDoctor($globalUtil," WHERE id='".$did[$i]."' ORDER BY id DESC ");
								echo "<pre>";
								print_r($doctorList);
								echo $doctorList->data[0]['firstName'];
								echo "</pre>";*/
								$sqldoctorList=mysql_query("SELECT firstName,lastName,id FROM ".TABLE_USER_DOCTOR." WHERE id='".$did[$i]."' ORDER BY id DESC ");
								$rsdoctorList=mysql_fetch_array($sqldoctorList);
								
								$count++;
								($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
								(in_array($rsdoctorList['id'], $did)) ? $checked = 'checked="checked"' : $checked = 'checked=" "';
								?>
								<tr id="<?php echo $rsdoctorList['id']; ?>" class="<?php echo $tr_class; ?>">
									<td align="center"  width="1%"><input type="checkbox" id="didchk" name="didchk[]" value="<?php echo $rsdoctorList['id']; ?>" <?php echo $checked; ?>  /></td>
									<td align="center" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left"><?php echo $rsdoctorList['firstName'].' '.$rsdoctorList['lastName']; ?></div></td>
									<!--<td align="center" style="font-size: 13px;padding-left: 5px;text-align: left;">View</td>-->
								</tr>
								<?php 
								$k++;
									   
									}
									?>
									</table>
									<?php
								}	
							} 
						} ?>
						</td>
						<td height="5px" id="search_doctor_list" >&nbsp;</td>
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