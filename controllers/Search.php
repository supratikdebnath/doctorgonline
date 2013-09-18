<?php
$requestMode='';
if(isset($_GET['rm'])){
	$requestMode = $_GET['rm'];
	if($requestMode=='ajax'){ require('../includes/connection.php');
	}
	}	
$globalUtil->unsetGetUrlDataAll();
$globalUtil->setGetUrlData($_GET);
$search=$globalUtil->getGetUrlData('search');
if(checkSearchCriteria($search)==true){
	
	$city='';
	
	//For Doctor Search
	$specialization='';
	$doctorName='';
	
	
	//For Hospital Search
	$hospitalName='';
	$hcid = '';
	$htid = '';
	if($search=='Doctor'){
		$doctorName = $globalUtil->getGetUrlData('DoctorName');
		$specialization = $globalUtil->getGetUrlData('specialization');
		$city = $globalUtil->getGetUrlData('city');
		$page = $globalUtil->getGetUrlData('page');
		$itemLimit=5;
		if($page == '' || $page == '0' || $page == '1'){
			$startIndex = 0;
		}
		else{
			$startIndex = ($page-1)*$itemLimit;
		}
		$nextPage = $page+1+1;	
		$searchResult = getDoctorSearchResult($doctorName,$specialization,$city,$startIndex,$itemLimit);
		
		if($requestMode=='ajax'){
			ajaxDoctorSearchHTML($searchResult,$nextPage);
			}
		}
	if($search=='Hospital'){
		$hospitalName = $globalUtil->getGetUrlData('HospitalName');
		$city = $globalUtil->getGetUrlData('city');
		$hcid = $globalUtil->getGetUrlData('hcid');
		$htid = $globalUtil->getGetUrlData('htid');
		$page = $globalUtil->getGetUrlData('page');
		$itemLimit=5;
		if($page == '' || $page == '0' || $page == '1'){
			$startIndex = 0;
		}
		else{
			$startIndex = ($page-1)*$itemLimit;
		}
		$nextPage = $page+1+1;	
		$searchResult = getHospitalSearchResult($hospitalName,$city,$hcid,$htid,$startIndex,$itemLimit);
		if($requestMode=='ajax'){
			ajaxHospitalSearchHTML($searchResult,$nextPage);
			}
		}	
	if($search=='Pathology'){
		$pathcentre = $globalUtil->getGetUrlData('pathcentre');
		$city = $globalUtil->getGetUrlData('city');
		$page = $globalUtil->getGetUrlData('page');
		$itemLimit=5;
		if($page == '' || $page == '0' || $page == '1'){
			$startIndex = 0;
		}
		else{
			$startIndex = ($page-1)*$itemLimit;
		}
		$nextPage = $page+1+1;	
		$searchResult = getPathologySearchResult($pathcentre,$city,$startIndex,$itemLimit);

		if($requestMode=='ajax'){
			ajaxPathologySearchHTML($searchResult,$nextPage);
			}
		}	
	}
else{
	$globalUtil->redirectUrl($globalUtil->generateUrl(MAIN_SITE_URL."index.php"));
	}	
function getDoctorSearchResult($doctorName,$specialization,$city,$startLimit,$itemLimit){
	global $doctor;
	global $globalUtil;
	
	$searchCondition  =  " ";
	$searchCondition .= "WHERE ";
	if($doctorName!=''){
		//$searchCondition .= "( firstName LIKE '".$doctorName."%' OR lastName LIKE '%".$doctorName."' OR middleName LIKE '%".$doctorName."%' ) AND ";
		$searchCondition .= " CONCAT(firstName,' ',middleName,' ', lastName) LIKE '%".$doctorName."%' AND ";
		}
	if($specialization!=''){
		$searchCondition .= "specid='".$specialization."' AND ";
		}
	if($city!=''){
		$searchCondition .= "cid='".$city."' AND ";
		}		
	$searchCondition .= "status='1'";	
	$totaldoctorResult=$doctor->getDoctor($globalUtil,$searchCondition);
	$doctorResultCount=$totaldoctorResult['numrows'];
	
	$searchCondition .= " ORDER BY createDt DESC LIMIT ".$startLimit.",".$itemLimit;
	
	$doctorResult=$doctor->getDoctor($globalUtil,$searchCondition);
	//echo "<pre>";print_r($latestDocs);echo "<pre>";die();	
	$doctorResult['totalnumrows']=$doctorResultCount;
	return $doctorResult;
	}
