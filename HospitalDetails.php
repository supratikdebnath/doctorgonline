<?php require('includes/connection.php');?>
<?php require(PROJECT_DOCUMENT_PATH.CONTROLLER_FOLDER.CONTROLLER_HospitalDetails);?>
<?php //echo "<pre>";print_r($hospitalDetails);echo "<pre>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<title><?php echo SITE_TITLE;?> - Hospital Profile - <?php echo $hospitalDetails['data'][0]['hospitalName'];?></title>
<?php include(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."commonHead.php");?>
<!-- Lightbox panel css starts -->
<link href="<?php echo CSS_URL;?>lightBox.css" rel="stylesheet" type="text/css" />
<!-- Lightbox panel css ends -->
<script type="text/javascript" src="<?php echo JS_URL;?>jquery.form.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<!--<script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>-->
<script language="JavaScript">
$(document).ready(function() {

    $(".tabs .tab[id^=tab_menu]").click(function() {
        var curMenu=$(this);
        $(".tabs .tab[id^=tab_menu]").removeClass("selected");
        curMenu.addClass("selected");

        var index=curMenu.attr("id").split("tab_menu_")[1];
        $(".curvedContainer .tabcontent").css("display","none");
        $(".curvedContainer #tab_content_"+index).css("display","block");
    });
        
	 $.ajax({url: 'http://maps.googleapis.com/maps/api/geocode/json', 
	           data: {sensor : false, address : '<?php echo $googleMapAddressString;?>'},
			   dataType:'json',
			   success: function(data) { 
		     if(data.status=='OK'){
			 var latitude=data.results[0].geometry.location.lat;
			 var longitude=data.results[0].geometry.location.lng;
			 var formatted_address=data.results[0].formatted_address;
			 //alert(latitude+'/'+longitude);
			 showGMap(latitude,longitude,formatted_address);
			 //showGMap1(latitude,longitude);
			 }
			}});
			
	
});

function showGMap(latitude,longitude,formatted_address){  
   var address='<?php echo $googleMapAddressParameter;?>';
   var q=address.replace(/(\r\n|\n|\r)/gm,"");
   var gmapUrl=	'http://maps.google.com/maps?oe=UTF-8&hl=en&ie=UTF8&hq=&hnear=&ll='+latitude+','+longitude+'&sll='+latitude+','+longitude+'&spn=0.025358,0.06609&q='+q+'&hnear='+formatted_address+'&aq=&t=m&z=14&iwloc=near&markers=color:red&output=embed&center=0.025358,0.06609';	
   //alert(gmapUrl);
   $('#GMap').attr('src',gmapUrl);
}
</script>
<script type="text/javascript">
$(document).ready(function(){
 $('#loading').hide();
});

function wall(){
$('#loading').show();

  var name = $('#name').val();///#name is the input id from the form and will be equal the variable "name"
  var comment = $('#comment').val();/////#comment is textarea id from the form and will be equal the variable "comment"
  var URL = "post.html"; /////post.html will be equal the variable "comment"
  
  $.post(URL,{wall:"post",name1:name,comment1:comment},function(data){//parameter wall will be equal "post", name1 will be equal to the var "name" and comment1 will be equal to the var "comment"
  $("#result").prepend(data).show();// the result will be placed above the the #result div
  $('#loading').hide();
  });
 }
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#lightbox").hide();
$("#editphoto").click(function(){
	$("#lightbox").show();
});
$("#close-panel").click(function(){
	$("#lightbox").hide();
});
$('#file').live('change', function(){
$("#imageform").ajaxForm({
target: '#putpic'
}).submit();
//$("#lightbox, #lightbox-panel").fadeOut(300);
$("#lightbox").hide();
//$("#close-panel").hide();
});
});

</script>
</head>
<body class="innerBody">
<!--main content start -->
<div id="wrapper">

       <div class="header header1">
