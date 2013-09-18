<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class State{
	public function insertState($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_STATES)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updateState($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_STATES)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteState($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_STATES,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_STATES." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_STATES)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getStates($globalUtil,$condition=""){
		$sql="SELECT state.id as id,state.cid as cid,state.stateName as stateName,country.countryName as countryName,state.status as status,state.createDt as createDt,state.modifyDt as modifyDt FROM ".TABLE_STATES." state LEFT JOIN ".TABLE_COUNTRIES." country ON state.cid=country.id"." ".$condition." ORDER BY state.stateName ASC";
		$stateList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $stateList;
		}
	public function validateState($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['stateName']==''){
			$error=true;
			$errormsg .= "Please enter state name<br/>";
			}
		if($data['cid']==''){
			$error=true;
			$errormsg .= "Please select country<br/>";
			}	
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_STATES." WHERE id='".$id."'";
		$stateStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$stateStatus['data'][0]['status'];
		return $res;
		}
		
	public function getCountries($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_COUNTRIES." ".$condition." ORDER BY countryName DESC";
		$countryList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $countryList;
		}
	public function getCountryOptions($globalUtil,$selectParms,$optionselectedval=''){
		$countryList=$this->getCountries($globalUtil,"WHERE status='1'");
		//print_r($countryList);
		for($i=0;$i<count($countryList['data']);$i++){
		$optionsParms[$i]['value']=$countryList['data'][$i]['id'];
		$optionsParms[$i]['label']=$countryList['data'][$i]['countryName'];
		}
		
		//print_r($optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}								
}
?>