function getHospitalSearchResult($hospitalName,$city,$hcid,$htid,$startLimit,$itemLimit){
	global $hospital;
	global $globalUtil;
	
	$searchCondition  =  " ";
	$searchCondition .= "WHERE ";
	if($hospitalName!=''){
		//$searchCondition .= "( firstName LIKE '".$doctorName."%' OR lastName LIKE '%".$doctorName."' OR middleName LIKE '%".$doctorName."%' ) AND ";
		$searchCondition .= " hospitalName LIKE '%".$hospitalName."%' AND ";
		}
	if($hcid!=''){
		$searchCondition .= "hcid='".$hcid."' AND ";
		}
	if($htid!=''){
		$searchCondition .= "htid='".$htid."' AND ";
		}	
	if($city!=''){
		$searchCondition .= "cid='".$city."' AND ";
		}		
	$searchCondition .= "status='1'";	
	$totalhospitalResult=$hospital->getHospital($globalUtil,$searchCondition);
	$hospitalResultCount=$totalhospitalResult['numrows'];
	
	$searchCondition .= " ORDER BY createDt DESC LIMIT ".$startLimit.",".$itemLimit;
	
	$hospitalResult=$hospital->getHospital($globalUtil,$searchCondition);
	//echo "<pre>";print_r($latestDocs);echo "<pre>";die();	
	$hospitalResult['totalnumrows']=$hospitalResultCount;
	return $hospitalResult;
	}
function getPathologySearchResult($pathcentre,$city,$startLimit,$itemLimit){
	global $pathology;
	global $globalUtil;
	
	$searchCondition  =  " ";
	$searchCondition .= "WHERE ";
	if($pathcentre!=''){
		//$searchCondition .= "( firstName LIKE '".$doctorName."%' OR lastName LIKE '%".$doctorName."' OR middleName LIKE '%".$doctorName."%' ) AND ";
		$searchCondition .= " pathologycenterName  LIKE '%".$pathcentre."%' AND ";
		}
	if($city!=''){
		$searchCondition .= "cid='".$city."' AND ";
		}		
	$searchCondition .= "status='1'";	
	$totalpathologyResult=$pathology->getPathology($globalUtil,$searchCondition);
	$pathologyResultCount=$totalpathologyResult['numrows'];
	
	$searchCondition .= " ORDER BY createDt DESC LIMIT ".$startLimit.",".$itemLimit;
	
	$pathologyResult=$pathology->getPathology($globalUtil,$searchCondition);
	//echo "<pre>";print_r($latestDocs);echo "<pre>";die();	
	$pathologyResult['totalnumrows']=$pathologyResultCount;
	return $pathologyResult;
	}		
function checkSearchCriteria($type){
	$result = false;
	if($type=='Doctor'){
		$result = true;
		}
	if($type=='Hospital'){
		$result = true;
		}
	if($type=='Pathology'){
		$result = true;
		}	
	return $result;	
	}	