<div class="headerLeft"><a href="<?php echo $globalUtil->generateUrl(MAIN_SITE_URL.'index.php');?>"><img src="<?php echo IMAGES_URL;?>logo.gif" width="316" height="120" alt="" /></a>
</div>
<!--header right start -->
<div class="headerRight">
<?php require(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."loginmenu.php");?>
</div>
<!--header right end -->
</div>
<!--header  -->
<!--body main start -->
  <div class="mainBody mainBody1">
	 <div class="midlepan midlepan1">
		<div class="profileTop">
		        <div class="profileLeft">
                  <div class="profileBoxleft profileBoxleft1">
               	  <span class="profileleftTop">&nbsp;</span>
                    <div class="profileimgCon">
                   		<span id="putpic"><img src="<?php if($hospitalDetails['data'][0]['hospitalImg']==''){?><?php echo IMAGES_URL."hospital.gif";?><?php }else{?><?php echo DOCTOR_IMG_URL."medium/".$hospitalDetails['data'][0]['hospitalImg'];}?>" style="height:203px; width:165px; padding: 0 0 0 2px;" alt="<?php echo $hospitalDetails['data'][0]['hospitalName'];?>"> </span>
                    	<!--<h4 id="editphoto" style="cursor:pointer;">Change Photo</h4>-->
                    </div>
                	<span class="profileBottomCurve">&nbsp;</span>
                
                
                </div>
                 <p class="profilelink"></p>
             
                </div>
                <div id="lightbox">
                <div id="lightbox-panel">
                    
                     
                    
                    <div style="border:1px solid #c1d2e6; float:left; width:100%; padding:10px 0;">
                    <form id="imageform" method="post" enctype="multipart/form-data" action='docedit_photo.html'>
                    <!--<label for="file"></label>
                    <input type="file" name="file" id="file"/> -->
                    </form>
                    </div>
                    <div id="displayerror_r"></div>
                </div>
                <!-- /lightbox-panel -->
                <div id="lightbox-panel2">
                <!--<input type="button" value="" class="cross" id="close-panel" />-->
                </div>
                
          </div>
           <!-- <div id="claim" style="display:none">
            <form action="claim.html" method="post" id="claim1">
             		<label>Name:</label>
                    <input type="text" class="ayainputbg" id="name_c"  name="name_c"  /><br />                    
             		<label>Email:</label>
                    <input type="text" class="ayainputbg" id="email_c"  name="email_c"  /><br/>
                    <label>Contact No.:</label>
                    <input type="text" class="ayainputbg" id="contact_c"  name="contact_c"  /><br/>
                    <label>Message:</label>
                    <textarea class="ayatextareasmallbg" name="message_c" id="message_c"></textarea><br/>
            		<input type="submit" value="Submit" id="submit2" style="float:right; " /><br/>
            		<div id="displayerror_r"></div>
            </form>
            
            </div> -->
                <div class="profileRight">
                  <div class="profileRightLeft">
                    <div class="profileRightLeft">
                    <h2>Welcome to <?php echo $hospitalDetails['data'][0]['hospitalName'];?> Profile</h2>
                    <p>Type : <span class="green">Govt</span><br />
                    Category :<span class="green">General</span></p>
                    <p> Discipline: <span>Allopathic Ayurvedic Unani Homeopathic</span><br />
    Address: <span><?php echo $hospitalDetails['data'][0]['address'].$hospitalGeoLocationForAddress;?></span><br />
      
    
    City:<span> <?php echo $hospitalGeoLocation['cityName'];?>
    </span><br />
    Pincode:<span> <?php echo $hospitalDetails['data'][0]['pincode'];?>
    </span><br />
    Phone:<span> <?php echo $hospitalDetails['data'][0]['phoneNo'];?>
    </span><br />
    Fax No:<span> <?php echo $hospitalDetails['data'][0]['fax'];?>
    </span><br />
    Website: <span><a href="<?php echo $hospitalDetails['data'][0]['website'];?>" class="doctoremaillink" target="_blank"><?php echo $hospitalDetails['data'][0]['website'];?></a></span></p>
              <br class="spacer"/>
    <div class="facebookpan">
                  <!--<img src="images/face-book-like.jpg" width="139" height="31" alt="" />-->
                  
                   <!--<img src="images/face-book-share.jpg" width="115" height="31" alt="" /> --> 
                   </div>
                   
                   </div>
                  </div>
                   <div class="googleadsense">
				   <script type="text/javascript"><!--
					google_ad_client = "ca-pub-9775737065620122";
					/* DoctorGonline Doctor Details Page */
					google_ad_slot = "6591931437";
					google_ad_width = 336;
					google_ad_height = 280;
					//-->
					</script>
					<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>
										</div>
                    <br class="spacer" />
                    <div class="profileBorder">
                    <ul>
                        <!--<li><img src="<?php echo IMAGES_URL;?>profile-right-icon_1.jpg" width="35" height="24" alt="" /> User review</li>-->
                        <?php if($hospitalDetails['data'][0]['registrationNo']!=''){?>
                        <li><img src="<?php echo IMAGES_URL;?>govt.jpg" width="35" height="24" alt="" /> Government Registered</li><?php }?>
                        <?php if($hospitalDetails['data'][0]['available24Hrs']=='Y'){?>
                        <li><img src="<?php echo IMAGES_URL;?>24hrs.jpg" width="35" height="24" alt="" /> 	24hrs Availability</li><?php }?>
                        <?php if($hospitalDetails['data'][0]['creditCardAccept']=='Y'){?>
                        <li class="nomarg"><img src="<?php echo IMAGES_URL;?>card.jpg" width="35" height="24" alt="" /> Credit Card</li><?php }?>
                    
                    </ul>
                    
       
                    
     <br class="spacer" /> 
     </div>
                
                </div>
            <br class="spacer" /> 
        </div>
        <div class="profiletabpan">                
        <div class="tabscontainer">
     <div class="tabs">
         <div class="tab selected first" id="tab_menu_1">
             <div class="link">Diagnostic Details</div>
             <div class="arrow"></div>
         </div>
         <!--
         <div class="tab" id="tab_menu_2">
             <div class="link">Department Info</div>
             <div class="arrow"></div>
         </div>
          <div class="tab last" id="tab_menu_4">
             <div class="link">Detailed Room Info</div>
             <div class="arrow"></div>
         </div>
         
         <div class="tab last" id="tab_menu_5">
             <div class="link">Basic Doctor data</div>
             <div class="arrow"></div>
         </div>
         -->
         
         <div class="tab last" id="tab_menu_3">
             <div class="link">Pathology Information</div>
             <div class="arrow"></div>
         </div>
         <!--
         <div class="tab last" id="tab_menu_6">
             <div class="link">Health Package Info</div>
             <div class="arrow"></div>
         </div>
          <div class="tab last" id="tab_menu_7">
             <div class="link">Health Insurence Comp.</div>
             <div class="arrow"></div>
         </div>
         <div class="tab last" id="tab_menu_8">
             <div class="link">One Person Contact</div>
             <div class="arrow"></div>
         </div>
          <div class="tab last" id="tab_menu_9">
             <div class="link">Reviews</div>
             <div class="arrow"></div>
         </div>
         -->
         <div class="tab last" id="tab_menu_11">
             <div class="link">Map</div>
             <div class="arrow"></div>
         </div>
		<!--          
		<div class="tab last" id="tab_menu_10">
             <div class="link">Account Settings</div>
             <div class="arrow"></div>
        </div>
        -->
         
    </div>
	<div class="curvedContainer">
		<div class="tabcontent" id="tab_content_1" style="display:block">
				<h2 class="profileRighttitle">Diagnostic Details</h2>
				<div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
				
				 
                 <div style="width:240px; float:left; padding-right:10px;">
                 <p class="tabtxt" style="color:#6b8d99; font-size:14px;">
                 <b>Email: </b><br/><br/>
                 <b>Alternate Email: </b><br/><br/>
                 <b>Landline No: </b><br/><br/>
                 <b>Alternate No: </b><br/><br/>
                 <b>Fax No: </b><br/><br/>
                 <b>Website: </b><br/><br/>
                 <b>Govt. Reg No: </b><br/><br/>
                 <b>About Us: </b><br/><br/>
           
                 </p>
                 </div>
                 
                 <div style="width:400px; float:left; font-size:14px;">
                <?php echo $hospitalDetails['data'][0]['emailAlternate'];?><br/><br/>
                <?php echo $hospitalDetails['data'][0]['emailAlternate'];?><br/><br/>
                <?php echo $hospitalDetails['data'][0]['phoneNo'];?><br/><br/>
                <?php echo $hospitalDetails['data'][0]['phoneNoAlternate'];?><br/><br/>
                <?php echo $hospitalDetails['data'][0]['fax'];?><br/><br/>
                <?php echo $hospitalDetails['data'][0]['website'];?><br/><br/>
                <?php echo $hospitalDetails['data'][0]['registrationNo'];?><br/><br/>
                <?php echo nl2br(strip_tags(stripslashes($hospitalDetails['data'][0]['about'])));?><br/>
				</div>
                

                
 </div>
        <span class="profileBottom">&nbsp;</span>
            
		</div>
        <div class="tabcontent" id="tab_content_3">
			
                <h2 class="profileRighttitle">Pathology Information</h2>
				<div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                 <p class="tabtxt">
                 <div style="width:240px; float:left; padding-right:10px;">
                 <p class="tabtxt" style="color:#6b8d99; font-size:14px;">
                 <b>Year of Establishment: </b><br/><br/>
                 <b>Contact No: </b><br/><br/>
                 <b>Accreditation : </b><br/><br/>
                 <b>Open All Days : </b><br/><br/>
                 <b>Closed On : </b><br/><br/>
                 <b>Facilities : </b><br/><br/>
                 <b>Any Tie-Ups with Specialised Labs: </b><br/><br/>
                 <b>Extra Charges(if Any): </b><br/><br/>
                 <b>Home Collection(if Any): </b><br/><br/>
           
                 </p>
                 </div>
                 <div style="width:400px; float:left; font-size:14px;">
                <?php echo $hospitalPathology['data'][0]['yearofEstablishment'];?><br/><br/>
                <?php echo $hospitalPathology['data'][0]['contactNo'];?><br/><br/>
                <?php echo $hospitalPathologyAccreditionName;?><br/><br/>
                <?php if($hospitalPathology['data'][0]['openAllDays']=='1'){echo "Yes";}else{ echo "No";};?><br/><br/>
                <?php echo $hospitalPathology['data'][0]['closedOn'];?><br/><br/>
                <?php $hospitalUserFacilities=explode(',',$hospitalPathology['data'][0]['pfids']);
				      $noOfHospitalFacilities=count($hospitalUserFacilities);
					  $hfi=0;
					  foreach($hospitalUserFacilities as $key=>$hospitalFacilities){ 
					  echo $hospitalFacilities; 
					  if($noOfHospitalFacilities!=$hfi+1)
						  {echo ' | ';} 
						  $hfi++;
						  }
					  ?>
                      <br/><br/>
                <?php echo $hospitalPathology['data'][0]['tieUpsLabs'];?><br/><br/>
                <?php echo $hospitalPathology['data'][0]['extraCharges'];?><br/></br/>
                <?php echo $hospitalPathology['data'][0]['homeCollection'];?><br/></br/>
				</div>
                  <br />
                 </p>
        </div>
        <span class="profileBottom">&nbsp;</span>
        </div>
        <div class="tabcontent" id="tab_content_11">
                <h2 class="profileRighttitle">Map</h2>
				<div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                 <p class="tabtxt">
                   <iframe width="770" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="GMap"></iframe>
                 </p>
				</div>
        <span class="profileBottom">&nbsp;</span> 
		</div>
     </div>    
  </div>
</div>
<!--main content end -->
<!--footer start -->
<?php include(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."footer.php");?>
<!--footer end -->
</body>
</html>
