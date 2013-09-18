<?php
#############################
#By Subhro Ray		#
#Date : 16022012			#
#Last Updated: 16022012		#
#############################
class Pathology{
	public function insertPathology($globalUtil,$data){
			
			$data_doctor_details=$data;
			if($globalUtil->sqlinsert($data_doctor_details,TABLE_USER_Pathology)){
				//$data_qualification=array();
				//$globalUtil->sqlinsert($data_qualification,TABLE_USER_Pathology_QUALIFICATIONS);
				/*Clinic Data Insert Starts*/
				//$data_clinic=array();
				//$globalUtil->sqlinsert($data_clinic,TABLE_USER_Pathology_CLINICS);
				/*Clinic Data Inserts Ends*/
				
				/*Clinic Timings Data Insert Starts*/
				//$data_clinic_timings=array();				
				//$globalUtil->sqlinsert($data_clinic_timings,TABLE_USER_Pathology_CLINICS_TIMINGS);
				/*Clinic Timings Data Insert Ends*/
					return true;
			}
			else{
			return false;
			}
		}
	public function updatePathology($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_USER_Pathology)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deletePathology($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_PATHOLOGY_DETAILS,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_PATHOLOGY_DETAILS." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_PATHOLOGY_DETAILS)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_PATHOLOGY_DETAILS." WHERE id='".$id."'";
		$stateStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$stateStatus['data'][0]['status'];
		return $res;
		}
	public function getPathology($globalUtil,$condition){
					 $sql="SELECT id as pathologyDetailsid,pid,hfid,haid,pathologycenterName,address,cid,sid,zid,aid,pincode,emailAlternate,website,phoneNo,phoneNoAlternate,fax,creditCardAccept,available24Hrs,about,registrationNo,pathologyCenterImg,pathologyCenterImgDetails,YrofEstablishment,emergencyServiceNoAvailable,emergencyServiceNo,ambulenceNoAvailable,ambulenceNo,tieupWithSpecializedLabs,tieupWithLabs,sampleCollectionAtHome,sampleCollection,featured_value,status as statusPathologyDetails,did,createDt,modifyDt FROM ".TABLE_PATHOLOGY_DETAILS." ".$condition; //Edited By Samannoy
			$PathologyDetails=$globalUtil->sqlFetchRowsAssoc($sql,2);
			/*echo "<pre>";print_r($PathologyDetails);echo "</pre>";die();*/
			
			if($PathologyDetails['numrows']>0){
				for($i=0;$i<$PathologyDetails['numrows'];$i++){
					if($PathologyDetails['data'][$i]['pid']!=''){
						if($this->checkPathologyIsUser($globalUtil,$PathologyDetails['data'][$i]['pid'])){
						   $PathologyPrimaryInfo=$globalUtil->userDetails($globalUtil,$PathologyDetails['data'][$i]['pid']);
						   if($PathologyPrimaryInfo['num']>0){
							   $PathologyDetails['data'][$i]=array_merge($PathologyDetails['data'][$i],$PathologyPrimaryInfo['data'][0]);
							   }
						}	
					}
/*					$PathologyType=$this->getPathologyType($globalUtil,"WHERE id='".$PathologyDetails['data'][$i]['htid']."' AND status='1'");
					//echo "<pre>";print_r($PathologyType);echo "<pre>";die();
					if($PathologyType){
					$PathologyDetails['data'][$i]['htidName']=$PathologyType[0]['typeName'];
					}
					else{
					$PathologyDetails['data'][$i]['htidName']='';
					} //Commented By Samannoy*/
					
/*					$PathologyCategory=$this->getPathologyCategory($globalUtil,"WHERE id='".$PathologyDetails['data'][$i]['hcid']."' AND status='1'");
					if($PathologyCategory){
					$PathologyDetails['data'][$i]['hcidName']=$PathologyCategory[0]['categoryName'];
					}
					else{
					$PathologyDetails['data'][$i]['hcidName']='';
					} //Commented By Samannoy*/
					
					$PathologyAccred=$this->getPathologyAccreditation($globalUtil,"WHERE id='".$PathologyDetails['data'][$i]['haid']."' AND status='1'");
					if($PathologyAccred){
					$PathologyDetails['data'][$i]['haidName']=$PathologyAccred[0]['accreditationName'];
					}
					else{
					$PathologyDetails['data'][$i]['haidName']='';
					}
					
					$PathologyDetails['data'][$i]['hfid']=$globalUtil->stringToArr(',',$PathologyDetails['data'][$i]['hfid']);
					//$PathologyDetails['data'][$i]['hdid']=$globalUtil->stringToArr(',',$PathologyDetails['data'][$i]['hdid']);		//Commented by Samannoy		
					
										
					
					
			    //echo "<pre>";print_r($PathologyDetails);echo "</pre>";die();		
				//echo "<pre>";print_r($PathologyDetails);echo "</pre>";die();
				}
			}
			return $PathologyDetails;
		}
	public function checkPathologyIsUser($globalUtil,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT u.id FROM ".TABLE_USERS." u INNER JOIN ".TABLE_USERS_TYPE." ut ON u.tid=ut.id WHERE id='".$id."' AND ut.u.id='3'",2);
		if($checkifExists==1){
				return true;
			}
		else{
				return false;
			}	
		}
	public function getPathologyFeatured($globalUtil,$condition=""){
		$sql="SELECT pathologyCenterImg FROM ".TABLE_PATHOLOGY_DETAILS." ".$condition;
		$specFeatured=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $specFeatured;
		}
	public function getPathologyMostViewed($globalUtil,$condition=""){
		$sql="SELECT pathologyCenterImg,viewedcount,pathologycenterName,id  FROM ".TABLE_PATHOLOGY_DETAILS." ".$condition;
		$specViewed=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $specViewed;
		}
	public function validatePathologyDetails($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['pathologycenterName']==''){
			$error=true;
			$errormsg .= "Please enter Pathology Center Name<br/>";
			}
		if($data['address']==''){
			$error=true;
			$errormsg .= "Please enter Pathology address<br/>";
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
		
	public function getPathologyType($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,typeName FROM ".TABLE_Pathology_TYPE." ".$condition;
		//echo $sql;die();
		$PathologyTypes=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($PathologyTypes['numrows']>0){
			return $PathologyTypes['data'];
			}
		else{
			return false;
			}	
		}
	public function getPathologyCategory($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,categoryName FROM ".TABLE_Pathology_CATEGORY." ".$condition;
		$PathologyCategory=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($PathologyCategory['numrows']>0){
			return $PathologyCategory['data'];
			}
		else{
			return false;
			}	
		}
	public function getPathologyAccreditation($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,accreditationName FROM ".TABLE_HOSPITAL_ACCREDITATION." ".$condition;
		$PathologyAccred=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($PathologyAccred['numrows']>0){
			return $PathologyAccred['data'];
			}
		else{
			return false;
			}	
		}
	public function getPathologyFacilities($globalUtil,$condition="WHERE status='1'"){
		//echo $fidarr;
		$sql="SELECT id,facilityName FROM ".TABLE_PATHOLOGY_FACILITIES." ".$condition;	
		$PathologyFacilities=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($PathologyFacilities['numrows']>0){
			return $PathologyFacilities['data'];
			}
		else{
			return false;
			}
	}
	public function getPathologyDisciplines($globalUtil,$condition="WHERE status='1'"){
		//echo $didarr;
		$sql="SELECT id,disciplineName FROM ".TABLE_Pathology_DISCIPLINE." ".$condition;	
		$PathologyDisciplines=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($PathologyDisciplines['numrows']>0){
			return $PathologyDisciplines['data'];
			}
		else{
			return false;
			}
	}
	public function getPathologyTypeOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getPathologyType($globalUtil,$condition);
		//echo "<pre>";print_r($list);echo "</pre>";die();
		for($i=0;$i<count($list);$i++){
		$optionsParms[$i]['value']=$list[$i]['id'];
		$optionsParms[$i]['label']=$list[$i]['typeName'];
		}
		//print_r($optionsParms);die();
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Type-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}	
	public function getPathologyCategoryOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getPathologyCategory($globalUtil,$condition);
		//echo "<pre>";print_r($list);echo "</pre>";die();
		for($i=0;$i<count($list);$i++){
		$optionsParms[$i]['value']=$list[$i]['id'];
		$optionsParms[$i]['label']=$list[$i]['categoryName'];
		}
		//print_r($optionsParms);die();
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Category-')),$optionsParms);
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
	
