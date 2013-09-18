<?php
require("includes/connection.php");
require(PROJECT_DOCUMENT_PATH.CKEDITOR_FOLDER."ckeditor.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminUtil->CheckAdminPagePrivs($globalUtil,$_SESSION['adminUserSession']['uid'],$_SESSION['adminUserSession']['privs'],"Modify Pathology");

$sqlAdminPrivsMaster="SELECT id as value,privilegeName as label FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE privilegeStatus='1'";
$adminPrivsMasterArr=$globalUtil->sqlFetchRowsAssoc($sqlAdminPrivsMaster,2);

$pathologyTestNameObj=new PathologyTestName;
$pathologyObj=new Pathology;
$hospitalObj=new Hospital;
$doctorObj=new Doctor;
$AreaObj=new Area;
$cityId = ''; //Added By Samannoy
$status=array(array("value"=>"1","label"=>"Active"),array("value"=>"0","label"=>"In-Active"));
$action='';
$id=0;
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
	$pageHeading="Add Pathology Center";
	$submitValue="Submit";
	}
elseif($doaction=="edit"){
	
	$id=$_GET['id'];
	$pageHeading="Modify Pathology Center";
	$submitValue="Update";
	
	
	$formData=$pathologyObj->getPathology($globalUtil,"WHERE id='".$id."'");
	$adminUtil->unsetPostFormDataAll();
	//echo "<pre>";print_r($formData['data'][0]);echo "</pre>";
	$adminUtil->setPostFormData($formData['data'][0]);
	$featured_value=$adminUtil->getPostFormData("featured_value");
	//echo $adminUtil->getPostFormData("creditCardAccept");
	$cityId=$adminUtil->getPostFormData("cid");
	
	//Edited By Samannoy Starts
	$pathologyInfoList= $pathologyObj->getPathologyInfo($globalUtil," WHERE pid='".$id."' ORDER BY id DESC ");
    $healthInfoList=    $pathologyObj->getHealthInfo($globalUtil," WHERE pid='".$id."' ORDER BY id DESC ");
    $contactInfoList=   $pathologyObj->getContactInfo($globalUtil," WHERE pid='".$id."' ORDER BY id DESC ");
	
    //Edited By Samannoy Ends
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

  $("#addPathInfo tr:even").addClass("trEven");
  $("#addPathInfo tr:odd").addClass("trOdd");
  
  $("#addHealthMoreInfo tr:even").addClass("trEven");
  $("#addHealthMoreInfo tr:odd").addClass("trOdd");	
  
  $("#addContactInfo tr:even").addClass("trEven");
  $("#addContactInfo tr:odd").addClass("trOdd");	
  
      	
});

</script>
<script type="text/javascript" src="<?php echo CKEDITOR_URL;?>ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.editorConfig = function( config )
{
	config.autoParagraph = false;
}

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
///////////////////////////////////////////////////////////// Pathology Center Information Ajax /////////////////////////////////////////////////////////////////////////////////////

function addPathologyMoreInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
	testType=$('#testType').val();
	testName=$('#testName').val();
	testPrice=$('#testPrice').val();
	additionalInfo=$('#additionalInfo').val();
	id='<?php echo $id;?>';
	error='';
	if(testType==''){
		alert('Please select Test Type');
		$('#search_msg').html('');
		error=1;
		}
	else if(testName==''){
		alert('Please select Test Name');
		$('#search_msg').html('');
		error=1;
		}	
	else if(testPrice==''){
		alert('Please enter Test Price');
		$('#search_msg').html('');
		error=1;
		}		
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {id: id, testType: testType, testName: testName, testPrice: testPrice, additionalInfo: additionalInfo, action:'addPathologyMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_path').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Updating Pathology Center Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Pathology Center Information adding failed. Try again.');	
			}
			else{ 
			    $('#msg_path').animate({opacity:0.2}, 1000, function() { $('#msg_path').html('').animate({opacity:1}),1000  });
				$('#addPathInfo tr:last').after(result);
				
			}
		  }
		});
	}
	}
function removePathologySpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
pid='<?php echo $id;?>';
$.ajax({
		  url: ajaxUrl,
		  data: {   id: id, pid: pid, action:'delPathologyMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_path').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Deleting Pathology Center Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Pathology Center Information adding failed. Try again.');	
			}
			else{
			    $('#msg_path').animate({opacity:0.2}, 1000, function() { $('#msg_path').html('<strong class="formlabel">Record deleted successfully....</strong>').animate({opacity:1}),1000  });
				$("#trpathid"+id).remove();
			}
		  }
		});	
	}
}


///////////////////////////////////////////////////////////// Health Package Information Ajax /////////////////////////////////////////////////////////////////////////////////////

function addHealthInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
	packageName=$('#packageName').val();
	packagePrice=$('#packagePrice').val();
	details=$('#details').val();
	id='<?php echo $id;?>';
	error='';
	if(packageName==''){
		alert('Please enter Package Name');
		error=1;
		}
	else if(packagePrice==''){
		alert('Please enter Package Price');
		error=1;
		}	
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {id: id, packageName: packageName, packagePrice: packagePrice, details: details, action:'addHealthMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_health').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Updating Health Package Information...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Health Package Information adding failed. Try again.');	
			}
			else{ 
			    $('#msg_health').animate({opacity:0.2}, 1000, function() { $('#msg_health').html('').animate({opacity:1}),1000  });
				$('#addHealthMoreInfo tr:last').after(result);
				
			}
		  }
		});
	}
	}
function removeHealthSpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
pid='<?php echo $id;?>';
$.ajax({
		  url: ajaxUrl,
		  data: { pid: pid, id: id, action:'delHealthMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_health').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Deleting Health Package Information...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Health Package Information adding failed. Try again.');	
			}
			else{
			    $('#msg_health').animate({opacity:0.2}, 1000, function() { $('#msg_health').html('').animate({opacity:1}),1000  });
				$("#trhealthid"+id).remove();
			}
		  }
		});	
	}
}

///////////////////////////////////////////////////////////// Contact Person Details Ajax /////////////////////////////////////////////////////////////////////////////////////

function addContactInfo(){	
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
	name=$('#name').val();
	designation=$('#designation').val();
	email=$('#email').val();
	contactno=$('#contactno').val();
	id='<?php echo $id;?>';
	error='';
	if(name==''){
		alert('Please enter Name');
		error=1;
		}
	else if(designation==''){
		alert('Please enter Designation');
		error=1;
		}
	else if(email==''){
		alert('Please enter Email');
		error=1;
		}		
	if(error==''){	
		$.ajax({
		  url: ajaxUrl,
		  data: {id: id, name: name, designation: designation, email: email, contactno: contactno, action:'addContactMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_contact').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Updating Contact Person Details...</strong>');},
		  success: function(result) {
			
			
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Contact Person Details adding failed. Try again.');	
			}
			else{ 
			    $('#msg_contact').animate({opacity:0.2}, 1000, function() { $('#msg_contact').html('').animate({opacity:1}),1000  });
				$('#addContactInfo tr:last').after(result);
				
			}
		  }
		});
	}
	}
function removeContactSpec(id){

if(window.confirm('Would you like to remove this record?')==true)
{
ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
pid='<?php echo $id;?>';
$.ajax({
		  url: ajaxUrl,
		  data: {  pid: pid, id: id, action:'delContactMore' },
		  type: 'POST',
		  beforeSend: function(){$('#msg_contact').html('<img src="<?php echo $globalUtil->generateUrl(ADMIN_IMAGES_URL."ajax-loader.gif");?>" border="0"><strong class="formlabel">Deleting Contact Person Details...</strong>');},
		  success: function(result) {
			
			//alert(result);  
			if(result=='invaliddata'){
				alert('Invalid Data Requested.');
			}
			if(result=='failed'){
				alert('Contact Person Details adding failed. Try again.');	
			}
			else{
			    $('#msg_contact').animate({opacity:0.2}, 1000, function() { $('#msg_contact').html('').animate({opacity:1}),1000  });
				$("#trcontactid"+id).remove();
			}
		  }
		});	
		
	}
}

