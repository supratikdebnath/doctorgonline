<?php
require("includes/connection.php");
require(PROJECT_DOCUMENT_PATH.CKEDITOR_FOLDER."ckeditor.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Modify Doctor");

$sqlAdminPrivsMaster="SELECT id as value,privilegeName as label FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE privilegeStatus='1'";
$adminPrivsMasterArr=$globalUtil->sqlFetchRowsAssoc($sqlAdminPrivsMaster,2);

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
	$pageHeading="Add Doctor";
	$submitValue="Submit";
	}
elseif($doaction=="edit"){
	
	$id=$_GET['id'];
	$pageHeading="Modify Doctor";
	$submitValue="Update";
	
	
	$formData=$doctorObj->getDoctor($globalUtil,"WHERE id='".$id."'");
	$adminUtil->unsetPostFormDataAll();
	//echo "<pre>";print_r($formData['data'][0]);echo "</pre>";
	$adminUtil->setPostFormData($formData['data'][0]);
	$cid=$adminUtil->getPostFormData("cid");
    $featured_value=$adminUtil->getPostFormData("featured_value");
	$doctorQualificationList=$doctorObj->getDoctorQualifications($globalUtil," WHERE dq.did='".$id."' AND tq.status='1' AND ts.status='1' ORDER BY dq.id ASC");
	//echo "<pre>";print_r($doctorQualificationList);echo "</pre>";die();
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
  //alert(Date.parse(<?php echo date('Y-m-d');?>));

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

	jQuery.validator.addMethod("greaterThan", 
	function(value, element, params) {
	
		if (!/Invalid|NaN/.test(new Date(value))) {
			return new Date(value) > new Date($(params).val());
		}
	
		return isNaN(value) && isNaN($(params).val()) 
			|| (Number(value) > Number($(params).val())); 
	},'Must be greater than {0}.');
	
	jQuery.validator.addMethod("CheckDOB", function (value, element) {
                // checking whether the date entered is in correct format
                //var isValid = value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
				var isValid = true;
                if(isValid){
                    //var minDate = Date.parse("01/01/1910");
                    var today = new Date();
					var today = Date.parse(today);
					var DOB = Date.parse(value);
                    //if ((DOB >= today || DOB <= minDate)) {
                    if (DOB >= today) {
					    isValid =  false;
                    }
                    return isValid;
                }
            }, "NotValid");
   
});
maxLength($("#address"));
</script>
<script type="text/javascript" src="<?php echo CKEDITOR_URL;?>ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.editorConfig = function( config )
{
	config.autoParagraph = false;
}

function addQualification(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Doctor);?>';
	specid=$('#specidq').val();
	qid=$('#qid').val();
	yearOfCompletion=$('#yearOfCompletion').val();
	instituteName=$('#instituteName').val();
    did='<?php echo $id;?>';
	error='';
	if(specid==''){
		alert('Please select specialization for Qualification');
		error=1;
		}
	else if(qid==''){
		alert('Please select Qualification');
		error=1;
		}	
	else if(yearOfCompletion==''){
		alert('Please select year of completion');
		error=1;
		}	
	else if(instituteName==''){
		alert('Please enter institute name');
		error=1;
		}		
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: { did: did, specid: specid, qid: qid, yearOfCompletion: yearOfCompletion, instituteName: instituteName, action:'addDocQ' },
		  type: 'POST',
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Qualification adding failed. Try again.');	
			}
			else{
				$('#docSpecification tr:last').before(result);
			}
		  }
		});
	}
}

