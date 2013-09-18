<?php
require("../includes/connection.php");
$doctor=new Doctor;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 
	 $did=$_POST['did'];
	 $xray = ($_POST['xray']=='Y') ? 'Y' : 'N';
	 $creditCardAccept = ($_POST['creditCardAccept']=='Y') ? 'Y' : 'N';
	 $emergency = ($_POST['emergency']=='Y') ? 'Y' : 'N';
	 $ownUnit = ($_POST['ownUnit']=='Y') ? 'Y' : 'N';
	 $homeVisit = ($_POST['homeVisit']=='Y') ? 'Y' : 'N';
	 $homeVisitCharges = ($homeVisit=='Y') ? $_POST['homeVisitCharges'] : 0.00;
	 
	 $formDataClinic=array("did"=>$_POST['did'],"clinicName"=>$_POST["clinicName"],"clinicAddress"=>$_POST["clinicAddress"],"clinicPhoneNumber"=>$_POST["clinicPhoneNumber"],"clinicCharges"=>$_POST["clinicCharges"],"xray"=>$xray,"creditCardAccept"=>$creditCardAccept,"emergency"=>$emergency,"ownUnit"=>$ownUnit,"homeVisit"=>$homeVisit,"homeVisitCharges"=>$homeVisitCharges,"createDt"=>time());
	 $validData=$doctor->validateDoctorClinic($globalUtil,$formDataClinic);
	 if(!$validData['errors']){
	 $newDoctorClinicAdded=$doctor->insertDoctorClinic($globalUtil,$formDataClinic);
	 
	 /*Insert Into Doctor Clinic Timings Starts*/
	 $clnTimeSep=',';
	 $daySunMor=$globalUtil->arrToString($clnTimeSep,$_POST['daySunMor']);
	 $daySunEve=$globalUtil->arrToString($clnTimeSep,$_POST['daySunEve']);
	 $dayMonMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayMonMor']);
	 $dayMonEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayMonEve']);
	 $dayTueMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayTueMor']);
	 $dayTueEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayTueEve']);
	 $dayWedMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayWedMor']);
	 $dayWedEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayWedEve']);
	 $dayThurMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayThurMor']);
	 $dayThurEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayThurEve']);
	 $dayFriMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayFriMor']);
	 $dayFriEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayFriEve']);
	 $daySatMor=$globalUtil->arrToString($clnTimeSep,$_POST['daySatMor']);
	 $daySatEve=$globalUtil->arrToString($clnTimeSep,$_POST['daySatEve']);
	 
	 $clnid=$doctor->getLatestDoctorClinic($globalUtil,'');
	 $formDataClinicTimings=array("clnid"=>$clnid,'daySunMor'=>$daySunMor,'daySunEve'=>$daySunEve,'dayMonMor'=>$dayMonMor,'dayMonEve'=>$dayMonEve,'dayTueMor'=>$dayTueMor,'dayTueEve'=>$dayTueEve,'dayWedMor'=>$dayWedMor,'dayWedEve'=>$dayWedEve,'dayThurMor'=>$dayThurMor,'dayThurEve'=>$dayThurEve,'dayFriMor'=>$dayFriMor,'dayFriEve'=>$dayFriEve,'daySatMor'=>$daySatMor,'daySatEve'=>$daySatEve,'createDt'=>time());
	 $newDoctorClinicTimingAdded=$doctor->insertDoctorClinicTimings($globalUtil,$formDataClinicTimings);
	 /*Insert Into Doctor Clinic Timings Ends*/
	 
		if($newDoctorClinicAdded && $newDoctorClinicTimingAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifydoctorclinicmsg",SUCCESS_MSG_NEW_DOCTOR_CLINIC,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifydoctorclinicmsg",ERROR_MSG_NEW_DOCTOR_CLINIC,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifydoctorclinicmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctorClinic.php").'?did='.$did);
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $xray = ($_POST['xray']=='Y') ? 'Y' : 'N';
	 $creditCardAccept = ($_POST['creditCardAccept']=='Y') ? 'Y' : 'N';
	 $emergency = ($_POST['emergency']=='Y') ? 'Y' : 'N';
	 $ownUnit = ($_POST['ownUnit']=='Y') ? 'Y' : 'N';
	 $homeVisit = ($_POST['homeVisit']=='Y') ? 'Y' : 'N';
	 $homeVisitCharges = ($homeVisit=='Y') ? $_POST['homeVisitCharges'] : 0.00;
	 $did=$_POST['did'];
	 $id=$_POST['id'];
	 
	 $formDataClinic=array("id"=>$_POST['id'],"did"=>$_POST['did'],"clinicName"=>$_POST["clinicName"],"clinicAddress"=>$_POST["clinicAddress"],"clinicPhoneNumber"=>$_POST["clinicPhoneNumber"],"clinicCharges"=>$_POST["clinicCharges"],"xray"=>$xray,"creditCardAccept"=>$creditCardAccept,"emergency"=>$emergency,"ownUnit"=>$ownUnit,"homeVisit"=>$homeVisit,"homeVisitCharges"=>$homeVisitCharges);
	 $validData=$doctor->validateDoctorClinic($globalUtil,$formDataClinic);
	 if(!$validData['errors']){
	 $doctorClinicUpdated=$doctor->updateDoctorClinic($globalUtil,$formDataClinic);
	 
	 /*Update Doctor Clinic Timings Starts*/
	 $clnTimeSep=',';
	 $daySunMor=$globalUtil->arrToString($clnTimeSep,$_POST['daySunMor']);
	 $daySunEve=$globalUtil->arrToString($clnTimeSep,$_POST['daySunEve']);
	 $dayMonMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayMonMor']);
	 $dayMonEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayMonEve']);
	 $dayTueMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayTueMor']);
	 $dayTueEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayTueEve']);
	 $dayWedMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayWedMor']);
	 $dayWedEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayWedEve']);
	 $dayThurMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayThurMor']);
	 $dayThurEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayThurEve']);
	 $dayFriMor=$globalUtil->arrToString($clnTimeSep,$_POST['dayFriMor']);
	 $dayFriEve=$globalUtil->arrToString($clnTimeSep,$_POST['dayFriEve']);
	 $daySatMor=$globalUtil->arrToString($clnTimeSep,$_POST['daySatMor']);
	 $daySatEve=$globalUtil->arrToString($clnTimeSep,$_POST['daySatEve']);
	 
	 $clnid=$id; // Clinic ID
	 $formDataClinicTimings=array('id'=>$_POST['dctid'],"clnid"=>$clnid,'daySunMor'=>$daySunMor,'daySunEve'=>$daySunEve,'dayMonMor'=>$dayMonMor,'dayMonEve'=>$dayMonEve,'dayTueMor'=>$dayTueMor,'dayTueEve'=>$dayTueEve,'dayWedMor'=>$dayWedMor,'dayWedEve'=>$dayWedEve,'dayThurMor'=>$dayThurMor,'dayThurEve'=>$dayThurEve,'dayFriMor'=>$dayFriMor,'dayFriEve'=>$dayFriEve,'daySatMor'=>$daySatMor,'daySatEve'=>$daySatEve);
	 $doctorClinicTimingupdate=$doctor->updateDoctorClinicTimings($globalUtil,$formDataClinicTimings);
	 /*Update Doctor Clinic Timings Ends*/	 
	 
		if($doctorClinicUpdated && $doctorClinicTimingupdate){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifydoctorclinicmsg",SUCCESS_MSG_UPDATE_DOCTOR_CLINIC,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifydoctorclinicmsg",ERROR_MSG_UPDATE_DOCTOR_CLINIC,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$msgInfo->setMessage("modifydoctorclinicmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctorClinic.php").'?did='.$did);
	
	}	
?>