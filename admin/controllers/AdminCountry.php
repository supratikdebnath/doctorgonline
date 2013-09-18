<?php
require("../includes/connection.php");
$country=new Country;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("countryName"=>$_POST["countryName"],"countryCode"=>$_POST["countryCode"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$country->validateCountry($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newCountryAdded=$country->insertCountry($globalUtil,$formData);
		if($newCountryAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifycountrymsg",SUCCESS_MSG_NEW_COUNTRY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifycountrymsg",ERROR_MSG_NEW_COUNTRY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifycountrymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyCountry.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"countryName"=>$_POST["countryName"],"countryCode"=>$_POST["countryCode"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$country->validateCountry($globalUtil,$formData);
	 if(!$validData['errors']){
	 $countryUpdated=$country->updateCountry($globalUtil,$formData);
		if($countryUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listcountrymsg",SUCCESS_MSG_UPDATE_COUNTRY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listcountrymsg",ERROR_MSG_UPDATE_COUNTRY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listcountrymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php"));
	
	}	
?>