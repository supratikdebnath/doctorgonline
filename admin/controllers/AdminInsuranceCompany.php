<?php
require("../includes/connection.php");
$insuranceCompany=new InsuranceCompany;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("insurance_company"=>$_POST["insurance_company"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$insuranceCompany->validateInsuranceCompany($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newInsuranceCompanyAdded=$insuranceCompany->insertInsuranceCompany($globalUtil,$formData);
		if($newInsuranceCompanyAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifyInsuranceCompanymsg",SUCCESS_MSG_NEW_INSURANCE_COMPANY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifyInsuranceCompanymsg",ERROR_MSG_NEW_INSURANCE_COMPANY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifyInsuranceCompanymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyInsuranceCompany.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"insurance_company"=>$_POST["insurance_company"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$insuranceCompany->validateInsuranceCompany($globalUtil,$formData);
	 if(!$validData['errors']){
	 $insuranceCompanyUpdated=$insuranceCompany->updateInsuranceCompany($globalUtil,$formData);
		if($insuranceCompanyUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listInsuranceCompanymsg",SUCCESS_MSG_UPDATE_INSURANCE_COMPANY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listInsuranceCompanymsg",ERROR_MSG_UPDATE_INSURANCE_COMPANY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listInsuranceCompanymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php"));
	
	}	
?>