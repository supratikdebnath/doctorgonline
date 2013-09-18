<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################

error_reporting(E_ERROR); //0 OR E_ALL OR E_ERROR | E_WARNING | E_PARSE
ini_set('date.timezone', 'Asia/Calcutta');
define("DB_USERNAME","thinkdmn_dgodev");
define("DB_PASSWORD","Nych]4#(ULMq");
define("DB_HOSTNAME","localhost");
define("DB_NAME","thinkdmn_doctorgonline_dev");
define("SITE_URL","doctorgonline.com");
define("REWRITE_URL",true); // If true url pattern without extension.
define("URL_SECURED",false); // If true https else http
if(URL_SECURED){
	define("URL_PREFIX","https://");
}
else{
	define("URL_PREFIX","http://");
}
define('SITE_TITLE','Doctor G Online - One stop place to search your medical emergency needs');	


?>