function ajaxDoctorSearchHTML($searchResult,$nextPage){
	global $doctor;
	global $globalUtil;
	global $area;
	if($searchResult['numrows']>0){
                      for($i=0;$i<$searchResult['numrows'];$i++){
                      ?>
                      <div class="searchRightgradient">
                        <div class="searchLeftBox">
                       <?php if($searchResult['data'][$i]['doctorImg']==''){?><img src="<?php echo IMAGES_URL."doctor.jpg";?>" style="height:64px; width:64px" alt="<?php echo $searchResult['data'][$i]['firstName']." ".$searchResult['data'][$i]['middleName']." ".$searchResult['data'][$i]['lastName'];?>" /><?php } else {?><img src="<?php print DOCTOR_IMG_URL."small/".$searchResult['data'][$i]['doctorImg'];?>" style="height:64px; width:64px;" alt="<?php echo $searchResult['data'][$i]['firstName']." ".$searchResult['data'][$i]['middleName']." ".$searchResult['data'][$i]['lastName'];?>" /><?php }?>            
                        <div class="searchrightdoctorpan">
                        <h3><?php echo $searchResult['data'][$i]['firstName']." ".$searchResult['data'][$i]['lastName']." ".$searchResult['data'][$i]['middleName'];?></h3>
                        <p><strong>Specialization :</strong><span>
                        <?php
                        $specializationName=$doctor->getSpecializations($globalUtil," WHERE id ='".$searchResult['data'][$i]['specid']."' AND status='1'");
                        $specName=($specializationName['numrows']>0) ? $specializationName['data'][0]['specName'] : '';
                        ?>
                        <?php echo $specName;?></span></p>
                      <p>  <strong>Registration No :</strong><span><?php echo $searchResult['data'][$i]['registrationNo'];?></span></p>
                       <p>  <strong>Exprerience :</strong><span><?php echo $searchResult['data'][$i]['yearsOfExp'];?> Years</span></p>
                         
                       <p class="searchlefttxt">  
                       <?php
                       //echo $searchResult['data'][$i]['aid'];
                       $areaDetails=$area->getAreas($globalUtil,"WHERE area.id='".$searchResult['data'][$i]['aid']."' AND area.status='1'");
                       //print_r($areaDetails);
                       if($areaDetails['numrows']>0){
                        echo $areaDetails['data'][0]['areaName'].", ".$areaDetails['data'][0]['zoneName'];
                        $cityDetails=$area->getCity($globalUtil,"WHERE id='".$searchResult['data'][$i]['cid']."' AND status='1'");
                       
                       if($cityDetails['numrows']>0){
                        echo ", ".$cityDetails['data'][0]['cityName'];
                       }
                        echo ", ".$areaDetails['data'][0]['stateName'];
                       }
                       ?></p> 
                        </div>
                    
                    </div>
                        <div class="searchrightBox">
                    
                    <p><strong>Consultation fees:</strong> <span>Rs.<?php echo $searchResult['data'][$i]['consultancyFees'];?></span></p>
                                
                    <p><img src="<?php echo IMAGES_URL?>like-icon.gif" width="16" height="18" alt="" /> (0 Like) <span> Reviews</span></p>
                    <div class="detailsicon">
                                            <?php if($searchResult['data'][$i]['registrationNo']!=''){?>
                                            <img src="<?php echo IMAGES_URL?>govt.jpg" title="Government Registered " width="35" height="24" alt="" />
                         <?php }?> 
                         <?php if($searchResult['data'][$i]['available24Hrs']=='Y'){?>                               <img src="<?php echo IMAGES_URL?>24hrs_1.jpg" title="24hrs Availability " width="35" height="24" alt="" />
                                            <?php }?>
                                            <?php if($searchResult['data'][$i]['creditCardAccept']=='Y'){?>                    
                                             <img src="<?php echo IMAGES_URL?>card_1.jpg" title="Credit Card" width="35" height="24" alt="" />
                                             <?php }?>
                                       </div>
                   <div class="detailsicon">
                 <a href="<?php echo $doctor->doctorPublicUrl(array("id"=>$searchResult['data'][$i]['doctorDetailsid'],"firstName"=>$searchResult['data'][$i]['firstName'],"middleName"=>$searchResult['data'][$i]['middleName'],"lastName"=>$searchResult['data'][$i]['lastName']));?>"> <img src="<?php echo IMAGES_URL?>details.gif"  width="69" height="26" class="nomarg" alt="" /></a>
                  </div>
                  </div>
                      </div>
                      <?php
                      }
					  ?>
                      <a id="showMore" href="javascript:showMore('<?php echo $nextPage;?>');"><img src="<?php echo IMAGES_URL;?>show-more-button.png" class="searchShowMore"/></a>
					  <?php } else{?>No Records Found<?php die();}}?>
