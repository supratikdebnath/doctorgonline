<?php
require("../includes/connection.php");
$doctor=new Doctor;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	
	 $formData=array("firstName"=>$_POST["firstName"],"lastName"=>$_POST["lastName"],"middleName"=>$_POST["middleName"],"gender"=>$_POST["gender"],"dateOfBirth"=>$globalUtil->formatDate($_POST["dateOfBirth"],'Y-m-d'),"address"=>$_POST["address"],"cid"=>$_POST["cid"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"aid"=>$_POST["aid"],"pincode"=>$_POST["pincode"],"emailAlternate"=>$_POST["emailAlternate"],"website"=>$_POST["website"],"mobileNo"=>$_POST["mobileNo"],"phoneNo"=>$_POST["phoneNo"],"phoneNoAlternate"=>$_POST["phoneNoAlternate"],"fax"=>$_POST["fax"],"creditCardAccept"=>$_POST["creditCardAccept"],"specid"=>$_POST["specid"],"available24Hrs"=>$_POST["available24Hrs"],"about"=>$_POST["about"],"yearsOfExp"=>$_POST["yearsOfExp"],"registrationNo"=>$_POST["registrationNo"],"designation"=>$_POST["designation"],"consultancyFees"=>$_POST["consultancyFees"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"],"featured_value"=>$_POST["featured_value"]);
	 $validData=$doctor->validateDoctor($globalUtil,$formData);
	 if(!$validData['errors']){
		/*Image Upload Start*/		
		$doctorImageData=$doctor->uploadDocImage($globalUtil,$_FILES['doctorImg'],$_POST["firstName"].'_'.$_POST["lastName"],$_POST['previousDoctorImg'],$_POST['removeDoctorImg']);
		$formData=array_merge($formData,$doctorImageData); 
	    /*Image Upload Ends*/
	 $newDoctorAdded=$doctor->insertDoctor($globalUtil,$formData);
		
		if($newDoctorAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifydoctormsg",SUCCESS_MSG_NEW_DOCTOR,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifydoctormsg",ERROR_MSG_NEW_DOCTOR,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifydoctormsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctor.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"firstName"=>$_POST["firstName"],"lastName"=>$_POST["lastName"],"middleName"=>$_POST["middleName"],"gender"=>$_POST["gender"],"dateOfBirth"=>$globalUtil->formatDate($_POST["dateOfBirth"],'Y-m-d'),"address"=>$_POST["address"],"cid"=>$_POST["cid"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"aid"=>$_POST["aid"],"pincode"=>$_POST["pincode"],"emailAlternate"=>$_POST["emailAlternate"],"website"=>$_POST["website"],"mobileNo"=>$_POST["mobileNo"],"phoneNo"=>$_POST["phoneNo"],"phoneNoAlternate"=>$_POST["phoneNoAlternate"],"fax"=>$_POST["fax"],"creditCardAccept"=>$_POST["creditCardAccept"],"specid"=>$_POST["specid"],"available24Hrs"=>$_POST["available24Hrs"],"about"=>$_POST["about"],"yearsOfExp"=>$_POST["yearsOfExp"],"registrationNo"=>$_POST["registrationNo"],"designation"=>$_POST["designation"],"consultancyFees"=>$_POST["consultancyFees"],"modifyDt"=>time(),"status"=>$_POST["status"],"featured_value"=>$_POST["featured_value"]);
	 $validData=$doctor->validateDoctor($globalUtil,$formData);
	 if(!$validData['errors']){
		/*Image Upload Start*/		
		$doctorImageData=$doctor->uploadDocImage($globalUtil,$_FILES['doctorImg'],$_POST["firstName"].'_'.$_POST["lastName"],$_POST['previousDoctorImg'],$_POST['removeDoctorImg']);
		$formData=array_merge($formData,$doctorImageData); 
	    /*Image Upload Ends*/	 
	    $doctorUpdated=$doctor->updateDoctor($globalUtil,$formData);
		
		if($doctorUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listdoctormsg",SUCCESS_MSG_UPDATE_DOCTOR,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listdoctormsg",ERROR_MSG_UPDATE_DOCTOR,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listdoctormsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php"));
	
	}	
//For Adding Doctor Qualification
else if(isset($_POST['action']) && $_POST['action']=='addDocQ'){
	$formData=array('did'=>$_POST['did'],'specid'=>$_POST['specid'],'qid'=>$_POST['qid'],'yearOfCompletion'=>$_POST['yearOfCompletion'],'instituteName'=>$_POST['instituteName']);
	if($doctor->validateDoctorQualification($globalUtil,$formData)==false){
	   echo "invaliddata";
	   die();
	}
	else{
		if($doctor->insertDoctorQualification($globalUtil,$formData)){
		   $doctorQualificationList=$doctor->getDoctorQualifications($globalUtil," WHERE dq.did='".$_POST['did']."' AND tq.status='1' AND ts.status='1' ORDER BY dq.id DESC LIMIT 0,1");
		   $html = '';
		   $html = '<tr><td colspan="5" height="5px"></tr>';
		   
		   if($doctorQualificationList['numrows']>0){
			   
			  for($i=0;$i<count($doctorQualificationList['data']);$i++){
				  $html .= '<tr id="trqid'.$doctorQualificationList['data'][$i]['docqid'].'">';
				  $html .= '<td align="center">'.$doctorQualificationList['data'][$i]['qualificationName'].'</td>
							<td align="center">'.$doctorQualificationList['data'][$i]['specName'].'</td>  
							<td align="center">'.$doctorQualificationList['data'][$i]['instituteName'].'</td>
							<td align="center">'.$doctorQualificationList['data'][$i]['yearOfCompletion'].'</td>
							<td align="center"><a href="javascript:void(0);" onclick="javascript:removeSpec("'.$doctorQualificationList['data'][$i]['docqid'].'")"><b>Remove</b></a></td>';
				  $html .= '</tr>';
			  }
			}
			  
			  echo $html;die();
		}
		else{
			echo "failed"; 
			die();	
		}
		
	}
	
	}
//For Deleting Doctor Qualification
else if(isset($_POST['action']) && $_POST['action']=='delDocQ' && $_POST['did']!='' && $_POST['id']!=''){
	$id=$_POST['id'];
	$did=$_POST['did'];
	$sqlExists="SELECT * FROM ".TABLE_USER_DOCTOR_QUALIFICATIONS." WHERE id='".$id."' AND did='".$did."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($doctor->deleteDoctorQualification($globalUtil,$adminUtil,$id,$did)!=0){
		echo "success";
	}
	else{
		echo "failed";
		}
	}
	else{
		echo "invaliddata"; 
		die();	
	}
}		
?>