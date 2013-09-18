<?php
#############################
#By Subhro Ray		        #
#Date : 07032013			#
#www.samannoychatterjee.net #
#############################
class PathologyTestName{
	public function insertPathologyTestName($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_PATHOLOGY_TEST_NAME)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updatePathologyTestName($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_PATHOLOGY_TEST_NAME)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deletePathologyTestName($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_PATHOLOGY_TEST_NAME,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_PATHOLOGY_TEST_NAME)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getPathologyTestName($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_PATHOLOGY_TEST_NAME." ".$condition." ORDER BY test_name  ASC";
		$PathologyTestNameList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $PathologyTestNameList;
		}
	public function validatePathologyTestName($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['test_name']==''){
			$error=true;
			$errormsg .= "Please enter Pathology Test Name<br/>";
			}
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id='".$id."'";
		$pathologyTestNameStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$pathologyTestNameStatus['data'][0]['status'];
		return $res;
		}
	public function getPathologyTestType($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_PATHOLOGY_TEST_TYPE." ".$condition." ORDER BY test_type DESC";
		$pathologyTestTypeList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $pathologyTestTypeList;
		}
	public function getPathologyTestTypeOptions($globalUtil,$selectParms,$optionselectedval=''){
		$pathologyTestTypeList=$this->getPathologyTestType($globalUtil,"WHERE status='1'");
		//print_r($countryList);
		for($i=0;$i<count($pathologyTestTypeList['data']);$i++){
		$optionsParms[$i]['value']=$pathologyTestTypeList['data'][$i]['id'];
		$optionsParms[$i]['label']=$pathologyTestTypeList['data'][$i]['test_type'];
		}
		
		//print_r($optionsParms);
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Pathology Test Type-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}														
}
?>
