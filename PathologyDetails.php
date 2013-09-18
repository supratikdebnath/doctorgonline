<?php require('includes/connection.php');?>
<?php require(PROJECT_DOCUMENT_PATH.CONTROLLER_FOLDER.CONTROLLER_PathologyDetails);?>
<?php $pathologyObj=new Pathology;
	$pid=$pathologyDetails['data'][0]['pathologyDetailsid'];
//echo "<pre>";print_r($pathologyDetails);echo "<pre>"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW" />
<title><?php echo SITE_TITLE;?> - Pathology Center Information - <?php echo $pathologyDetails['data'][0]['pathologycenterName'];?></title>
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
	           data: {sensor : false, address : '<?php echo $globalUtil->removeLineBreakHTML(str_replace(array(' ','-','_','&'),'+',$pathologyDetails['data'][0]['address']));?><?php echo $pathologyGeoLocationString;?>'},
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
   var gmapUrl=	'http://maps.google.com/maps?oe=UTF-8&hl=en&ie=UTF8&hq=&hnear=&ll='+latitude+','+longitude+'&sll='+latitude+','+longitude+'&spn=0.025358,0.06609&q=<?php echo $globalUtil->removeLineBreakHTML(str_replace(' ','+',$pathologyDetails['data'][0]['address']));?>&hnear='+formatted_address+'&aq=&t=m&z=14&iwloc=near&markers=color:red&output=embed&center=0.025358,0.06609';	
   //alert(gmapUrl);
  // $('#GMap').attr('src',gmapUrl);
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
                   		<span id="putpic"><img src="<?php if($pathologyDetails['data'][0]['pathologyCenterImg']==''){?><?php echo IMAGES_URL."Pathologica.jpg";?><?php }else{?><?php echo PATHOLOGY_CENTER_IMG_URL."medium/".$pathologyDetails['data'][0]['pathologyCenterImg'];}?>" style="height:203px; width:165px; padding: 0 0 0 2px;" alt="<?php echo $pathologyDetails['data'][0]['pathologycenterName'];?>"> </span>
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
              
              	<h2>Welcome to <?php echo $pathologyDetails['data'][0]['pathologycenterName'];?>'s Information</h2>
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Govt_reg.png" /></span>Name:</p>
				<p class="proright"><?php echo $pathologyDetails['data'][0]['pathologycenterName'];?></p>
                
                <br class="spacer" />
                                 
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>address.png" /></span>Address:</p>
				<p class="proright">
                <textarea cols="40" rows="10" disabled="disabled"><?php echo $pathologyDetails['data'][0]['address'].$pathologyGeoLocationForAddress;?></textarea></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>address.png" /></span>Pincode:</p>
				<p class="proright"><?php echo $pathologyDetails['data'][0]['pincode'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Land_phone.png" /></span>Phone :</p>
				<p class="proright"><?php echo $pathologyDetails['data'][0]['phoneNo'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Mobile.png" /></span>Mobile :</p>
				<p class="proright"><?php echo $pathologyDetails['data'][0]['phoneNoAlternate'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Fax.png" /></span>Fax:</p>
				<p class="proright"><?php echo $pathologyDetails['data'][0]['fax'];?></p>
                
                <br class="spacer" />
                
                <p class="proleft2"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span>Website:</p>
				<p class="proright"><a href="<?php echo $pathologyDetails['data'][0]['website'];?>" class="doctoremaillink" target="_blank"><?php echo $pathologyDetails['data'][0]['website'];?></a></p>
                
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
                        <?php if($pathologyDetails['data'][0]['registrationNo']!=''){?>
                        <li><img src="<?php echo IMAGES_URL;?>govt.jpg" width="35" height="24" alt="" /> Government Registered</li><?php }?>
                        <?php if($pathologyDetails['data'][0]['available24Hrs']=='Y'){?>
                        <li><img src="<?php echo IMAGES_URL;?>24hrs.jpg" width="35" height="24" alt="" /> 	24hrs Availability</li><?php }?>
                        <?php if($pathologyDetails['data'][0]['creditCardAccept']=='Y'){?>
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
                 <div class="tab" id="tab_menu_2">
                     <div class="link">Map</div>
                     <div class="arrow"></div>
                 </div>
                 <div class="tab" id="tab_menu_3">
                     <div class="link">Doctors</div>
                     <div class="arrow"></div>
                 </div>
                 <div class="tab" id="tab_menu_4">
                     <div class="link">Pathology Test Info</div>
                     <div class="arrow"></div>
                 </div>
                  <div class="tab" id="tab_menu_5">
                     <div class="link">Health Package Info</div>
                     <div class="arrow"></div>
                 </div>
                 <div class="tab" id="tab_menu_6">
                     <div class="link">Contact Details Info</div>
                     <div class="arrow"></div>
                 </div>
                
            </div>
            <div class="curvedContainer">
                <div class="tabcontent" id="tab_content_1" style="display:block">
                        <h2 class="profileRighttitle">Pathological Center Info</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                         
                          <div class="brandblk brandblk1">
                          
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>email.png" /></span><strong>Email:</strong></p>
                            <p class="proright"><a href="mailto:<?php echo $pathologyDetails['data'][0]['emailAlternate'];?>" class="doctoremaillink"><?php echo $pathologyDetails['data'][0]['emailAlternate'];?></a></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Land_phone.png" /></span><strong>Landline No</strong>:</p>
                            <p class="proright"><?php echo $pathologyDetails['data'][0]['phoneNo'];?></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Land_phone.png" /></span><strong>Alternate No:</strong></p>
                            <p class="proright"><?php echo $pathologyDetails['data'][0]['phoneNoAlternate'];?></p>
                        
                            <br class="spacer" />
                            
                           <p class="proleft"> <span><img src="<?php echo IMAGES_URL;?>Fax.png" /></span><strong>Fax:</strong></p>
                           <p class="proright"><?php echo $pathologyDetails['data'][0]['fax'];?></p>
                                <br class="spacer" />
                                
                           <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Website:</strong></p>
                           <p class="proright"><a href="<?php echo $pathologyDetails['data'][0]['website'];?>" class="doctoremaillink" target="_blank"><?php echo $pathologyDetails['data'][0]['website'];?></a></p>
                            <br class="spacer" />
                            
                           <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Accredation:</strong></p>
                           <p class="proright">
						   <?php 
						
						   $accName=mysql_fetch_array(mysql_query("SELECT accreditationName FROM dgo_hospital_accreditations WHERE id=".$pathologyDetails['data'][0]['haid']));
						   echo $accName['accreditationName'];
						   ?></p>
                            <br class="spacer" />
                            
                           <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Other Facility:</strong></p>
                           <p class="proright">
						   <?php 
						    
							$hfid_array=array();
							$hfid_array=$pathologyDetails['data'][0]['hfid'];
							$k=0;
							for($i=0;$i<count($hfid_array);$i++)
							{
							$k++;
						    $facName=mysql_fetch_array(mysql_query("SELECT facilityName FROM dgo_pathology_facilities WHERE id=".$hfid_array[$i]));
						    $fac=$facName['facilityName']."<br/>";
							echo "(".$k.") ".$fac;
							}
						   ?></p>
                            <br class="spacer" />
                            
                           <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Specialized labs Tie Up:</strong></p>
                           <p class="proright">
						   <?php 
						    
							if($pathologyDetails['data'][0]['tieupWithSpecializedLabs']=='Y')
							{
							echo $pathologyDetails['data'][0]['tieupWithLabs'];
							}
						   ?></p>
                            <br class="spacer" />
                            
                           <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Emergency Service No:</strong></p>
                           <p class="proright">
						   <?php 
						    
							if($pathologyDetails['data'][0]['emergencyServiceNoAvailable']=='Y')
							{
							echo $pathologyDetails['data'][0]['emergencyServiceNo'];
							}
						   ?></p>
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Ambulence No:</strong></p>
                           <p class="proright">
						   <?php 
						    
							if($pathologyDetails['data'][0]['ambulenceNoAvailable']=='Y')
							{
							echo $pathologyDetails['data'][0]['ambulenceNo'];
							}
						   ?></p>
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Website.png" /></span><strong>Sample Collection:</strong></p>
                           <p class="proright">
						   <?php 
						    
							if($pathologyDetails['data'][0]['tieupWithSpecializedLabs']=='Y')
							{
							echo $pathologyDetails['data'][0]['tieupWithLabs'];
							}
						   ?></p>
                            <br class="spacer" />
                                
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>Govt_reg.png" /></span><strong>Govt. Reg No:</strong></p>
                            <p class="proright"><?php echo $pathologyDetails['data'][0]['registrationNo'];?></p>
                        
                            <br class="spacer" />
                            
                            <p class="proleft"><span><img src="<?php echo IMAGES_URL;?>about_us.png" /></span><strong>About Us:</strong></p>
                            <p class="proright1"><?php echo nl2br(strip_tags(stripslashes($pathologyDetails['data'][0]['about'])));?></p>
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
                    
                        <h2 class="profileRighttitle">Associated Doctors</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        <?php
                         $strdid=$pathologyDetails['data'][0]['did'];
							if($strdid!='')
								  {
										$did=explode(",",$strdid);
										$k=0;
										$count=0;
										$tr_class='';
										$checked='';
										?>
                        <table  width="90%" cellspacing="0" cellpadding="0" border="0" align="center"   style="border:#666666; border-width:thin; border-style:solid;position:static;">
						  <tr>
					      <td width="34%" bgcolor="#8ADFFF" class="formlabel"><b>&nbsp;Associated Doctor</u></b></td><td width="30%" bgcolor="#8ADFFF" class="formlabel"><b>&nbsp;Specialization</b></td><td width="36%" bgcolor="#8ADFFF" class="formlabel"><b>&nbsp;Qualification</b></td></tr>       
                                 <?php
										
										if(count($did)>0){
								
								for($i=0;$i<count($did);$i++){
								
								$sqldoctorList=mysql_query("SELECT firstName,lastName,id,specid FROM ".TABLE_USER_DOCTOR." WHERE id='".$did[$i]."' ORDER BY id DESC ");
								$rsdoctorList=mysql_fetch_array($sqldoctorList);
								$sqlspecialization=mysql_fetch_array(mysql_query("SELECT id,specName FROM dgo_specialization WHERE id=".$rsdoctorList['specid']));
	  $sqlqid=mysql_fetch_array(mysql_query("SELECT qid FROM dgo_user_doctor_qualifications WHERE specid =".$rsdoctorList['specid']));
	  $sqlqual=mysql_fetch_array(mysql_query("SELECT qualificationName FROM dgo_qualification WHERE id =".$sqlqid['qid']));
	                            ($sqlqual['qualificationName'] !='') ? $qname = '<b>'.$sqlqual['qualificationName']."</b>" : $qname = "No Qualification Available";
								$count++;
								($count%2 == 0) ? $tr_class = "#CAD6E6" : $tr_class = "";
								(in_array($rsdoctorList['id'], $did)) ? $checked = 'checked="checked"' : $checked = 'checked=" "';
								?>
								<tr id="<?php echo $rsdoctorList['id']; ?>"  bgcolor="<?php echo $tr_class; ?>">
									
						<td align="center" bgcolor="<?php echo $tr_class; ?>" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left"><?php echo $rsdoctorList['firstName'].' '.$rsdoctorList['lastName']; ?></div></td>
						<td align="center" bgcolor="<?php echo $tr_class; ?>" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left"><?php echo $sqlspecialization['specName']; ?></div></td>
                        <td align="center" bgcolor="<?php echo $tr_class; ?>" style="font-size: 13px;padding-left: 5px;text-align: left;"><div align="left"><?php echo $qname; ?></div></td>                            
								</tr>
								<?php 
								$k++;
									   
									}
									
								}else{ ?>
                                 <tr><td align="center" bgcolor="#CAD6E6" colspan="3"><strong>No Records Found</strong></td></tr>
                                <?php
									
								}
								?>
                                </table>
                                <?php
							} 
        
                   ?>
        </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>
                <div class="tabcontent" id="tab_content_4">
                    
                        <h2 class="profileRighttitle">Pathology Test Information</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        
                       <table  width="90%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addPathInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr><td width="29%" bgcolor="#8ADFFF" class="formlabel">&nbsp;<strong>Test Type</strong></td> 
					  <td width="30%" bgcolor="#8ADFFF" class="formlabel"><strong>Test Name</strong></td> <td width="13%" bgcolor="#8ADFFF" class="formlabel"><strong>Price</strong></td> <td width="28%" bgcolor="#8ADFFF" class="formlabel"><strong>Additional Info</strong></td>  </tr>
					 
					   <?php 
					   
					        $pathologyInfoList= $pathologyObj->getPathologyInfo($globalUtil," WHERE pid='".$pid."' ORDER BY id DESC ");
							$addinfo = '';
							$action = '';
							$count=0;
							if($pathologyInfoList['numrows']>0){
							for($i=0;$i<$pathologyInfoList['numrows'];$i++){
							if($pathologyInfoList['data'][$i]['additionalInfo']!='')
							$addinfo = $pathologyInfoList['data'][$i]['additionalInfo'];
							else
							$addinfo = 'No additional info available';
							$sqlExistsTestType="SELECT test_type FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id='".$pathologyInfoList['data'][$i]['testTypeId']."'";
							$rsExistsTestType=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestType,2);
							$sqlExistsTestName="SELECT test_name,status FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id='".$pathologyInfoList['data'][$i]['testNameId']."'";
							$rsExistsTestName=$globalUtil->sqlFetchRowsAssoc($sqlExistsTestName,2);
							$count++;
							($count%2 == 0) ? $tr_class = "#CAD6E6" : $tr_class = "";
							($rsExistsTestName['data'][0]['status']==0) ? $action = "<b><em>Disabled</em></b>" : $action = "<a href='javascript:void(0);' onclick='javascript:removePathologySpec(".$pathologyInfoList['data'][$i]['id'].");'><b>Remove</b></a>";
							?>
							<tr id="trpathid<?php echo $pathologyInfoList['data'][$i]['id'];?>" bgcolor="<?php echo $tr_class; ?>">
								<td align="left" class="formlabel">&nbsp;<?php echo $rsExistsTestType['data'][0]['test_type'];?></td>
								<td align="left" class="formlabel"><?php echo $rsExistsTestName['data'][0]['test_name'];?></td>
								<td align="left" class="formlabel"><?php echo $pathologyInfoList['data'][$i]['testPrice'];?></td>
								<td align="left" class="formlabel"><?php echo $addinfo;?></td>
								
							</tr>
							<?php 
								}
							}	else {
								?>
                                <tr><td align="center" bgcolor="#CAD6E6" colspan="4"><strong>No Records Found</strong></td></tr>
                                <?php
							}
							?>
  </table>
        
                       
                </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>
                <div class="tabcontent" id="tab_content_5">
                    
                        <h2 class="profileRighttitle">Health Package Information</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        
                       <table width="90%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addHealthMoreInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr><td width="30%" bgcolor="#8ADFFF" class="formlabel">&nbsp;<strong>Package Name</strong></td> 
					  <td width="34%" bgcolor="#8ADFFF" class="formlabel"><strong>Package  Price</strong></td> <td width="36%" bgcolor="#8ADFFF" class="formlabel"><strong>Details</strong></td> </tr>
					 
					   <?php 
					   
					        $healthInfoList= $pathologyObj->getHealthInfo($globalUtil," WHERE pid='".$pid."' ORDER BY id DESC ");
							$addinfo = '';
							$count=0;
							if($healthInfoList['numrows']>0){
							for($i=0;$i<$healthInfoList['numrows'];$i++){
							if($healthInfoList['data'][$i]['details']!='')
							$details = $healthInfoList['data'][$i]['details'];
							else
							$details = 'No additional info available';
							$count++;
							($count%2 == 0) ? $tr_class = "#CAD6E6" : $tr_class = "";
							?>
							<tr id="trhealthid<?php echo $healthInfoList['data'][$i]['id'];?>"  bgcolor="<?php echo $tr_class; ?>">
								<td align="left" class="formlabel">&nbsp;<?php echo $healthInfoList['data'][$i]['packageName'];?></td>
								<td align="left" class="formlabel"><?php echo $healthInfoList['data'][$i]['packagePrice'];?></td>
								<td align="left" class="formlabel"><?php echo $details;?></td>
						 </tr>
							<?php 
								}
							}	
							 	else {
								?>
                                <tr><td align="center" bgcolor="#CAD6E6" colspan="3"><strong>No Records Found</strong></td></tr>
                                <?php
							}
							?>
  </table>
        
        
                </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>
                <div class="tabcontent" id="tab_content_6">
                    
                        <h2 class="profileRighttitle">Contact Person Details Information</h2>
                        <div class="searchRightgradient searchRightgradient1 searchRightgradienttwo">
                        
                       <table width="90%" cellspacing="0" cellpadding="0" border="0" align="center" class="" id="addContactInfo" style="border:#666666; border-width:1px; border-style:solid;">
					  <tr><td width="14%" bgcolor="#8ADFFF" class="formlabel">&nbsp;<strong>Name</strong></td> 
					  <td width="23%" bgcolor="#8ADFFF" class="formlabel"><strong>Designation</strong></td> 
					  <td width="20%" bgcolor="#8ADFFF" class="formlabel"><strong>Email</strong></td> 
					  <td width="22%" bgcolor="#8ADFFF" class="formlabel"><strong>Contact No</strong></td> 
					  </tr>
					 
					   <?php 
							$addinfo = '';
							$count=0;
							$contactInfoList=   $pathologyObj->getContactInfo($globalUtil," WHERE pid='".$pid."' ORDER BY id DESC ");
							if($contactInfoList['numrows']>0){
							for($i=0;$i<$contactInfoList['numrows'];$i++){
							if($contactInfoList['data'][$i]['contactno']!='')
							  $contactno = $contactInfoList['data'][$i]['contactno'];
							  else
							  $contactno = 'No contact no available';
							  $count++;
							  ($count%2 == 0) ? $tr_class = "#CAD6E6" : $tr_class = "";
							?>
							<tr id="trcontactid<?php echo $contactInfoList['data'][$i]['id'];?>" bgcolor="<?php echo $tr_class; ?>">
								<td align="left" class="formlabel">&nbsp;<?php echo $contactInfoList['data'][$i]['name'];?></td>
								<td align="left" class="formlabel"><?php echo $contactInfoList['data'][$i]['designation'];?></td>
								<td align="left" class="formlabel"><?php echo $contactInfoList['data'][$i]['email'];?></td>
								<td align="left" class="formlabel"><?php echo $contactno; ?></td>
						 </tr>
					 <?php 
								}
							}	
							else {
								?>
                                <tr><td align="center" bgcolor="#CAD6E6" colspan="4"><strong>No Records Found</strong></td></tr>
                                <?php
							}
							?>
  </table>
        
        
                </div>
                <span class="profileBottom">&nbsp;</span>
                    
                </div>
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
