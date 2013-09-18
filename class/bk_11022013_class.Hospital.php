<?php
#############################
#By Samannoy Chatterjee		#
#Date : 23122012			#
#Last Updated: 28122012		#
#www.samannoychatterjee.net #
#############################
class Hospital{
	public function insertHospital($globalUtil,$data){
			
			$data_doctor_details=$data;
			if($globalUtil->sqlinsert($data_doctor_details,TABLE_USER_HOSPITAL)){
				//$data_qualification=array();
				//$globalUtil->sqlinsert($data_qualification,TABLE_USER_HOSPITAL_QUALIFICATIONS);
				/*Clinic Data Insert Starts*/
				//$data_clinic=array();
				//$globalUtil->sqlinsert($data_clinic,TABLE_USER_HOSPITAL_CLINICS);
				/*Clinic Data Inserts Ends*/
				
				/*Clinic Timings Data Insert Starts*/
				//$data_clinic_timings=array();				
				//$globalUtil->sqlinsert($data_clinic_timings,TABLE_USER_HOSPITAL_CLINICS_TIMINGS);
				/*Clinic Timings Data Insert Ends*/
					return true;
			}
			else{
			return false;
			}
		}
	public function updateHospital($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_USER_HOSPITAL)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteHospital($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_USER_HOSPITAL,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_USER_HOSPITAL." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_USER_HOSPITAL)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_USER_HOSPITAL." WHERE id='".$id."'";
		$stateStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$stateStatus['data'][0]['status'];
		return $res;
		}
	public function getHospital($globalUtil,$condition){
			$sql="SELECT id as hospitalDetailsid, hid,hospitalName,address,cid,sid,zid,aid,pincode,emailAlternate,website,phoneNo,phoneNoAlternate,fax,creditCardAccept,available24Hrs,about,registrationNo,hospitalImg,hospitalImgDetails,medicoLegalCases,noOfBeds,authorizedBy,htid,hcid,haid,hfid,hdid,YrofEstablishment,otherFacility,oPDContactNoAvailable,oPDContactNo,bloodBankNoAvailable,bloodBankNo,emergencyServiceNoAvailable,emergencyServiceNo,eyeBankNoAvailable,eyeBankNo,organBankNoAvailable,organBankNo,ambulenceNoAvailable,ambulenceNo,healthInsurenceTieUpsNoAvailable,healthInsurenceTieUpsNo,guestHouseNoAvailable,guestHouseNo,status as statusHospitalDetails,createDt,modifyDt FROM ".TABLE_USER_HOSPITAL." ".$condition;
			$HospitalDetails=$globalUtil->sqlFetchRowsAssoc($sql,2);
			//echo "<pre>";print_r($HospitalDetails);echo "</pre>";die();
			
			if($HospitalDetails['numrows']>0){
				for($i=0;$i<$HospitalDetails['numrows'];$i++){
					if($HospitalDetails['data'][$i]['hid']!=''){
						if($this->checkHospitalIsUser($globalUtil,$HospitalDetails['data'][$i]['hid'])){
						   $hospitalPrimaryInfo=$globalUtil->userDetails($globalUtil,$HospitalDetails['data'][$i]['hid']);
						   if($hospitalPrimaryInfo['num']>0){
							   $HospitalDetails['data'][$i]=array_merge($HospitalDetails['data'][$i],$hospitalPrimaryInfo['data'][0]);
							   }
						}	
					}
					$hospitalType=$this->getHospitalType($globalUtil,"WHERE id='".$HospitalDetails['data'][$i]['htid']."' AND status='1'");
					//echo "<pre>";print_r($hospitalType);echo "<pre>";die();
					if($hospitalType){
					$HospitalDetails['data'][$i]['htidName']=$hospitalType[0]['typeName'];
					}
					else{
					$HospitalDetails['data'][$i]['htidName']='';
					}
					
					$hospitalCategory=$this->getHospitalCategory($globalUtil,"WHERE id='".$HospitalDetails['data'][$i]['hcid']."' AND status='1'");
					if($hospitalCategory){
					$HospitalDetails['data'][$i]['hcidName']=$hospitalCategory[0]['categoryName'];
					}
					else{
					$HospitalDetails['data'][$i]['hcidName']='';
					}
					
					$hospitalAccred=$this->getHospitalAccreditation($globalUtil,"WHERE id='".$HospitalDetails['data'][$i]['haid']."' AND status='1'");
					if($hospitalAccred){
					$HospitalDetails['data'][$i]['haidName']=$hospitalAccred[0]['accreditationName'];
					}
					else{
					$HospitalDetails['data'][$i]['haidName']='';
					}
					
					$HospitalDetails['data'][$i]['hfid']=$globalUtil->stringToArr(',',$HospitalDetails['data'][$i]['hfid']);
					$HospitalDetails['data'][$i]['hdid']=$globalUtil->stringToArr(',',$HospitalDetails['data'][$i]['hdid']);				
					
										
					
					
			    //echo "<pre>";print_r($HospitalDetails);echo "</pre>";die();		
				//echo "<pre>";print_r($HospitalDetails);echo "</pre>";die();
				}
			}
			return $HospitalDetails;
		}
	public function checkHospitalIsUser($globalUtil,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT u.id FROM ".TABLE_USERS." u INNER JOIN ".TABLE_USERS_TYPE." ut ON u.tid=ut.id WHERE id='".$id."' AND ut.u.id='3'",2);
		if($checkifExists==1){
				return true;
			}
		else{
				return false;
			}	
		}	
	public function validateHospital($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['hospitalName']==''){
			$error=true;
			$errormsg .= "Please enter hospital name<br/>";
			}
		if($data['address']==''){
			$error=true;
			$errormsg .= "Please enter hospital address<br/>";
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
		
	public function getHospitalType($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,typeName FROM ".TABLE_HOSPITAL_TYPE." ".$condition;
		//echo $sql;die();
		$HospitalTypes=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($HospitalTypes['numrows']>0){
			return $HospitalTypes['data'];
			}
		else{
			return false;
			}	
		}
	public function getHospitalCategory($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,categoryName FROM ".TABLE_HOSPITAL_CATEGORY." ".$condition;
		$HospitalCategory=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($HospitalCategory['numrows']>0){
			return $HospitalCategory['data'];
			}
		else{
			return false;
			}	
		}
	public function getHospitalAccreditation($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,accreditationName FROM ".TABLE_HOSPITAL_ACCREDITATION." ".$condition;
		$HospitalAccred=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($HospitalAccred['numrows']>0){
			return $HospitalAccred['data'];
			}
		else{
			return false;
			}	
		}
	public function getHospitalFacilities($globalUtil,$condition="WHERE status='1'"){
		//echo $fidarr;
		$sql="SELECT id,facilityName FROM ".TABLE_HOSPITAL_FACILITIES." ".$condition;	
		$HospitalFacilities=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($HospitalFacilities['numrows']>0){
			return $HospitalFacilities['data'];
			}
		else{
			return false;
			}
	}
	public function getHospitalDisciplines($globalUtil,$condition="WHERE status='1'"){
		//echo $didarr;
		$sql="SELECT id,disciplineName FROM ".TABLE_HOSPITAL_DISCIPLINE." ".$condition;	
		$HospitalDisciplines=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($HospitalDisciplines['numrows']>0){
			return $HospitalDisciplines['data'];
			}
		else{
			return false;
			}
	}
	public function getHospitalTypeOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getHospitalType($globalUtil,$condition);
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
	public function getHospitalCategoryOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getHospitalCategory($globalUtil,$condition);
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
		$list=$this->getHospitalDisciplines($globalUtil,$condition);
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
		$list=$this->getHospitalFacilities($globalUtil,$condition);
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
	public function getHospitalAccreditationOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getHospitalAccreditation($globalUtil,$condition);
		//echo "<pre>";print_r($list);echo "</pre>";die();
		for($i=0;$i<count($list);$i++){
		$optionsParms[$i]['value']=$list[$i]['id'];
		$optionsParms[$i]['label']=$list[$i]['accreditationName'];
		}
		//print_r($optionsParms);die();
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
	public function hospitalPublicUrl($Parameters){
		$url = MAIN_SITE_URL."Hospital/";
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
		// Added For Hospital Pathology Starts
		public function insertHospitalPathology($globalUtil,$data){
			$data_pathology_details=$data;
			if($globalUtil->sqlinsert($data_pathology_details,TABLE_HOSPITAL_PATHOLOGY)){
					return true;
			}
			else{
			return false;
			}
		}
		public function updateHospitalPathology($globalUtil,$data){

			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."' AND hid='".$data['hid']."'",TABLE_HOSPITAL_PATHOLOGY)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
		public function insertHospitalPathologyTest($globalUtil,$data){
			
			$data_pathology_details=$data;
			if($globalUtil->sqlinsert($data_pathology_details,TABLE_HOSPITAL_PATHOLOGY_TESTS)){
					return true;
			}
			else{
			return false;
			}
		}
		//Condition send WHERE hid, i.e Hospital ID returns array ['numrows'] ['data']
		public function getHospitalPathology($globalUtil,$condition){
		$sql = "SELECT id,hid,yearofEstablishment,contactNo,haid,openAllDays,closedOn,pfids,extraCharges,tieUpsLabs,reportsViaEmail,homeCollection FROM ".TABLE_HOSPITAL_PATHOLOGY." ".$condition;
		$HospitalPathologyDetails = $globalUtil->sqlFetchRowsAssoc($sql,2);	
		return $HospitalPathologyDetails;
		}
		
		//Condition send WHERE hid, i.e Hospital ID return array ['numrows'] ['data'].
		public function getHospitalPathologyTest($globalUtil,$condition){
		$sql = "SELECT id,hid,testType,testName,testPrice,additionalInfo FROM ".TABLE_HOSPITAL_PATHOLOGY_TESTS." ".$condition;
		$HospitalPathologyTestDetails = $globalUtil->sqlFetchRowsAssoc($sql,2);	
		return $HospitalPathologyTestDetails;
		}		
		
		public function deleteHospitalPathologyTest($globalUtil,$adminUtil,$id,$hid){
		$delete=$globalUtil->sqldelete(TABLE_HOSPITAL_PATHOLOGY_TESTS,"WHERE id='".$id."' AND hid='".$hid."'");
		return $delete;
		//return $delete;
		}
		
		public function getHospitalPathologyFacilities(){
		$pathalogyFacilities=array(0=>'Any Collection Center',1=>'Portable X-Ray',2=>'Portable ECG',3=>'Portable USG',4=>'Discount / Membership Card Facility',5=>'Online Facility To Book Test',6=>'Home Delivery of Report',7=>'Reports sent via email');
		return $pathalogyFacilities;
		}
		// Added For Hospital Pathology End								 
}
?>