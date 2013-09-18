<?php require('includes/connection.php');?>
<?php require(PROJECT_DOCUMENT_PATH.CONTROLLER_FOLDER.CONTROLLER_Search);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo SITE_TITLE;?> - Search Doctor, Hospitals, Ambulance, Pathelogy Labs, Nurses/Aaya</title>
<?php include(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."commonHead.php");?>
<!--For Search Filter Criteria Starts-->
<script type="text/javascript">
$(document).ready(function(){

searchfilters('<?php echo $search;?>');

$("input[name$='search']").click(function(){

var radio_value = $(this).val();
searchfilters(radio_value);
});
});

function searchfilters(radio_value){
//alert(radio_value);
if(radio_value=='Doctor') {
$("#leftinner1").show();
$("#leftinner2").hide();
$("#leftinner3").hide();
$("#leftinner4").hide();
$("#leftinner5").hide();
$("#leftinner6").hide();


}
if(radio_value=='BloodDonor') {
$("#leftinner2").show();
$("#leftinner1").hide();
$("#leftinner3").hide();
$("#leftinner4").hide();
$("#leftinner5").hide();
$("#leftinner6").hide();

}
else if(radio_value=='Hospital') {
$("#leftinner3").show();
$("#leftinner2").hide();
$("#leftinner1").hide();
$("#leftinner4").hide();
$("#leftinner5").hide();
$("#leftinner6").hide();

}
else if(radio_value=='Ambulance') {
$("#leftinner4").show();
$("#leftinner2").hide();
$("#leftinner3").hide();
$("#leftinner1").hide();
$("#leftinner5").hide();
$("#leftinner6").hide();

}
else if(radio_value=='Ayah') {
$("#leftinner5").show();
$("#leftinner2").hide();
$("#leftinner3").hide();
$("#leftinner4").hide();
$("#leftinner1").hide();
$("#leftinner6").hide();

}
else if(radio_value=='Pathology') {
$("#leftinner6").show();
$("#leftinner2").hide();
$("#leftinner3").hide();
$("#leftinner4").hide();
$("#leftinner5").hide();
$("#leftinner1").hide();

}

}
</script>
<!--For Search Filter Criteria Ends-->
<!--For jQuery Scroll Pagination Starts-->
<script type="text/javascript">
function showMore(pageNumber){
	$('#showMore').remove();
	$('#SearchLoader').show();
	var request = $.ajax({
	url: "<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.CONTROLLER_FOLDER.CONTROLLER_Search);?>",
	type: "GET",
	data: { search : '<?php echo $search;?>',DoctorName : '<?php echo $doctorName;?>', city : '<?php echo $city;?>',specialization : '<?php echo $specialization;?>',page : pageNumber,rm : 'ajax'},
	dataType: "html"
	});
	
	request.done(function(data) {
	if($('#SearchLoader').show()){	
		$('#SearchLoader').hide();
	}
	if(data!='No Records Found')
	$("#resultSearch").append(data);
	});
	
	request.fail(function(jqXHR, textStatus) {
	if($('#SearchLoader').show()){	
		$('#SearchLoader').hide();
	}	
	alert( "Request failed: " + textStatus );
	});
}
</script>
<!--For jQuery Scroll Pagination Ends-->
</head>
<body>
    <!--main content start -->
    <div id="wrapper">
    
    <div class="header header1">
    <div class="headerLeft"><a href="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'index.php');?>"><img src="<?php echo IMAGES_URL;?>logo.gif" width="316" height="120" alt="" /></a>
    </div>
    
    <!--header right start -->
      <div class="headerRight">
      <?php require(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."loginmenu.php");?>
    <!--header right end -->
    </div>
    <!--header  -->
    </div>
    <!--body main start -->
     <div class="mainBody mainBody1">
	 	<div class="midlepan midlepan1">
     		<div class="searchLeft">
				<div class="searchleftBox">
					<h2>Search Category</h2>
                    <div class="leftinner">
                        <input type="radio" class="searchradio" name="search" value="Doctor" <?php if($search=="Doctor"){?>checked="checked"<?php }?>/>
                        <label>Doctor</label>
                        <br class="spacer" />
                        <!--<input type="radio" class="searchradio" name="search" value="BloodDonor" <?php if($search=="BloodDonor"){?>checked="checked"<?php }?>/>
                        <label>Blood Donor</label>
                        <br class="spacer" />-->
                        <input type="radio" class="searchradio" name="search" value="Hospital" <?php if($search=="Hospital"){?>checked="checked"<?php }?>/>
                        <label>Hospital</label>
                        <br class="spacer" />
                        <!--<input type="radio" class="searchradio" name="search" value="Ambulance" <?php if($search=="Ambulance"){?>checked="checked"<?php }?>/>
                        <label>Ambulance</label>
                        <br class="spacer" />
                        <input type="radio" class="searchradio" name="search" value="Ayah" <?php if($search=="Ayah"){?>checked="checked"<?php }?>/>
                        <label>Ayah</label>
                        
                        <br class="spacer" />-->
                        <input type="radio" class="searchradio" name="search" value="Pathology" <?php if($search=="Pathology"){?>checked="checked"<?php }?>/>
                        <label>Pathology</label>
                    </div>
					<span class="leftBottom">&nbsp;</span>
				</div>
    			<div class="searchleftBox">
                    <span class="searchTop">&nbsp;</span>
                    <div class="leftinner" id="leftinner1">
                    <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form1" id="form1">
                      <input type="hidden" name="search" value="Doctor" />
                      <label>Doctor Name:</label>
                      <input type="text" class="searchinput" id="DoctorName" name="DoctorName" value="<?php print $doctorName;?>"/>
                      <label>Field of Practice:</label>
                      <?php echo $doctor->getSpecializationsOptions($globalUtil,array('id'=>'specialization','name'=>'specialization','class'=>'searchselect'),$specialization,$condition='');?>
                      <label>City :</label>
                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'searchselect'),$city,$condition='');?>
                    <input type="hidden" name="page" id="page" value="0"/>
                    <input type="submit" value="search" class="viewsearch"/>
                    </form>
                    </div>
                    <div class="leftinner" id="leftinner3">
                    <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form3" id="form3">
                    <input type="hidden" name="search" value="Hospital" />
                    <label>Hospital Name:</label>
                    <input type="text" class="searchinput" id="HospitalName" name="HospitalName" value="<?php print $hospitalName;?>"/>
                    <label>Hospital Category:</label>
                    
                    <?php print $hospital->getHospitalCategoryOptions($globalUtil,array("id"=>'hcid',"name"=>'hcid','class'=>'searchselect'),$hcid,"WHERE status='1'");?>
                    
                    <label>Hospital Type:</label>
                    
                    <?php print $hospital->getHospitalTypeOptions($globalUtil,array("id"=>'htid',"name"=>'htid','class'=>'searchselect'),$htid,"WHERE status='1'");?>
                    
                    <label>City</label><br/>
                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'hcity','name'=>'city','class'=>'searchselect'),$city,$condition='');?>
                    <!--<label>Rate Range</label>
                    <input type="text" class="searchinput" id="rate_range" name="rate_range" />
                    -->
                    <input type="hidden" name="page" id="page" value="0"/>
                    <input type="submit" value="search" class="viewsearch"/>
                    </form>
                    </div>
                    <div class="leftinner" id="leftinner2">
                    <form action="blood_search.html" method="get" name="form2" id="form2">
                    <input type="hidden" name="type" value="blooddonor" />
                    
                    <label>Blood Group:</label>
                    <select name="bgroup" class="searchselect" id="bloodgroup">
                    <option value="">-Select Group-</option>
                    <option value="A Positive">A Positive</option>
                    <option value="A Negative">A Negative</option>
                    <option value="A Unkown">A Unkown</option>
                    <option value="B Positive">B Positive</option>
                    <option value="B Negative">B Negative</option>
                    <option value="B Unknown">B Unknown</option>
                    <option value="AB Positive">AB Positive</option>
                    <option value="AB Negative">AB Negative</option>
                    <option value="AB Unknown">AB Unknown</option>
                    <option value="O Positive">O Positive</option>
                    <option value="O Negative">O Negative</option>
                    <option value="O Unknown">O Unknown</option>
                    <option value="Unknown">Unknown</option>
                    </select>
                    <label>City</label>
                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'searchselect'),$optionselectedval='',$condition='');?>
                    <input type="submit" value="search" class="viewsearch"/>
                    </form>
                    </div>
                    <div class="leftinner" id="leftinner4">
                    <form action="ambulance_search.html" method="get" name="form4" id="form4">
                    <input type="hidden" name="type" value="ambulance" />
                    
                    <label>City</label>
                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'searchselect'),$optionselectedval='',$condition='');?>
                    <label>Vehicle Types</label>
                    <select name="car_type" class="searchselect" id="car_type">
                    <option selected="selected" value="">-Select Type-</option>
                    <option>AC</option>
                    <option>NON-AC</option>
                    
                    </select>
                    
                    <input type="submit" value="search" class="viewsearch"/>
                    
                    </form>
                    </div>
                    <div class="leftinner" id="leftinner5">
                    <form action="ayah_search.html" method="get" name="form5" id="form5">
                    
                    <input type="hidden" name="type" value="ayah" />
                    <label>City</label>
                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'searchselect'),$optionselectedval='',$condition='');?>
                    
                    <label>Center Name:</label>
                    <input type="text" class="searchinput" id="center_name" name="center_name" />
                    
                    <input type="submit" value="search" class="viewsearch"/>
                    
                    </form>
                    </div>
                    <div class="leftinner" id="leftinner6">
                    <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form6" id="form6">
                    <input type="hidden" name="search" value="Pathology" />
                    <label>Centre Name:</label>
                    <input type="text" class="searchinput" id="pathcentre" name="pathcentre" />
                    <!--<label>Medical Test Types:</label>
                    <select class="searchselect" name="pathtest" id="pathtest">
                    <option selected="selected" value="">-Select Test Type-</option>
                    <option>Echo</option>
                    <option>Holter</option>
                    <option>Ncv</option>
                    <option>Vep</option>
                    </select>-->
                    
                    <label>City:</label>
                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'searchselect'),$optionselectedval='',$condition='');?>
					<input type="hidden" name="page" id="page" value="0"/>
                    <input type="submit" value="search" class="viewsearch"/>
                    </form>
                    
                    </div>
                    <span class="leftBottom">&nbsp;</span>
    			</div>
			</div> 
            <div class="searchRight">
            <h2>Search Result</h2>
                    <!--<div id="debug">
		<a href="#" id="debug-trigger">+</a>
		<h3>Debug bar</h3>
		<nav id="debug-nav">
			<a href="#" rel="destroy">Destroy</a>
			<a href="#" rel="pause">Pause</a>
			<a href="#" rel="resume">Resume</a>
			<a href="#" rel="toggle">Toggle</a>
			<a href="#" rel="scroll">Scroll</a>
			<a href="#" rel="unbind">Unbind</span></a>
			<a href="#" rel="bind">Bind</span></a>
			<a href="#" rel="retrieve">Retrieve</a>
			<a href="#" rel="cthullu">Invalid command</a>
			<a href="#" rel="pause" data-arg="the-apocalypse">Invalid argument</a>
		</nav>
	</div>-->
                    <div id="resultSearch">
                      <?php if($searchResult['numrows']>0){
                      for($i=0;$i<$searchResult['numrows'];$i++){
					  
					  if($search=='Doctor'){
                      ?>
                      <div class="searchRightgradient">
                        <div class="searchLeftBox">
                       <a href="<?php echo $doctor->doctorPublicUrl(array("id"=>$searchResult['data'][$i]['doctorDetailsid'],"firstName"=>$searchResult['data'][$i]['firstName'],"middleName"=>$searchResult['data'][$i]['middleName'],"lastName"=>$searchResult['data'][$i]['lastName']));?>"> <?php if($searchResult['data'][$i]['doctorImg']==''){?><img src="<?php echo IMAGES_URL."doctor.jpg";?>" style="height:64px; width:64px" alt="<?php echo $searchResult['data'][$i]['firstName']." ".$searchResult['data'][$i]['middleName']." ".$searchResult['data'][$i]['lastName'];?>" border="0" /><?php } else {?><img src="<?php print DOCTOR_IMG_URL."small/".$searchResult['data'][$i]['doctorImg'];?>" style="height:64px; width:64px;" alt="<?php echo $searchResult['data'][$i]['firstName']." ".$searchResult['data'][$i]['middleName']." ".$searchResult['data'][$i]['lastName'];?>" border="0" /><?php }?></a>            
                        <div class="searchrightdoctorpan">
                        <h3><?php echo "Dr. ".$searchResult['data'][$i]['firstName']." ".$searchResult['data'][$i]['middleName']." ".$searchResult['data'][$i]['lastName'];?></h3>
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
                 <a href="<?php echo $doctor->doctorPublicUrl(array("id"=>$searchResult['data'][$i]['doctorDetailsid'],"firstName"=>$searchResult['data'][$i]['firstName'],"middleName"=>$searchResult['data'][$i]['middleName'],"lastName"=>$searchResult['data'][$i]['lastName']));?>" > <img src="<?php echo IMAGES_URL?>details.gif"  width="69" height="26" class="nomarg" alt="" /></a>
                  </div>
                  </div>
                      </div>
                      <?php }
					  if($search=='Hospital'){
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
                      <?php }
					  if($search=='Pathology'){
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
                      <?php }
					  ?>
					  
                      <?php
                      }}else{?>
                      <div class="searchRightgradient">
                        No Records Found
                      </div>
                      <?php }?>
                      <?php if($searchResult['totalnumrows']>$itemLimit){?>
                      <a id="showMore" href="javascript:showMore('<?php echo $nextPage;?>');"><img src="<?php echo IMAGES_URL;?>show-more-button.png" class="searchShowMore"/></a>
                      <?php }?>
                      
                      <!--<div class="paginationbg">
            
            <a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">8</a> <a href="#">9</a> <a href="#">10</a> <a href="#">>></a> </div>-->
                      <!--Pagination Div Ends-->  
                      </div> 
         
                      <div id="SearchLoader" class="loading" style="display:none;">
                      	<img src="<?php echo IMAGES_URL;?>ajax-loader.gif"/>
                      </div>
                  </div>
        	</div>
     </div>
    <!--body main end -->
    </div>
    <!--main content end -->
    <!--footer start -->
	<?php include(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."footer.php");?>
	<!--footer end -->
</body>

</html>