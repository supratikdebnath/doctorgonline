<?php require('includes/connection.php');?>
<?php require(PROJECT_DOCUMENT_PATH.CONTROLLER_FOLDER.CONTROLLER_DoctorDetails);?>
<?php //echo "<pre>";print_r($doctorDetails);echo "<pre>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<title><?php echo SITE_TITLE;?> - Doctor Profile - <?php echo "Dr. ".$doctorDetails['data'][0]['firstName']." ".$doctorDetails['data'][0]['middleName']." ".$doctorDetails['data'][0]['lastName'];?></title>
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
	           data: {sensor : false, address : '<?php echo $globalUtil->removeLineBreakHTML(str_replace(array(' ','-','_','&'),'+',$doctorDetails['data'][0]['address']));?><?php echo $doctorGeoLocationString;?>'},
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
   var gmapUrl=	'http://maps.google.com/maps?oe=UTF-8&hl=en&ie=UTF8&hq=&hnear=&ll='+latitude+','+longitude+'&sll='+latitude+','+longitude+'&spn=0.025358,0.06609&q=<?php echo $globalUtil->removeLineBreakHTML(str_replace(' ','+',$doctorDetails['data'][0]['address']));?>&hnear='+formatted_address+'&aq=&t=m&z=14&iwloc=near&markers=color:red&output=embed&center=0.025358,0.06609';	
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
                   		<span id="putpic"><img src="<?php if($doctorDetails['data'][0]['doctorImg']==''){?><?php echo IMAGES_URL."doctor.jpg";?><?php }else{?><?php echo DOCTOR_IMG_URL."medium/".$doctorDetails['data'][0]['doctorImg'];}?>" style="height:203px; width:165px; padding: 0 0 0 2px;" alt="<?php echo $doctorDetails['data'][0]['firstName']." ".$doctorDetails['data'][0]['middleName']." ".$doctorDetails['data'][0]['lastName'];?>"> </span>
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

                <div class="brandblk">
              
              	<h2>Welcome to <?php echo "Dr. ".$doctorDetails['data'][0]['firstName']." ".$doctorDetails['data'][0]['middleName']." ".$doctorDetails['data'][0]['lastName'];?>'s Profile</h2>
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>address.png" /></span>Name:</p>
				<p class="proright"><?php echo "Dr. ".$doctorDetails['data'][0]['firstName']." ".$doctorDetails['data'][0]['middleName']." ".$doctorDetails['data'][0]['lastName'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>address.png" /></span>Address:</p>
				<p class="proright"><?php echo $doctorDetails['data'][0]['address'].$doctorGeoLocationForAddress;?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Land_phone.png" /></span>Phone :</p>
				<p class="proright"><?php echo $doctorDetails['data'][0]['phoneNo'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Mobile.png" /></span>Mobile :</p>
				<p class="proright"><?php echo $doctorDetails['data'][0]['mobileNo'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Fax.png" /></span>Fax:</p>
				<p class="proright"><?php echo $doctorDetails['data'][0]['fax'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span>Website:</p>
				<p class="proright"><a href="<?php echo $doctorDetails['data'][0]['website'];?>" class="doctoremaillink" target="_blank"><?php echo $doctorDetails['data'][0]['website'];?></a></p>
                
                <br class="spacer" />
                

			</div>
                <!--<p>Address : <span class="green">207, Sunit Banerjee Road, Ghola</span><br />
                City : <span class="green">8 </span><br />
Phone : <span class="green"> </span><br />
Registration No. : <span class="green"> 123456789</span></p>-->
                </div>
                <!--<div style="width:250px; float:left;">
                 <br />                
                <br />
                <br/>
               <a href="http://" target="_blank"></a><br/>
                </div>-->
                <div class="facebookpan"></div>
                   <!--<img src="<?php echo IMAGES_URL;?>google-adsence.jpg" class="googleadsence" width="319" height="187" alt="" />-->
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
                        <?php if($doctorDetails['data'][0]['registrationNo']!=''){?>
                        <li><img src="<?php echo IMAGES_URL;?>govt.jpg" width="35" height="24" alt="" /> Government Registered</li><?php }?>
                        <?php if($doctorDetails['data'][0]['available24Hrs']=='Y'){?>
                        <li><img src="<?php echo IMAGES_URL;?>24hrs.jpg" width="35" height="24" alt="" /> 	24hrs Availability</li><?php }?>
                        <?php if($doctorDetails['data'][0]['creditCardAccept']=='Y'){?>
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
                     <div class="link">Info</div>
                     <div class="arrow"></div>
                 </div>
                 <div class="tab last" id="tab_menu_4">
                     <div class="link">Qualification</div>
                     <div class="arrow"></div>
                 </div>
                 <div class="tab" id="tab_menu_2">
                     <div class="link">Map</div>
                     <div class="arrow"></div>
                 </div>
                 <div class="tab" id="tab_menu_3">
                     <div class="link">Doctor Chamber</div>
                     <div class="arrow"></div>
                 </div>
                 <!--<div class="tab" id="tab_menu_5">
                     <div class="link">Personal Details</div>
                     <div class="arrow"></div>
                 </div>-->
                 <!--<div class="tab" id="tab_menu_6">
                     <div class="link">Work Experience</div>
                     <div class="arrow"></div>
                 </div>-->
                 <!--<div class="tab" id="tab_menu_7">
                     <div class="link">Reviews</div>
                     <div class="arrow"></div>
                 </div>-->
            </div>
            <div class="curvedContainer">
                <div class="tabcontent" id="tab_content_1" style="display:block">
                        <h2 class="profileRighttitle">Doctor's Info</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                         
                          <div class="brandblk brandblk1">
                          
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>email.png" /></span><strong>Email:</strong></p>
                            <p class="proright"><a href="mailto:<?php echo $doctorDetails['data'][0]['emailAlternate'];?>" class="doctoremaillink"><?php echo $doctorDetails['data'][0]['emailAlternate'];?></a></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>alternet_email.png" /></span><strong>Alternate Email:</strong></p>
                            <p class="proright"><a href="mailto:<?php echo $doctorDetails['data'][0]['emailAlternate'];?>" class="doctoremaillink"><?php echo $doctorDetails['data'][0]['emailAlternate'];?></a></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>alternet_email.png" /></span><strong>Date of Birth:</strong></p>
                            <p class="proright"><?php echo date("d/m/Y",strtotime($doctorDetails['data'][0]['dateOfBirth']));?></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>alternet_email.png" /></span><strong>Gender:</strong></p>
                            <p class="proright"><?php echo $doctorDetails['data'][0]['gender']; ?></p>
                        
                            <br class="spacer" />
                            
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>alternet_email.png" /></span><strong>Designation:</strong></p>
                            <p class="proright"><?php echo $doctorDetails['data'][0]['designation']; ?></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Mobile.png" /></span><strong>Mobile No:</strong></p>
                            <p class="proright"><?php echo $doctorDetails['data'][0]['mobileNo'];?></p>
                        
                            <br class="spacer" />
                        
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Land_phone.png" /></span><strong>Landline No:</strong></p>
                            <p class="proright"><?php echo $doctorDetails['data'][0]['phoneNo'];?></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Land_phone.png" /></span><strong>Alternate No:</strong></p>
                            <p class="proright"><?php echo $doctorDetails['data'][0]['phoneNoAlternate'];?></p>
                        
                            <br class="spacer" />
                            
                           <p class="proleft"> <span><img src="<?php echo IMAGES_URL;?>Fax.png" /></span><strong>Fax: </strong></p>
                           <p class="proright"><?php echo $doctorDetails['data'][0]['fax'];?></p>
                                <br class="spacer" />
                                
                                <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Website:</strong></p>
                                <p class="proright"><a href="<?php echo $doctorDetails['data'][0]['website'];?>" class="doctoremaillink" target="_blank"><?php echo $doctorDetails['data'][0]['website'];?></a></p>
                                <br class="spacer" />
                                
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Govt_reg.png" /></span><strong>Govt. Reg No:</strong></p>
                            <p class="proright"><?php echo $doctorDetails['data'][0]['registrationNo'];?></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>email.png" /></span><strong>Experience:</strong></p>
                            <p class="proright1"><?php echo $doctorDetails['data'][0]['yearsOfExp'];?> Years</p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>about_us.png" /></span><strong>About Me:</strong></p>
                            <p class="proright1"><?php echo nl2br(strip_tags(stripslashes($doctorDetails['data'][0]['about'])));?></p>
                            
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>about_us.png" /></span><strong>Consultancy Fees:</strong></p>
                            <p class="proright1"><?php echo $doctorDetails['data'][0]['consultancyFees'];?></p>
                            
                            <br class="spacer" />
                         </div>         
                        </div>
                        <span class="profileBottom">&nbsp;</span>
                </div>
                <div class="tabcontent" id="tab_content_2">
                    
                        <h2 class="profileRighttitle">Map</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        
                         <p class="tabtxt"><iframe width="770" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="GMap"></iframe></p>
        
        
                </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>       
                <div class="tabcontent" id="tab_content_3">
                    
                        <h2 class="profileRighttitle">Doctor Chamber</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        <center>
                        <table width="90%" cellspacing="0" cellpadding="0" border="1" align="center" class="" style="border:#666666; border-width:1px; border-style:solid;">   
             <tbody>
                <tr style="background-color:#507cd1; color:#fff;">
                    <th nowrap="nowrap" bgcolor="#8ADFFF"><strong><font color="#000000">Name</font></strong></th>
                    <th nowrap="nowrap"bgcolor="#8ADFFF"><strong><font color="#000000">Contact</font></strong></th>
                    <th nowrap="nowrap"bgcolor="#8ADFFF"><strong><font color="#000000">Address</font></strong></th>
                    <th nowrap="nowrap"bgcolor="#8ADFFF"><strong><font color="#000000">Mon</font></strong></th>
                    <th nowrap="nowrap"bgcolor="#8ADFFF"><strong><font color="#000000">Tue</font></strong></th>
                    <th nowrap="nowrap"bgcolor="#8ADFFF"><strong><font color="#000000">Wed</font></strong></th>
                    <th nowrap="nowrap"bgcolor="#8ADFFF"><strong><font color="#000000">Thur</font></strong></th>
                    <th nowrap="nowrap" bgcolor="#8ADFFF"><strong><font color="#000000">Fri</font></strong></th>
                    <th nowrap="nowrap" bgcolor="#8ADFFF"><strong><font color="#000000">Sat</font></strong></th>
                    <th nowrap="nowrap" bgcolor="#8ADFFF"><strong><font color="#000000">Sun</font></strong></th>
                    <th nowrap="nowrap" bgcolor="#8ADFFF"><strong><font color="#000000">Facilities</font></strong></th>
                    <th nowrap="nowrap" bgcolor="#8ADFFF"><strong><font color="#000000">Fees</font></strong></th>
                    <th nowrap="nowrap" bgcolor="#8ADFFF"><strong><font color="#000000">Home Visit Fees</font></strong></th>
                 </tr>
                 <?php 
                 //echo "<pre>";print_r($doctorDetails['data'][0]['clinicinfo']);echo "</pre>";die();
				 $count=0;
                 if($doctorDetails['data'][0]['clinicinfo']['numrows']>0){
                     
                 for($i=0;$i<count($doctorDetails['data'][0]['clinicinfo']['data']);$i++){
         
                 $dayMonMor=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayMonMor']);
                 $dayMonMorTiming= ($dayMonMor[0]=='' || $dayMonMor[1]=='') ? 'NA' : $dayMonMor[0]." to ".$dayMonMor[1];
                 
                 
                 $dayMonEve=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayMonEve']);
                 $dayMonEveTiming= ($dayMonEve[0]=='' || $dayMonEve[1]=='') ? 'NA' : $dayMonEve[0]." to ".$dayMonEve[1];
                 
                 $dayTueMor=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayTueMor']);
                 $dayTueMorTiming= ($dayTueMor[0]=='' || $dayTueMor[1]=='') ? 'NA' : $dayTueMor[0]." to ".$dayTueMor[1];
                 
                 $dayTueEve=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayTueEve']);
                 $dayTueEveTiming= ($dayTueEve[0]=='' || $dayTueEve[1]=='') ? 'NA' : $dayTueEve[0]." to ".$dayTueEve[1];
                 
                 $dayWedMor=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayWedMor']);
                 $dayWedMorTiming= ($dayWedMor[0]=='' || $dayWedMor[1]=='') ? 'NA' : $dayWedMor[0]." to ".$dayWedMor[1];
                 
                 $dayWedEve=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayWedEve']);
                 $dayWedEveTiming= ($dayWedEve[0]=='' || $dayWedEve[1]=='') ? 'NA' : $dayWedEve[0]." to ".$dayWedEve[1];
                 
                 $dayThurMor=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayThurMor']);
                 $dayThurMorTiming= ($dayThurMor[0]=='' || $dayThurMor[1]=='') ? 'NA' : $dayThurMor[0]." to ".$dayThurMor[1];
                 
                 $dayThurEve=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayThurEve']);
                 $dayThurEveTiming= ($dayThurEve[0]=='' || $dayThurEve[1]=='') ? 'NA' : $dayThurEve[0]." to ".$dayThurEve[1];
                 
                 $dayFriMor=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayFriMor']);
                 $dayFriMorTiming= ($dayFriMor[0]=='' || $dayFriMor[1]=='') ? 'NA' : $dayFriMor[0]." to ".$dayFriMor[1];
                 
                 $dayFriEve=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['dayFriEve']);
                 $dayFriEveTiming= ($dayFriEve[0]=='' || $dayFriEve[1]=='') ? 'NA' : $dayFriEve[0]." to ".$dayFriEve[1];
                 
                 $daySatMor=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['daySatMor']);
                 $daySatMorTiming= ($daySatMor[0]=='' || $daySatMor[1]=='') ? 'NA' : $daySatMor[0]." to ".$daySatMor[1];
                 
                 $daySatEve=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['daySatEve']);
                 $daySatEveTiming= ($daySatEve[0]=='' || $daySatEve[1]=='') ? 'NA' : $daySatEve[0]." to ".$daySatEve[1];
                 
                 $daySunMor=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['daySunMor']);
                 $daySunMorTiming= ($daySunMor[0]=='' || $daySunMor[1]=='') ? 'NA' : $daySunMor[0]." to ".$daySunMor[1];
                 
                 $daySunEve=$globalUtil->stringtoArr(',',$doctorDetails['data'][0]['clinicinfo']['data'][$i]['daySunEve']);
                 $daySunEveTiming= ($daySunEve[0]=='' || $daySunEve[1]=='') ? 'NA' : $daySunEve[0]." to ".$daySunEve[1];
				 
				 $count++;
			     ($count%2 == 0) ? $tr_class = "#CAD6E6" : $tr_class = "";
                 ?>
                 <tr bgcolor="<?php echo $tr_class; ?>">
                    <td align="center"><?php echo $doctorDetails['data'][0]['clinicinfo']['data'][$i]['clinicName'];?></td>
                    <td align="center"><?php echo $doctorDetails['data'][0]['clinicinfo']['data'][$i]['clinicPhoneNumber'];?></td>
                    <td align="center"><?php echo $doctorDetails['data'][0]['clinicinfo']['data'][$i]['clinicAddress'];?></td>
                    <td align="center"><b><i>Morn:</i></b> <?php echo $dayMonMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayMonEveTiming;?> </td>
                    <td align="center"><b><i>Morn:</i></b> <?php echo $dayTueMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayTueEveTiming;?> </td>
                    <td align="center"><b><i>Morn:</i></b> <?php echo $dayWedMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayWedEveTiming;?> </td>
                    <td align="center"><b><i>Morn:</i></b> <?php echo $dayThurMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayThurEveTiming;?> </td>
                    <td align="center"><b><i>Morn:</i></b> <?php echo $dayFriMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $dayFriEveTiming;?> </td>
                    <td align="center"><b><i>Morn:</i></b> <?php echo $daySatMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $daySatEveTiming;?> </td>
                    <td align="center"><b><i>Morn:</i></b> <?php echo $daySunMorTiming;?> <b><i><br />Eve:</i></b> <?php echo $daySunEveTiming;?> </td>
                    <td align="center"><?php
                    if($doctorDetails['data'][0]['clinicinfo']['data'][$i]['xray']=='Y') { echo 'X-Ray<br />';}
                    if($doctorDetails['data'][0]['clinicinfo']['data'][$i]['creditCardAccept']=='Y') { echo 'Credit Card<br />';}
                    if($doctorDetails['data'][0]['clinicinfo']['data'][$i]['emergency']=='Y') { echo 'Emergency<br />';}
                    if($doctorDetails['data'][0]['clinicinfo']['data'][$i]['ownUnit']=='Y') { echo 'Own Unit<br />';}
                    if($doctorDetails['data'][0]['clinicinfo']['data'][$i]['homeVisit']=='Y') { echo 'Home Visit<br />';}
                    
                    ?></td>
                    <td align="center"><?php echo $doctorDetails['data'][0]['clinicinfo']['data'][$i]['clinicCharges'];?></td>
                    <td align="center"><?php
                    if($doctorDetails['data'][0]['clinicinfo']['data'][$i]['homeVisit']=='Y') {
                        echo $doctorDetails['data'][0]['clinicinfo']['data'][$i]['homeVisitCharges']; 
                        }
                    ?></td>
                </tr>
                 
                 <?php }
                 }
                 else{
                 ?>
                 <tr><td colspan="13" height="8px">No records found.</td></tr>
                 <?php
                 }
                 ?>	
            </tbody>
        </table>
                        </center>
                </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>
                <div class="tabcontent" id="tab_content_4">
                    
                        <h2 class="profileRighttitle">Qualifications</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                         <p class="tabtxt">
        <?php 
		if($doctorQualificationList['numrows']>0){
			$count=0;
		?>
         <table cellpadding="0" cellspacing="0" width="90%" style="border:#666666; border-width:1px; border-style:solid;" id="docSpecification" align="center">
    	<tr style="background-color:#507cd1; color:#fff; font-weight:bold;">
        	<td align="center" bgcolor="#8ADFFF"><font color="#000000">Qualification</font></td>
            <td align="center" bgcolor="#8ADFFF"><font color="#000000">Specialization</font></td>
            <td align="center" bgcolor="#8ADFFF"><font color="#000000">Institute</font></td>
            <td align="center" bgcolor="#8ADFFF"><font color="#000000">Yr. of Completition</font></td>
        </tr>
        <?php
		for($i=0;$i<$doctorQualificationList['numrows'];$i++){
			 $count++;
			($count%2 == 0) ? $tr_class = "#CAD6E6" : $tr_class = "";
			?>
        <tr id="trqid<?php echo $doctorQualificationList['data'][$i]['docqid'];?>" bgcolor="<?php echo $tr_class; ?>">
        	<td align="center"><?php echo $doctorQualificationList['data'][$i]['qualificationName'];?></td>
            <td align="center"><?php echo $doctorQualificationList['data'][$i]['specName'];?></td>
            <td align="center"><?php echo $doctorQualificationList['data'][$i]['instituteName'];?></td>
            <td align="center"><?php echo $doctorQualificationList['data'][$i]['yearOfCompletion'];?></td>
        </tr>
        <?php 
			}	
		?>
    </table>
    <?php 	} ?>
                         </p>
                </div>
                <span class="profileBottom">&nbsp;</span>
                </div>
                
                <!--<div class="tabcontent" id="tab_content_5">
                     <h2 class="profileRighttitle">Personal Details</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        <div class="profileRightForm">
                       <p class="tabtxt"></p>
        
        </div>
        
         </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>-->
                
                <!--<div class="tabcontent" id="tab_content_6">
                     <h2 class="profileRighttitle">Work Experience</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        <div class="profileRightForm">
                       <p class="tabtxt"></p>
        
        </div>
        
         </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>-->
                
                <!--<div class="tabcontent" id="tab_content_7">
                     <h2 class="profileRighttitle">Reviews</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        <div class="profileRightForm">
                       <p class="tabtxt"></p>
        
        </div>
        
         </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>-->
            </div>
        </div>
</div>
 
    <!--<div class="profiletabpan">
                <div class="profileRight">
                <h2 class="profileRighttitle"><span>Write a Review for</span> Dr. Archana Gupta</h2>
				<div class="searchRightgradient searchRightgradient1">
                <div class="profileRightForm">
                <form action="doctor_comment_process.html" name="f1" method="post">
                <input type="hidden" name="name" id="name" value="samannoychatterjee@gmail.com" />
                <input type="hidden" name="doctorid" id="doctorid" value="1" />
                
                <label><span>Write a review:</span><br />
(Minimum 200 characters<br /> to enter the write for a<br /> bite contest)</label>

<textarea class="textareabg" name="comment" id="comment"></textarea>
<input type="submit" class="profileSubmit" onclick="return false" onmousedown="javascript:wall();" />
</form>

</div>


        </div>
        <span class="profileBottom">&nbsp;</span>
 </div>
        
        </div>-->
     </div>    
  </div>
</div>
<!--main content end -->
<!--footer start -->
<?php include(PROJECT_DOCUMENT_PATH.COMMON_FOLDER."footer.php");?>
<!--footer end -->
</body>
</html>