	public function getDisciplinesOptions($globalUtil,$type,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getPathologyDisciplines($globalUtil,$condition);
		//echo "<pre>";print_r($list);echo "</pre>";
		for($i=0;$i<count($list);$i++){
		$optionsParms[$i]['value']=$list[$i]['id'];
		$optionsParms[$i]['label']=$list[$i]['disciplineName'];
		}
		//echo "<pre>";print_r($selectParms);print_r($optionsParms);print_r($optionselectedval);echo "</pre>";die();
		$html = '';
		if($type=='checkbox'){
			$html = $globalUtil->htmlCheckBoxes($selectParms,$optionsParms,$optionselectedval);
			}
		else{	
		$html = $globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		}
		return $html;
	}
	public function getOtherFacilitiesOptions($globalUtil,$type,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getPathologyFacilities($globalUtil,$condition);
		
		//echo "<pre>";print_r($list);echo "</pre>";
		for($i=0;$i<count($list);$i++){
		
		$optionsParms[$i]['value']=$list[$i]['id'];
		$optionsParms[$i]['label']=$list[$i]['facilityName'];
		
		}
		
		//echo "<pre>";print_r($selectParms);print_r($optionsParms);print_r($optionselectedval);echo "</pre>";die();
		$html = '';
		if($type=='checkbox'){
			$html = $globalUtil->htmlCheckBoxes($selectParms,$optionsParms,$optionselectedval);
			}
		else{	
		$html = $globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		}
		return $html;
	}	
	public function getPathologyAccreditationOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getPathologyAccreditation($globalUtil,$condition);
		//echo "<pre>";print_r($list);echo "</pre>";die();
		for($i=0;$i<count($list);$i++){
		$optionsParms[$i]['value']=$list[$i]['id'];
		$optionsParms[$i]['label']=$list[$i]['accreditationName'];
		}
		//print_r($optionsParms);die();
		
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Accreditation-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
	public function pathologyPublicUrl($Parameters){
		$url = MAIN_SITE_URL."Pathology/";
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
		// Add For Pathology Details Starts
		public function insertPathologyDetails($globalUtil,$data){
			$data_pathology_details=$data;
			if($globalUtil->sqlinsert($data_pathology_details,TABLE_PATHOLOGY_DETAILS)){
					return true;
			}
			else{
			return false;
			}
		}
		// Add  For Pathology Details End
		
		// Update  For Pathology Details Starts
		public function updatePathologyDetails($globalUtil,$data){

			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_PATHOLOGY_DETAILS)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
		// Update  For Pathology Details End
		
		
		// Image Upload Starts
		public function uploadPathologyImage($globalUtil,$uploadfile,$newFileName,$prevImgName='',$removeImg='N'){
		
		 $pathologyFolderPath=PROJECT_DOCUMENT_PATH.PATHOLOGY_CENTER_IMG_FOLDER;
		 $tempFileName=	$uploadfile['tmp_name'];
		 
		 $pathologyImageFolderSmall=$pathologyFolderPath."small/";
		 $pathologyImageFolderMedium=$pathologyFolderPath."medium/";
		 $pathologyImageFolderLarge=$pathologyFolderPath."large/";
		 //echo $docImageFolderSmall."<br />".$docImageFolderMedium."<br />".$docImageFolderLarge;//die();
		 //echo "<pre>";print_r($_FILES);echo "</pre>";die();	 
		 $return['pathologyCenterImg']=$prevImgName; 
		 //$return['doctorImgDetails']='';
		 
		 if($prevImgName!=''){
			if($removeImg=='Y'){
				 if(file_exists($pathologyImageFolderSmall.$prevImgName)){
				 unlink($pathologyImageFolderSmall.$prevImgName);
				 }
				 if(file_exists($pathologyImageFolderMedium.$prevImgName)){
				 unlink($pathologyImageFolderMedium.$prevImgName);
				 }
				 if(file_exists($pathologyImageFolderLarge.$prevImgName)){
				 unlink($pathologyImageFolderLarge.$prevImgName);
				 }
				 $return['pathologyCenterImg']=''; 
				 $return['pathologyCenterImgDetails']='';
			 }
				 
		}	
		 if(isset($uploadfile) && $uploadfile['name']!=''){
		 $oldFileName=$uploadfile['name'];
		 $fileExt=$globalUtil->getFileExtension($oldFileName);
		 
		 $newFileName=$newFileName."_".time().".".$fileExt;
		 $newFileDetails=$_FILES['pathologyCenterImg']['type'];
		 
		
		if(file_exists($pathologyImageFolderSmall.$prevImgName)){
		 	unlink($pathologyImageFolderSmall.$prevImgName);
		 }
		
		 if(file_exists($pathologyImageFolderMedium.$prevImgName)){
			unlink($pathologyImageFolderMedium.$prevImgName);
		 }
		 if(file_exists($pathologyImageFolderLarge.$prevImgName)){
		 	unlink($pathologyImageFolderLarge.$prevImgName);
		 }
		 
		 if(move_uploaded_file($tempFileName,$pathologyImageFolderLarge.$newFileName)){
			 //Resize image (options: exact, portrait, landscape, auto, crop)
			 $imgResizeObj = new ImageResizer($pathologyImageFolderLarge.$newFileName);
			 $imgResizeObj -> resizeImage($resizeObj->width, $resizeObj->height, 'exact');
			 $imgResizeObj -> saveImage($pathologyImageFolderLarge.$newFileName, 100);
			 
			 $imgResizeObj -> resizeImage(400, 271, 'exact');
			 $imgResizeObj -> saveImage($pathologyImageFolderMedium.$newFileName, 100);
			 
			 $imgResizeObj -> resizeImage(165, 100, 'portrait');
			 $imgResizeObj -> saveImage($pathologyImageFolderSmall.$newFileName, 100);
			 $imgResizeObj->destroyImage();
			 
			 $return['pathologyCenterImg']=$newFileName;
			 $return['pathologyCenterImgDetails']=$newFileDetails;
		 }
	   }
	   return $return;
	}	
	    // Image Upload Ends
		
		// Add For Pathology Center Information  Starts
		public function insertPathologyInfo($globalUtil,$data){
			
			$data_pathology_tests_details=$data;
			if($globalUtil->sqlinsert($data_pathology_tests_details,TABLE_PATHOLOGY_TESTS)){
					return true;
			}
			else{
			return false;
			}
		}
		// Add For Pathology Center Information  End
		
		//Select For Pathology Center Information  Starts
		public function getPathologyInfo($globalUtil,$condition){
		$sql = "SELECT id,pid,testTypeId,testNameId,testPrice,additionalInfo FROM ".TABLE_PATHOLOGY_TESTS." ".$condition;
		$pathologyInfoDetails = $globalUtil->sqlFetchRowsAssoc($sql,2);	
		return $pathologyInfoDetails;
		}		
		//Select For Pathology Center Information  End
		
		//Delete For Pathology Center Information  Starts
		public function deletePathologyInfo($globalUtil,$adminUtil,$id,$pid){
		if($pid=='')
		{
		$delete=$globalUtil->sqldelete(TABLE_PATHOLOGY_TESTS,"WHERE testNameId='".$id."'");
		}
		else if($pid!='')
		{
		$delete=$globalUtil->sqldelete(TABLE_PATHOLOGY_TESTS,"WHERE id='".$id."' AND pid='".$pid."'");
		}
		return $delete;
		//return $delete;
		}
		//Delete For Pathology Center Information  End
		
			// Add For Health Package Information  Starts
		public function insertHealthInfo($globalUtil,$data){
			
			$data_health_package_details=$data;
			if($globalUtil->sqlinsert($data_health_package_details,TABLE_PATHOLOGY_HEALTH_PACKAGE)){
					return true;
			}
			else{
			return false;
			}
		}
		// Add For Health Package Information  End
		
		//Select For Health Package Information  Starts
		public function getHealthInfo($globalUtil,$condition){
		$sql = "SELECT id,pid,packageName,packagePrice,details FROM ".TABLE_PATHOLOGY_HEALTH_PACKAGE." ".$condition;
		$healthInfoDetails = $globalUtil->sqlFetchRowsAssoc($sql,2);	
		return $healthInfoDetails;
		}		
		//Select For Health Package Information  End
		
		//Delete For Health Package Information  Starts
		public function deleteHealthInfo($globalUtil,$adminUtil,$id,$pid){
		$delete=$globalUtil->sqldelete(TABLE_PATHOLOGY_HEALTH_PACKAGE,"WHERE id='".$id."' AND pid='".$pid."'");
		return $delete;
		//return $delete;
		}
		//Delete For Health Package Information  End
		
		// Add For Contact Person  Starts
		public function insertContactInfo($globalUtil,$data){
			
			$data_contact_person_details=$data;
			if($globalUtil->sqlinsert($data_contact_person_details,TABLE_PATHOLOGY_CONTACT_PERSON)){
					return true;
			}
			else{
			return false;
			}
		}
		// Add For Contact Person  End
		
		// Select For Contact Person  Start
		public function getContactInfo($globalUtil,$condition){
		$sql = "SELECT id,pid,name,designation,email,contactno FROM ".TABLE_PATHOLOGY_CONTACT_PERSON." ".$condition;
		$contactInfoDetails = $globalUtil->sqlFetchRowsAssoc($sql,2);	
		return $contactInfoDetails;
		}		
		//Select For Contact Person  End
		
		//Delete For Contact Person  Starts
		public function deleteContactInfo($globalUtil,$adminUtil,$id,$pid){
		$delete=$globalUtil->sqldelete(TABLE_PATHOLOGY_CONTACT_PERSON,"WHERE id='".$id."' AND pid='".$pid."'");
		return $delete;
		//return $delete;
		}
		//Delete For Contact Person  End
		
		/*public function getPathologyFacilities(){
		$pathalogyFacilities=array(0=>'Any Collection Center',1=>'Portable X-Ray',2=>'Portable ECG',3=>'Portable USG',4=>'Discount / Membership Card Facility',5=>'Online Facility To Book Test',6=>'Home Delivery of Report',7=>'Reports sent via email');
		return $pathalogyFacilities;
		}*/
		// For validating info regarding pathology unit test types	start	
		function validatePathologyInfo($globalUtil,$data){
				$error=false;
				$errormsg="";
				
			if($data['testTypeId']==''){
				$error=true;
				$errormsg .= "Please select Test Type<br/>";
				}	
			if($data['testNameId']==''){
				$error=true;
				$errormsg .= "Please select Test Name<br/>";
				}	
			$return=array("errors"=>$error,"errormsgs"=>$errormsg);
				return $return;	
				}
		// For validating info regarding pathology unit test types	end	
		
		// For validating info regarding health package	starts
		function validateHealthPackageInfo($globalUtil,$data){
				$error=false;
				$errormsg="";
				
			if($data['packageName']==''){
				$error=true;
				$errormsg .= "Please enter Package Name<br/>";
				}	
			if($data['packagePrice']==''){
				$error=true;
				$errormsg .= "Please enter Package Price<br/>";
				}	
				$return=array("errors"=>$error,"errormsgs"=>$errormsg);
				return $return;	
				}
		// For validating info regarding pathology unit test types	end	
		
		// For validating info regarding contact person	starts	
		function validateContactPersonInfo($globalUtil,$data){
				$error=false;
				$errormsg="";
				
			if($data['name']==''){
				$error=true;
				$errormsg .= "Please enter Name<br/>";
				}	
			if($data['designation']==''){
				$error=true;
				$errormsg .= "Please enter Designation<br/>";
				}
			if($data['email']==''){
				$error=true;
				$errormsg .= "Please enter Email<br/>";
				}
			if($data['contactno']==''){
				$error=true;
				$errormsg .= "Please enter Contact No<br/>";
				}	
				$return=array("errors"=>$error,"errormsgs"=>$errormsg);
				return $return;	
				}
		// For validating info regarding contact person	starts	end
		
							 
}


?>