<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class Area{
	public function insertArea($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_AREAS)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updateArea($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_AREAS)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteArea($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_AREAS,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_AREAS." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_AREAS)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getAreas($globalUtil,$condition=""){
		$sql="SELECT area.id as id,area.zid as zid,area.sid as sid,state.cid as cid,area.areaName as areaName,state.stateName as stateName,country.countryName as countryName,zone.zoneName,area.status as status,area.createDt as createDt,area.modifyDt as modifyDt FROM ".TABLE_AREAS." area LEFT JOIN ".TABLE_ZONES." zone ON area.zid=zone.id LEFT JOIN ".TABLE_STATES." state on area.sid=state.id LEFT JOIN ".TABLE_COUNTRIES." country ON state.cid=country.id"." ".$condition." ORDER BY area.areaName,state.stateName ASC";
		
		//echo $sql ; die();
		$areaList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $areaList;
		}
	public function validateArea($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['areaName']==''){
			$error=true;
			$errormsg .= "Please enter area name<br/>";
			}
		/*if($data['cid']==''){
			$error=true;
			$errormsg .= "Please select country<br/>";
			}*/
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
		$sql="SELECT status FROM ".TABLE_AREAS." WHERE id='".$id."'";
		$stateStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$stateStatus['data'][0]['status'];
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
	public function getCity($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_CITY." ".$condition." ORDER BY cityName ASC";
		$cityList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $cityList;
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
		
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select State-')),$optionsParms);
		
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
		
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Zone-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
	public function getCityOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE status='1'";
		}
		$zoneList=$this->getCity($globalUtil,$condition);
		//print_r($countryList);
		for($i=0;$i<count($zoneList['data']);$i++){
		$optionsParms[$i]['value']=$zoneList['data'][$i]['id'];
		$optionsParms[$i]['label']=$zoneList['data'][$i]['cityName'];
		}
		
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select City-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
	public function getAreaOptions($globalUtil,$selectParms,$optionselectedval='',$condition=''){
	    if($condition!=''){
		$condition="WHERE area.status='1'";
		}
		$areaList=$this->getAreas($globalUtil,$condition);
		/*echo "<pre>";print_r($areaList);echo "</pre>";*/
		for($i=0;$i<count($areaList['data']);$i++){
		$optionsParms[$i]['value']=$areaList['data'][$i]['id'];
		$optionsParms[$i]['label']=$areaList['data'][$i]['areaName'];
		}
		
		$optionsParms=array_merge(array(array('value'=>'','label'=>'-Select Area-')),$optionsParms);
		
		$html_options=$globalUtil->htmlSelectTag($selectParms,$optionsParms,$optionselectedval);
		return $html_options;
	}
	
	public function getLocationNameFromId($globalUtil,$id='1',$type="COUNTRY"){
		   $name='';
		   if($type=="COUNTRY"){
			   $country=$this->getCountries($globalUtil,"WHERE id='".$id."'");
			   if($country['numrows']>0){
			   	$name=$country['data'][0]['countryName'];
			  	 }	 	
			   }
		   if($type=="STATE"){
			   $state=$this->getStates($globalUtil,"WHERE id='".$id."'");
			   //echo "<pre>";print_r($state);echo "</pre>";
			   if($state['numrows']>0){
			   	$name=$state['data'][0]['stateName'];
			  	 }
			   }
		   if($type=="CITY"){
			   $city=$this->getCity($globalUtil,"WHERE id='".$id."'");
			   if($city['numrows']>0){
			   	$name=$city['data'][0]['cityName'];
			  	 }
			   }
		   if($type=="ZONE"){
			   $zone=$this->getZones($globalUtil,"WHERE id='".$id."'");
			   if($zone['numrows']>0){
			   	$name=$zone['data'][0]['zoneName'];
			  	 }
			   }
		   if($type=="AREA"){
			  // echo $id." ".$type;die();
			   $area=$this->getAreas($globalUtil,"WHERE area.id='".$id."'");
			  // echo "<pre>";print_r($area);echo "</pre>";
			   if($area['numrows']>0){
			   	$name=$area['data'][0]['areaName'];
			   	 }
		   	   }
		   return $name;	   	   	   	   
			   
		}								
}
?>