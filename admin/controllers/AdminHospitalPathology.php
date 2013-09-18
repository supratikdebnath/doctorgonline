<?php
require("../includes/connection.php");
$hospital=new Hospital;
$insuranceCompany=new InsuranceCompany;
$insuranceTPA=new InsuranceTPA;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 
	 $hid=$_POST['hid'];
	 $pfids=implode(',',$_POST['pfids']);
	 //$tieUpsLabs=implode(',',$_POST['tieUpsLabs']);
	 
	 $formData=array("hid"=>$_POST['hid'],"yearofEstablishment"=>$_POST["yearofEstablishment"],"contactNo"=>$_POST["contactNo"],"haid"=>$_POST["haid"],"openAllDays"=>$_POST["openAllDays"],"closedOn"=>$_POST['closedOn'],"pfids"=>$pfids,"extraCharges"=>$_POST['extraCharges'],"tieUpsLabs"=>$_POST['tieUpsLabs'],"reportsViaEmail"=>$_POST['reportsViaEmail'],"homeCollection"=>$_POST['homeCollection']);
	 //$validData=$doctor->validateDoctorClinic($globalUtil,$formDataClinic);
	 if(!$validData['errors']){
	 $newHospitalPathologyAdded=$hospital->insertHospitalPathology($globalUtil,$formData);
	 
	 
		if($newHospitalPathologyAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifyHospitalPathologymsg",SUCCESS_MSG_NEW_HOSPITAL_PATHOLOGY,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifyHospitalPathologymsg",ERROR_MSG_NEW_HOSPITAL_PATHOLOGY,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifyHospitalPathologymsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospitalPathology.php").'?hid='.$hid);
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $id=$_POST['id'];
	 $hid=$_POST['hid'];
	 $pfids=implode(',',$_POST['pfids']);
	 //$tieUpsLabs=implode(',',$_POST['tieUpsLabs']);
	 
	 $formData=array("id"=>$id,"hid"=>$hid,"yearofEstablishment"=>$_POST["yearofEstablishment"],"contactNo"=>$_POST["contactNo"],"haid"=>$_POST["haid"],"openAllDays"=>$_POST["openAllDays"],"closedOn"=>$_POST['closedOn'],"pfids"=>$pfids,"extraCharges"=>$_POST['extraCharges'],"tieUpsLabs"=>$_POST['tieUpsLabs'],"reportsViaEmail"=>$_POST['reportsViaEmail'],"homeCollection"=>$_POST['homeCollection']);
	 
	 //echo "<pre>";print_r($formData);echo "</pre>";die();
	 //$validData=$hospital->validateDoctorClinic($globalUtil,$formDataClinic);
	 //if(!$validData['errors']){
	 $hospitalPathologyUpdated=$hospital->updateHospitalPathology($globalUtil,$formData);	  
	//$msgInfo->setMessage("modifydoctorclinicmsg",$validData['errormsgs'],"errormsg");
	//$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospitalPathology.php").'?hid='.$hid);
	
	}
//For Adding More Info of Pathology Tests
else if(isset($_POST['action']) && $_POST['action']=='addMore'){
$formData=array('hid'=>$_POST['hid'],'testType'=>$_POST['testType'],'testName'=>$_POST['testName'],'testPrice'=>$_POST['testPrice'],'additionalInfo'=>$_POST['additionalInfo']);

if($hospital->validateHospitalPathologyTest($globalUtil,$formData)==false){
	   echo "invaliddata";
	   die();
	}
	else{
		if($hospital->insertHospitalPathologyTest($globalUtil,$formData))
		{
		$hospitalPathologyTestList=$hospital->getHospitalPathologyTest($globalUtil," WHERE hid=".$_POST['hid']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="5" ></tr>';
		   
		   if($hospitalPathologyTestList['numrows']>0){
			   
			  for($i=0;$i<count($hospitalPathologyTestList['data']);$i++){
			  if($hospitalPathologyTestList['data'][$i]['additionalInfo']!='')
			  $addinfo = $hospitalPathologyTestList['data'][$i]['additionalInfo'];
			  else
			  $addinfo = 'No additional info available';
			  $sqlExistsTestType="SELECT test_type FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id=".$hospitalPathologyTestList['data'][$i]['testType'];
			  $rsExistsTestType=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestType,2);
			  $sqlExistsTestName="SELECT test_name,status FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id=".$hospitalPathologyTestList['data'][$i]['testName'];
			  $rsExistsTestName=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestName,2);
			  ($hospitalPathologyTestList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trid'.$hospitalPathologyTestList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  class="formlabel">'.$rsExistsTestType['data'][$i]['test_type'].'</td>
				  			<td align="left"  class="formlabel">'.$rsExistsTestName['data'][$i]['test_name'].'</td>
							<td align="left"  class="formlabel">'.$hospitalPathologyTestList['data'][$i]['testPrice'].'</td>  
							<td align="center"  class="formlabel">'.$addinfo.'</td>
							<td align="center"  class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeSpec('.$hospitalPathologyTestList['data'][$i]['id'].')"><b>Remove</b></a></td>';
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
//For Deleting More Info of Pathology Tests
else if(isset($_POST['action']) && $_POST['action']=='deladdMore' && $_POST['id']!='' && $_POST['hid']!=''){
	$id=$_POST['id'];
	$hid=$_POST['hid'];
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_PATHOLOGY_TESTS." WHERE id='".$id."' AND hid='".$hid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($hospital->deleteHospitalPathologyTest($globalUtil,$adminUtil,$id,$hid)!=0){
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
//For Adding More Info of Departments
else if(isset($_POST['action']) && $_POST['action']=='addDepartmentMore'){
$formData=array('hid'=>$_POST['hid'],'department_name'=>$_POST['department_name'],'registration_time'=>$_POST['registration_time'],'consulation_time'=>$_POST['consulation_time'],'contactno'=>$_POST['contactno'],'openAllDay'=>$_POST['openAllDay'],'otherInformationAvailable'=>$_POST['otherInformationAvailable'],'otherInformation'=>$_POST['otherInformation']);

if($hospital->insertHospitalDepartment($globalUtil,$formData))
		{
		$hospitalDepartmentList=$hospital->getHospitalDepartment($globalUtil," WHERE hid=".$_POST['hid']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="7" ></tr>';
		   
		   if($hospitalDepartmentList['numrows']>0){
			   
			  for($i=0;$i<count($hospitalDepartmentList['data']);$i++){
			  if($hospitalDepartmentList['data'][$i]['otherInformationAvailable']=='Y')
				$addinfo = $hospitalDepartmentList['data'][$i]['otherInformation'];
				else
				$addinfo = 'No other info available';
			
			  ($hospitalDepartmentList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trdelid'.$hospitalDepartmentList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  class="formlabel">'.$hospitalDepartmentList['data'][$i]['department_name'].'</td>
				  			<td align="left"  class="formlabel">'.$hospitalDepartmentList['data'][$i]['registration_time'].'</td>
							<td align="left"  class="formlabel">'.$hospitalDepartmentList['data'][$i]['consulation_time'].'</td>
							<td align="left"  class="formlabel">'.$hospitalDepartmentList['data'][$i]['contactno'].'</td>
							<td align="left"  class="formlabel">'.$hospitalDepartmentList['data'][$i]['openAllDay'].'</td>
							<td align="center"  class="formlabel">'.$addinfo.'</td>
							<td align="center"  class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeDeptSpec('.$hospitalDepartmentList['data'][$i]['id'].')"><b>Remove</b></a></td>';
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
//For Deleting More Info of Departments
else if(isset($_POST['action']) && $_POST['action']=='delDeptMore' && $_POST['id']!='' && $_POST['hid']!=''){
	$id=$_POST['id'];
	$hid=$_POST['hid'];
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_DEPARTMENT_INFORMATION." WHERE id='".$id."' AND hid='".$hid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($hospital->deleteHospitalDepartment($globalUtil,$adminUtil,$id,$hid)!=0){
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
//For Adding More Info of Rooms
else if(isset($_POST['action']) && $_POST['action']=='addRoomMore'){
$formData=array('hid'=>$_POST['hid'],'room_type'=>$_POST['room_type'],'bed_no'=>$_POST['bed_no'],'bed_charge'=>$_POST['bed_charge'],'day_charge'=>$_POST['day_charge'],'contactroomno'=>$_POST['contactroomno'],'arr_other_str'=>$_POST['arr_other_str']);

if($hospital->insertHospitalRoom($globalUtil,$formData))
		{
		$hospitalRoomList=$hospital->getHospitalRoom($globalUtil," WHERE hid=".$_POST['hid']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="7" ></tr>';
		   
		   if($hospitalRoomList['numrows']>0){
			   
			  for($i=0;$i<count($hospitalRoomList['data']);$i++){
			 
				
			
			  ($hospitalRoomList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trrolid'.$hospitalRoomList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  class="formlabel">'.$hospitalRoomList['data'][$i]['room_type'].'</td>
				  			<td align="left"  class="formlabel">'.$hospitalRoomList['data'][$i]['bed_no'].'</td>
							<td align="left"  class="formlabel">'.$hospitalRoomList['data'][$i]['bed_charge'].'</td>
							<td align="left"  class="formlabel">'.$hospitalRoomList['data'][$i]['day_charge'].'</td>
							<td align="left"  class="formlabel">'.$hospitalRoomList['data'][$i]['contactroomno'].'</td>
							<td align="center"  class="formlabel">'.$hospitalRoomList['data'][$i]['arr_other_str'].'</td>
							<td align="center"  class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeRoomSpec('.$hospitalRoomList['data'][$i]['id'].')"><b>Remove</b></a></td>';
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
//For Deleting More Info of Rooms
else if(isset($_POST['action']) && $_POST['action']=='delRoomMore' && $_POST['id']!='' && $_POST['hid']!=''){
	$id=$_POST['id'];
	$hid=$_POST['hid'];
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_ROOM_INFORMATION." WHERE id='".$id."' AND hid='".$hid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($hospital->deleteHospitalRoom($globalUtil,$adminUtil,$id,$hid)!=0){
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
//For Adding More Info of Health
else if(isset($_POST['action']) && $_POST['action']=='addHealthMore'){
$formData=array('hid'=>$_POST['hid'],'packageName'=>$_POST['packageName'],'packagePrice'=>$_POST['packagePrice'],'details'=>$_POST['details']);

if($hospital->insertHospitalHealth($globalUtil,$formData))
		{
		$hospitalHealthList=$hospital->getHospitalHealth($globalUtil," WHERE hid=".$_POST['hid']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="7" ></tr>';
		   
		   if($hospitalHealthList['numrows']>0){
			   
			  for($i=0;$i<count($hospitalHealthList['data']);$i++){
			 if($hospitalHealthList['data'][$i]['details']!='')
							$details = $hospitalHealthList['data'][$i]['details'];
							else
							$details = 'No additional info available';
				
			
			  ($hospitalHealthList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trhelid'.$hospitalHealthList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  class="formlabel">'.$hospitalHealthList['data'][$i]['packageName'].'</td>
				  			<td align="left"  class="formlabel">'.$hospitalHealthList['data'][$i]['packagePrice'].'</td>
							<td align="left"  class="formlabel">'.$details.'</td>
							<td align="center"  class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeHealthSpec('.$hospitalHealthList['data'][$i]['id'].')"><b>Remove</b></a></td>';
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
//For Deleting More Info of Health
else if(isset($_POST['action']) && $_POST['action']=='delHealthMore' && $_POST['id']!='' && $_POST['hid']!=''){
	$id=$_POST['id'];
	$hid=$_POST['hid'];
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_HEALTH_INFORMATION." WHERE id='".$id."' AND hid='".$hid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($hospital->deleteHospitalHealth($globalUtil,$adminUtil,$id,$hid)!=0){
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
//For Adding More Info of Insurance Company
else if(isset($_POST['action']) && $_POST['action']=='addInsuranceCoMore'){
$formData=array('hid'=>$_POST['hid'],'insurance_company'=>$_POST['insurance_company'],'flag'=>$_POST['flag']);

if($insuranceCompany->insertHospitalInsuranceCompany($globalUtil,$formData))
		{
		$insuranceCompanyList=$insuranceCompany->getHospitalInsuranceCompany($globalUtil," WHERE hid=".$_POST['hid']." AND insurance_tpa='' AND flag=1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="2" ></tr>';
		
		   if($insuranceCompanyList['numrows']>0){
			   
			  for($i=0;$i<count($insuranceCompanyList['data']);$i++){
				
			
			  ($insuranceCompanyList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trinslid'.$insuranceCompanyList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  class="formlabel">'.$insuranceCompanyList['data'][$i]['insurance_company'].'</td>
							<td align="center"  class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeInsuranceCoSpec('.$insuranceCompanyList['data'][$i]['id'].')"><b>Remove</b></a></td>';
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
//For Deleting More Info of Insurance Company
else if(isset($_POST['action']) && $_POST['action']=='delInsuranceCoMore' && $_POST['id']!='' && $_POST['hid']!=''){
	$id=$_POST['id'];
	$hid=$_POST['hid'];
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_INSURANCE." WHERE id='".$id."' AND hid='".$hid."' AND flag=1 ";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($insuranceCompany->deleteHospitalInsuranceCompany($globalUtil,$adminUtil,$id,$hid)!=0){
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
//For Adding More Info of Insurance TPA
else if(isset($_POST['action']) && $_POST['action']=='addInsuranceTPAMore'){
$formData=array('hid'=>$_POST['hid'],'insurance_tpa'=>$_POST['insurance_tpa'],'flag'=>$_POST['flag']);

if($insuranceTPA->insertHospitalInsuranceTPA($globalUtil,$formData))
		{
		$insuranceTPAList=$insuranceTPA->getHospitalInsuranceTPA($globalUtil," WHERE hid=".$_POST['hid']." AND insurance_company='' AND flag=2");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="2" ></tr>';
		
		   if($insuranceTPAList['numrows']>0){
			   
			  for($i=0;$i<count($insuranceTPAList['data']);$i++){
				
			
			  ($insuranceTPAList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trinstpalid'.$insuranceTPAList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  class="formlabel">'.$insuranceTPAList['data'][$i]['insurance_tpa'].'</td>
							<td align="center"  class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeInsuranceTPASpec('.$insuranceTPAList['data'][$i]['id'].')"><b>Remove</b></a></td>';
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
//For Deleting More Info of Insurance TPA
else if(isset($_POST['action']) && $_POST['action']=='delInsuranceTPAMore' && $_POST['id']!='' && $_POST['hid']!=''){
	$id=$_POST['id'];
	$hid=$_POST['hid'];
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_INSURANCE." WHERE id='".$id."' AND hid='".$hid."' AND flag=2 ";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($insuranceTPA->deleteHospitalInsuranceTPA($globalUtil,$adminUtil,$id,$hid)!=0){
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
//For Adding More Info of Contact
else if(isset($_POST['action']) && $_POST['action']=='addContactMore'){
$formData=array('hid'=>$_POST['hid'],'name'=>$_POST['name'],'designation'=>$_POST['designation'],'email'=>$_POST['email'],'contactno'=>$_POST['hospcontactno']);

if($hospital->insertHospitalContact($globalUtil,$formData))
		{
		$hospitalContactList=$hospital->getHospitalContact($globalUtil,"  WHERE hid=".$_POST['hid']." ORDER BY id DESC LIMIT 0,1");
		   $html = '';
		   $addinfo = '';
		   $html = '<tr><td colspan="2" ></tr>';
		
		   if($hospitalContactList['numrows']>0){
			   
			  for($i=0;$i<count($hospitalContactList['data']);$i++){
				
			
			  ($hospitalContactList['data'][$i]['id']%2 == 0) ? $tr_class = "trOdd" : $tr_class = "trEven";
				  $html .= '<tr id="trcolid'.$hospitalContactList['data'][$i]['id'].'"  class="'.$tr_class.'">';
				  $html .= '<td align="center"  class="formlabel">'.$hospitalContactList['data'][$i]['name'].'</td>
				            <td align="center"  class="formlabel">'.$hospitalContactList['data'][$i]['designation'].'</td>
							<td align="center"  class="formlabel">'.$hospitalContactList['data'][$i]['email'].'</td>
							<td align="center"  class="formlabel">'.$hospitalContactList['data'][$i]['contactno'].'</td>
							<td align="center"  class="formlabel"><a href="javascript:void(0);" onclick="javascript:removeContactSpec('.$hospitalContactList['data'][$i]['id'].')"><b>Remove</b></a></td>';
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
//For Deleting More Info of Insurance TPA
else if(isset($_POST['action']) && $_POST['action']=='delContactMore' && $_POST['id']!='' && $_POST['hid']!=''){
	$id=$_POST['id'];
	$hid=$_POST['hid'];
	$sqlExists="SELECT * FROM ".TABLE_HOSPITAL_CONTACT_INFORMATION." WHERE id='".$id."' AND hid='".$hid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($hospital->deleteHospitalContact($globalUtil,$adminUtil,$id,$hid)!=0){
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