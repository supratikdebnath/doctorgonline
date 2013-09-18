<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 28122012		#
#www.samannoychatterjee.net #
#############################
class GlobalUtil extends DatabaseConnection{
/*Connecting To Database Class*/
public function __contruct($hostname,$username,$password,$dbname){
	 parent::__contruct($hostname,$username,$password,$dbname);
	}
/*Validate The Email Address*/	
public static function checkMail($val){ 
	
	if(filter_var($val,FILTER_VALIDATE_EMAIL)){
		return true;
		}
	else{
		return false;
		}	
	}
/*To Check If Email has valid Domain*/
public static function verifyEmailDNS($email){
    // This will split the email into its front
    // and back (the domain) portions
    list($name, $domain) = split('@',$email);
    if(!checkdnsrr($domain,'MX')){
        // No MX record found
        return false;
    } else {
        // MX record found, return true
        return true;
    }
}
/*To Check If Email has valid Domain*/	
/*Redirect Url*/		
public static function redirectUrl($val){
		ob_start();
		header("Location:".$val);
		exit();
	}		
/*Force Session Destroy if any*/
public static function destroySessionNow(){
	if(isset($_SESSION)){
	foreach($_SESSION as $key)
		{
			if(isset($_SESSION[$key])){
			unset($_SESSION[$key]);
			}
		}	
	}
	session_destroy();
	}
/*Generate Url*/
public static function generateUrl($val){
	if(REWRITE_URL==true){
			$val=str_replace(".php","/",$val);
			return $val;
		}
	else
		{	
			return $val;
		}
	}
/*Generate Url*/

/*Loading Page*/
public static function loadingPage(){
	//$html = '<table align="center" width="100%" cellpadding="0" cellspacing="0"><tr><td align="center"><img src="'.ADMIN_IMAGES_URL.'wait.gif"></td></tr></table>';
	//return $html;
	}
/*Loading Page*/	

/*Please Wait*/
public static function pleaseWait($val){
	//return sleep($val);
	}
/*Please Wait*/

/*Get Date & Time*/
public static function dateFromTime($val,$format){
 $result=date($format,$val);
 return $result;
}

public static function getTimeFromDate($val){
	$val=strtotime($val);
}

public static function formatDate($val,$format){
	$result=date($format,strtotime($val));
	return $result;
	}
/*Get Date & Time*/
/*To Print an Array in Page*/
public static function printArray($val){
	echo "<pre>";
	print_r($val);
	echo "</pre>";	
	die();
}
/*To Print an Array in Page*/
/*To Print a value in page*/
public static function printValue($val){
	echo "<b>".$val."</b><br/>";
	die();
}
/*To Print a value in page*/
public static function htmlSelectTag($selectParms,$optionsParms,$optionselectedval=''){
	$html = '';
	$html .= '<select ';
	foreach($selectParms as $attr=>$val){
	$html .= $attr.'="'.$val.'" ';
	}
	$html .='>';
	
	$html .= self::htmlOptions($optionsParms,$optionselectedval); 
	$html .='</select>';
	return $html;
}
public static function htmlOptions($optionsParms,$selectedval=''){
	$html = '';
	foreach($optionsParms as $optionvals){	
	$html .= '<option ';
	$html .= 'value="'.$optionvals['value'].'"';
	if($optionvals['value']==$selectedval){
	$html .= ' selected="selected"';	
		}
	$html .= '>';
	$html .= $optionvals['label'];
	$html .= '</option>';
	}
	return $html;
}
/*Generate Password*/
public static function encryptAccountPassword($val){
	$pass=md5($val);
	return $pass;
	}
/*Generate Password*/

/*Get Status Message*/
public static function getStatusMessage($val){ // 0 or 1
	$active="Active";
	$inActive="In-Active";
	$unDefined="Undefined";
	if($val==0){
		return $inActive;
		}
	if($val==1){
		return $active;
		}		
	else{
		return $unDefined;
		}
	}
/*Get Status Message*/
/*Base64Encode & Decode*/
public static function base64encode($val){
$result=base64_encode($val);
return $result;
}

public static function base64decode($val){
$result=base64_decode($val);
return $result;
}
/*Base64Encode & Decode*/

/*Get Current Url*/
public static function currentUrl(){
$result="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
return $result; 
}
/*Get Current Url*/
/*Get Http Referer Page*/
public static function getHttpRefererPage(){
$result=$_SERVER['HTTP_REFERER'];
return $result;
}
/*Get Http Referer Page*/

/*Read Folder and Files from a directory*/
public static function getFolderFilesFromDir($directory) 
  {
	if(is_dir($directory)){
		$handle=opendir($directory);
		$i=0;
		while($readDir=readdir($handle)){
			if($readDir!='.' && $readDir!='..'){
				if(is_dir($directory.$readDir)){
					//echo $readDir." is a directory"."<br />";
					$result['dir'][$i][]=$readDir;
					$result['dir'][$i][]=self::getFolderFilesFromDir($directory.$readDir."/");
				}
				else 
				{
					//echo $readDir." is a file"."<br />";
					$result['file'][$i][]=$readDir;
				}
			$i++;	
			}
			
		}
	}
	//self::printArray($result);
    return $result;
  }
/*Read Folder and Files from a directory*/
/*get User Information Starts*/
public function userDetails($id){
	$sql="SELECT id,email,status,tid,createDt,modifyDt FROM ".TABLE_USERS." WHERE id='".$id."'";
	$data=$globalUtil->sqlFetchRowsAssoc($sql,2);
  	return $data;
  }	
/*get User Information Ends*/

/*Convert String To Array Starts*/
public static function stringtoArr($separator,$string){
	//echo $separator," / ".$string; die();
	$stringToArray=explode($separator,$string);
	return $stringToArray;
  }
/*Convert String To Array Ends*/

/*Convert Array To String Starts*/
public static function arrToString($separator,$arr){
	$arrToString=implode($separator,$arr);
	return $arrToString;
  }
/*Convert Array To String Ends*/

/*Get HTML Check Boxes */
public static function htmlCheckBoxes($params,$dataArr,$selectArr){
	//echo "<pre>";print_r($selectArr);echo "<pre>";die();
	$html = '';
	if(is_array($dataArr)){
		$id=0;
		$cnt=0;
		$html = "<table border='0' width='100%'><tr>";
		foreach($dataArr as $labelCheckbox){	
		$cnt++;
		$html .= '<td valign="top"><input type="checkbox"';
		if(count($params)>0){
		foreach($params as $label=>$val){
			    if($label=='id'){
					$val=$val.$id;
					}
				$html .= $label.'="'.$val.'"';
			}
		}
		$html .='value="'.$labelCheckbox['value'].'"';
		if(is_array($selectArr)){
			//print $labelCheckbox['value'];
			for($i=0;$i<count($selectArr);$i++){
			if($selectArr[$i]==$labelCheckbox['value']){
				$html .= 'checked="checked"';
				}
			}
		}
			
		$html .= '/>'.$labelCheckbox['label'].'</td>';
		$id++;
		if($cnt%3==0){
				$html .= "</tr><tr>";
			}
	   }
	   $html .= "</tr></table>";
	}
	return $html;
	}
/*Get HTML Check Boxes*/

/*Get File Extension*/
public function getFileExtension($filename){
	 $splitfilename=explode('.',$filename);
	 $noOfArr=count($splitfilename);
	 $extension=$splitfilename[$noOfArr-1];
	 return $extension;
	}
/*Get File Extension*/

/*Set/Unset Get Form Data */
public function setGetUrlData($val){
	foreach($val as $keys=>$values){
		$_SESSION['getData'][$keys]=$values;
		}
	}
public function unsetGetUrlDataAll(){
	if(isset($_SESSION['getData'])){
		foreach($_SESSION['getData'] as $keys=>$values){
		unset($_SESSION['getData'][$keys]);
		}
	  }
	}
public function unsetGetUrlData($key){
	if(isset($_SESSION['getData'][$key])){
		unset($_SESSION['getData'][$key]);
	  }
	}	
public function getGetUrlData($key){
	$val="";
	if(isset($_SESSION['getData'][$key])){
	$val=$_SESSION['getData'][$key];
	$this->unsetGetUrlData($key);
	return $val;
	}
	else{
		return $val;
		}
	}		
/*Set/Unset Post Form Data */

/*function to check if defined starts*/
public function checkDefined($val){
	if(isset($val) && !empty($val)){
		return $val;
		}
	else{
		return '';
		}	
	}
/*Function to check if defined ends*/	

/*Removing Line Break In HTML Content*/
public function removeLineBreakHTML($html){
	$output = str_replace(array("\r\n", "\r"), "\n", $html);
	$lines = explode("\n", $output);
	$new_lines = array();
	
	foreach ($lines as $i => $line) {
		if(!empty($line))
			$new_lines[] = trim($line);
	}
	return implode($new_lines);	
	}
/*Removing Line Break In HTML Content*/
}
?>