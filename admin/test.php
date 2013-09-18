<?php
require("includes/connection.php");
//echo 1;
//$result=$globalUtil->getFolderFilesFromDir(PROJECT_DOCUMENT_PATH."CATEGORY-IMAGES/UNREGISTERED-USERS/ALLUSER-MAIN-ORIGINAL-IMAGES/");
//print_r(scandir(PROJECT_DOCUMENT_PATH."CATEGORY-IMAGES/UNREGISTERED-USERS/ALLUSER-MAIN-ORIGINAL-IMAGES/"));
//$globalUtil->printArray($result);

$hospitalObj=new Hospital;
$hospitalDetails=$hospitalObj->getHospital($globalUtil,'');
$globalUtil->printArray($hospitalDetails);
?>