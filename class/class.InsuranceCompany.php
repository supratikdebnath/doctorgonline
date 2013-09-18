<?php
#############################
#By Subhro Ray		        #
#Date : 20032013			#
#www.samannoychatterjee.net #
#############################
class InsuranceCompany{
	public function insertInsuranceCompany($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_INSURANCE_COMPANY)){
			return true;
			}
			else{
			return false;
			}
		}
	public function insertHospitalInsuranceCompany($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_HOSPITAL_INSURANCE)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updateInsuranceCompany($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_INSURANCE_COMPANY)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteInsuranceCompany($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_INSURANCE_COMPANY,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_INSURANCE_COMPANY." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_INSURANCE_COMPANY)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getInsuranceCompany($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_INSURANCE_COMPANY." ".$condition." ORDER BY insurance_company  ASC";
		$insuranceCompanyList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $insuranceCompanyList;
		}
	public function getHospitalInsuranceCompany($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_HOSPITAL_INSURANCE." ".$condition." ORDER BY insurance_company  ASC";
		$insuranceCompanyList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $insuranceCompanyList;
		}
	public function deleteHospitalInsuranceCompany($globalUtil,$adminUtil,$id,$hid){
		$delete=$globalUtil->sqldelete(TABLE_HOSPITAL_INSURANCE,"WHERE id='".$id."' AND hid='".$hid."' AND flag=1 ");
		return $delete;
		}
	public function validateInsuranceCompany($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['insurance_company']==''){
			$error=true;
			$errormsg .= "Please enter Insurance Company<br/>";
			}
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_INSURANCE_COMPANY." WHERE id='".$id."'";
		$insuranceCompanyStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$insuranceCompanyStatus['data'][0]['status'];
		return $res;
		}
	public function getInsuranceCompanyType($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,insurance_company FROM ".TABLE_INSURANCE_COMPANY." ".$condition;
		//echo $sql;die();
		$insuranceCompanyTypes=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($insuranceCompanyTypes['numrows']>0){
			return $insuranceCompanyTypes['data'];
			}
		else{
			return false;
			}	
		}
	public function getInsuranceCompanyOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getInsuranceCompanyType($globalUtil,$condition);
		//echo "<pre>";print_r($list);echo "</pre>";die();
		for($i=0;$i<count($list);$i++){
		$optionsParms[$i]['value']=$list[$i]['insurance_company'];
		$optionsParms[$i]['label']=$list[$i]['insurance_company'];
		}
		//print_r($optionsParms);
	$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Insurance Company-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}	
	
}
?>
