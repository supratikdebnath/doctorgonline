<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 29122012		#
#www.samannoychatterjee.net #
#############################
if(session_id()==""){
	session_start();
}
//define("DOCUMENT_ROOT_PATH","C:/xampp/htdocs");
//define("PROJECT_FOLDER","/doctorgonline/");
define("DOCUMENT_ROOT_PATH","/home/thinkdmn/public_html/doctorgonline.com");
define("PROJECT_FOLDER","/dev/app/doctorgonline/");
define("PROJECT_DOCUMENT_ROOT_PATH",DOCUMENT_ROOT_PATH.PROJECT_FOLDER);

define("CONFIG_FOLDER","config/");
define("CONTROLLER_FOLDER","controllers/");
define("CLASS_FOLDER","class/");
define("INCLUDE_FOLDER","includes/");
define("COMMON_FOLDER","common/");
define("CKEDITOR_FOLDER","ckeditor/");

define("JS_FOLDER","js/");
define("CSS_FOLDER","css/");
define("IMAGES_FOLDER","images/");

define("PROJECT_DOCUMENT_PATH",DOCUMENT_ROOT_PATH.PROJECT_FOLDER);
require(PROJECT_DOCUMENT_PATH.CONFIG_FOLDER."config.php");
define("ADMIN_FOLDER",PROJECT_FOLDER."admin/");
define("MAIN_SITE_URL",URL_PREFIX.SITE_URL.PROJECT_FOLDER);
define("ADMIN_SITE_URL",URL_PREFIX.SITE_URL.ADMIN_FOLDER);

define("ADMIN_DOCUMENT_PATH",DOCUMENT_ROOT_PATH.ADMIN_FOLDER);

require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER."filenames.php");
require(PROJECT_DOCUMENT_PATH.CONFIG_FOLDER."databaseTables.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER."constants.php");
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_DatabaseConnection);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_GlobalUtil);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_Messages);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminUtil);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_ImageResizer);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminLogin);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminLogout);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminChangePassword);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminChangeEmail);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminCreateUser);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminUserList);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminModifyUser);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_AdminUserSessionLog);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_LatestNews);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_Country);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_State);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_City);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_Area);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_Doctor);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_Hospital);
require(PROJECT_DOCUMENT_PATH.CLASS_FOLDER.CLASS_Pathology);

/*Front Ends CLASSES & CONTROLLERS & FILES PROJECT SPECIFIC*/

require(PROJECT_DOCUMENT_PATH.INCLUDE_FOLDER."filenames.php");


define("CSS_URL",MAIN_SITE_URL.CSS_FOLDER);
define("IMAGES_URL",MAIN_SITE_URL.IMAGES_FOLDER);
define("JS_URL",MAIN_SITE_URL.JS_FOLDER);
define("CKEDITOR_URL",MAIN_SITE_URL.CKEDITOR_FOLDER);
define("DOCTOR_IMG_FOLDER","secured/doctorProfileImages/");
define("DOCTOR_IMG_URL",MAIN_SITE_URL.DOCTOR_IMG_FOLDER);
define("HOSPITAL_IMG_FOLDER","secured/hospitalProfileImages/");
define("HOSPITAL_IMG_URL",MAIN_SITE_URL.HOSPITAL_IMG_FOLDER);
define("PATHOLOGY_CENTER_IMG_FOLDER","secured/pathologyProfileImages/");
define("PATHOLOGY_CENTER_IMG_URL",MAIN_SITE_URL.PATHOLOGY_CENTER_IMG_FOLDER);

global $globalUtil;
global $msgInfo;
global $adminUtil;
global $doctor;
global $hospital;
global $area;
global $pathology;

$globalUtil=new GlobalUtil(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);
$msgInfo=new Messages;
$adminUtil=new AdminUtil();
$doctor=new Doctor;
$hospital=new Hospital;
$pathology=new Pathology;
$area=new Area;

?>