<?php
function ajaxHospitalSearchHTML($searchResult,$nextPage){
	global $hospital;
	global $globalUtil;
	global $area;
	if($searchResult['numrows']>0){
                      for($i=0;$i<$searchResult['numrows'];$i++){
                      ?>
                      <?php
$hospitalType=$hospital->getHospitalType($globalUtil,"WHERE id='".$searchResult['data'][$i]['htid']."' AND status='1'");
$hospitalTypeName=$hospitalType[0]['typeName'];

$hospitalCategory=$hospital->getHospitalCategory($globalUtil,"WHERE id='".$searchResult['data'][$i]['hcid']."' AND status='1'");
$hospitalCategoryName=$hospitalCategory[0]['categoryName'];

$hospitalGeoLocationString='';
if($hospitalGeoLocation=getCountryNameByStateId($searchResult['data'][0]['cid'])){
$hospitalGeoLocationString='+'.str_replace(array(' ','-','_','&'),'+',$hospitalGeoLocation['cityName'].'+'.$hospitalGeoLocation['stateName'].'+'.$hospitalGeoLocation['countryName']);

$hospitalGeoLocationForAddress = ', '.$hospitalGeoLocation['cityName'].', '.$hospitalGeoLocation['stateName'].', '.$hospitalGeoLocation['countryName'];
}

?>
<div class="searchRightgradient">
        	<div class="searchLeftBox">
            <div class="searchrightdoctorpan">
            	<h3><?php echo $searchResult['data'][$i]['hospitalName'];?></h3>
                <p><strong>Type :</strong><span><?php echo $hospitalTypeName;?></span></p>
                <p><strong>Category :</strong><span><?php echo $hospitalCategoryName;?> </span></p>
                <p><strong>Website :</strong><span><?php echo $searchResult['data'][$i]['website'];?></span> </p>
               <p class="searchlefttxt"> <?php echo $searchResult['data'][$i]['address'];?>,<?php echo $hospitalGeoLocationForAddress;?>, <?php echo $searchResult['data'][$i]['pincode'];?>.</p> 
                </div>
            
            </div>
      <div class="searchrightBox">
            <p><img src="<?php echo IMAGES_URL?>like-icon.gif" width="16" height="18" alt="" /> (0 Like) <span> Reviews</span></p>
            <div class="detailsicon">
            	<img src="<?php echo IMAGES_URL?>details-icon-1.gif" width="33" height="32" alt="" class="nomarg" />
            	<img src="<?php echo IMAGES_URL?>details-icon-2.gif" width="33" height="32" alt="" />
            	<img src="<?php echo IMAGES_URL?>details-icon-3.gif" width="33" height="32" alt=""  />
           </div>
           <div class="detailsicon">
         <a href="<?php echo $hospital->hospitalPublicUrl(array("id"=>$searchResult['data'][$i]['hospitalDetailsid'],"hospitalName"=>$searchResult['data'][$i]['hospitalName']));?>" > <img src="<?php echo IMAGES_URL?>details.gif"  width="69" height="26" class="nomarg" alt="" /></a>
          </div>
          </div>
     
        </div>
                      <?php
                      }
					  ?>
                      <a id="showMore" href="javascript:showMore('<?php echo $nextPage;?>');"><img src="<?php echo IMAGES_URL;?>show-more-button.png" class="searchShowMore"/></a>
					  <?php } else{?>No Records Found<?php die();}}?>
