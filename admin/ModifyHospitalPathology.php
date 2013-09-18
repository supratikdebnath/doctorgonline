<?php
require("includes/connection.php");
require(PROJECT_DOCUMENT_PATH.CKEDITOR_FOLDER."ckeditor.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Modify Hospital Pathology");

$sqlAdminPrivsMaster="SELECT id as value,privilegeName as label FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE privilegeStatus='1'";
$adminPrivsMasterArr=$globalUtil->sqlFetchRowsAssoc($sqlAdminPrivsMaster,2);

$pathologyTestNameObj=new PathologyTestName;
$insuranceCompanyObj=new InsuranceCompany;
$insuranceTPAObj=new InsuranceTPA;
$hospitalObj=new Hospital;
$AreaObj=new Area;

if($_GET['hid']!=''){
$hid=$_GET['hid'];
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

if($action=='del' && $hid!='' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_PATHOLOGY_TESTS." WHERE id='".$id."' AND hid='".$hid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($hospitalObj->deleteHospitalPathologyTest($globalUtil,$adminUtil,$id,$hid)!=0){
	$msgInfo->setMessage("modifyHospitalPathologyTestmsg",SUCCESS_MSG_HOSPITAL_PATHOLOGY_TEST_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("modifyHospitalPathologymsg",ERROR_MSG_HOSPITAL_PATHOLOGY_TEST_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospitalPathology.php").'?hid='.$hid);
	
	}
	else{
	$msgInfo->setMessage("modifyHospitalPathologymsg",ERROR_MSG_HOSPITAL_PATHOLOGY_TEST_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospitalPathology.php").'?hid='.$hid);	
	}
}

	$formData=$hospitalObj->getHospitalPathology($globalUtil,"WHERE hid='".$hid."'");
	if($formData['numrows']==1){
		//echo 'Invalid Request. No Data Found. <a href="javascript:window.close();">Close Window</a>';
		//die();
	  $doaction="edit";	
	  $pageHeading="Modify Hospital Pathology";
	  $submitValue="Update";
	
	//echo "<pre>";print_r($formData);echo "</pre>";//die();
	$adminUtil->unsetPostFormDataAll();
	//echo "<pre>";print_r($formData['data'][0]);echo "</pre>";
	$adminUtil->setPostFormData($formData['data'][0]);
	//echo $adminUtil->getPostFormData("creditCardAccept");
	}
	else{
		$doaction="add";
		$pageHeading="Add Hospital Pathology";
		$submitValue="Submit";	
	}
	
$hospitalPathologyTestList=$hospitalObj->getHospitalPathologyTest($globalUtil,"WHERE hid='".$hid."'");
$hospitalDepartmentList=$hospitalObj->getHospitalDepartment($globalUtil,"WHERE hid='".$hid."'");
$hospitalRoomList=$hospitalObj->getHospitalRoom($globalUtil,"WHERE hid='".$hid."'");
$hospitalHealthList=$hospitalObj->getHospitalHealth($globalUtil,"WHERE hid='".$hid."'");
$insuranceCompanyList=$insuranceCompanyObj->getHospitalInsuranceCompany($globalUtil,"WHERE hid='".$hid."' AND insurance_tpa='' AND flag=1 ");
$insuranceTPAList=$insuranceTPAObj->getHospitalInsuranceTPA($globalUtil,"WHERE hid='".$hid."' AND insurance_company='' AND flag=2 ");
$hospitalContactList=$hospitalObj->getHospitalContact($globalUtil,"WHERE hid='".$hid."'");
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
   //maxLength($("#clinicAddress")); 
});

/*CKEDITOR.editorConfig = function( config )
{
   config.enableTabKeyTools = true;
};*/
function availableNumbers(checkboxid,textboxid){

    if($("#"+checkboxid).is(":checked")){
	$('#'+textboxid).removeAttr('disabled');		
	}
	else{
	$('#'+textboxid).val('');	
	$('#'+textboxid).attr('disabled','disabled');
	}
}
</script>
<script type="text/javascript" src="<?php echo CKEDITOR_URL;?>ckeditor.js"></script>
<!--<script type="text/javascript">
CKEDITOR.editorConfig = function( config )
{
	config.autoParagraph = false;
}
</script>-->
<script>
///////////////////////////////////////////////////////////// Get Pathology Test Name Ajax Start /////////////////////////////////////////////////////////////////////////////////////
function getTestName()
{

    ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
	testType=$('#testType').val();
	
	error='';
	if(testType=='N' || testType==''){
		alert('Please enter Pathlogy Test Type first');
		error=1;
		}
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {testType: testType, action:'getPathologyTestName' },
		  type: 'POST',
		  beforeSend: function(){$('#search_msg').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Listing Test Name...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Pathology Center Information adding failed. Try again.');	
			}
			else{
			 result_new = new Array();
			 result_new=result.split("*");
			
			if(result_new[1]=='0')
			{
			 $('#search_msg').animate({opacity:0.2}, 800, function() { $('#search_msg').html('<strong class="formlabel"><em>No Test Name exists !!</em></strong>').animate({opacity:1}),800  });
			  $('#testName').html(result_new[0]);
			}
			else if(result_new[1]!='0')
			{
			    $('#search_msg').animate({opacity:0.2}, 800, function() { $('#search_msg').html('<strong class="formlabel"><em>Listed.Please select Test Name</em></strong>').animate({opacity:1}),800  });
				$('#testName').html(result);
			}
				
				
				
			}
		  }
		});
	}
   
}
///////////////////////////////////////////////////////////// Get Pathology Test Name Ajax End /////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Remove Message Start /////////////////////////////////////////////////////////////////////////////////////
function removeMessage()
{
$('#search_msg').html('');
}
///////////////////////////////////////////////////////////// Remove Message End /////////////////////////////////////////////////////////////////////////////////////
</script>
<script>
///////////////////////////////////////////////////////////// Add More Pathology Test Start /////////////////////////////////////////////////////////////////////////////////////

function addMoreInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
	testType=$('#testType').val();
	testName=$('#testName').val();
	testPrice=$('#testPrice').val();
	additionalInfo=$('#additionalInfo').val();
	hid='<?php echo $hid;?>';
	error='';
	if(testType==''){
		alert('Please select Test Type');
		error=1;
		}
	else if(testName==''){
		alert('Please select Test Name');
		error=1;
		}	
	else if(testPrice==''){
		alert('Please enter Test Price');
		error=1;
		}	
	/*else if(additionalInfo==''){
		alert('Please enter Additional Info(if any)');
		error=1;
		}	*/	
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {hid: hid, testType: testType, testName: testName, testPrice: testPrice, additionalInfo: additionalInfo, action:'addMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg').html('<strong class="formlabel">Updating Test Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital pathology information adding failed. Try again.');	
			}
			else{ 
			    $('#msg').animate({opacity:0.2}, 1000, function() { $('#msg').html('').animate({opacity:1}),1000  });
				$('#tridnorecord').hide();
				$('#addInfo tr:last').after(result);
				
			}
		  }
		});
	}
	}
function removeSpec(id){
if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
hid='<?php echo $hid;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { hid: hid, id: id, action:'deladdMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg').html('<strong class="formlabel">Deleting Test Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital pathology information adding failed. Try again.');	
			}
			else{
			    $('#msg').animate({opacity:0.2}, 1000, function() { $('#msg').html('').animate({opacity:1}),1000  });
				$('#tridnorecord').show();
				$("#trid"+id).remove();
			}
		  }
		});	

     }
}
///////////////////////////////////////////////////////////// Add More Pathology Test End /////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Add Department Information Start /////////////////////////////////////////////////////////////////////////////////////

function addDepartmentInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
	department_name=$('#department_name').val();
	registration_time=$('#registration_time').val();
	consulation_time=$('#consulation_time').val();
	contactno=$('#contactno').val();
	if($('#openAllDay1').attr('checked')==true)
	{
	openAllDay=$('#openAllDay1').val();
	}
	else if($('#openAllDay2').attr('checked')==true)
	{
	openAllDay=$('#openAllDay2').val();
	}
	otherInformationAvailable=$('#otherInformationAvailable').val();
	otherInformation=$('#otherInformation').val();
	hid='<?php echo $hid;?>';
	
	error='';
	if(department_name==''){
		alert('Please enter Department Name');
		error=1;
		}
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {hid: hid, department_name: department_name, registration_time: registration_time, consulation_time: consulation_time, contactno: contactno,  openAllDay: openAllDay, otherInformationAvailable: otherInformationAvailable, otherInformation: otherInformation, action:'addDepartmentMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_dept').html('<strong class="formlabel">Updating Department Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Department Information adding failed. Try again.');	
			}
			else{ 
			    $('#msg_dept').animate({opacity:0.2}, 1000, function() { $('#msg_dept').html('').animate({opacity:1}),1000  });
				$('#trdelidnorecord').hide();
				$('#addDeptInfo tr:last').after(result);
				
			}
		  }
		});
	   }
	}
function removeDeptSpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
hid='<?php echo $hid;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { hid: hid, id: id, action:'delDeptMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_dept').html('<strong class="formlabel">Deleting Department Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Department Information deletion failed. Try again.');	
			}
			else{
			    $('#msg_dept').animate({opacity:0.2}, 1000, function() { $('#msg_dept').html('').animate({opacity:1}),1000  });
				$('#trdelidnorecord').show();
				$("#trdelid"+id).remove();
			}
		  }
		});	
     }
}


///////////////////////////////////////////////////////////// Add Department Information End /////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Add Room Information Start /////////////////////////////////////////////////////////////////////////////////////
function chkOther(val)
{
	
	if(val=='Any Other facility' && $('#arr_id6').attr('checked')==true)
	{
		
		$("#otherFacility").removeAttr('disabled');
	}
	else if($('#arr_id6').attr('checked')==false)
	{
		
		$("#otherFacility").attr('disabled','disabled');
	}
	
}
function addRoomInfo(){	
    var count=$('#arr_count').val();
	var arr_other= new Array();
	
    for(i=0;i<count;i++)
	{
		if($('#arr_id'+i).attr('checked')==true)
	    {
			
			if(arr_other[i] !== "" && arr_other[i] !== null){
				
				if($('#arr_name'+i).val()=='Any Other facility' && $('#arr_id6').attr('checked')==true)
				{
					arr_other.push($('#arr_name'+i).val());
					arr_other.pop($('#arr_name6').val());
					arr_other.push($("#otherFacility").val());
					
				}
				else
				{
				arr_other.push($('#arr_name'+i).val());
				}
			   }
		}
	}
	arr_other_str=arr_other.toString();
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
	room_type=$('#room_type').val();
	bed_no=$('#bed_no').val();
	bed_charge=$('#bed_charge').val();
	day_charge=$('#day_charge').val();
	contactroomno=$('#contactroomno').val();
	hid='<?php echo $hid;?>';
	
	error='';
	if(room_type==''){
		alert('Please enter Room Type/ Name');
		error=1;
		}
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {hid: hid, room_type: room_type, bed_no: bed_no, bed_charge: bed_charge, day_charge:day_charge, contactroomno: contactroomno,  arr_other_str: arr_other_str, action:'addRoomMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_room').html('<strong class="formlabel">Updating Room Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Room Information adding failed. Try again.');	
			}
			else{ 
			    $('#msg_room').animate({opacity:0.2}, 1000, function() { $('#msg_room').html('').animate({opacity:1}),1000  });
				$('#trrolidnorecord').hide();
				$('#addRoomInfo tr:last').after(result);
				
			}
		  }
		});
	   }
	}
function removeRoomSpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
hid='<?php echo $hid;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { hid: hid, id: id, action:'delRoomMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_dept').html('<strong class="formlabel">Deleting Room Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Room Information deletion failed. Try again.');	
			}
			else{
			    $('#msg_dept').animate({opacity:0.2}, 1000, function() { $('#msg_dept').html('').animate({opacity:1}),1000  });
				$('#trrolidnorecord').show();
				$("#trrolid"+id).remove();
			}
		  }
		});	
     }
}


///////////////////////////////////////////////////////////// Add Room Information End /////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Add Health Information Start /////////////////////////////////////////////////////////////////////////////////////

function addHealthInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
	packageName=$('#packageName').val();
	packagePrice=$('#packagePrice').val();
	details=$('#details').val();
	hid='<?php echo $hid;?>';
	
	error='';
	if(packageName==''){
		alert('Please enter Package Name');
		error=1;
		}
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {hid: hid, packageName: packageName, packagePrice: packagePrice, details: details, action:'addHealthMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_health').html('<strong class="formlabel">Updating Health Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Health Information adding failed. Try again.');	
			}
			else{ 
			    $('#msg_health').animate({opacity:0.2}, 1000, function() { $('#msg_health').html('').animate({opacity:1}),1000  });
				$('#trhelidnorecord').hide();
				$('#addHealthInfo tr:last').after(result);
				
			}
		  }
		});
	   }
	}
function removeHealthSpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
hid='<?php echo $hid;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { hid: hid, id: id, action:'delHealthMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_health').html('<strong class="formlabel">Deleting Health Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Health Information deletion failed. Try again.');	
			}
			else{
			    $('#msg_dept').animate({opacity:0.2}, 1000, function() { $('#msg_health').html('').animate({opacity:1}),1000  });
				$('#trhelidnorecord').show();
				$("#trhelid"+id).remove();
			}
		  }
		});	
     }
}


///////////////////////////////////////////////////////////// Add Health Information End /////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Add Insurance Company Information Start ////////////////////////////////////////////////////////////////////////////

function addInsuranceCoInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
	insurance_company=$('#insurance_company').val();
	flag=1;
	hid='<?php echo $hid;?>';
	
	error='';
	if(insurance_company==''){
		alert('Please select Insurance Company');
		error=1;
		}
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {hid: hid, insurance_company: insurance_company, flag: flag, action:'addInsuranceCoMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_insu_co').html('<strong class="formlabel">Updating Insurance Company Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Insurance Company adding failed. Try again.');	
			}
			else{ 
			    $('#msg_insu_co').animate({opacity:0.2}, 1000, function() { $('#msg_insu_co').html('').animate({opacity:1}),1000  });
				$('#trinslidnorecord').hide();
				$('#addInsuranceCoInfo tr:last').after(result);
				
			}
		  }
		});
	   }
	}
function removeInsuranceCoSpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
hid='<?php echo $hid;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { hid: hid, id: id, action:'delInsuranceCoMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_insu_co').html('<strong class="formlabel">Deleting Insurance Company Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Insurance Company Information deletion failed. Try again.');	
			}
			else{
			    $('#msg_insu_co').animate({opacity:0.2}, 1000, function() { $('#msg_insu_co').html('').animate({opacity:1}),1000  });
				$('#trinslidnorecord').show();
				$("#trinslid"+id).remove();
			}
		  }
		});	
     }
}


///////////////////////////////////////////////////////////// Add Insurance Company Information End //////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Add Insurance Company Information Start ////////////////////////////////////////////////////////////////////////////

function addInsuranceTPAInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
	insurance_tpa=$('#insurance_tpa').val();
	flag=2;
	hid='<?php echo $hid;?>';
	
	error='';
	if(insurance_tpa==''){
		alert('Please select Insurance TPA');
		error=1;
		}
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {hid: hid, insurance_tpa: insurance_tpa, flag: flag, action:'addInsuranceTPAMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_insu_tpa').html('<strong class="formlabel">Updating Insurance TPA Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Insurance TPA adding failed. Try again.');	
			}
			else{ 
			    $('#msg_insu_tpa').animate({opacity:0.2}, 1000, function() { $('#msg_insu_tpa').html('').animate({opacity:1}),1000  });
				$('#trinstpalidnorecord').hide();
				$('#addInsuranceTPAInfo tr:last').after(result);
				
			}
		  }
		});
	   }
	}
function removeInsuranceTPASpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
hid='<?php echo $hid;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { hid: hid, id: id, action:'delInsuranceTPAMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_insu_tpa').html('<strong class="formlabel">Deleting Insurance TPA Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Insurance TPA Information deletion failed. Try again.');	
			}
			else{
			    $('#msg_insu_tpa').animate({opacity:0.2}, 1000, function() { $('#msg_insu_tpa').html('').animate({opacity:1}),1000  });
				$('#trinstpalidnorecord').show();
				$("#trinstpalid"+id).remove();
			}
		  }
		});	
     }
}


///////////////////////////////////////////////////////////// Add Insurance Company Information End //////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////// Add Contact Information Start ////////////////////////////////////////////////////////////////////////////

function addContactInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
	name=$('#name').val();
	designation=$('#designation').val();
	email=$('#email').val();
	hospcontactno=$('#hospcontactno').val();
	hid='<?php echo $hid;?>';
	
	error='';
	if(name==''){
		alert('Please enter your Name');
		error=1;
		}
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {hid: hid, name: name, designation: designation, email:email, hospcontactno:hospcontactno, action:'addContactMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_contact').html('<strong class="formlabel">Updating Contact Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Contact Information adding failed. Try again.');	
			}
			else{ 
			    $('#msg_contact').animate({opacity:0.2}, 1000, function() { $('#msg_contact').html('').animate({opacity:1}),1000  });
				$('#trcolidnorecord').hide();
				$('#addContactInfo tr:last').after(result);
				
			}
		  }
		});
	   }
	}
function removeContactSpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>';
hid='<?php echo $hid;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { hid: hid, id: id, action:'delContactMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_contact').html('<strong class="formlabel">Deleting Contact Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Hospital Contact Information deletion failed. Try again.');	
			}
			else{
			    $('#msg_contact').animate({opacity:0.2}, 1000, function() { $('#msg_contact').html('').animate({opacity:1}),1000  });
				$('#trcolidnorecord').show();
				$("#trcolid"+id).remove();
			}
		  }
		});	
     }
}


