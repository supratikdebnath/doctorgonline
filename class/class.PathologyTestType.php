<?php
#############################
#By Subhro Ray		        #
#Date : 07032013			#
#www.samannoychatterjee.net #
#############################
class PathologyTestType{
	public function insertPathologyTestType($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_PATHOLOGY_TEST_TYPE)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updatePathologyTestType($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_PATHOLOGY_TEST_TYPE)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deletePathologyTestType($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_PATHOLOGY_TEST_TYPE,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_PATHOLOGY_TEST_TYPE)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getPathologyTestType($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_PATHOLOGY_TEST_TYPE." ".$condition." ORDER BY test_type  ASC";
		$PathologyTestTypeList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $PathologyTestTypeList;
		}
	public function validatePathologyTestType($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['test_type']==''){
			$error=true;
			$errormsg .= "Please enter Pathology Test Type<br/>";
			}
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id='".$id."'";
		$pathologyTestTypeStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$pathologyTestTypeStatus['data'][0]['status'];
		return $res;
		}						
}
?>