<?php
function ajaxPathologySearchHTML($searchResult,$nextPage){
	global $pathology;
	global $globalUtil;
	global $area;
	
	if($searchResult['numrows']>0){
                      for($i=0;$i<$searchResult['numrows'];$i++){
                      ?>
                      <div class="searchRightgradient">
                        <div class="searchLeftBox">
                       <?php if($searchResult['data'][$i]['pathologyCenterImg']==''){?><img src="<?php echo IMAGES_URL."Pathologica.jpg";?>" style="height:64px; width:64px" alt="<?php echo $searchResult['data'][$i]['pathologycenterName'];?>" /><?php } else {?><img src="<?php print PATHOLOGY_CENTER_IMG_URL."small/".$searchResult['data'][$i]['pathologyCenterImg'];?>" style="height:64px; width:64px;" alt="<?php echo $searchResult['data'][$i]['pathologycenterName'];?>" /><?php }?>            
                        <div class="searchrightdoctorpan">
                        <h3><?php echo $searchResult['data'][$i]['pathologycenterName']?></h3>
                        
                       <p><strong>Registration No :</strong><span><?php echo $searchResult['data'][$i]['registrationNo'];?></span></p>
                       
                         
                       <p class="searchlefttxt">  
                       <?php
                       //echo $searchResult['data'][$i]['aid'];
                       $areaDetails=$area->getAreas($globalUtil,"WHERE area.id='".$searchResult['data'][$i]['aid']."' AND area.status='1'");
                       //print_r($areaDetails);
                       if($areaDetails['numrows']>0){
                        echo $areaDetails['data'][0]['areaName'].", ".$areaDetails['data'][0]['zoneName'];
                        $cityDetails=$area->getCity($globalUtil,"WHERE id='".$searchResult['data'][$i]['cid']."' AND status='1'");
                       
                       if($cityDetails['numrows']>0){
                        echo ", ".$cityDetails['data'][0]['cityName'];
                       }
                        echo ", ".$areaDetails['data'][0]['stateName'];
                       }
                       ?></p> 
                        </div>
                    
                    </div>
                        <div class="searchrightBox">
                    
                    <p><strong>Registration No:</strong> <span><?php echo $searchResult['data'][$i]['registrationNo'];?></span></p>
                                
                    <p><img src="<?php echo IMAGES_URL?>like-icon.gif" width="16" height="18" alt="" /> (0 Like) <span> Reviews</span></p>
                    <div class="detailsicon">
                                            <?php if($searchResult['data'][$i]['registrationNo']!=''){?>
                                            <img src="<?php echo IMAGES_URL?>govt.jpg" title="Government Registered " width="35" height="24" alt="" />
                         <?php }?> 
                         <?php if($searchResult['data'][$i]['available24Hrs']=='Y'){?>                               <img src="<?php echo IMAGES_URL?>24hrs_1.jpg" title="24hrs Availability " width="35" height="24" alt="" />
                                            <?php }?>
                                            <?php if($searchResult['data'][$i]['creditCardAccept']=='Y'){?>                    
                                             <img src="<?php echo IMAGES_URL?>card_1.jpg" title="Credit Card" width="35" height="24" alt="" />
                                             <?php }?>
                                       </div>
                   <div class="detailsicon">
                 <a href="<?php echo $pathology->pathologyPublicUrl(array("id"=>$searchResult['data'][$i]['pathologyDetailsid'],"pathologycenterName"=>$searchResult['data'][$i]['pathologycenterName']));?>"> <img src="<?php echo IMAGES_URL?>details.gif"  width="69" height="26" class="nomarg" alt="" /></a>
                  </div>
                  </div>
                      </div>
                      <?php
                      }
					  ?>
                      <a id="showMore" href="javascript:showMore('<?php echo $nextPage;?>');"><img src="<?php echo IMAGES_URL;?>show-more-button.png" class="searchShowMore"/></a>
					  <?php } else{?>No Records Found<?php die();}}?>

<?php
function getCountryNameByStateId($id){
	global $globalUtil;
	$state=new City;
	$countryDetails=$state->getCity($globalUtil,"WHERE city.id='".$id."'");
	if($countryDetails['numrows']>0){
			return $countryDetails['data'][0];
		}
	else {	return '';};	
	}
?>                      					  
                      