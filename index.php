<?php require('includes/connection.php');?>
<?php require(PROJECT_DOCUMENT_PATH.CONTROLLER_FOLDER.CONTROLLER_Home);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />

<title><?php echo SITE_TITLE;?> - Welcome</title>
<?php include(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."commonHead.php");
		$latestDocs=getLatestDoctors();
		$latestDocsFeatured=getLatestDoctorsFeatured();
		$latestPathFeatured=getLatestPathologyCenterFeatured();
		$latestHospFeatured=getLatestHospitalFeatured();
		$arr=array_merge_recursive($latestDocsFeatured['data'],$latestPathFeatured['data'],$latestHospFeatured['data']);
		
		
		$latestDocsViewed=getLatestDoctorsMostViewed();
		$latestPathViewed=getLatestPathologyCenterMostViewed();
		$latestHospViewed=getLatestHospitalMostViewed();
		$arr_view=array_merge_recursive($latestDocsViewed['data'],$latestPathViewed['data'],$latestHospViewed['data']);
		
		$sort_arr = subval_sort($arr_view,'viewedcount'); 
		/*echo '<pre>';
		print_r($sort_arr);*/
?>
<!-- Smooth menu js start-->

<script type="text/javascript" src="<?php echo JS_URL;?>tab.js"></script>
<script type="text/javascript" src="<?php echo JS_URL;?>tooltip.js"></script>
<link href="<?php echo CSS_URL;?>tooltip.css" rel="stylesheet" type="text/css" />
<style type="text/css">
        h3 { font: normal 24px/36px Arial;}
        h4 { font-family: "Trebuchet MS", Verdana; }    
        #span4 img {cursor:pointer;margin:20px;}   
    </style>
<!--Latest Doctor Scroll Starts-->
<script type="application/javascript">
window.addEvent("domready", function() {

			/* Example 5 */
			var gallery5 = new slideGallery($$("div.gallery")[0], {
				steps: 1,
				mode: "circle",
				autoplay: true,
				duration: 2000
			});
			
		});
</script>
<!--Latest Doctor Scroll Ends-->

 

<!-- registered doctor scroller start -->
<script type="text/javascript">

var delayb4scroll=2000
var marqueespeed=2 
var pauseit=1

////NO NEED TO EDIT BELOW THIS LINE////////////

var copyspeed=marqueespeed
var pausespeed=(pauseit==0)? copyspeed: 0
var actualheight=''

function scrollmarquee(){
if (parseInt(cross_marquee.style.top)>(actualheight*(-1)+8))
cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px"
else
cross_marquee.style.top=parseInt(marqueeheight)+8+"px"
}

function initializemarquee(){
cross_marquee=document.getElementById("vmarquee")
cross_marquee.style.top=0
marqueeheight=document.getElementById("marqueecontainer").offsetHeight
actualheight=cross_marquee.offsetHeight
if (window.opera || navigator.userAgent.indexOf("Netscape/7")!=-1){ //if Opera or Netscape 7x, add scrollbars to scroll and exit
cross_marquee.style.height=marqueeheight+"px"
cross_marquee.style.overflow="scroll"
return
}
setTimeout('lefttime=setInterval("scrollmarquee()",30)', delayb4scroll)
}

if (window.addEventListener)
window.addEventListener("load", initializemarquee, false)
else if (window.attachEvent)
window.attachEvent("onload", initializemarquee)
else if (document.getElementById)
window.onload=initializemarquee


</script>

<!-- registered doctor scroller end -->
<!-- validation -->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>-->
<script type="text/javascript">
$(document).ready(function(){
$("#submit1").click(validate1);
$("#submit2").click(validate2);
$("#submit3").click(validate3);
$("#submit4").click(validate4);
$("#submit5").click(validate5);
$("#submit6").click(validate6);
});
function validate1(){
	if($('select#specialization').val()=="" && $('select#city').val()=="")
	{
		$('#specialization').css("border","1px solid #F00");
		$('#specialization').removeAttr('value');
		$('#specialization').focus();
		$('#city').css("border","1px solid #F00");
		$('#city').removeAttr('value');
		$('#city').focus();
		$("#highlight1").html('Please select the fields marked in red');
		$("#highlight1").css("color","#8f0000");
		return false;
	}
	
	
}