///////////////////////////////////////////////////////////// Doctor List Ajax /////////////////////////////////////////////////////////////////////////////////////

function list_doctor(val,id)
{

if(id==1)
{
	if(val!='')
	{
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
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
	ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
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
 ajaxUrl='<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>';
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
function cancelFunc(){
	var r=confirm("Are you sure you want to cancel ?");
if (r==true)
  {
 	window.location='<?php echo $globalUtil->base64decode($_GET['returnurl']);?>';	
  }
	
}
function phonenumber()  
{  
  var phoneno = /^\d{10}$/;  
  if((document.getElementById("emergencyServiceNo").value.match(phoneno))) 
    {  
      	return true;  
    }  
  else  
    {  
        alert("Invalid Emergency Service No");  
        return false;  
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
					<td bgcolor="#999999" class="leftpanel" id="leftpanel">
						<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."leftmenu.php");?>
					</td>
					<td bgcolor="#999999" class="rightpanel" id="rightpanel">
						<form onsubmit="return phonenumber()" id="adminformmain" name="adminformmain" action="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Pathology);?>" enctype="multipart/form-data" method="post" class="formstyle1">
                        <?php
                        if($doaction=="edit"){
						?><input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
						
                        <?php }?>
                        <table width="100%" cellpadding="0" cellspacing="0">
							<tr><td class="PageHeading" colspan="3"><?php echo $pageHeading;?></td></tr>
							<tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <?php
                        if($doaction=="edit"){
						?>
                            <tr><td class="PageHeading" colspan="3" align="right" style="font-size: 14px;"><!--<a href="javascript:void(0);" onclick="javascript:window.open('<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospitalPathology.php").'?hid='.$id;?>&do=','Manage Hospital Pathology','scrollbars=yes,menubar=no,resizable=no,status=no,toolbar=no,width=960');">Manage Hospital Pathology</a>--></td></tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <?php }?> 
                            <?php
							if($msgInfo->hasMsg('modifypathologymsg')){
							?>
                    		<tr>
                    			<td class="msgposition" colspan="3" align="center"><?php echo $msgInfo->displayMsg('modifypathologymsg');?></td>
                    		</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                   		    <?php
							}
							?>
                             <tr>
								<td colspan="3" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b>Basic Information</b></td></tr>  
                            <tr>
								<td class="formlabel">Pathology Center Name <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="pathologycenterName" name="pathologycenterName" validate="{required:true,messages:{required:'Please enter a Pathology Center name.'}}" value="<?php echo $adminUtil->getPostFormData("pathologycenterName");?>"/></div></td>
							</tr>
                               <tr>
                            	<td colspan="3" height="5px">                            </tr>
							 <tr>
								<td class="formlabel">Pathology Center  Profile Image</td>
                                <td class="separter">:</td>
                                <td class="forminput"><input type="file" name="pathologyCenterImg" id="pathologyCenterImg" validate="{accept:'jpeg|jpg|png|gif',messages:{accept:'jpeg,png,gif are allowed file extensions.'}}"/> (Allowed extensions jpeg,jpg,gif,png)</td>
							</tr>
                             <tr>
                           	<td colspan="3" height="5px">                            
                            </tr>
                            <tr>
								<td class="formlabel"><strong>Is featured User ?</strong></td>
                                <td class="separter">:</td>
                                <td class="forminput"> <input type="checkbox" id="featured_value" name="featured_value" value="1" <?php if($featured_value=='1'){ echo 'checked="checked"';}?>/>   (Optional) </td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <?php 
							$pathologyCenterProfileImg=$adminUtil->getPostFormData("pathologyCenterImg");
							if($pathologyCenterProfileImg!='' && $doaction=="edit"){?>
                            <tr>
								<td class="formlabel">Current Pathology Center Profile Image</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <input type="hidden" name="previousPathologyCenteImg" id="previousPathologyCenteImg" value="<?php echo $pathologyCenterProfileImg;?>" />
                                <img src="<?php print PATHOLOGY_CENTER_IMG_URL."medium/".$pathologyCenterProfileImg;?>" height="203" /><br />
                                Remove Image <input type="checkbox" name="removePathologyCenteImg" id="removePathologyCenteImg" value="Y" />                                </td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>   
                            <?php }?>  
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Address <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><textarea name="address" id="address" validate="{required:true,messages:{required:'Please enter a Pathology Center Address.'}}" style="width: 209px; height: 54px;" maxlength="180"><?php echo $adminUtil->getPostFormData("address");?></textarea></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">State <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getStateOptions($globalUtil,array("id"=>'sid',"name"=>'sid','validate'=>"{required:true,messages:{required:'Select a state.'}}"),$adminUtil->getPostFormData("sid"),"WHERE status='1' AND cid='".$cityId."'");?></td>
							</tr>      
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">City <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getCityOptions($globalUtil,array("id"=>'cid',"name"=>'cid','validate'=>"{required:true,messages:{required:'Select a city.'}}"),$cityId);?></td>
							</tr>      
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Zone <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getZoneOptions($globalUtil,array("id"=>'zid',"name"=>'zid','validate'=>"{required:true,messages:{required:'Select a zone.'}}"),$adminUtil->getPostFormData("zid"),"WHERE status='1'");?></td>
							</tr>      
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
								<td class="formlabel">Area <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $AreaObj->getAreaOptions($globalUtil,array("id"=>'aid',"name"=>'aid','validate'=>"{required:true,messages:{required:'Select a area.'}}"),$adminUtil->getPostFormData("aid"),"WHERE status='1'");?></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Pincode <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="pincode" name="pincode" validate="{required:true,digits:true,messages:{required:'Please enter pincode.'}}" value="<?php echo $adminUtil->getPostFormData("pincode");?>"/></div></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Alternate Email Address</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="emailAlternate" name="emailAlternate" validate="{email:true,messages:{email:'Please enter valid email.'}}" value="<?php echo $adminUtil->getPostFormData("emailAlternate");?>"/></div></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
								<td class="formlabel">Website</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="website" name="website" validate="{url:true,messages:{email:'Please enter valid url/website.'}}" value="<?php echo $adminUtil->getPostFormData("website");?>"/></div> Ex: http://doctorgonline.com / http://www.doctorgonline.com</td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Landline No.</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="phoneNo" name="phoneNo" validate="{digits:true,messages:{digits:'Please enter valid phone number.'}}" value="<?php echo $adminUtil->getPostFormData("phoneNo");?>"/></div> Please add STD Code . Ex: 03321234567 </td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Alternate Phone/Mobile No.</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="phoneNoAlternate" name="phoneNoAlternate" validate="{digits:true,messages:{digits:'Please enter valid alternate phone/mobile number.'}}" value="<?php echo $adminUtil->getPostFormData("phoneNoAlternate");?>"/></div> Please add STD Code . Ex: 03321234567 / 9830098300 </td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>  
                            <tr>
								<td class="formlabel">Fax No.</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="fax" name="fax" validate="{digits:true,messages:{digits:'Please enter valid fax number.'}}" value="<?php echo $adminUtil->getPostFormData("fax");?>"/></div> Please add STD Code . Ex: 03321234567</td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Accept Credit Card <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput"> 
                                <?php $creditCardAccept=$adminUtil->getPostFormData("creditCardAccept");?>
                                Yes <input type="radio" id="creditCardAccept1" name="creditCardAccept" validate="{required:true,messages:{required:'Please select credit card option'}}" value="Y" <?php if($creditCardAccept=="Y"){?>checked="checked"<?php }?>/> No <input type="radio" id="creditCardAccept2" name="creditCardAccept" validate="{required:true,messages:{required:'Please select credit card option'}}" value="N" <?php if($creditCardAccept=="N"){?>checked="checked"<?php }?>/></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
								<td class="formlabel">24 Hrs Availability <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $available24Hrs=$adminUtil->getPostFormData("available24Hrs");?>
                                 Yes <input type="radio" id="available24Hrs1" name="available24Hrs" validate="{required:true,messages:{required:'Please select 24 Hrs Availability'}}" value="Y" <?php if($available24Hrs=="Y"){?>checked="checked"<?php }?>/> No <input type="radio" id="available24Hrs2" name="available24Hrs" validate="{required:true,messages:{required:'Please select 24 Hrs Availability'}}" value="N" <?php if($available24Hrs=="N"){?>checked="checked"<?php }?>/></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
								<td class="formlabel">About</td>
                                <td class="separter">:</td>
                                <td class="forminput"><textarea name="about" id="about" style="width: 209px; height: 54px;"><?php echo $adminUtil->getPostFormData("about");?></textarea></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
								<td class="formlabel">Government Registration No</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="registrationNo" name="registrationNo" value="<?php echo $adminUtil->getPostFormData("registrationNo");?>"/></div>(If not available type "Not Available")</td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
								<td colspan="3" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b>Pathology Center Information</b></td></tr><tr>
                            	<td colspan="3" height="5px">                            </tr>      
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
								<td class="formlabel">Year of Establishment</td>
                                <td class="separter">:</td>
                                <td class="forminput"><div class="forminputboxbg"><input type="input" class="formtextbox" id="YrofEstablishment" name="YrofEstablishment" value="<?php echo $adminUtil->getPostFormData("YrofEstablishment");?>"/></div> Ex: 2012</td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
								<td class="formlabel">Accreditation</td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $pathologyObj->getPathologyAccreditationOptions($globalUtil,array("id"=>'haid',"name"=>'haid'),$adminUtil->getPostFormData("haid"),"WHERE status='1'");?></td>
							</tr>
                           <tr>
								<td class="formlabel">Other Facility</td>
                                <td class="separter">:</td>
                                <td class="forminput"><?php print $pathologyObj->getOtherFacilitiesOptions($globalUtil,'checkbox',array("id"=>'hfid',"name"=>'hfid[]'),$adminUtil->getPostFormData("hfid"),"WHERE status='1'");?></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                             <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
                            	<td class="formlabel">Any Tie-up with Specialized labs</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $tieupWithSpecializedLabs = $adminUtil->getPostFormData("tieupWithSpecializedLabs");?>
                                (Available) 
                              <input type="checkbox" id="tieupWithSpecializedLabs" name="tieupWithSpecializedLabs" value="Y" onclick="javascript:availableNumbers(this.id,'tieupWithLabs');" <?php if($tieupWithSpecializedLabs=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="tieupWithLabs" name="tieupWithLabs" value="<?php echo $adminUtil->getPostFormData("tieupWithLabs");?>" <?php if($tieupWithSpecializedLabs=='N' || $tieupWithSpecializedLabs==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>   
                            <tr>
                            	<td class="formlabel">Emergency Service No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $emergencyServiceNoAvailable = $adminUtil->getPostFormData("emergencyServiceNoAvailable");?>
                                (Available) 
                              <input type="checkbox" id="emergencyServiceNoAvailable" name="emergencyServiceNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'emergencyServiceNo');" <?php if($emergencyServiceNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="emergencyServiceNo" name="emergencyServiceNo" value="<?php echo $adminUtil->getPostFormData("emergencyServiceNo");?>" <?php if($emergencyServiceNoAvailable=='N' || $emergencyServiceNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
                            	<td class="formlabel">Ambulance No.</td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $ambulenceNoAvailable = $adminUtil->getPostFormData("ambulenceNoAvailable");?>
                                (Available) 
                              <input type="checkbox" id="ambulenceNoAvailable" name="ambulenceNoAvailable" value="Y" onclick="javascript:availableNumbers(this.id,'ambulenceNo');" <?php if($ambulenceNoAvailable=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><input type="input" class="formtextbox" id="ambulenceNo" name="ambulenceNo" value="<?php echo $adminUtil->getPostFormData("ambulenceNo");?>" <?php if($ambulenceNoAvailable=='N' || $ambulenceNoAvailable==''){ echo 'disabled="disabled"';}?>/></div></td>
                            </tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
                            	<td class="formlabel">Sample Collection At Home </td>
                                <td class="separter">:</td>
                                <td class="forminput">
                                <?php $sampleCollectionAtHome = $adminUtil->getPostFormData("sampleCollectionAtHome");?>
                                (Available) 
                              <input type="checkbox" id="sampleCollectionAtHome" name="sampleCollectionAtHome" value="Y" onclick="javascript:availableNumbers(this.id,'sampleCollection');" <?php if($sampleCollectionAtHome=='Y'){ echo 'checked="checked"';}?>/> <div class="forminputboxbg"><!--<input type="input" class="formtextbox" id="sampleCollection" name="sampleCollection" value="<?php echo $adminUtil->getPostFormData("sampleCollection");?>" <?php if($sampleCollectionAtHome=='N' || $sampleCollectionAtHome==''){ echo 'disabled="disabled"';}?>/>--><textarea style="width: 209px; height: 54px;" id="sampleCollection" <?php if($sampleCollectionAtHome=='N' || $sampleCollectionAtHome==''){ echo 'disabled="disabled"';}?> name="sampleCollection"><?php echo $adminUtil->getPostFormData("sampleCollection");?></textarea></</div></td>
                            </tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>                 
                            <tr>
								<td class="formlabel">Status <span class="compulsory">*</span></td>
                                <td class="separter">:</td>
                                <td class="forminput">
<select name="status" id="status" validate="{required:true,messages:{required:'Please select Status.'}}" class="selectbox1">
								<?php echo $globalUtil->htmlOptions($status,$adminUtil->getPostFormData("status"));?>
                                </select></td>
							</tr>
							<tr>
                           	<td colspan="3" height="5px"></tr>
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
                            	<td colspan="3" height="5px">
								
								</tr>      
                            <tr>
							<tr><td colspan="3" height="5px"></tr>
							<?php if($action=='edit'){ ?>
                            <tr>
								<td colspan="3" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b>Pathology Test Information</b></td>
                            </tr><tr>
                            	<td colspan="3" height="5px">                            </tr>      
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
                           	<td colspan="3" height="5px">  
							<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="">
								 <tr>
						<td width="12%" class="formlabel">Test Type<span class="compulsory">*</span>: 
						<td width="34%">
						<?php print $pathologyTestNameObj->getPathologyTestTypeOptions($globalUtil,array("id"=>'testType',"name"=>'testType','validate'=>"{required:true,messages:{required:'Select a Pathology Test Type.'}}","onchange"=>'getTestName()'),'');?>
						&nbsp;<span id="search_msg"></span>
						<!-- <select name="testType" id="testType">
						<option value="">Select Type</option>
						<option value="type1">type1</option>
						<option value="type2">type2</option>
						</select> -->
						</td>
						<td width="15%" class="formlabel">Test Name<span class="compulsory">*</span>: </td>
						<td width="39%">
						<select name="testName" id="testName" onChange="removeMessage()">
						<option value="">-Select Pathology Test Name-</option>
						
						</select> 
						</td>
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Test Price<span class="compulsory">*</span>: </td>
						<td><input type="text" name="testPrice" id="testPrice" /></td>
						<td class="formlabel">Additional Info( if any): </td>
						<td><input type="text" name="additionalInfo" id="additionalInfo" /></td>
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More Info" onclick="javascript:addPathologyMoreInfo();"/></td>
						<td colspan="2" align="left"><span id="msg_path"></span></td>
					  </tr>
					  <tr>
						<td colspan="4" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="4">
			<table  width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addPathInfo" style="border:#666666; border-width:1px; border-style:solid;">
            <tr>
			    <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Test Type</strong></td> 
				<td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Test Name</strong></td> 
				<td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Price</strong></td> 
				<td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Additional Info</strong></td> 
			    <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> 
			</tr>
					 <?php 
							$addinfo = '';
							$action = '';
							if($pathologyInfoList['numrows']>0){
							for($i=0;$i<$pathologyInfoList['numrows'];$i++){
							if($pathologyInfoList['data'][$i]['additionalInfo']!='')
							$addinfo = $pathologyInfoList['data'][$i]['additionalInfo'];
							else
							$addinfo = 'No additional info available';
							$sqlExistsTestType="SELECT test_type FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id='".$pathologyInfoList['data'][$i]['testTypeId']."'";
							$rsExistsTestType=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestType,2);
							$sqlExistsTestName="SELECT test_name,status FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id='".$pathologyInfoList['data'][$i]['testNameId']."'";
							$rsExistsTestName=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestName,2);
							
							($rsExistsTestName['data'][0]['status']==0) ? $action = "<b><em>Disabled</em></b>" : $action = "<a href='javascript:void(0);' onclick='javascript:removePathologySpec(".$pathologyInfoList['data'][$i]['id'].");'><b>Remove</b></a>";
							?>
							<tr id="trpathid<?php echo $pathologyInfoList['data'][$i]['id'];?>">
								<td align="center" class="formlabel"><?php echo $rsExistsTestType['data'][0]['test_type'];?></td>
								<td align="center" class="formlabel"><?php echo $rsExistsTestName['data'][0]['test_name'];?></td>
								<td align="center" class="formlabel"><?php echo $pathologyInfoList['data'][$i]['testPrice'];?></td>
								<td align="center" class="formlabel"><?php echo $addinfo;?></td>
								<td align="center" class="formlabel"><?php echo $action;?></td>
							</tr>
							<?php 
								}
							}	
							?>
  </table>
</table>    </tr>
                            <tr>
							<tr>
                           	<td colspan="3" height="5px"></tr>
								<td colspan="3" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b>Health Package Information</b></td>
                            </tr><tr>
                            	<td colspan="3" height="5px">                            </tr>      
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
                           	<td colspan="3" height="5px">  
							<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="">
								 <tr>
						<td width="12%" class="formlabel">Package Name <span class="compulsory">*</span>: 
						<td width="34%">
						<input type="text" name="packageName" id="packageName" />						</td>
						
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Package  Price<span class="compulsory">*</span>: </td>
						<td><input type="text" name="packagePrice" id="packagePrice" /></td>
						<td width="15%" class="formlabel">Details: </td>
						<td width="39%"><input type="text" name="details" id="details" /></td>
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More Info" onclick="javascript:addHealthInfo();"/></td>
						<td colspan="2"><span id="msg_health"></span></td>
					  </tr>
					  <tr>
						<td colspan="4" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="4">
		<table width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addHealthMoreInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Package Name</strong></td> 
					  <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Package  Price</strong></td> 
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Details</strong></td>
                      <td bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> </tr>
					   <?php 
							$addinfo = '';
							if($healthInfoList['numrows']>0){
							for($i=0;$i<$healthInfoList['numrows'];$i++){
							if($healthInfoList['data'][$i]['details']!='')
							$details = $healthInfoList['data'][$i]['details'];
							else
							$details = 'No additional info available';
							?>
							<tr id="trhealthid<?php echo $healthInfoList['data'][$i]['id'];?>">
								<td align="center" class="formlabel"><?php echo $healthInfoList['data'][$i]['packageName'];?></td>
								<td align="center" class="formlabel"><?php echo $healthInfoList['data'][$i]['packagePrice'];?></td>
								<td align="center" class="formlabel"><?php echo $details;?></td>
								<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeHealthSpec('<?php echo $healthInfoList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
							</tr>
							<?php 
								}
							}	
							?>
  </table>
</table>    </tr>
                           <tr>
                           	<td colspan="3" height="5px"></tr>
							<tr>
								<td colspan="3" bgcolor="#999999" style="border-bottom-color:#000000; border-bottom-width:thin; border-bottom-style:solid;border-top-color:#000000; border-top-width:thin; border-top-style:solid;"><b>Contact Person Details </b></td>
							</tr><tr>
                            	<td colspan="3" height="5px">                            </tr>      
                            <tr>
                           	<td colspan="3" height="5px">                            </tr> 
                            <tr>
                           	<td colspan="3" height="5px">  
							<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" class="">
								 <tr>
						<td width="11%" class="formlabel">Name<span class="compulsory">*</span>: 
						<td width="35%">
						<input type="text" name="name" id="name" />
						</td>
						<td width="16%" class="formlabel">Designation<span class="compulsory">*</span>: </td>
						<td width="38%">
						<input type="text" name="designation" id="designation" />
						</td>
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					   <tr>
						<td class="formlabel">Email<span class="compulsory">*</span>: </td>
						<td><input type="text" name="email" id="email" /></td>
						<td class="formlabel">Contact No : </td>
						<td><input type="text" name="contactno" id="contactno" /></td>
					  </tr>
					  <tr>
						<td colspan="4">&nbsp;</td>
					  </tr>
					   <tr>
						<td colspan="2"><input type="button" value="Add More Info" onclick="javascript:addContactInfo();"/></td>
						<td colspan="2"><span id="msg_contact"></span></td>
					  </tr>
					  <tr>
						<td colspan="4" >&nbsp;</td>
					  </tr>
					   <tr>
					   <td  colspan="4">
					  <table width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addContactInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr>
            <td width="14%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Name</strong></td> 
			<td width="23%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Designation</strong></td> 
			<td width="20%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Email</strong></td> 
			<td width="22%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Contact No</strong></td> 
			<td width="21%" bgcolor="#999999" class="formlabel" style="border-bottom:#000; border-bottom-width:1px; border-bottom-style:solid;"><strong>Action</strong></td> 
					  </tr>
					  <?php 
							$addinfo = '';
							if($contactInfoList['numrows']>0){
							for($i=0;$i<$contactInfoList['numrows'];$i++){
							if($contactInfoList['data'][$i]['contactno']!='')
							  $contactno = $contactInfoList['data'][$i]['contactno'];
							  else
							  $contactno = 'No contact no available';
							?>
							<tr id="trcontactid<?php echo $contactInfoList['data'][$i]['id'];?>">
								<td align="center" class="formlabel"><?php echo $contactInfoList['data'][$i]['name'];?></td>
								<td align="center" class="formlabel"><?php echo $contactInfoList['data'][$i]['designation'];?></td>
								<td align="center" class="formlabel"><?php echo $contactInfoList['data'][$i]['email'];?></td>
								<td align="center" class="formlabel"><?php echo $contactno; ?></td>
								<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeContactSpec('<?php echo $contactInfoList['data'][$i]['id'];?>');"><b>Remove</b></a></td>
							</tr>
							<?php 
								}
							}	
							?>
  </table>
</table>    </tr>
                            <tr>
                            <?php } ?>
							<tr>
							  <td></td>
                              <td></td>
                              <td class="btnposition"><input type="submit" name="Submit" class="submitbtn" value="<?php echo $submitValue;?>" /> &nbsp; <input type="button" class="submitbtn" value="Cancel" onclick="cancelFunc();"/></td>
							</tr>
                            <tr>
                           	<td colspan="3" height="5px">                            </tr>
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