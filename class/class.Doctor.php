<?php
#############################
#By Samannoy Chatterjee		#
#Date : 23122012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class Doctor{
	public function insertDoctor($globalUtil,$data){
			
			$data_doctor_details=$data;
			if($globalUtil->sqlinsert($data_doctor_details,TABLE_USER_DOCTOR)){
					return true;
			}
			else{
			return false;
			}
		}
	public function updateDoctor($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_USER_DOCTOR)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteDoctor($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_USER_DOCTOR,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_USER_DOCTOR." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_USER_DOCTOR)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_USER_DOCTOR." WHERE id='".$id."'";
		$stateStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$stateStatus['data'][0]['status'];
		return $res;
		}
	public function getDoctor($globalUtil,$condition){
			$sql="SELECT id as doctorDetailsid, did,firstName,lastName,middleName,gender,dateOfBirth,address,cid,sid,zid,aid,pincode,emailAlternate,website,mobileNo,phoneNo,phoneNoAlternate,fax,creditCardAccept,specid,available24Hrs,about,yearsOfExp,registrationNo,designation,consultancyFees,doctorImg,doctorImgDetails,featured_value,status as statusDoctorDetails,createDt,modifyDt FROM ".TABLE_USER_DOCTOR." ".$condition;
			//echo $sql; die();
			$DoctorDetails=$globalUtil->sqlFetchRowsAssoc($sql,2);
			//echo "<pre>";print_r($DoctorDetails);echo "</pre>";die();
			
			if($DoctorDetails['numrows']>0){
				for($i=0;$i<$DoctorDetails['numrows'];$i++){
					if($DoctorDetails['data'][$i]['did']!=''){
						if($this->checkDoctorIsUser($globalUtil,$DoctorDetails['data'][$i]['did'])){
						   $doctorPrimaryInfo=$globalUtil->userDetails($globalUtil,$DoctorDetails['data'][$i]['did']);
						   if($doctorPrimaryInfo['num']>0){
							   $DoctorDetails['data'][$i]=array_merge($DoctorDetails['data'][$i],$doctorPrimaryInfo['data'][0]);
							   }
						}
					}
			    //echo "<pre>";print_r($DoctorDetails);echo "</pre>";die();		
					$DoctorDetails['data'][$i]['clinicinfo']=$this->getDoctorClinic($globalUtil,"WHERE did='".$DoctorDetails['data'][$i]['doctorDetailsid']."'");
					$DoctorDetails['data'][$i]['qualifications']=$this->getDoctorQualifications($globalUtil,"WHERE did='".$DoctorDetails['data'][$i]['doctorDetailsid']."'");
				//echo "<pre>";print_r($DoctorDetails);echo "</pre>";die();
				}
			}
			return $DoctorDetails;
		}
	public function checkDoctorIsUser($globalUtil,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT u.id FROM ".TABLE_USERS." u INNER JOIN ".TABLE_USERS_TYPE." ut ON u.tid=ut.id WHERE id='".$id."' AND ut.u.id='2'",2);
		if($checkifExists==1){
				return true;
			}
		else{
				return false;
			}	
		}
	public function getDoctorFeatured($globalUtil,$condition=""){
		$sql="SELECT doctorImg  FROM ".TABLE_USER_DOCTOR." ".$condition;
		$specFeatured=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $specFeatured;
		}
	public function getLatestDoctorsMostViewed($globalUtil,$condition=""){
		$sql="SELECT doctorImg,viewedcount,firstName,middleName,lastName,id  FROM ".TABLE_USER_DOCTOR." ".$condition;
		$specViewed=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $specViewed;
		}
	public function getSpecializations($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_SPECIALIZATION." ".$condition." ORDER BY specName ASC";
		$specList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $specList;
		}
	public function getQualifications($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_QUALIFICATION." ".$condition." ORDER BY qualificationName ASC";
		$quaList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $quaList;
		}	
	public function getSpecializationsOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$specList=$this->getSpecializations($globalUtil,$condition);
		
		$optionsParmsSelect=array(array('value'=>'','label'=>'-Select Specialization-'));
		
		//print_r($specList);
		for($i=0;$i<count($specList['data']);$i++){
		$optionsParms[$i]['value']=$specList['data'][$i]['id'];
		$optionsParms[$i]['label']=$specList['data'][$i]['specName'];
		}
		
		$optionsParms=array_merge($optionsParmsSelect,$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
		
	public function getQualificationsOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$quaList=$this->getQualifications($globalUtil,$condition);
		//print_r($specList);
		for($i=0;$i<count($quaList['data']);$i++){
		$optionsParms[$i]['value']=$quaList['data'][$i]['id'];
		$optionsParms[$i]['label']=$quaList['data'][$i]['qualificationName'];
		}
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}	
	
	public function getYearOptions($globalUtil,$selectParms,$optionselectedval='',$startYr,$endYr){
			for($i=$startYr;$i<=$endYr;$i++){
				$optionsParms[$i]['value']=$i;
				$optionsParms[$i]['label']=$i;
			}
			$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
		}
	
	public function validateDoctor($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['firstName']==''){
			$error=true;
			$errormsg .= "Please enter first name<br/>";
			}
		if($data['lastName']==''){
			$error=true;
			$errormsg .= "Please enter last name<br/>";
			}	
		if($data['sid']==''){
			$error=true;
			$errormsg .= "Please select state<br/>";
			}
		if($data['cid']==''){
			$error=true;
			$errormsg .= "Please select city<br/>";
			}		
		if($data['zid']==''){
			$error=true;
			$errormsg .= "Please select zone<br/>";
			}	
		if($data['aid']==''){
			$error=true;
			$errormsg .= "Please select area<br/>";
			}		
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}	
	public function getClinicTimingHTMLOptions($selected=""){
		
		$html='';
		for($i=0;$i<10;$i++){
		$selectedval='';
		$value1='0'.$i.':00:00';
		$value2='0'.$i.':30:00';	
		if($value1==$selected){
        	$selectedval='selected="selected"';
		}
		$html .= '<option value="'.$value1.'" '.$selectedval.'>0'.$i.':00</option>';
		if($value2==$selected){
        	$selectedval='selected="selected"';
		}
		
		$html .= '<option value="'.$value2.'" '.$selectedval.'>0'.$i.':30</option>';
			   } 	   
		for($i=10;$i<24;$i++){
		$selectedval = '';
		$value3=$i.':00:00';
		$value4=$i.':30:00';
		
		if($value3==$selected){
        	$selectedval='selected="selected"';
		}		
        $html .= '<option value="'.$value3.'" '.$selectedval.'>'.$i.':00</option>';
		if($value4==$selected){
        	$selectedval='selected="selected"';
		}
		$html .= '<option value="'.$value4.'" '.$selectedval.'>'.$i.':30</option>';
			   }	   
			   
		return $html;
		}	
	public function insertDoctorClinic($globalUtil,$data){
			
			if($globalUtil->sqlinsert($data,TABLE_USER_DOCTOR_CLINICS)){
					return true;
			}
			else{
			return false;
			}
		}
	public function updateDoctorClinic($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."' AND did='".$data['did']."'",TABLE_USER_DOCTOR_CLINICS)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function insertDoctorClinicTimings($globalUtil,$data){
			
			if($globalUtil->sqlinsert($data,TABLE_USER_DOCTOR_CLINICS_TIMINGS)){
					return true;
			}
			else{
			return false;
			}
		}
	public function updateDoctorClinicTimings($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."' AND clnid='".$data['clnid']."'",TABLE_USER_DOCTOR_CLINICS_TIMINGS)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}		
	public function getLatestDoctorClinic($globalUtil,$condition=''){
		$sql="SELECT id FROM ".TABLE_USER_DOCTOR_CLINICS." ".$condition."ORDER BY id DESC LIMIT 0,1";
		$latestClinic=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($latestClinic['numrows']>0){
			return $latestClinic['data'][0]['id'];
			}
		else{
			return false;
			}	
		}				
	public function deleteDoctorClinic($globalUtil,$adminUtil,$id,$did){
		if($this->deleteDoctorClinicTimings($globalUtil,$adminUtil,$id)!=0){
		 	$delete=$globalUtil->sqldelete(TABLE_USER_DOCTOR_CLINICS,"WHERE id='".$id."' AND did='".$did."'");
			return $delete;
		}
		else{
			return 0;
		}
		//return $delete;
		}	
	public function deleteDoctorClinicTimings($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_USER_DOCTOR_CLINICS_TIMINGS,"WHERE clnid='".$id."'");
		return $delete;
		}	
	public function validateDoctorClinic($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['did']==''){
			$error=true;
			$errormsg .= "Please select Doctor.<br/>";
			}
		if($data['clinicName']==''){
			$error=true;
			$errormsg .= "Please enter clinic name<br/>";
			}	
		if($data['clinicAddress']==''){
			$error=true;
			$errormsg .= "Please enter clinic address<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function getDoctorClinic($globalUtil,$condition){
			$sql="SELECT id as doctorClinicid, did,clinicName,clinicAddress,clinicPhoneNumber,clinicCharges,xray,creditCardAccept,emergency,ownUnit,homeVisit,homeVisitCharges,createDt FROM ".TABLE_USER_DOCTOR_CLINICS." ".$condition;
			//echo $sql; die();
			$DoctorClinicDetails=$globalUtil->sqlFetchRowsAssoc($sql,2);
			//echo "<pre>";print_r($DoctorDetails);echo "</pre>";die();
			
			if($DoctorClinicDetails['numrows']>0){
				for($i=0;$i<$DoctorClinicDetails['numrows'];$i++){
			    //echo "<pre>";print_r($DoctorClinicDetails);echo "</pre>";die();		
					$DoctorClinicTimings=$this->getDoctorClinicTimings($globalUtil,"WHERE clnid='".$DoctorClinicDetails['data'][$i]['doctorClinicid']."'");
					if(is_array($DoctorClinicTimings) && $DoctorClinicTimings!=false){
						 $DoctorClinicDetails['data'][$i]=array_merge($DoctorClinicDetails['data'][$i],$DoctorClinicTimings);
						}
				//echo "<pre>";print_r($DoctorClinicDetails);echo "</pre>";die();
				}
			}
			return $DoctorClinicDetails;
		}
	public function getDoctorClinicTimings($globalUtil,$condition){
		
			$sql="SELECT id as dctid,daySunMor, daySunEve,dayMonMor,dayMonEve,dayTueMor,dayTueEve,dayWedMor,dayWedEve,dayThurMor,dayThurEve,dayFriMor,dayFriEve,daySatMor,daySatEve,daySunMor,daySunEve FROM ".TABLE_USER_DOCTOR_CLINICS_TIMINGS." ".$condition;
			//echo $sql; die();
			$DoctorClinicTimings=$globalUtil->sqlFetchRowsAssoc($sql,2);
			//echo "<pre>";print_r($DoctorClinicTimings);echo "</pre>";die();
			if($DoctorClinicTimings['numrows']>0){
				return $DoctorClinicTimings['data'][0];
			}
			else{
				return false;
			}
		}	
	public function uploadDocImage($globalUtil,$uploadfile,$newFileName,$prevImgName='',$removeImg='N'){
		
		 $doctorFolderPath=PROJECT_DOCUMENT_PATH.DOCTOR_IMG_FOLDER;
		 $tempFileName=	$uploadfile['tmp_name'];
		 
		 $docImageFolderSmall=$doctorFolderPath."small/";
		 $docImageFolderMedium=$doctorFolderPath."medium/";
		 $docImageFolderLarge=$doctorFolderPath."large/";
		 //echo $docImageFolderSmall."<br />".$docImageFolderMedium."<br />".$docImageFolderLarge;//die();
		 //echo "<pre>";print_r($_FILES);echo "</pre>";die();	 
		 $return['doctorImg']=$prevImgName; 
		 //$return['doctorImgDetails']='';
		 
		 if($prevImgName!=''){
			if($removeImg=='Y'){
				 if(file_exists($docImageFolderSmall.$prevImgName)){
				 unlink($docImageFolderSmall.$prevImgName);
				 }
				 if(file_exists($docImageFolderMedium.$prevImgName)){
				 unlink($docImageFolderMedium.$prevImgName);
				 }
				 if(file_exists($docImageFolderLarge.$prevImgName)){
				 unlink($docImageFolderLarge.$prevImgName);
				 }
				 $return['doctorImg']=''; 
				 $return['doctorImgDetails']='';
			 }
				 
		}	
		 if(isset($uploadfile) && $uploadfile['name']!=''){
		 $oldFileName=$uploadfile['name'];
		 $fileExt=$globalUtil->getFileExtension($oldFileName);
		 
		 $newFileName=$newFileName."_".time().".".$fileExt;
		 $newFileDetails=$_FILES['doctorImg']['type'];
		 
		 
		 if(file_exists($docImageFolderSmall.$prevImgName)){
		 	unlink($docImageFolderSmall.$prevImgName);
		 }
		 if(file_exists($docImageFolderMedium.$prevImgName)){
			unlink($docImageFolderMedium.$prevImgName);
		 }
		 if(file_exists($docImageFolderLarge.$prevImgName)){
		 	unlink($docImageFolderLarge.$prevImgName);
		 }
		 
		 if(move_uploaded_file($tempFileName,$docImageFolderLarge.$newFileName)){
			 //Resize image (options: exact, portrait, landscape, auto, crop)
			 $imgResizeObj = new ImageResizer($docImageFolderLarge.$newFileName);
			 $imgResizeObj -> resizeImage($resizeObj->width, $resizeObj->height, 'exact');
			 $imgResizeObj -> saveImage($docImageFolderLarge.$newFileName, 100);
			 
			 $imgResizeObj -> resizeImage(400, 271, 'exact');
			 $imgResizeObj -> saveImage($docImageFolderMedium.$newFileName, 100);
			 
			 $imgResizeObj -> resizeImage(165, 100, 'portrait');
			 $imgResizeObj -> saveImage($docImageFolderSmall.$newFileName, 100);
			 $imgResizeObj->destroyImage();
			 
			 $return['doctorImg']=$newFileName;
			 $return['doctorImgDetails']=$newFileDetails;
		 }
	   }
	   return $return;
	}
	
	public function validateDoctorQualification($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['did']==''){
			$error=true;
			}
		if($data['specid']==''){
			$error=true;
			}	
		if($data['qid']==''){
			$error=true;
			}
		if($data['yearOfCompletion']==''){
			$error=true;
			}		
		if($data['instituteName']==''){
			$error=true;
			}		
		if($error){
			return false;	
		}
		else{
			return true;
		}	
	}
	public function insertDoctorQualification($globalUtil,$data){
			
			if($globalUtil->sqlinsert($data,TABLE_USER_DOCTOR_QUALIFICATIONS)){
					return true;
			}
			else{
			return false;
			}
		}
	
	public function deleteDoctorQualification($globalUtil,$adminUtil,$id,$did){
		 $delete=$globalUtil->sqldelete(TABLE_USER_DOCTOR_QUALIFICATIONS,"WHERE id='".$id."' AND did='".$did."'");
			return $delete;
		}
	public function getDoctorQualifications($globalUtil,$condition){
		 $sql="SELECT dq.id as docqid,dq.did as did,dq.specid as specid,dq.qid as quid,dq.yearOfCompletion as yearOfCompletion,dq.instituteName as instituteName,ts.specName as specName ,tq.qualificationName as qualificationName FROM ".TABLE_USER_DOCTOR_QUALIFICATIONS." dq LEFT JOIN  ".TABLE_QUALIFICATION." tq ON dq.qid=tq.id LEFT JOIN ".TABLE_SPECIALIZATION." ts ON ts.id=dq.specid ".$condition;
			//echo $sql; die();
			$DoctorQualifications=$globalUtil->sqlFetchRowsAssoc($sql,2);
			//echo "<pre>";print_r($DoctorClinicTimings);echo "</pre>";die();
				return $DoctorQualifications;
		}	
	public function doctorPublicUrl($Parameters){
		$url = MAIN_SITE_URL."Doctor/";
		$queryString = '';
		$noOfParms=count($Parameters);
		//echo $noOfParms."<br />";
		$k=1;
		foreach($Parameters as $params=>$val){
			if($params=='id' && $val!=''){
				$queryString .= str_replace(array(" ","/",""),'-',$val)."/";
				}
			elseif($params!='id' && $val!=''){
				$queryString .= str_replace(array(" ","/",""),'-',$val);
				}
			elseif($params!='id' && $val!='' && $noOfParms>$i){
				$queryString .= "-";
				}	
			//echo "Samannoy".$k."<br />";	
			$k++;		
			
			}
			//die();
		$url = $url.$queryString;	
		return $url;	
		
		}	
}
?>