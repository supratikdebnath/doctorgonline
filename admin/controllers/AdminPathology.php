<?php
require("../includes/connection.php");
$pathology=new Pathology;
$doctor=new Doctor;


//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 

	 $hfid=implode(',',$_POST['hfid']);
	 $did=implode(',',$_POST['did']);
	 //$tieUpsLabs=implode(',',$_POST['tieUpsLabs']);
	$_POST['removePathologyCenteImg']='';
	$_POST['previousPathologyCenteImg']='';
	 
	  $formData=array("pathologycenterName"=>$_POST["pathologycenterName"],"address"=>$_POST["address"],"cid"=>$_POST["cid"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"aid"=>$_POST["aid"],"pincode"=>$_POST["pincode"],"emailAlternate"=>$_POST["emailAlternate"],"website"=>$_POST["website"],"phoneNo"=>$_POST["phoneNo"],"phoneNoAlternate"=>$_POST["phoneNoAlternate"],"fax"=>$_POST["fax"],"creditCardAccept"=>$_POST["creditCardAccept"],"available24Hrs"=>$_POST["available24Hrs"],"about"=>$_POST["about"],"registrationNo"=>$_POST["registrationNo"],"hfid"=>$hfid,"haid"=>$_POST['haid'],"YrofEstablishment"=>$_POST["YrofEstablishment"],"emergencyServiceNoAvailable"=>$_POST["emergencyServiceNoAvailable"],"emergencyServiceNo"=>$_POST["emergencyServiceNo"],"tieupWithSpecializedLabs"=>$_POST["tieupWithSpecializedLabs"],"tieupWithLabs"=>$_POST["tieupWithLabs"],"ambulenceNoAvailable"=>$_POST["ambulenceNoAvailable"],"ambulenceNo"=>$_POST["ambulenceNo"],"sampleCollectionAtHome"=>$_POST["sampleCollectionAtHome"],"sampleCollection"=>$_POST["sampleCollection"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"],"featured_value"=>$_POST["featured_value"],"did"=>$did); //Edited By Samannoy
	 $validData=$pathology->validatePathologyDetails($globalUtil,$formData);
	 if(!$validData['errors']){
	 
	 	/*Image Upload Start*/		
		$pathologyImageData=$pathology->uploadPathologyImage($globalUtil,$_FILES['pathologyCenterImg'],$_POST["pathologycenterName"],$_POST['previousPathologyCenteImg'],$_POST['removePathologyCenteImg']);
		$formData=array_merge($formData,$pathologyImageData); 
	    /*Image Upload Ends*/
		
	 $newPathologyDetailsAdded=$pathology->insertPathologyDetails($globalUtil,$formData);
	 
	 
		if($newPathologyDetailsAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifypathologymsg",SUCCESS_MSG_NEW_PATHOLOGY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifypathologymsg",ERROR_MSG_NEW_PATHOLOGY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifypathologymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathology.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){

	 $_POST['removePathologyCenteImg']='';
	 $id=$_POST['id'];
	 $hfid=implode(',',$_POST['hfid']);
	 $didchk=implode(',',$_POST['didchk']);

	 //$tieUpsLabs=implode(',',$_POST['tieUpsLabs']);
	 $formData=array("id"=>$id,"pathologycenterName"=>$_POST["pathologycenterName"],"address"=>$_POST["address"],"cid"=>$_POST["cid"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"aid"=>$_POST["aid"],"pincode"=>$_POST["pincode"],"emailAlternate"=>$_POST["emailAlternate"],"website"=>$_POST["website"],"phoneNo"=>$_POST["phoneNo"],"phoneNoAlternate"=>$_POST["phoneNoAlternate"],"fax"=>$_POST["fax"],"creditCardAccept"=>$_POST["creditCardAccept"],"available24Hrs"=>$_POST["available24Hrs"],"about"=>$_POST["about"],"registrationNo"=>$_POST["registrationNo"],"hfid"=>$hfid,"haid"=>$_POST['haid'],"YrofEstablishment"=>$_POST["YrofEstablishment"],"emergencyServiceNoAvailable"=>$_POST["emergencyServiceNoAvailable"],"emergencyServiceNo"=>$_POST["emergencyServiceNo"],"tieupWithSpecializedLabs"=>$_POST["tieupWithSpecializedLabs"],"tieupWithLabs"=>$_POST["tieupWithLabs"],"ambulenceNoAvailable"=>$_POST["ambulenceNoAvailable"],"ambulenceNo"=>$_POST["ambulenceNo"],"sampleCollectionAtHome"=>$_POST["sampleCollectionAtHome"],"sampleCollection"=>$_POST["sampleCollection"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"],"featured_value"=>$_POST["featured_value"],"did"=>$didchk); //Edited By Samannoy
	 
	 $validData=$pathology->validatePathologyDetails($globalUtil,$formData);
	 if(!$validData['errors']){
	 
	 	/*Image Upload Start*/		
		$pathologyImageData=$pathology->uploadPathologyImage($globalUtil,$_FILES['pathologyCenterImg'],$_POST["pathologycenterName"],$_POST['previousPathologyCenteImg'],$_POST['removePathologyCenteImg']);
		$formData=array_merge($formData,$pathologyImageData); 
	    /*Image Upload Ends*/
		
	 $newPathologyDetailsAdded=$pathology->updatePathologyDetails($globalUtil,$formData);
	 
	 
		if($newPathologyDetailsAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listpathologymsg",SUCCESS_MSG_UPDATE_PATHOLOGY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listpathologymsg",ERROR_MSG_UPDATE_PATHOLOGY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("listpathologymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	//$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathology.php?do=edit&id=".$id));
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php"));
}
/*   For Adding Pathology Center Information      */

else if(isset($_POST['action']) && $_POST['action']=='addPathologyMore'){
$formData=array('pid'=>$_POST['id'],'testTypeId'=>$_POST['testType'],'testNameId'=>$_POST['testName'],'testPrice'=>$_POST['testPrice'],'additionalInfo'=>$_POST['additionalInfo']);

if($pathology->validatePathologyInfo($globalUtil,$formData)==false){
	   echo "invaliddata";
	   die();
	}
	else{
		if($pathology->insertPathologyInfo($globalUtil,$formData))
		{
		$pathologyInfoList=$pathology->getPathologyInfo($globalUtil,"WHERE pid=".$_POST['id']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $action = '';
		   $html = '<tr><td colspan="5" style="background-color:#CCC"></td></tr>'; //Edited By Samannoy
		   if($pathologyInfoList['numrows']>0){
			   
			  for($i=0;$i<count($pathologyInfoList['data']);$i++){
			  if($pathologyInfoList['data'][$i]['additionalInfo']!='')
			  $addinfo = $pathologyInfoList['data'][$i]['additionalInfo'];
			  else
			  $addinfo = 'No additional info available';
			  $sqlExistsTestType="SELECT test_type FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id='".$pathologyInfoList['data'][$i]['testTypeId']."'";
			  $rsExistsTestType=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestType,2);
			  $sqlExistsTestName="SELECT test_name,status FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id='".$pathologyInfoList['data'][$i]['testNameId']."'";
			  $rsExistsTestName=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestName,2);
			  ($pathologyInfoList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
			  ($rsExistsTestName['data'][0]['status']==0) ? $action = "<b><em>Disabled</em></b>" : $action = "<a href='javascript:void(0);' onclick='javascript:removePathologySpec(".$pathologyInfoList['data'][$i]['id'].");'><b>Remove</b></a>";
				  $html .= '<tr id="trpathid'.$pathologyInfoList['data'][$i]['id'].'" class="'.$tr_class.'">';
				  $html .= '<td align="center" class="formlabel">'.$rsExistsTestType['data'][$i]['test_type'].'</td>
				  			<td align="center" class="formlabel">'.$rsExistsTestName['data'][$i]['test_name'].'</td>
							<td align="center" class="formlabel">'.$pathologyInfoList['data'][$i]['testPrice'].'</td>  
							<td align="center" class="formlabel">'.$addinfo.'</td>
							<td align="center" class="formlabel">'.$action.'</td>'; //Edited By Samannoy
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
/*                                        */	

/*    For Deleting Pathology Center Information */
else if(isset($_POST['action']) && $_POST['action']=='delPathologyMore' && $_POST['id']!='' && $_POST['pid']!=''){
	$id=$_POST['id'];
	$pid=$_POST['pid'];
	$sqlExists="SELECT * FROM ".TABLE_PATHOLOGY_TESTS." WHERE id='".$id."' AND pid='".$pid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($pathology->deletePathologyInfo($globalUtil,$adminUtil,$id,$pid)!=0){
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

/*  

/*   For Adding Health Package Information      */
else if(isset($_POST['action']) && $_POST['action']=='addHealthMore'){
$formData=array('pid'=>$_POST['id'],'packageName'=>$_POST['packageName'],'packagePrice'=>$_POST['packagePrice'],'details'=>$_POST['details']);

if($pathology->validateHealthPackageInfo($globalUtil,$formData)==false){
	   echo "invaliddata";
	   die();
	}
	else{
		if($pathology->insertHealthInfo($globalUtil,$formData))
		{
		$healthInfoList=$pathology->getHealthInfo($globalUtil,"WHERE pid=".$_POST['id']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="4"></td></tr>'; //Edited By Samannoy
		   
		   if($healthInfoList['numrows']>0){
			   
			  for($i=0;$i<count($healthInfoList['data']);$i++){
			  if($healthInfoList['data'][$i]['details']!='')
			  $details = $healthInfoList['data'][$i]['details'];
			  else
			  $details = 'No additional info available';
			   ($healthInfoList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trhealthid'.$healthInfoList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center" class="formlabel">'.$healthInfoList['data'][$i]['packageName'].'</td>
				  			<td align="center" class="formlabel">'.$healthInfoList['data'][$i]['packagePrice'].'</td>
							<td align="center" class="formlabel">'.$details.'</td>
							<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeHealthSpec(\''.$healthInfoList['data'][$i]['id'].'\')"><b>Remove</b></a></td>'; //Edited By Samannoy
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
/*   

/*    For Deleting Health Package Information */
else if(isset($_POST['action']) && $_POST['action']=='delHealthMore' && $_POST['id']!='' && $_POST['pid']!=''){
	$id=$_POST['id'];
	$pid=$_POST['pid'];
	$sqlExists="SELECT * FROM ".TABLE_PATHOLOGY_HEALTH_PACKAGE." WHERE id='".$id."' AND pid='".$pid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($pathology->deleteHealthInfo($globalUtil,$adminUtil,$id,$pid)!=0){
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
/*                                                  */	
												 
/*   For Adding Contact Person Details Starts      */
else if(isset($_POST['action']) && $_POST['action']=='addContactMore'){
$formData=array('pid'=>$_POST['id'],'name'=>$_POST['name'],'designation'=>$_POST['designation'],'email'=>$_POST['email'],'contactno'=>$_POST['contactno']);

if($pathology->validateContactPersonInfo($globalUtil,$formData)==false){
	   echo "invaliddata";
	   die();
	}
	else{
		if($pathology->insertContactInfo($globalUtil,$formData))
		{
		$contactInfoList=$pathology->getContactInfo($globalUtil,"WHERE pid=".$_POST['id']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="5"></td></tr>';
		   
		   if($contactInfoList['numrows']>0){
			   
			  for($i=0;$i<count($contactInfoList['data']);$i++){
			  if($contactInfoList['data'][$i]['contactno']!=''){ // Edited By Samannoy
			  $contactno = $contactInfoList['data'][$i]['contactno']; // Edited By Samannoy
			  }
			  else{
			  $contactno = 'No contact no available';
			  }
			   ($contactInfoList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trhealthid'.$contactInfoList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center" class="formlabel">'.$contactInfoList['data'][$i]['name'].'</td>
				  			<td align="center" class="formlabel">'.$contactInfoList['data'][$i]['designation'].'</td>
							<td align="center" class="formlabel">'.$contactInfoList['data'][$i]['email'].'</td>
							<td align="center" class="formlabel">'.$contactno.'</td>
							<td align="center" class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeContactSpec(\''.$contactInfoList['data'][$i]['id'].'\')"><b>Remove</b></a></td>'; //Edited By Samannoy
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
/*   

/*    For Deleting Contact Person Details */
else if(isset($_POST['action']) && $_POST['action']=='delContactMore' && $_POST['id']!='' && $_POST['pid']!=''){
	$id=$_POST['id'];
	$pid=$_POST['pid'];
	$sqlExists="SELECT * FROM ".TABLE_PATHOLOGY_CONTACT_PERSON." WHERE id='".$id."' AND pid='".$pid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($pathology->deleteContactInfo($globalUtil,$adminUtil,$id,$pid)!=0){
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
/*  

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
	$pathologyInfoList=$pathology->getPathology($globalUtil,"WHERE id=".$pid);
	$did=explode(",",$pathologyInfoList['data'][0]['did']);
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
    $pathologyInfoList=$pathology->getPathology($globalUtil,"WHERE id=".$pid);
	$did=explode(",",$pathologyInfoList['data'][0]['did']);
	
	array_push($did, $_POST['doctorid']);
	$didarr=implode(",",$did);
	$formData=array("id"=>$pid,"did"=>$didarr);
	$pathology->updatePathologyDetails($globalUtil,$formData);
	
	$html .= '<table  width="90%" cellspacing="0" cellpadding="0" border="1" align="center"   style="border:#666666; border-width:1px; border-style:solid;position:static;">
						  <tr><td width="1%"><b></b></td><td class="formlabel"><b>List of <u>Selected Doctor name</u></b></td><!--<td width="15%" class="formlabel"><div align="left"><b>View Details</b></div></td>--></tr>';
							if(count($did)>0){
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

/*    For Getting Pathology Test Name */                                             	
else if(isset($_POST['action']) && $_POST['action']=='getPathologyTestName' && $_POST['testType']!=''){
$sqlExists="SELECT id,test_name FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE tid='".$_POST['testType']."'";
$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
if($ifExists>0)
        {
?>
<option value="" >-Select Pathology Test Name-</option>
<?php
for($i=0;$i<$ifExists;$i++){
$rsExists=$globalUtil->sqlFetchRowsAssoc($sqlExists,2);
?>
<option value="<?php echo $rsExists['data'][$i]['id']; ?>"><?php echo $rsExists['data'][$i]['test_name']; ?></option>
<?php
                           }
                }
else
	    {
		
		echo '<option value="">No Test Name exists !!</option>*0';
		
       }	
}				
?>