function validate2(){
	if($('select#bloodgroup').val()=="" && $('select#city1').val()=="")
	{
		$('#bloodgroup').css("border","1px solid #F00");
		$('#bloodgroup').removeAttr('value');
		$('#bloodgroup').focus();
		$('#city1').css("border","1px solid #F00");
		$('#city1').removeAttr('value');
		$('#city1').focus();
		$("#highlight2").html('Please Select Atleast One Field');
		$("#highlight2").css("color","#8f0000");
		return false;
	}
	
	
}

function validate3(){
	//if($('#HospitalName').val().length<1 && $('select#hcid').val()=="" && $('select#hcity').val()=="" && $('select#htid').val()=="" &&  $('#rateRange').val().length<1)
	if($('#HospitalName').val().length<1 && $('select#hcity').val()=="")
	{
		$('#HospitalName').css("border","1px solid #F00");
		$('#HospitalName').removeAttr('value');
		$('#HospitalName').focus();
		$('#hcity').css("border","1px solid #F00");
		$('#hcity').removeAttr('value');
		$('#hcity').focus();
		//$('#hcid').css("border","1px solid #F00");
		//$('#hcid').removeAttr('value');
		//$('#hcid').focus();
		//$('#htid').css("border","1px solid #F00");
		//$('#htid').removeAttr('value');
		//$('#htid').focus();
		//$('#rateRange').css("border","1px solid #F00");
		//$('#rateRange').removeAttr('value');
		//$('#rateRange').focus();
		$("#highlight3").html('Please select the fields marked in red.');
		$("#highlight3").css("color","#8f0000");
		return false;
	}
	
	
}
function validate4(){
	if($('select#car_type').val()=="" && $('select#ambulance_city').val()=="")
	{
		$('#car_type').css("border","1px solid #F00");
		$('#car_type').removeAttr('value');
		$('#car_type').focus();
		$('#ambulance_city').css("border","1px solid #F00");
		$('#ambulance_city').removeAttr('value');
		$('#ambulance_city').focus();
		$("#highlight4").html('Please Select Atleast One Field');
		$("#highlight4").css("color","#8f0000");
		return false;
	}
	
	
}
function validate5(){
	if($('select#bloodgroup').val()=="" && $('select#ayah_city').val()=="" && $('#center_name').val().length<1)
	{
		$('#bloodgroup').css("border","1px solid #F00");
		$('#bloodgroup').removeAttr('value');
		$('#bloodgroup').focus();
		$('#ayah_city').css("border","1px solid #F00");
		$('#ayah_city').removeAttr('value');
		$('#ayah_city').focus();
		$('#center_name').css("border","1px solid #F00");
		$('#center_name').removeAttr('value');
		$('#center_name').focus();
		$("#highlight5").html('Please Select Atleast One Field');
		$("#highlight5").css("color","#8f0000");
		return false;
	}
	
	
}
function validate6(){
	if($('#pathcentre').val().length<1 && $('select#path_city').val()=="" && $('select#pathtest').val()=="")
	{
		$('#pathcentre').css("border","1px solid #F00");
		$('#pathcentre').removeAttr('value');
		$('#pathcentre').focus();
		$('#path_city').css("border","1px solid #F00");
		$('#path_city').removeAttr('value');
		$('#path_city').focus();
		$('#pathtest').css("border","1px solid #F00");
		$('#pathtest').removeAttr('value');
		$('#pathtest').focus();
		$("#highlight6").html('Please Select Atleast One Field');
		$("#highlight6").css("color","#8f0000");
		return false;
	}
	
	
}