///////////////////////////////////////////////////////////// Add Insurance Company Information End //////////////////////////////////////////////////////////////////////////////
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
						<form id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Hospital_Pathology);?>" enctype="multipart/form-data" method="post" class="formstyle1">
                        <input type="hidden" name="hid" id="hid" value="<?php echo $hid;?>" />
						<?php
                        if($doaction=="edit"){
						?><input type="hidden" name="id" id="id" value="<?php echo $adminUtil->getPostFormData("id");?>" />
                        <?php }?>
                        <table width="100%" cellpadding="0" cellspacing="0">
							<tr><td class="PageHeading" colspan="3"><?php echo $pageHeading;?></td></tr>
							<tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <?php
							if($msgInfo->hasMsg('modifyHospitalPathologymsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3"><?php echo $msgInfo->displayMsg('modifyHospitalPathologymsg');?></td>
                    		</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                   		    <?php
							}
							?>
                            <tr>
								<td class="formlabel">Year of Establishment <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="yearofEstablishment" name="yearofEstablishment" validate="{date:true,messages:{date:'Please enter year of establishment.'}}" value="<?php echo $adminUtil->getPostFormData("yearofEstablishment");?>"/></div></td>
							</tr>
                            <tr>
								<td class="formlabel">Contact No <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="contactNo" name="contactNo" validate="{digits:true,messages:{digits:'Please enter valid contact number with STD CODE.'}}" value="<?php echo $adminUtil->getPostFormData("contactNo");?>"/></div> Ex : 03321235678</td>
							</tr>
                            <tr>
								<td class="formlabel">Accreditation </td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $hospitalObj->getHospitalAccreditationOptions($globalUtil,array("id"=>'haid',"name"=>'haid'),$adminUtil->getPostFormData("haid"),"WHERE status='1'");?></td>
							</tr>
                            <tr>
								<td class="formlabel">Open All Days </td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $openAllDaysStatus=$adminUtil->getPostFormData("openAllDays");?>
                                Yes <input type="radio" id="openAllDays1" name="openAllDays" value="1" <?php if($openAllDaysStatus=='1'){?>checked="checked"<?php }?>/>  No <input type="radio" id="openAllDays2" name="openAllDays" value="0" <?php if($openAllDaysStatus=='0'){?>checked="checked"<?php }?>/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Closed On </td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $closedOnDay=$adminUtil->getPostFormData("closedOn")?>
                                <select name="closedOn" id="closedOn">
                                <option value="Sunday" <?php if($closedOnDay=='Sunday'){?>selected="selected"<?php }?>>Sunday</option>
                                <option value="Monday" <?php if($closedOnDay=='Monday'){?>selected="selected"<?php }?>>Monday</option>
                                <option value="Tuesday" <?php if($closedOnDay=='Tuesday'){?>selected="selected"<?php }?>>Tuesday</option>
                                <option value="Wednusday" <?php if($closedOnDay=='Wednusday'){?>selected="selected"<?php }?>>Wednusday</option>
                                <option value="Thursday" <?php if($closedOnDay=='Thursday'){?>selected="selected"<?php }?>>Thursday</option>
                                <option value="Friday" <?php if($closedOnDay=='Friday'){?>selected="selected"<?php }?>>Friday</option>
                                <option value="Saturday" <?php if($closedOnDay=='Saturday'){?>selected="selected"<?php }?>>Saturday</option>
                                </select></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Facilities </td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $pathologyFacilities=$hospitalObj->getHospitalPathologyFacilities();
								$hospitalUserFacilities=$adminUtil->getPostFormData("pfids");
								$hospitalUserFacilities=explode(',',$hospitalUserFacilities);
								foreach($pathologyFacilities as $key=>$values){
								?>
                                <input type="checkbox" id="pfids<?php echo $key;?>" name="pfids[]" value="<?php echo $values;?>" <?php if(in_array($values,$hospitalUserFacilities)){?>checked="checked"<?php }?>/> <?php echo $values;?> &nbsp;
                                <?php }?>
                                
                                
                                </td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Any Tie-Ups with Specialised Labs</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <div class="forminputboxbg"><input type="input" class="formtextbox" id="tieUpsLabs" name="tieUpsLabs" value="<?php echo $adminUtil->getPostFormData("tieUpsLabs");?>"/></div>
                                </td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Extra Charges(if Any)</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <div class="forminputboxbg"><input type="input" class="formtextbox" id="extraCharges" name="extraCharges" value="<?php echo $adminUtil->getPostFormData("extraCharges");?>"/></div>
                                </td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
								<td class="formlabel">Home Collection(if Any)</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <div class="forminputboxbg"><input type="input" class="formtextbox" id="homeCollection" name="homeCollection" value="<?php echo $adminUtil->getPostFormData("homeCollection");?>"/></div>
                                </td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
                            <tr>
							<tr>
								<td></td>
                                <td></td>
                                <td class="btnposition"><input type="submit" name="Submit" class="submitbtn" value="<?php echo $submitValue;?>" /> &nbsp; <input type="button" class="submitbtn" value="Close" onclick="javascript:window.close();"/></td>
							</tr>
                            <tr>
                            	<td colspan="3" height="5px">
                            </tr>
						</table>
                        </form>
                        <br /><br />
						<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="formstyle1 cliniclisting">
						<tr><td colspan="4" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><strong>Pathology Test Information</strong></td>
						<tr><td colspan="4">&nbsp;</td>
						</tr>
  						<tr>
						<td width="8%" class="formlabel">Test Type<span class="compulsory">*</span>: 
						<td width="36%">
	<?php print $pathologyTestNameObj->getPathologyTestTypeOptions($globalUtil,array("id"=>'testType',"name"=>'testType','validate'=>"{required:true,messages:{required:'Select a Pathology Test Type.'}}","onchange"=>'getTestName()'),'');?>
	&nbsp;<span id="search_msg"></span>
	<!--<select name="testType" id="testType">
	<option value="">Select Type</option>
	<option value="type1">type1</option>
	<option value="type2">type2</option>-->
	</select>
	</td>
    <td width="12%" class="formlabel">Test Name<span class="compulsory">*</span>: </td>
	<td width="44%">
	<select name="testName" id="testName" onChange="removeMessage()">
	<option value="">-Select Pathology Test Name-</option>
	</select> 
	<!--<select name="testName" id="testName">
	<option value="">Select Name</option>
	<option value="name1">name1</option>
	<option value="name2">name2</option>
	</select>-->
	</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td class="formlabel">Test Price<span class="compulsory">*</span>: </td>
    <td><input type="text" name="testPrice" id="testPrice" /></td>
	<td class="formlabel">Additional Info( if any): </td>
    <td><!--<input type="text" name="additionalInfo" id="additionalInfo" />--><textarea name="additionalInfo" id="additionalInfo" rows="5" cols="40"></textarea></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2"><input type="button" value="Add More" onclick="javascript:addMoreInfo();"/></td>
	<td colspan="2"><span id="msg"></span></td>
  </tr>
  <tr>
    <td colspan="4" >&nbsp;</td>
  </tr>
   <tr>
   <td  colspan="4">
  <table width="80%" cellspacing="0" cellpadding="0" border="0" align="center"  id="addInfo" style="border:#666666; border-width:1px; border-style:solid;">
  <tr >
  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Test Type</strong></td>
  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Test Name</strong></td> 
  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Price</strong></td> 		  
  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Additional Info</strong></td> 
  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td>
  </tr>
   <?php 
        $addinfo = '';
		$count=0;
		if($hospitalPathologyTestList['numrows']>0){
		for($i=0;$i<$hospitalPathologyTestList['numrows'];$i++){
		if($hospitalPathologyTestList['data'][$i]['additionalInfo']!='')
		$addinfo = $hospitalPathologyTestList['data'][$i]['additionalInfo'];
	    else
		$addinfo = 'No additional info available';
		$count++;
		($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
		$sqlExistsTestType="SELECT test_type FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id=".$hospitalPathologyTestList['data'][$i]['testType'];
		$rsExistsTestType=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestType,2);
		$sqlExistsTestName="SELECT test_name,status FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id=".$hospitalPathologyTestList['data'][$i]['testName'];
		$rsExistsTestName=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestName,2);
		?>
        <tr id="trid<?php echo $hospitalPathologyTestList['data'][$i]['id'];?>" class="<?php echo $tr_class; ?>">
        	<td align="center" class="formlabel"><?php echo $rsExistsTestType['data'][0]['test_type'];?></td>
            <td align="center" class="formlabel"><?php echo $rsExistsTestName['data'][0]['test_name'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalPathologyTestList['data'][$i]['testPrice'];?></td>
            <td align="center" class="formlabel"><?php echo $addinfo;?></td>
            <td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeSpec('<?php echo $hospitalPathologyTestList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
        </tr>
        <?php 
			}
		}else{ ?>
        <tr><td align="center" id="tridnorecord" colspan="5" style="font-size: 13px;"><strong><em>No Records Displayed</em></strong></td></tr>
        <?php
		}
		?>
  </table><br />
</table>
 						<br /><br />
                  <table width="100%" cellspacing="0" cellpadding="0" border="0" id="" align="center" class="formstyle1 cliniclisting">
						<tr><td colspan="5" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><strong>Department Information</strong></td>
						<tr><td colspan="5">&nbsp;</td>
						</tr>
								 <tr>
						<td width="11%" class="formlabel">Department Name<span class="compulsory">*</span>: 
						<td width="21%">
						<input type="text" name="department_name" id="department_name" />
						</td>
						<td width="11%" class="formlabel">Registration Time: </td>
						<td width="16%">
						<input type="text" name="registration_time" id="registration_time" />
						</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Consulation Time <span class="compulsory"></span>: </td>
						<td><input type="text" name="consulation_time" id="consulation_time" /></td>
						<td class="formlabel">Contact No : </td>
						<td><input type="text" name="contactno" id="contactno" /></td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="32" class="formlabel">Open All Days  <span class="compulsory"></span>: </td>
						<td> Yes <input type="radio" id="openAllDay1" name="openAllDay" validate="{required:true,messages:{required:'Please select credit card option'}}" value="Y" /> No <input type="radio" id="openAllDay2" name="openAllDay" validate="{required:true,messages:{required:'Please select credit card option'}}" value="N" /></td>
						<td class="formlabel">&nbsp;</td>
						<td align="right" valign="top" width="16%"><span class="formlabel">Other Information(Available)  : </span>						  <input type="checkbox" id="otherInformationAvailable" name="otherInformationAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'otherInformation');" /></td><td width="41%"> <textarea id="otherInformation" name="otherInformation" rows="5" cols="40" disabled="disabled"></textarea></td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More" onclick="javascript:addDepartmentInfo();"/></td>
						<td colspan="4"><span id="msg_dept"></span></td>
					  </tr>
					  <tr>
						<td colspan="5" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="5">
					  <table width="90%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addDeptInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
		<td width="11%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Department Name</strong></td> 
		<td width="12%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Registration Time</strong></td> 
		<td width="15%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Consulation Time</strong></td> 
		<td width="11%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Contact No</strong></td>
		<td width="14%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Open All Days</strong></td>
		<td width="16%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Other Information</strong></td>        <td width="21%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> 
					  </tr>
                      <?php 
				$addinfo = '';
				$count=0;
				if($hospitalDepartmentList['numrows']>0){
				for($i=0;$i<$hospitalDepartmentList['numrows'];$i++){
				if($hospitalDepartmentList['data'][$i]['otherInformationAvailable']=='Y')
				$addinfo = $hospitalDepartmentList['data'][$i]['otherInformation'];
				else
				$addinfo = 'No other info available';
				$count++;
				($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				
		?>
        <tr id="trdelid<?php echo $hospitalDepartmentList['data'][$i]['id'];?>" class="<?php echo $tr_class; ?>">
        	<td align="center" class="formlabel"><?php echo $hospitalDepartmentList['data'][$i]['department_name'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalDepartmentList['data'][$i]['registration_time'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalDepartmentList['data'][$i]['consulation_time'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalDepartmentList['data'][$i]['contactno'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalDepartmentList['data'][$i]['openAllDay'];?></td>
            <td align="center" class="formlabel"><?php echo $addinfo;?></td>
            <td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeDeptSpec('<?php echo $hospitalDepartmentList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
        </tr>
        <?php 
			}
		}else{ ?>
        <tr><td align="center" id="trdelidnorecord" colspan="7" style="font-size: 13px;"><strong><em>No Records Displayed</em></strong></td></tr>
        <?php
		}
			?>		   
  </table><br />
</table>

                  <br /><br />
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="" align="center" class="formstyle1 cliniclisting">
						<tr><td colspan="5" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><strong>Detailed Room Information</strong></td>
						<tr><td colspan="5">&nbsp;</td>
						</tr>
								 <tr>
						<td width="12%" class="formlabel">Room Type/ Name<span class="compulsory">*</span>: 
						<td width="31%">
						<input type="text" name="room_type" id="room_type" />
						</td>
						<td width="14%" class="formlabel">No. Of Bed: </td>
						<td width="43%">
						<input type="text" name="bed_no" id="bed_no" />
						</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Charges per Bed<span class="compulsory"></span>: </td>
						<td><input type="text" name="bed_charge" id="bed_charge" /></td>
						<td class="formlabel">Charges per Day : </td>
						<td><input type="text" name="day_charge" id="day_charge" /></td>
					  </tr>
                      <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Contact No<span class="compulsory"></span>: </td>
						<td><input type="text" name="contactroomno" id="contactroomno" /></td>
						<td class="formlabel" valign="top">Others : </td>
						<td>
                        <?php
                        $arr=array('AC','TV','24 hrs Nurse','Attached Toilet','Relative Stay','Internet','Any Other facility');
						$html = "<table border='0' width='100%'><tr>";
						$cnt=0;
						$id=0;
						for($i=0;$i<count($arr);$i++)
						{
							$cnt++;
							$html .= '<td valign="top" class="formlabel"><input type="checkbox" value="'.$arr[$i].'" id="arr_id'.$i.'" onclick="chkOther(this.value)">';
							$html .= $arr[$i].'<input type="hidden" id="arr_name'.$i.'" value="'.$arr[$i].'"></td>';
							$id++;
							if($cnt%3==0){
									$html .= "</tr><tr>";
								}
						}
						$html .="<tr><td colspan='3'><textarea id='otherFacility' name='otherFacility' rows='5' cols='40' disabled='disabled'></textarea></td></tr>";
						$html .= "</tr></table>";
						
						echo $html;
						?>
                        <input type="hidden" id="arr_count" value="<?php echo count($arr); ?>" />
                        </td>
					  </tr>
                      
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More" onclick="javascript:addRoomInfo();"/></td>
						<td colspan="4"><span id="msg_room"></span></td>
					  </tr>
					  <tr>
						<td colspan="5" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="5">
					  <table width="90%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addRoomInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
		<td width="11%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Room Type/Name</strong></td> 
		<td width="12%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>No. Of Bed</strong></td> 
		<td width="15%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Charges per Bed</strong></td> 
		<td width="11%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Charges per Day</strong></td>
		<td width="14%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Contact No</strong></td>
		<td width="16%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Others</strong></td>    
		<td width="21%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> 
					  </tr>
                      <?php 
				$addinfo = '';
				$count=0;
				if($hospitalRoomList['numrows']>0){
				for($i=0;$i<$hospitalRoomList['numrows'];$i++){
				$count++;
				($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				
		?>
        <tr id="trrolid<?php echo $hospitalRoomList['data'][$i]['id'];?>" class="<?php echo $tr_class; ?>">
        	<td align="center" class="formlabel"><?php echo $hospitalRoomList['data'][$i]['room_type'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalRoomList['data'][$i]['bed_no'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalRoomList['data'][$i]['bed_charge'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalRoomList['data'][$i]['day_charge'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalRoomList['data'][$i]['contactroomno'];?></td>
            <td align="center" class="formlabel"><?php echo $hospitalRoomList['data'][$i]['arr_other_str'];?></td>
            <td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeRoomSpec('<?php echo $hospitalRoomList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
        </tr>
        <?php 
			}
		}else{ ?>
        <tr><td align="center" id="trrolidnorecord" colspan="7" style="font-size: 13px;"><strong><em>No Records Displayed</em></strong></td></tr>
        <?php
		}
			?>		   
  </table><br />
</table><br /><br />

<table width="100%" cellspacing="0" cellpadding="0" border="0" id="" align="center" class="formstyle1 cliniclisting">
						<tr>
						  <td colspan="5" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><strong>Health Package Information</strong></td>
						<tr><td colspan="5">&nbsp;</td></tr>
								 <tr>
						<td width="10%" class="formlabel">Package Name <span class="compulsory">*</span>: 
						<td width="29%">
						<input type="text" name="packageName" id="packageName" />						</td>
						
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Package  Price<span class="compulsory"></span>: </td>
						<td><input type="text" name="packagePrice" id="packagePrice" /></td>
						<td width="7%" class="formlabel">Details: </td>
						<td width="54%"><textarea id="details" name="details" rows="5" cols="40" ></textarea></td>
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More" onclick="javascript:addHealthInfo();"/></td>
						<td colspan="4"><span id="msg_health"></span></td>
					  </tr>
					  <tr>
						<td colspan="5" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="5">
					  <table width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addHealthInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Package Name</strong></td> 
					  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Package  Price</strong></td> 
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Details</strong></td>
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> </tr>
					   <?php 
							$addinfo = '';
							$count = 0;
							if($hospitalHealthList['numrows']>0){
							for($i=0;$i<$hospitalHealthList['numrows'];$i++){
							if($hospitalHealthList['data'][$i]['details']!='')
							$details = $hospitalHealthList['data'][$i]['details'];
							else
							$details = 'No additional info available';
							$count++;
							($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				
							?>
							<tr id="trhelid<?php echo $hospitalHealthList['data'][$i]['id'];?>" class="<?php echo $tr_class; ?>">
								<td align="center" class="formlabel"><?php echo $hospitalHealthList['data'][$i]['packageName'];?></td>
								<td align="center" class="formlabel"><?php echo $hospitalHealthList['data'][$i]['packagePrice'];?></td>
								<td align="center" class="formlabel"><?php echo $details;?></td>
								<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeHealthSpec('<?php echo $hospitalHealthList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
							</tr>
							<?php 
								}
							}else{ ?>
        <tr><td align="center" id="trhelidnorecord" colspan="4" style="font-size: 13px;"><strong><em>No Records Displayed</em></strong></td></tr>
        <?php
		}
		?>
  </table><br />
</table><br /><br />

<table width="100%" cellspacing="0" cellpadding="0" border="0" id="" align="center" class="formstyle1 cliniclisting">
						<tr>
						  <td colspan="7" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><strong>Health Insurence Company Tie Ups</strong></td>
						<tr><td colspan="5">&nbsp;</td>
						</tr>
								 <tr>
						<td width="11%" class="formlabel">Insurance Company <span class="compulsory">*</span>: 
						<td width="28%">
						<?php print $insuranceCompanyObj->getInsuranceCompanyOptions($globalUtil,array("id"=>'insurance_company',"name"=>'insurance_company','validate'=>"{required:true,messages:{required:'Select a Insurance Company.'}}"),'');?>						</td>
						
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More" onclick="javascript:addInsuranceCoInfo();"/></td>
						<td width="61%" colspan="4"><span id="msg_insu_co"></span></td>
					  </tr>
					  <tr>
						<td colspan="5" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="5">
					  <table width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addInsuranceCoInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
               <td width="84%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Insurance Company Name</strong></td>   <td width="16%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> </tr>
					   <?php 
							$addinfo = '';
							$count = 0;
							if($insuranceCompanyList['numrows']>0){
							for($i=0;$i<$insuranceCompanyList['numrows'];$i++){
							$count++;
							($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				
							?>
							<tr id="trinslid<?php echo $insuranceCompanyList['data'][$i]['id'];?>" class="<?php echo $tr_class; ?>">
								<td align="center" class="formlabel"><?php echo $insuranceCompanyList['data'][$i]['insurance_company'];?></td>
								<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeInsuranceCoSpec('<?php echo $insuranceCompanyList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
							</tr>
							<?php 
								}
							}else{ ?>
        <tr><td align="center" id="trinslidnorecord" colspan="2" style="font-size: 13px;"><strong><em>No Records Displayed</em></strong></td></tr>
        <?php
		}
		?>
  </table><br />
  <tr>
  <td width="11%" class="formlabel">Insurance TPA <span class="compulsory">*</span>: 
						<td width="28%">
						<?php print $insuranceTPAObj->getInsuranceTPAOptions($globalUtil,array("id"=>'insurance_tpa',"name"=>'insurance_tpa','validate'=>"{required:true,messages:{required:'Select a Insurance TPA.'}}"),'');?>						</td>
						
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More" onclick="javascript:addInsuranceTPAInfo();"/></td>
						<td width="61%" colspan="4"><span id="msg_insu_tpa"></span></td>
					  </tr>
					  <tr>
						<td colspan="5" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="5">
					  <table width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addInsuranceTPAInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
               <td width="84%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Insurance TPA Name</strong></td>   <td width="16%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> </tr>
					   <?php 
							$addinfo = '';
							$count = 0;
							if($insuranceTPAList['numrows']>0){
							for($i=0;$i<$insuranceTPAList['numrows'];$i++){
							$count++;
							($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				
							?>
							<tr id="trinstpalid<?php echo $insuranceTPAList['data'][$i]['id'];?>" class="<?php echo $tr_class; ?>">
								<td align="center" class="formlabel"><?php echo $insuranceTPAList['data'][$i]['insurance_tpa'];?></td>
								<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeInsuranceTPASpec('<?php echo $insuranceTPAList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
							</tr>
							<?php 
								}
							}else{ ?>
        <tr><td align="center" id="trinstpalidnorecord" colspan="2" style="font-size: 13px;"><strong><em>No Records Displayed</em></strong></td></tr>
        <?php
		}
		?>
  </table><br />

</table><br /><br />
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="" align="center" class="formstyle1 cliniclisting">
						<tr>
						  <td colspan="5" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><strong>Contact Person Information</strong></td>
                          <tr><td colspan="5">&nbsp;</td></tr>
						<tr><td width="11%" class="formlabel">Name<span class="compulsory">*</span>: 
						<td width="35%">
						<input type="text" name="name" id="name" />
						</td>
						<td width="16%" class="formlabel">Designation<span class="compulsory">*</span>: </td>
						<td width="38%">
						<input type="text" name="designation" id="designation" />
						</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Email<span class="compulsory">*</span>: </td>
						<td><input type="text" name="email" id="email" /></td>
						<td class="formlabel">Contact No : </td>
						<td><input type="text" name="hospcontactno" id="hospcontactno" /></td>
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="5">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More" onclick="javascript:addContactInfo();"/></td>
						<td colspan="4"><span id="msg_contact"></span></td>
					  </tr>
					  <tr>
						<td colspan="5" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="5">
					  <table width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addContactInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Name</strong></td> 
					  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Designation</strong></td> 
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Email</strong></td>
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Contact No</strong></td>
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> </tr>
					   <?php 
							$addinfo = '';
							$count = 0;
							if($hospitalContactList['numrows']>0){
							for($i=0;$i<$hospitalContactList['numrows'];$i++){
							$count++;
							($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				
							?>
							<tr id="trcolid<?php echo $hospitalHealthList['data'][$i]['id'];?>" class="<?php echo $tr_class; ?>">
								<td align="center" class="formlabel"><?php echo $hospitalContactList['data'][$i]['name'];?></td>
								<td align="center" class="formlabel"><?php echo $hospitalContactList['data'][$i]['designation'];?></td>
								<td align="center" class="formlabel"><?php echo $hospitalContactList['data'][$i]['email'];?></td>
                                <td align="center" class="formlabel"><?php echo $hospitalContactList['data'][$i]['contactno'];?></td>
								<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeContactSpec('<?php echo $hospitalContactList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
							</tr>
							<?php 
								}
							}else{ ?>
        <tr><td align="center" id="trcolidnorecord" colspan="4" style="font-size: 13px;"><strong><em>No Records Displayed</em></strong></td></tr>
        <?php
		}
		?>
  </table><br />
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