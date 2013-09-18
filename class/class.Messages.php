<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class Messages{

 var $sessionName="SESSION__MESSAGE";
 var $messageClass;
 var $message;
 var $finalMessage;
 var $messageName;
 
 public function setMessage($name,$msg,$class="success"){ // success, error or user defined.
 $this->messageName=$name;
 $this->message=$msg; 
 $this->messageClass=$class;
 }
 
 public function saveMessage(){ // Save Message for showing in another page
 	$_SESSION[$this->sessionName][$this->messageName]['msg']=$this->message;
	$_SESSION[$this->sessionName][$this->messageName]['class']=$this->messageClass;
 }
 
 public function getMessageClass(){ // Get Message class
 	if($this->messageClass=="success"){
	   $styleClass="msgsuccess";
	}
	else if($this->messageClass=="error"){
	   $styleClass="msgerror";
	}
	else
	{
	   $styleClass=$this->messageClass;
	}
	return $styleClass;
	
 }
 
 public function displayMsg($name){ // Display Message .
 if($this->hasMsg($name))
 	{
		$this->finalMessage=$_SESSION[$this->sessionName][$name]['msg'];
		$this->messageClass=$_SESSION[$this->sessionName][$name]['class'];
		unset($_SESSION[$this->sessionName][$name]);
	}
 else
 	{
		$this->finalMessage=$this->message;
	} 	
 $output='<span class="'.$this->getMessageClass().'">'.$this->finalMessage.'</span>';
 return $output;
 }

 public function hasMsg($name){ // Check if message present
    if (!isset($_SESSION[$this->sessionName][$name]))
    {
      return false;
    }
    return true;
  } 
 
}
?>