function removeSpec(qid){

ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Doctor);?>';
did='<?php echo $id;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { did: did, id: qid, action:'delDocQ' },
		  type: 'POST',
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Qualification deletion failed. Try again.');	
			}
			else{
				$("#trqid"+qid).remove();
			}
		  }
		});	
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
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Doctor);?>" enctype="multipart/form-data" method="post" class="formstyle1">
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
                        if($doaction=="edit"){
						?>
                            <tr><td class="PageHeading" colspan="3" align="right" style="font-size: 14px;"><a href="javascript:void(0);" onclick="javascript:window.open('<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctorClinic.php").'?did='.$id;?>','Modify Doctor Clinics','scrollbars=yes,menubar=no,resizable=no,status=no,toolbar=no,width=960');">Manage Doctor Clinic</a></td></tr>
                        <?php }?>    
							<tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php
							if($msgInfo->hasMsg('modifydoctormsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('modifydoctormsg');?></td>
                    		</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                   		    <?php
							}
							?>
                            <tr>
								<td class="formlabel">First Name <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="firstName" name="firstName" validate="{required:true,alpha:true,messages:{required:'Please enter a Doctor First name.'}}" value="<?php echo $adminUtil->getPostFormData("firstName");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Middle Name</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="middleName" name="middleName" value="<?php echo $adminUtil->getPostFormData("middleName");?>" validate="{alpha:true}"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Last Name <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="lastName" name="lastName" validate="{required:true,alpha:true,messages:{required:'Please enter a Doctor Last name.'}}" value="<?php echo $adminUtil->getPostFormData("lastName");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Gender <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"> 
                                <?php $gender=$adminUtil->getPostFormData("gender");?>
                                Male <input type="radio" id="gender1" name="gender" validate="{required:true,messages:{required:'Please select gender'}}" value="M" <?php if($gender=='M'){?>checked="checked"<?php }?>/> Female <input type="radio" id="gender2" name="gender" validate="{required:true,messages:{required:'Please select gender'}}" value="F" <?php if($gender=='F'){?>checked="checked"<?php }?>/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>  
                            <tr>
								<td class="formlabel">Date of Birth <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="dateOfBirth" name="dateOfBirth" validate="{required:true,date:true,CheckDOB:true,messages:{required:'Please enter a Doctor Date of Birth.',CheckDOB:'Date of Birth cannot be set to future.'}}" value="<?php echo $globalUtil->formatDate($adminUtil->getPostFormData("dateOfBirth"),'Y-m-d');?>"/></div> (YYYY-MM-DD)</td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">Address <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><textarea name="address" id="address" validate="{required:true,messages:{required:'Please enter a Doctor Residential Address.'}}" style="width: 209px; height: 54px;" maxlength="180"><?php echo $adminUtil->getPostFormData("address");?></textarea></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">State <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getStateOptions($globalUtil,array("id"=>'sid',"name"=>'sid','validate'=>"{required:true,messages:{required:'Select a state.'}}"),$adminUtil->getPostFormData("sid"),"WHERE status='1' AND cid='".$cid."'");?></td>
							</tr>      
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr> 
                            <tr>
								<td class="formlabel">City <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getCityOptions($globalUtil,array("id"=>'cid',"name"=>'cid','validate'=>"{required:true,messages:{required:'Select a city.'}}"),$cid);?></td>
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
								<td class="formlabel">Mobile Number  <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="mobileNo" name="mobileNo" validate="{required:true,digits:true,messages:{required:'Please enter mobile number',digits:'Please enter valid mobile number.'}}" value="<?php echo $adminUtil->getPostFormData("mobileNo");?>"/></div> Don't add +91 </td>
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
								<td class="formlabel">Specialization <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $doctorObj->getSpecializationsOptions($globalUtil,array("id"=>'specid',"name"=>'specid','validate'=>"{required:true,messages:{required:'Select a specialization.'}}"),$adminUtil->getPostFormData("specid"),"WHERE status='1'");?></td>
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
								<td class="formlabel">Years of Experience <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="yearsOfExp" name="yearsOfExp" validate="{required:true,digits:true,messages:{required:'Please enter years of experience',digits:'Please enter valid years of experience. Only Numbers.'}}" value="<?php echo $adminUtil->getPostFormData("yearsOfExp");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">About <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><textarea name="about" id="about" validate="{required:true,messages:{required:'Please enter about the Doctor.'}}" style="width: 209px; height: 54px;"><?php echo $adminUtil->getPostFormData("about");?></textarea></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Registration No <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="registrationNo" name="registrationNo" validate="{required:true,messages:{required:'Please enter valid registration number.'}}" value="<?php echo $adminUtil->getPostFormData("registrationNo");?>"/></div>(If not available type "Not Available")</td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Designation</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="designation" name="designation" value="<?php echo $adminUtil->getPostFormData("designation");?>"/></div></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Consultancy Fees</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="consultancyFees" name="consultancyFees" validate="{number: true,messages:{number:'Please enter consultancy fees example 100.00'}}" value="<?php echo $adminUtil->getPostFormData("consultancyFees");?>"/></div></td>
							</tr>
                             <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Doctor Profile Image</td>
                                <td class="separter">:</td>
                                <td class="forminput"><input type="file" name="doctorImg" id="doctorImg" validate="{accept:'jpeg|jpg|png|gif',messages:{accept:'jpeg,png,gif are allowed file extensions.'}}"/> (Allowed extensions jpeg,jpg,gif,png)</td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php 
							$doctorProfileImg=$adminUtil->getPostFormData("doctorImg");
							if($doctorProfileImg!='' && $doaction=="edit"){?>
                            <tr>
								<td class="formlabel">Current Doctor Profile Image</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <input type="hidden" name="previousDoctorImg" id="previousDoctorImg" value="<?php echo $doctorProfileImg;?>" />
                                <img src="<?php print DOCTOR_IMG_URL."medium/".$doctorProfileImg;?>" height="203" /><br />
                                Remove Image <input type="checkbox" name="removeDoctorImg" id="removeDoctorImg" value="Y" />
                                </td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>   
                            <?php }?>  
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                              <tr>
								<td class="formlabel"><strong>Make the Image Featured</strong></td>
                                <td class="separter">:</td>
                                <td class="forminput"> <input type="checkbox" id="featured_value" name="featured_value" value="1" <?php if($featured_value=='1'){ echo 'checked="checked"';}?>/>   (Optional) </td>
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
                            <?php if($action=='edit'){?>
                            <tr>
                            	<td colspan="3">
                                	<table cellpadding="0" cellspacing="0" width="100%" class="specificationlisting" id="docSpecification">
    	<tr>
        	<td align="center">Qualification</td>
            <td align="center">Specialization</td>
            <td align="center">Institute</td>
            <td align="center">Yr. of Completition</td>
            <td align="center"></td>
        </tr>
        <tr>
        	<td><?php print $doctorObj->getQualificationsOptions($globalUtil,array("id"=>'qid',"name"=>'qid','style'=>'width:190px;'),'',"WHERE status='1'");?></td>
            <td><?php print $doctorObj->getSpecializationsOptions($globalUtil,array("id"=>'specidq',"name"=>'specidq','style'=>'width:190px;'),'',"WHERE status='1'");?></td>  
            <td><input type="text" id="instituteName" name="instituteName"></td>
            <td><?php print $doctorObj->getYearOptions($globalUtil,array("id"=>'yearOfCompletion',"name"=>'yearOfCompletion','style'=>'width:190px;'),'','1920',date('Y',time()));?></td>
            <td>&nbsp;</td>
        </tr>
        <?php 
		if($doctorQualificationList['numrows']>0){
		for($i=0;$i<$doctorQualificationList['numrows'];$i++){?>
        <tr id="trqid<?php echo $doctorQualificationList['data'][$i]['docqid'];?>">
        	<td align="center"><?php echo $doctorQualificationList['data'][$i]['qualificationName'];?></td>
            <td align="center"><?php echo $doctorQualificationList['data'][$i]['specName'];?></td>
            <td align="center"><?php echo $doctorQualificationList['data'][$i]['instituteName'];?></td>
            <td align="center"><?php echo $doctorQualificationList['data'][$i]['yearOfCompletion'];?></td>
            <td align="center"><a href="javascript:void(0);" onclick="javascript:removeSpec('<?php echo $doctorQualificationList['data'][$i]['docqid'];?>');"><b>Remove</b></a></td>
        </tr>
        <?php 
			}
		}	
		?>
        <tr>
        	<td colspan="5" align="right"><input type="button" name="addqualification" id="addqualification" value="Add Qualification" onclick="javascript:addQualification();" /></td>
        </tr>
    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php }?>
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