<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class LatestNews{
	public function insertLatestNews($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_LATEST_NEWS)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updateLatestNews($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_LATEST_NEWS)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteLatestNews($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_LATEST_NEWS,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_LATEST_NEWS." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_LATEST_NEWS)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getLastestNews($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_LATEST_NEWS." ".$condition." ORDER BY modifyDt DESC";
		$latestNewsList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $latestNewsList;
		}
	public function validateLatestNews($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['topicName']==''){
			$error=true;
			$errormsg .= "Please enter topic name<br/>";
			}
		if($data['topicBody']==''){
			$error=true;
			$errormsg .= "Please enter topic body<br/>";
			}
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_LATEST_NEWS." WHERE id='".$id."'";
		$latestNewsStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$latestNewsStatus['data'][0]['status'];
		return $res;
		}						
}
?>