<?php
require("../includes/connection.php");
$hospital=new Hospital;
$doctor=new Doctor;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 if($_POST['hfid']!=''){
		 $hfid=implode(',',$_POST['hfid']);
		}
	 if($_POST['hdid']!=''){
		 $hdid=implode(',',$_POST['hdid']);
		}		
	 if($_POST['did']!=''){
		 $did=implode(',',$_POST['did']);
		}		
	 
	$_POST['removeHospitalImg']='';
	$_POST['previousHospitalImg']='';
	
	 $formData=array("hospitalName"=>$_POST["hospitalName"],"address"=>$_POST["address"],"cid"=>$_POST["cid"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"aid"=>$_POST["aid"],"pincode"=>$_POST["pincode"],"emailAlternate"=>$_POST["emailAlternate"],"website"=>$_POST["website"],"phoneNo"=>$_POST["phoneNo"],"phoneNoAlternate"=>$_POST["phoneNoAlternate"],"fax"=>$_POST["fax"],"creditCardAccept"=>$_POST["creditCardAccept"],"available24Hrs"=>$_POST["available24Hrs"],"about"=>$_POST["about"],"registrationNo"=>$_POST["registrationNo"],"medicoLegalCases"=>$_POST["medicoLegalCases"],"noOfBeds"=>$_POST["noOfBeds"],"authorizedBy"=>$_POST["authorizedBy"],"htid"=>$_POST["htid"],"hcid"=>$_POST["hcid"],"haid"=>$_POST["haid"],"hfid"=>$hfid,"hdid"=>$hdid,"YrofEstablishment"=>$_POST["YrofEstablishment"],"otherFacility"=>$_POST["otherFacility"],"oPDContactNoAvailable"=>$_POST["oPDContactNoAvailable"],"oPDContactNo"=>$_POST["oPDContactNo"],"bloodBankNoAvailable"=>$_POST["bloodBankNoAvailable"],"bloodBankNo"=>$_POST["bloodBankNo"],"emergencyServiceNoAvailable"=>$_POST["emergencyServiceNoAvailable"],"emergencyServiceNo"=>$_POST["emergencyServiceNo"],"eyeBankNoAvailable"=>$_POST["eyeBankNoAvailable"],"eyeBankNo"=>$_POST["eyeBankNo"],"organBankNoAvailable"=>$_POST["organBankNoAvailable"],"organBankNo"=>$_POST["organBankNo"],"ambulenceNoAvailable"=>$_POST["ambulenceNoAvailable"],"ambulenceNo"=>$_POST["ambulenceNo"],"healthInsurenceTieUpsNoAvailable"=>$_POST["healthInsurenceTieUpsNoAvailable"],"healthInsurenceTieUpsNo"=>$_POST["healthInsurenceTieUpsNo"],"guestHouseNoAvailable"=>$_POST["guestHouseNoAvailable"],"guestHouseNo"=>$_POST["guestHouseNo"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"],"featured_value"=>$_POST["featured_value"],"did"=>$did);
	 $validData=$hospital->validateHospital($globalUtil,$formData);
	 if(!$validData['errors']){
		 
		 /*Image Upload Start*/		
		$hospitalImageData=$hospital->uploadHospitalImage($globalUtil,$_FILES['hospitalImg'],$_POST["hospitalName"],$_POST['previousHospitalImg'],$_POST['removeHospitalImg']);
		$formData=array_merge($formData,$hospitalImageData); 
	    /*Image Upload Ends*/
		
	 $newHospitalAdded=$hospital->insertHospital($globalUtil,$formData);
		if($newHospitalAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifyhospitalmsg",SUCCESS_MSG_NEW_HOSPITAL,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifyhospitalmsg",ERROR_MSG_NEW_HOSPITAL,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifyhospitalmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospital.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 if($_POST['hfid']!=''){
		 $hfid=implode(',',$_POST['hfid']);
		}
	 if($_POST['hdid']!=''){
		 $hdid=implode(',',$_POST['hdid']);
		}		
	 if($_POST['didchk']!=''){
		 $didchk=implode(',',$_POST['didchk']);
		}
		
	 
	 $formData=array("id"=>$_POST['id'],"hospitalName"=>$_POST["hospitalName"],"address"=>$_POST["address"],"cid"=>$_POST["cid"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"aid"=>$_POST["aid"],"pincode"=>$_POST["pincode"],"emailAlternate"=>$_POST["emailAlternate"],"website"=>$_POST["website"],"phoneNo"=>$_POST["phoneNo"],"phoneNoAlternate"=>$_POST["phoneNoAlternate"],"fax"=>$_POST["fax"],"creditCardAccept"=>$_POST["creditCardAccept"],"available24Hrs"=>$_POST["available24Hrs"],"about"=>$_POST["about"],"registrationNo"=>$_POST["registrationNo"],"medicoLegalCases"=>$_POST["medicoLegalCases"],"noOfBeds"=>$_POST["noOfBeds"],"authorizedBy"=>$_POST["authorizedBy"],"htid"=>$_POST["htid"],"hcid"=>$_POST["hcid"],"haid"=>$_POST["haid"],"hfid"=>$hfid,"hdid"=>$hdid,"YrofEstablishment"=>$_POST["YrofEstablishment"],"otherFacility"=>$_POST["otherFacility"],"oPDContactNoAvailable"=>$_POST["oPDContactNoAvailable"],"oPDContactNo"=>$_POST["oPDContactNo"],"bloodBankNoAvailable"=>$_POST["bloodBankNoAvailable"],"bloodBankNo"=>$_POST["bloodBankNo"],"emergencyServiceNoAvailable"=>$_POST["emergencyServiceNoAvailable"],"emergencyServiceNo"=>$_POST["emergencyServiceNo"],"eyeBankNoAvailable"=>$_POST["eyeBankNoAvailable"],"eyeBankNo"=>$_POST["eyeBankNo"],"organBankNoAvailable"=>$_POST["organBankNoAvailable"],"organBankNo"=>$_POST["organBankNo"],"ambulenceNoAvailable"=>$_POST["ambulenceNoAvailable"],"ambulenceNo"=>$_POST["ambulenceNo"],"healthInsurenceTieUpsNoAvailable"=>$_POST["healthInsurenceTieUpsNoAvailable"],"healthInsurenceTieUpsNo"=>$_POST["healthInsurenceTieUpsNo"],"guestHouseNoAvailable"=>$_POST["guestHouseNoAvailable"],"guestHouseNo"=>$_POST["guestHouseNo"],"modifyDt"=>time(),"status"=>$_POST["status"],"featured_value"=>$_POST["featured_value"],"did"=>$didchk);
	 //echo "<pre>";print_r($formData);echo "</pre>";die();
	 $validData=$hospital->validateHospital($globalUtil,$formData);
	 if(!$validData['errors']){
		 
		  /*Image Upload Start*/		
		$hospitalImageData=$hospital->uploadHospitalImage($globalUtil,$_FILES['hospitalImg'],$_POST["hospitalName"],$_POST['previousHospitalImg'],$_POST['removeHospitalImg']);
		$formData=array_merge($formData,$hospitalImageData); 
	    /*Image Upload Ends*/
		
	 $hospitalUpdated=$hospital->updateHospital($globalUtil,$formData);
	 
		if($hospitalUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listhospitalmsg",SUCCESS_MSG_UPDATE_HOSPITAL,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listhospitalmsg",ERROR_MSG_UPDATE_HOSPITAL,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listhospitalmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php"));
	
	}	

/*    For Searching Doctors */                                             	
else if(isset($_POST['action']) && $_POST['action']=='searchDoctor' && $_POST['name']!=''){
$bad_img='<img src='.$globalUtil->generateUrl(ADMIN_IMAGES_URL."bad_mood.png").' border="0">';
if($_POST['id']==1)
	{
	$name=$_POST['name'];
	$html = '';
	$qname = '';
	$sqlExists=$doctor->getDoctor($globalUtil," WHERE  firstname LIKE '".$name."%' ORDER BY id");
	
	if($sqlExists['numrows']>0){
    $count=0;
	
	$html .= '<table  width="80%" cellspacing="0" cellpadding="0" border="1" align="left" class="" id="" style="border:#666666; border-width:1px; border-style:solid;">';
	$html .= '<tr><td width="1%"><b></b></td><td class="formlabel"><b>Doctor Name</b></td><td width="15%" class="formlabel"><div align="left"><b>Specialization</b></div></td><td width="15%" class="formlabel"><div align="left"><b>Qualification</b></div></td></tr>'; 
	for($i=0;$i<$sqlExists['numrows'];$i++){
      $count++;
	  $sqlspecialization=mysql_fetch_array(mysql_query("SELECT id,specName FROM dgo_specialization WHERE id=".$sqlExists['data'][$i]['specid']));
	  $sqlqid=mysql_fetch_array(mysql_query("SELECT qid FROM dgo_user_doctor_qualifications WHERE specid =".$sqlExists['data'][$i]['specid']));
	  $sqlqual=mysql_fetch_array(mysql_query("SELECT qualificationName FROM dgo_qualification WHERE id =".$sqlqid['qid']));
	  ($sqlqual['qualificationName'] !='') ? $qname = '<b>'.$sqlqual['qualificationName']."</b>" : $qname = "No Qualification Available";
	  ($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
	  $html .= '<tr id="'.$sqlExists['data'][$i]['doctorDetailsid'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  width="1%" ><input type="checkbox" id="did" name="did[]" value="'.$sqlExists['data'][$i]['doctorDetailsid'].'"></td>
				            <td align="center" nowrap="nowrap" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left">'.$sqlExists['data'][$i]['firstName'].' '.$sqlExists['data'][$i]['lastName'].'</div></td>
							<td align="center" nowrap="nowrap" style="font-size: 13px;padding-left: 5px;text-align: left;">'.$sqlspecialization['specName'].'</td>
						    <td align="center" nowrap="nowrap" style="font-size: 13px;padding-left: 5px;text-align: left;">'.$qname.'</td>';
				  $html .= '</tr>';
	 
	  
	  
	}
	              $html .= '</table>';
	 echo $html;
	 
	}
	else{
	    $html .= '<table  width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="" >';
		$html .= '<tr>';
		$html .= '<td align="center" style="font-size: 13px;float:left;padding-bottom:40px" >'.$bad_img.'&nbsp;<b style="color:#FF0000">No doctor starting with <u><font color="#0066FF">'.$name.'</font></u> found. Please <a href="'.$globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctor.php").'">add new doctor</a></b></td>'; 
		$html .= '</tr>';
		$html .= '</table>';
	 echo $html;
	 die();	
	}
	
 }
else if($_POST['id']==2)
	{
	$name=$_POST['name'];
	$pid=$_POST['pid'];
	$html = '';
	$checked = '';
	$msg='';
	$hospitalInfoList=$hospital->getHospital($globalUtil,"WHERE id=".$pid);
	$did=explode(",",$hospitalInfoList['data'][0]['did']);
	$sqlExists=$doctor->getDoctor($globalUtil," WHERE  firstname LIKE '".$name."%' ORDER BY id");
	if($sqlExists['numrows']>0){
    $count=0;
	
	$html .= '<table  width="80%" cellspacing="0" cellpadding="0" border="1" align="left" class="" id="" style="border:#666666; border-width:1px; border-style:solid;">';
	$html .= '<tr><td width="1%"><b></b></td><td class="formlabel"><b>Doctor Name</b>&nbsp;</td><td width="15%" class="formlabel"><div align="left"><b>Specialization</b></div></td><td width="15%" class="formlabel"><div align="left"><b>Qualification</b></div></td></tr>'; 
	for($i=0;$i<$sqlExists['numrows'];$i++){
      $count++;
	  $sqlspecialization=mysql_fetch_array(mysql_query("SELECT specName FROM dgo_specialization WHERE id=".$sqlExists['data'][$i]['specid']));
	  $sqlqid=mysql_fetch_array(mysql_query("SELECT qid FROM dgo_user_doctor_qualifications WHERE specid =".$sqlExists['data'][$i]['specid']));
	  $sqlqual=mysql_fetch_array(mysql_query("SELECT qualificationName FROM dgo_qualification WHERE id =".$sqlqid['qid']));
	  ($sqlqual['qualificationName'] !='') ? $qname = '<b>'.$sqlqual['qualificationName']."</b>" : $qname = "No Qualification Available";
	  ($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven"; 
	  (in_array($sqlExists['data'][$i]['doctorDetailsid'], $did)) ? $checked = 'checked="checked" disabled="disabled"' : $checked = '';
	  (in_array($sqlExists['data'][$i]['doctorDetailsid'], $did)) ? $msg = '<font color=blue>(<b><em>Already selected</em></b>)</font>' : $msg = '';
	  $html .= '<tr id="'.$sqlExists['data'][$i]['doctorDetailsid'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  width="1%"><input type="checkbox" id="did'.$count.'" name="did[]" value="'.$sqlExists['data'][$i]['doctorDetailsid'].'" '.$checked.' onclick="chkVal('.$sqlExists['data'][$i]['doctorDetailsid'].','.$count.','.$sqlExists['numrows'].')"></td>
				            <td align="center" nowrap="nowrap" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left">'.$sqlExists['data'][$i]['firstName'].' '.$sqlExists['data'][$i]['lastName'].' '.$msg.'</div></td>
							<td align="center" nowrap="nowrap" style="font-size: 13px;padding-left: 5px;text-align: left;">'.$sqlspecialization['specName'].'</td>
							<td align="center" nowrap="nowrap" style="font-size: 13px;padding-left: 5px;text-align: left;">'.$qname.'</td>';
				  $html .= '</tr>';
	 
	  
	  
	}
	              $html .= '</table>';
	 echo $html;
	 
	}
	else{
	    $html .= '<table  width="80%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="" >';
		$html .= '<tr>';
		$html .= '<td align="center" style="font-size: 13px;float:left;padding-bottom:40px" >'.$bad_img.'&nbsp;<b style="color:#FF0000">No doctor starting with <u><font color="#0066FF">'.$name.'</font></u> found. Please <a href="'.$globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctor.php").'">add new doctor</a></b></td>'; 
		$html .= '</tr>';
		$html .= '</table>';
	 echo $html;
	 die();	
	}
	}
}		
	/*    For Updating Already Searched Doctors */                                             	
else if(isset($_POST['action']) && $_POST['action']=='updateDoctorList' && $_POST['doctorid']!=''){
	$pid=$_POST['pid'];
	$html='';
	$count=0;
	$tr_class='';
    $hospitalInfoList=$hospital->getHospital($globalUtil,"WHERE id=".$pid);
	if($hospitalInfoList['data'][0]['did']!='')
	{
	$did=explode(",",$hospitalInfoList['data'][0]['did']);
	}
	if($did!='')
	{
	array_push($did, $_POST['doctorid']);
	$didarr=implode(",",$did);
	$formData=array("id"=>$pid,"did"=>$didarr);
	}
	else if($did=='')
	{
		//echo $_POST['doctorid'];
	$formData=array("id"=>$pid,"did"=>$_POST['doctorid']);
	}
	
	
	$hospital->updateHospitalDetails($globalUtil,$formData);
	
	$html .= '<table  width="90%" cellspacing="0" cellpadding="0" border="1" align="center"   style="border:#666666; border-width:1px; border-style:solid;position:static;">
						  <tr><td width="1%"><b></b></td><td class="formlabel"><b>List of <u>Selected Doctor name</u></b></td><!--<td width="15%" class="formlabel"><div align="left"><b>View Details</b></div></td>--></tr>';
							if(count($did)>0){
								for($i=0;$i<count($did);$i++){
								
								$sqldoctorList=mysql_query("SELECT firstName,lastName,id FROM ".TABLE_USER_DOCTOR." WHERE id='".$did[$i]."' ORDER BY id DESC ");
								$rsdoctorList=mysql_fetch_array($sqldoctorList);
								
								$count++;
								($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
								(in_array($rsdoctorList['id'], $did)) ? $checked = 'checked="checked"' : $checked = 'checked=" "';
								
							 $html .= '<tr id='.$rsdoctorList['id'].' class='.$tr_class.'>
									<td align="center"  width="1%"><input type="checkbox" id="didchk'.$count.'" name="didchk[]" value='.$rsdoctorList['id'].' '.$checked.'  /></td>
									<td align="center" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left">'.$rsdoctorList['firstName'].' '.$rsdoctorList['lastName'].'</div></td>
									<!--<td align="center" style="font-size: 13px;padding-left: 5px;text-align: left;">View</td>-->
								</tr>';
								
								
									   
									}
									
									$html .= '</table>';
								}
							else if(count($_POST['doctorid'])>0){
								for($i=0;$i<count($_POST['doctorid']);$i++){
								
								$sqldoctorList=mysql_query("SELECT firstName,lastName,id FROM ".TABLE_USER_DOCTOR." WHERE id='".$_POST['doctorid']."' ORDER BY id DESC ");
								$rsdoctorList=mysql_fetch_array($sqldoctorList);
								
								$count++;
								($count%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
								(in_array($rsdoctorList['id'], $did)) ? $checked = 'checked="checked"' : $checked = 'checked=" "';
								
							 $html .= '<tr id='.$rsdoctorList['id'].' class='.$tr_class.'>
									<td align="center"  width="1%"><input type="checkbox" id="didchk'.$count.'" name="didchk[]" value='.$rsdoctorList['id'].' '.$checked.'  /></td>
									<td align="center" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left">'.$rsdoctorList['firstName'].' '.$rsdoctorList['lastName'].'</div></td>
									<!--<td align="center" style="font-size: 13px;padding-left: 5px;text-align: left;">View</td>-->
								</tr>';
								
								
									   
									}
									
									$html .= '</table>';
								}
									
									echo $html;
	 die();	
									

}
?>