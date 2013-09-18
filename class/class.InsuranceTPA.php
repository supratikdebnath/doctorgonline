<?php
#############################
#By Subhro Ray		        #
#Date : 20032013			#
#www.samannoychatterjee.net #
#############################
class InsuranceTPA{
	public function insertInsuranceTPA($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_INSURANCE_TPA)){
			return true;
			}
			else{
			return false;
			}
		}
	public function insertHospitalInsuranceTPA($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_HOSPITAL_INSURANCE)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updateInsuranceTPA($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_INSURANCE_TPA)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteInsuranceTPA($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_INSURANCE_TPA,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_INSURANCE_TPA." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_INSURANCE_TPA)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getInsuranceTPA($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_INSURANCE_TPA." ".$condition." ORDER BY insurance_tpa  ASC";
		$InsuranceTPAList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $InsuranceTPAList;
		}
	public function getHospitalInsuranceTPA($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_HOSPITAL_INSURANCE." ".$condition." ORDER BY insurance_tpa  ASC";
		$insuranceCompanyList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $insuranceCompanyList;
		}
	public function deleteHospitalInsuranceTPA($globalUtil,$adminUtil,$id,$hid){
		$delete=$globalUtil->sqldelete(TABLE_HOSPITAL_INSURANCE,"WHERE id='".$id."' AND hid='".$hid."' AND flag=2 ");
		return $delete;
		}
	public function validateInsuranceTPA($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['insurance_tpa']==''){
			$error=true;
			$errormsg .= "Please enter Insurance TPA<br/>";
			}
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_INSURANCE_TPA." WHERE id='".$id."'";
		$insuranceTPAStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$insuranceTPAStatus['data'][0]['status'];
		return $res;
		}
	public function getInsuranceTPAType($globalUtil,$condition="WHERE status='1'"){
		$sql="SELECT id,insurance_tpa FROM ".TABLE_INSURANCE_TPA." ".$condition;
		//echo $sql;die();
		$insuranceTPATypes=$globalUtil->sqlFetchRowsAssoc($sql,2);
		if($insuranceTPATypes['numrows']>0){
			return $insuranceTPATypes['data'];
			}
		else{
			return false;
			}	
		}
	public function getInsuranceTPAOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$list=$this->getInsuranceTPAType($globalUtil,$condition);
		//echo "<pre>";print_r($list);echo "</pre>";die();
		for($i=0;$i<count($list);$i++){
		$optionsParms[$i]['value']=$list[$i]['insurance_tpa'];
		$optionsParms[$i]['label']=$list[$i]['insurance_tpa'];
		}
		//print_r($optionsParms);
	$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Insurance TPA-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}	
	
}
?>
