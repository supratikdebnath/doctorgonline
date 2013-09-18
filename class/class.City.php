<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class City{
	public function insertCity($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_CITY)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updateCity($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_CITY)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteCity($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_CITY,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_CITY." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_CITY)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getCity($globalUtil,$condition=""){
		$sql="SELECT city.id as id,city.sid as sid,city.zid as zid,zone.zoneName,city.cityName as cityName,state.stateName as stateName,country.countryName as countryName,country.id as cid,city.status as status,city.createDt as createDt,city.modifyDt as modifyDt FROM ".TABLE_CITY." city LEFT JOIN ".TABLE_STATES." state ON city.sid=state.id LEFT JOIN ".TABLE_ZONES." zone ON city.zid=zone.id LEFT JOIN ".TABLE_COUNTRIES." country ON state.cid=country.id"." ".$condition." ORDER BY city.cityName ASC";
		$cityList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $cityList;
		}
	public function validateCity($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['cityName']==''){
			$error=true;
			$errormsg .= "Please enter state name<br/>";
			}
		if($data['sid']==''){
			$error=true;
			$errormsg .= "Please select state<br/>";
			}
		if($data['zid']==''){
			$error=true;
			$errormsg .= "Please select zone<br/>";
			}		
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_CITY." WHERE id='".$id."'";
		$cityStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$cityStatus['data'][0]['status'];
		return $res;
		}
		
	public function getCountries($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_COUNTRIES." ".$condition." ORDER BY countryName ASC";
		$countryList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $countryList;
		}
	public function getStates($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_STATES." ".$condition." ORDER BY stateName ASC";
		$stateList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $stateList;
		}
	public function getZones($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_ZONES." ".$condition." ORDER BY zoneName ASC";
		$zoneList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $zoneList;
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
	
	public function getStateOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$stateList=$this->getStates($globalUtil,$condition);
		//print_r($countryList);
		for($i=0;$i<count($stateList['data']);$i++){
		$optionsParms[$i]['value']=$stateList['data'][$i]['id'];
		$optionsParms[$i]['label']=$stateList['data'][$i]['stateName'];
		}
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
	
	
	public function getZoneOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$zoneList=$this->getZones($globalUtil,$condition);
		//print_r($countryList);
		for($i=0;$i<count($zoneList['data']);$i++){
		$optionsParms[$i]['value']=$zoneList['data'][$i]['id'];
		$optionsParms[$i]['label']=$zoneList['data'][$i]['zoneName'];
		}
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}									
}
?>