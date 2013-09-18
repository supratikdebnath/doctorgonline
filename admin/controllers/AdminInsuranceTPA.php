<?php
require("../includes/connection.php");
$insuranceTPA=new InsuranceTPA;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("insurance_tpa"=>$_POST["insurance_tpa"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$insuranceTPA->validateInsuranceTPA($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newInsuranceTPAAdded=$insuranceTPA->insertInsuranceTPA($globalUtil,$formData);
		if($newInsuranceTPAAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifyInsuranceTPAmsg",SUCCESS_MSG_NEW_INSURANCE_TPA,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifyInsuranceTPAmsg",ERROR_MSG_NEW_INSURANCE_TPA,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifyInsuranceTPAmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyInsuranceTPA.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"insurance_tpa"=>$_POST["insurance_tpa"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$insuranceTPA->validateInsuranceTPA($globalUtil,$formData);
	 if(!$validData['errors']){
	 $insuranceTPAUpdated=$insuranceTPA->updateInsuranceTPA($globalUtil,$formData);
		if($insuranceTPAUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listInsuranceTPAmsg",SUCCESS_MSG_UPDATE_INSURANCE_TPA,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listInsuranceTPAmsg",ERROR_MSG_UPDATE_INSURANCE_TPA,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listInsuranceTPAmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php"));
	
	}	
?>