</script>
</head>
<body>
    <!--main content start -->
    <div id="wrapper">
    
    <div class="header">
    <div class="headerLeft"><a href="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'index.php');?>"><img src="<?php echo IMAGES_URL;?>logo.gif" width="316" height="120" alt="" /></a>
    <div class="slidebg">
        <div id="slideshow">
        <?php
		for($i=0;$i<count($arr);$i++)
		{
			$your_values = array_values($arr[$i]);
			$your_keys = array_keys($arr[$i]);
			$path=implode(',', $your_keys);
			$img=implode(' ', $your_values);
			/*echo '<pre>';
			print_r($arr[$i]);*/
			if($path!='' || $img!='')
		   {
			if($path=='doctorImg')
			{
		?>
        		<img src="<?php print DOCTOR_IMG_URL."medium/".$img;?>" width="400" height="271" alt="" class="active" />
        <?php
			}
			else if($path=='hospitalImg')
			{
			
		?>
        	<img src="<?php print HOSPITAL_IMG_URL."medium/".$img;?>" width="400" height="271" alt="" class="active" />
		<?php
			}
			else if($path=='pathologyCenterImg')
			{
		?>
                <img src="<?php print PATHOLOGY_CENTER_IMG_URL."medium/".$img;?>" width="400" height="271" alt="" class="active" />
           
           <?php
		    }
		   }
		   else
		   {
			 ?>
             <img src="<?php echo IMAGES_URL;?>top-left-slide-pic1" width="400" height="271" alt="" class="active" />
             <img src="<?php echo IMAGES_URL;?>top-left-slide-pic2" width="400" height="271" alt="" class="active" />
             <?php  
		   }
		}
		?>
         </div>
            <div id="slide-holder">
            <div id="slide-runner">&nbsp;</div>
    <!--content featured gallery here -->
       </div>  
      </div>
    </div>
    
    <!--header right start -->
      <div class="headerRight">
      <?php require(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."loginmenu.php");?>
    
    <div class="tabpan">
    	<ul id="tablist" class="menu">
    	<li><a href="" class="current" onClick="return expandcontent('sc1', this)">Doctor</a></li>
        <li><a href="" onClick="return expandcontent('sc2', this)" theme="#fff" style="color:#0075a0;">Blood Donor</a></li>
        <li><a href="" onClick="return expandcontent('sc3', this)" theme="#fff" style="color:#0075a0;">Hospital</a></li>
        <li><a href="" onClick="return expandcontent('sc4', this)" theme="#fff" style="color:#0075a0;">Ambulane</a></li>
        <li><a href="" onClick="return expandcontent('sc5', this)" theme="#fff" style="color:#0075a0;">Ayah</a></li>
        <li><a href="" onClick="return expandcontent('sc6', this)" theme="#fff" style="color:#0075a0;">Pathology</a></li>
    </ul>
    
    <div id="tabcontentcontainer">
    
    <div id="sc1" class="tabcontent">
    <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form1" id="form1">
    
                    <div id="doctor" class="content">
                     <div class="formleft">
                     <input type="hidden" name="search" value="Doctor" />
                            <label>Field of Practice:</label>
                            <?php echo $doctor->getSpecializationsOptions($globalUtil,array('id'=>'specialization','name'=>'specialization','class'=>'selectBox1'),$optionselectedval='',$condition='');?>
                          
                        <br class="spacer"/>
                       
                    </div>
                    <div class="formleft">
                    <div class="forminputBox forminputBox1">
                    <label>City:</label><br/>
                           <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'selectBox1'),$optionselectedval='',$condition='');?> 
                      </div>
                      </div>
                        
                              <input type="hidden" name="page" id="page" value="0"/>
                              <input type="submit" class="search" style="float:right;" id="submit1"/>
                           
                            
                     <div style="clear:both; padding:0 0 0 15px; margin-top:-40px; overflow:hidden; float:left;" id="highlight1"></div>       
                      
                    </div>
                     
    </form>
    </div>
    
    <div id="sc2" class="tabcontent">
     <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form2" id="form2">
    
                        <div id="blood" class="content">
                            <div class="formleft">
                            <input type="hidden" name="type" value="blood" />
                                
                                <label>Blood Group:</label>
                                <select name="bgroup" class="selectBox1" id="bloodgroup">
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
                               
                        </div>
                            
                            <div class="formleft">
                                    <label>City</label>
                                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'selectBox1'),$optionselectedval='',$condition='');?>
                                
                            </div>  
                           <input type="hidden" name="page" id="page" value="0"/>   
                           <input type="submit" class="search" style="float:right;" id="submit2"/>
                           <div style="clear:both; padding:0 0 0 15px; margin-top:-40px; overflow:hidden; float:left;" id="highlight2"></div>
                        </div>
    
    </form>
                            
    
    
    </div>
    
    <div id="sc3" class="tabcontent">
    <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form3" id="form3">
    
                        <div id="hospital" class="content">
                            <div class="formleft">
                            <input type="hidden" name="search" value="Hospital" />
                                <label>Hospital Name:</label>
                                <input type="text" class="txtBox" id="HospitalName" name="HospitalName"/>
                                <label>Hospital Category:</label>
                                
                                    <?php print $hospital->getHospitalCategoryOptions($globalUtil,array("id"=>'hcid',"name"=>'hcid','class'=>'selectBox1'),'',"WHERE status='1'");?>
                                 <br/>
                                <label>Hospital Type:</label>
                                
                                <?php print $hospital->getHospitalTypeOptions($globalUtil,array("id"=>'htid',"name"=>'htid','class'=>'selectBox1'),'',"WHERE status='1'");?>
                                       
                        </div>
                            
                            <div class="formleft">
                            <label>City</label><br/>
                                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'hcity','name'=>'city','class'=>'selectBox1'),$optionselectedval='',$condition='');?>
                               
                               <!-- <div class="forminputBox forminputBox1"> 
                                    
                                    
                               
                               <label>Rate Range</label> 
                               <input type="text" class="txtBox" id="rateRange" name="rateRange" />   
                               </div>-->
                            </div>
                            <input type="hidden" name="page" id="page" value="0"/>
                            <input type="submit" class="search" style="float:right;" id="submit3"/>   
                            <div style="clear:both; padding:0 0 0 15px; margin-top:-3px; overflow:hidden; float:left;" id="highlight3"></div>                  
                        </div>
    </form>
                            
    
    </div>
    
    <div id="sc4" class="tabcontent">
        <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form4" id="form4">
    
                        <div id="ambulance" class="content">
                             <div class="formleft">
                             <input type="hidden" name="type" value="ambulance" />
                             
                                <label>City</label>
                                    <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'selectBox1'),$optionselectedval='',$condition='');?>
                                    
                        </div>
                            
                            <div class="formleft">
                                 <label>Vehicle Types</label>
                             <select name="car_type" class="selectBox1" id="car_type">
                                 <option selected="selected" value="">-Select Type-</option>
                                   <option value="Y">AC</option>
                                    <option value="N">NON-AC</option>
                                    
                                    </select> 
                              
                                
                            </div>
                            <input type="submit" class="search"  style="float:right;" id="submit4" />   
                            <div style="clear:both; padding:0 0 0 15px; margin-top:-40px; overflow:hidden; float:left;" id="highlight4"></div>                
                        </div>
    </form>
    </div>
    
    <div id="sc5" class="tabcontent">
    
    <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form5" id="form5">
    
                    <div id="ayah" class="content">
                         <div class="formleft">
                         <input type="hidden" name="type" value="ayah" />
                         <label>City</label>
                              <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'selectBox1'),$optionselectedval='',$condition='');?>
                            
                            
                    </div>
                        
                        <div class="formleft">
                           <label>Center Name:</label>
                            <input type="text" class="txtBox" id="center_name" name="center_name" />  
                          
                              <input type="submit" class="search" style="float:right; margin-right:-20px;" id="submit5"/>
                    </div>
                    <div style="clear:both; padding:0 0 0 15px; margin-top:-40px; overflow:hidden; float:left;" id="highlight5"></div>
                    </div>
    </form>
    
    
    </div>
    
    
    
    <div id="sc6" class="tabcontent">
    
    <form action="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'Search.php');?>" method="get" name="form6" id="form6">
        
        <div id="pathological" class="content">
            <div class="formleft">
                <input type="hidden" name="search" value="Pathology" />
                <label>Centre Name:</label>
                <input type="text" class="txtBox" id="pathcentre" name="pathcentre" />
                <!--<label>Medical Test Types:</label>
                <select class="selectBox1" name="pathtest" id="pathtest">
                <option selected="selected" value="">-Select Test Type-</option>
                <option>Echo</option>
                <option>Holter</option>
                <option>Ncv</option>
                <option>Vep</option>
                </select>-->
            </div>
        
            <div class="formleft">
                <label>City:</label>
                <?php echo $area->getCityOptions($globalUtil,array('id'=>'city','name'=>'city','class'=>'selectBox1'),$optionselectedval='',$condition='');?>
            
            </div>
			<input type="hidden" name="page" id="page" value="0"/>
            <input type="submit" class="search" style="float:right;" id="submit6"/>
        
        
        <div style="clear:both; padding:0 0 0 15px; margin-top:-5px; overflow:hidden; float:left;" id="highlight6"></div>
        
        </div>
    </form>
    
    
    </div>
    
    
    </div>
   
    </div>
      
     </div>
    <!--header right end -->
    </div>
    <!--header  -->
    
    <!--body main start -->
      <div class="mainBody">
        <?php 
		
		if($latestDocs['numrows']>0){
		?>
        <h1>Latest Doctors Registered @ Doctor G Online</h1>
        <div class="topslide">
            <div class="slider">
                    <div class="gallery">
              <div class="holder">
            <ul style="margin-left: 0px;">
            <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-1.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-2.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-3.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-4.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-1.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-2.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-3.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-4.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
              <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-1.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-2.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-3.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-4.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-1.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-2.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-3.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
             <li> <img src="<?php echo IMAGES_URL;?>top-slide-pic-4.jpg" width="235" height="165" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 0px;" /></li>
              <?php //for($i=0;$i<$latestDocs['numrows'];$i++){?>
                
                
            <!-- <li><a href="<?php echo $doctor->doctorPublicUrl(array("id"=>$latestDocs['data'][$i]['doctorDetailsid'],"firstName"=>$latestDocs['data'][$i]['firstName'],"middleName"=>$latestDocs['data'][$i]['middleName'],"lastName"=>$latestDocs['data'][$i]['lastName']));?>"><?php if($latestDocs['data'][$i]['doctorImg']==''){?><img src="<?php echo IMAGES_URL."doctor.jpg";?>" height="165" alt="<?php echo $latestDocs['data'][$i]['firstName']." ".$latestDocs['data'][$i]['middleName']." ".$latestDocs['data'][$i]['lastName'];?>" /><?php } else {?><img src="<?php echo DOCTOR_IMG_URL."medium/".$latestDocs['data'][$i]['doctorImg'];?>" height="165" alt="<?php echo $latestDocs['data'][$i]['firstName']." ".$latestDocs['data'][$i]['middleName']." ".$latestDocs['data'][$i]['lastName'];?>" /><br /><?php }?><span class="sliderName"><?php echo $latestDocs['data'][$i]['firstName']." ".$latestDocs['data'][$i]['middleName']." ".$latestDocs['data'][$i]['lastName'];?></span></a></li>-->
             
             <?php //}?>
            </ul>
              </div>
              <a href="#" class="prev">prev</a>
                <a href="#" class="next">next</a>
                <div class="control">
                            <span class="info"></span>  </div>
            </div>
              </div>
        </div>
        <?php }?>
            
            
            <div class="midlepan">
                <div class="leftpan">
                    <!--<img src="<?php echo IMAGES_URL;?>left-google-ad.jpg" width="250" height="249" alt="" />-->
                    <script type="text/javascript"><!--
					google_ad_client = "ca-pub-9775737065620122";
					/* DoctorGonline Doctor Home Page Left Side */
					google_ad_slot = "5616981839";
					google_ad_width = 250;
					google_ad_height = 250;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
                    <div class="leftBottomBox">
                        <h2>Recently Registered Doctors</h2>
                        <div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
                        <div id="vmarquee" style="position: absolute; width: 98%;">
                        <!--YOUR SCROLL CONTENT HERE-->
                        
                               <ul>
                                                          
                                
                            </ul>
                        <!--YOUR SCROLL CONTENT HERE-->
                        </div>
                        </div>  
                        
                        
                    </div>
                </div>
                
              <div class="midpanel">
                
                <h2>Most Viewed Gallery <!--<span>(Residential Builders in India)</span>--></h2>
				<?php
				for($i=0;$i<count($sort_arr);$i++)
				{
				$your_values = array_values($sort_arr[$i]);
				$your_keys = array_keys($sort_arr[$i]);
			    /*echo "<pre>";
				print_r($your_values);*/
			if($your_keys[0]=='doctorImg' && $your_values[0]!='')
			{
			
		?>
        	 <div class="galleriBox">
             <span class="tooltip" onmouseover="tooltip.pop(this, '#demo2_tip<?php echo $i; ?>','<?php echo $i; ?>')">
             <a href="<?php echo $doctor->doctorPublicUrl(array("id"=>$your_values[5],"firstName"=>$your_values[2],"middleName"=>$your_values[3],"lastName"=>$your_values[4]));?>">
             <img src="<?php print DOCTOR_IMG_URL."small/".$your_values[0];?>"  width="100" height="100" alt=""  style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;"/>
             <!-- <p><?php echo $your_values[2]." ".$your_values[4];?></p>-->
             </a>
             </span>
             </div>
             <div style="display:none;">
             <div id="demo2_tip<?php echo $i; ?>" align="center">
                <b><u>Doctor Information</u></b><br /><br />
                <img src="<?php print DOCTOR_IMG_URL."small/".$your_values[0];?>"  width="100" height="100"  alt=""  style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />
                <br /><p><?php echo $your_values[2]." ".$your_values[3]." ".$your_values[4];?></p>
            </div>
        </div>
        <?php
			}
			else if($your_keys[0]=='doctorImg' && $your_values[0]=='')
			{
				?>
                <div class="galleriBox"> 
                 <span class="tooltip" onmouseover="tooltip.pop(this, '#demo2_tip<?php echo $i; ?>','<?php echo $i; ?>')">
                <a href="<?php echo $doctor->doctorPublicUrl(array("id"=>$your_values[5],"firstName"=>$your_values[2],"middleName"=>$your_values[3],"lastName"=>$your_values[4]));?>">
            <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />  </a>
            </span>
           		 </div>
              <div style="display:none;">
             <div id="demo2_tip<?php echo $i; ?>" align="center">
                <b><u>Doctor Information</u></b><br /><br />
                <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg"  width="100" height="100"  alt=""  style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />
                <br /><p><?php echo $your_values[2]." ".$your_values[3]." ".$your_values[4];?></p>
            </div>
        </div>
                <?php
				
			}
		 if($your_keys[0]=='hospitalImg' && $your_values[0]!='')
			{
		
		?>
        	<div class="galleriBox">
             <span class="tooltip" onmouseover="tooltip.pop(this, '#demo3_tip<?php echo $i; ?>','<?php echo $i; ?>')">
            <a href="<?php echo $hospital->hospitalPublicUrl(array("id"=>$your_values[3],"hospitalName"=>$your_values[2]));?>">
            <img src="<?php print HOSPITAL_IMG_URL."small/".$your_values[0];?>"  width="100" height="100" alt=""  style="border-color: #0075A0;
          border-radius: 6px; border-style: solid; border-width: 1px;" />
           <!-- <p><?php echo $your_values[2];?></p>-->
            </a>
            </span>
            </div>
            <div style="display:none;">
             <div id="demo3_tip<?php echo $i; ?>" align="center">
                <b><u>Hospital Information</u></b><br /><br />
                <img src="<?php print HOSPITAL_IMG_URL."small/".$your_values[0];?>"  width="100" height="100"  alt=""  style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />
                <br /><p><?php echo $your_values[2]." ".$your_values[3]." ".$your_values[4];?></p>
            </div>
        </div>
		<?php
			}
			else if($your_keys[0]=='hospitalImg' && $your_values[0]=='')
			{
				?>
                <div class="galleriBox"> 
             <span class="tooltip" onmouseover="tooltip.pop(this, '#demo3_tip<?php echo $i; ?>','<?php echo $i; ?>')">
            <a href="<?php echo $hospital->hospitalPublicUrl(array("id"=>$your_values[3],"hospitalName"=>$your_values[2]));?>">
            <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />  </a>
            </span>
           		 </div>
             <div style="display:none;">
             <div id="demo3_tip<?php echo $i; ?>" align="center">
                <b><u>Hospital Information</u></b><br /><br />
                <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg"  width="100" height="100"  alt=""  style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />
                <br /><p><?php echo $your_values[2]." ".$your_values[3]." ".$your_values[4];?></p>
            </div>
        </div>
                <?php
				
			}
			if($your_keys[0]=='pathologyCenterImg' && $your_values[0]!='')
			{
		?>
              <div class="galleriBox">
              <span class="tooltip" onmouseover="tooltip.pop(this, '#demo4_tip<?php echo $i; ?>','<?php echo $i; ?>')">
              <a href="<?php echo $pathology->pathologyPublicUrl(array("id"=>$your_values[3],"pathologycenterName"=>$your_values[2]));?>">
              <img src="<?php print PATHOLOGY_CENTER_IMG_URL."small/".$your_values[0];?>" width="100" height="100" alt=""  style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;"/>
              </a>
              </span>
              </div>
              <div style="display:none;">
              <div id="demo4_tip<?php echo $i; ?>" align="center">
                <b><u>Pathology Information</u></b><br /><br />
                <img src="<?php print PATHOLOGY_CENTER_IMG_URL."small/".$your_values[0];?>"  width="100" height="100"  alt=""  style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />
                <br /><p><?php echo $your_values[2]." ".$your_values[3]." ".$your_values[4];?></p>
            </div>
        </div>
           <?php
		    }
		  else if($your_keys[0]=='pathologyCenterImg' && $your_values[0]=='')
			{
				?>
                <div class="galleriBox"> 
            <span class="tooltip" onmouseover="tooltip.pop(this, '#demo4_tip<?php echo $i; ?>','<?php echo $i; ?>')">
              <a href="<?php echo $pathology->pathologyPublicUrl(array("id"=>$your_values[3],"pathologycenterName"=>$your_values[2]));?>">
            <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />  </a>
            </span>
           		 </div>
             <div style="display:none;">
              <div id="demo4_tip<?php echo $i; ?>" align="center">
                <b><u>Pathology Information</u></b><br /><br />
                <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg"  width="100" height="100"  alt="" title="<?php echo $your_values[2]." ".$your_values[4];?>" style="border-color: #0075A0;border-radius: 6px; border-style: solid; border-width: 1px;" />
                <br /><p><?php echo $your_values[2]." ".$your_values[3]." ".$your_values[4];?></p>
            </div>
        </div>
                <?php
				
			}
		
		   
		  }
			?>
			
				
				
               <!-- <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic1.jpg" width="100" height="100" alt="" />
                    <p>Hyderabad</p>
                </div>
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic2.jpg" width="100" height="100" alt="" />
                    <p>Delhi / NCR</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic3.jpg" width="100" height="100" alt="" />
                    <p>Indore / GWL</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic4.jpg" width="100" height="100" alt="" />
                    <p>Bhiwadi</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic5.jpg" width="100" height="100" alt="" />
                    <p>Delhi / NCR</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic6.jpg" width="100" height="100" alt="" />
                    <p>Delhi / NCR</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic7.jpg" width="100" height="100" alt="" />
                    <p>Delhi / NCR</p>
                </div>
                
               <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic8.jpg" width="100" height="100" alt="" />
                    <p>Chennai</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" />
                    <p>Location</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" />
                    <p>Location</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" />
                    <p>Location</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" />
                    <p>Location</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" />
                    <p>Location</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" />
                    <p>Location</p>
                </div>
                
                <div class="galleriBox">
                    <img src="<?php echo IMAGES_URL;?>gallery-pic9.jpg" width="100" height="100" alt="" />
                    <p>Location</p>
                </div>-->
             <br class="spacer" />
            <p class="midletxt"></p>
            <!--<img src="<?php echo IMAGES_URL;?>midle-google-ad.jpg" width="468" height="60" alt="" />-->
            <script type="text/javascript"><!--
			google_ad_client = "ca-pub-9775737065620122";
			/* DoctorGonline Home Page Bottom */
			google_ad_slot = "7093715034";
			google_ad_width = 468;
			google_ad_height = 60;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
            <p class="midletxt"></p>
            <!--<img src="<?php echo IMAGES_URL;?>midle-google-ad.jpg" width="468" height="60" alt="" />-->
            <script type="text/javascript"><!--
			google_ad_client = "ca-pub-9775737065620122";
			/* DoctorGonline Home Page Bottom */
			google_ad_slot = "7093715034";
			google_ad_width = 468;
			google_ad_height = 60;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
            </div>
                <div class="rightpanel">
                  <h2>Latest News</h2>
                  
                        
                     		 <ul class="latestnews">
                      	<?php
                        $latestnews=getlatestNews(); 
						if($latestnews['numrows']>0){
						for($i=0;$i<$latestnews['numrows'];$i++){
						?>
                        <li><font style="font-family:MyriadProCondensed; font-size:18px;"><a href="javascript:void(0);"><?php echo substr($latestnews['data'][$i]['topicName'],0,24); if(strlen($latestnews['data'][$i]['topicName'])>24){echo '...';}?></a></font></li>
                        <?php }
						 } else {?>
                        <li>No new updates available.</li>
						<?php }?>
                      </ul>
                      
                    
                     
                 <!--<img src="<?php echo IMAGES_URL;?>right-green-border.gif" class="greenBorder" width="182" height="6" alt="" />-->
                 
                 <!--<h2>Article</h2>-->
                             <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue. Curabitur varius adipiscing mauris vulputate posuere. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue. Curabitur.</p>
                 
               <p>  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue. Curabitur varius adipiscing mauris vulputate posuere.</p>-->
               
               <!--<img src="<?php echo IMAGES_URL;?>right-green-border.gif" class="greenBorder" width="182" height="6" alt="" />-->
                 
                 </div>
                
            </div>
            
     </div>
    <!--body main end -->
    <div class="footBottomBoxpan">
    
    <!--<div class="bottomBox">
    
    <span class="bottomleftBox">&nbsp;</span>
    <div class="bottomleftCon">
    <h2>FEATURED USERS REVIEWS</h2>
    <p><span>Mio Ameo, E M Bypass</span><br />
    <img src="<?php echo IMAGES_URL;?>green-star.gif" width="13" height="13" alt="" />
    <img src="<?php echo IMAGES_URL;?>green-star.gif" width="13" height="13" alt="" />
    <img src="<?php echo IMAGES_URL;?>green-star.gif" width="13" height="13" alt="" />
    <img src="<?php echo IMAGES_URL;?>yolow-star.gif" width="15" height="15" alt="" />
     by Cal Dg, yesterday<br />
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet<br /> 
      eros augue. Curabitur varius adipiscing .</p>
      
      <p><span>Mio Ameo, E M Bypass</span><br />
    <img src="<?php echo IMAGES_URL;?>green-star.gif" width="13" height="13" alt="" />
    <img src="<?php echo IMAGES_URL;?>green-star.gif" width="13" height="13" alt="" />
    <img src="<?php echo IMAGES_URL;?>green-star.gif" width="13" height="13" alt="" />
    <img src="<?php echo IMAGES_URL;?>yolow-star.gif" width="15" height="15" alt="" />
     by Cal Dg, yesterday<br />
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet<br /> 
      eros augue. Curabitur varius adipiscing .</p>
      
      <a href="#" class="viewmore">View More</a>
      </div>
    <span class="bottomleftBoxBottom">&nbsp;</span>
    
    </div>-->
    
    
    
    <!--<div class="bottomBox bottomBox1">
    
    <span class="bottomleftBox">&nbsp;</span>
    <div class="bottomleftCon">
    <h3>RECENTLY ADDED FORUM TOPICS</h3>
    
     <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue. Curabitur varius adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue.</p>
     
    <p> Fusce sit amet eros augue. Curabitur varius adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce sit amet eros augue.</p>
    
    <a href="#" class="viewmore">View More</a>
      
      
      
    </div>
    <span class="bottomleftBoxBottom">&nbsp;</span>
    
    </div>-->
    
    
    
    
    </div>
    </div>
    <!--main content end -->
    
    <!--footer start -->
	<?php include(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."footer.php");?>
	<!--footer end -->
</body>

</html>