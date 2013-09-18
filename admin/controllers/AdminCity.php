<?php
require("../includes/connection.php");
$city=new City;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("cityName"=>$_POST["cityName"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$city->validateCity($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newCityAdded=$city->insertCity($globalUtil,$formData);
		if($newCityAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifycitymsg",SUCCESS_MSG_NEW_CITY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifycitymsg",ERROR_MSG_NEW_CITY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifycitymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyCity.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"cityName"=>$_POST["cityName"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$city->validateCity($globalUtil,$formData);
	 if(!$validData['errors']){
	 $cityUpdated=$city->updateCity($globalUtil,$formData);
		if($cityUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listcitymsg",SUCCESS_MSG_UPDATE_CITY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listcitymsg",ERROR_MSG_UPDATE_CITY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listcitymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CityList.php"));
	
	}	
?>