<table width="100%" cellpadding="0" cellspacing="0" id="LeftMenu" class="LeftMenu">
							<tr><td class="PageHeading">Admin Menu</td></tr>
							<tr><td class="Menu" id="Menu0"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu0');">Account Settings</a>
                            <div class="SubMenu" id="SubMenu0">
                            <ul>
                            	<li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ChangePassword.php");?>">Change Password</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ChangeEmail.php");?>">Change Email</a></li>
                            </ul>
                            </div>
                            </td></tr>
							<tr><td class="Menu" id="Menu1"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu1');">Application Settings</a>
                            <div class="SubMenu" id="SubMenu1">
                            <ul>
                                <li><a href="#">Start/Stop Application</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."CreateAdminUser.php");?>">Create Admin User</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."AdminUserList.php");?>">List of Admin User</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."AdminUserSessionLog.php");?>">Admin Session Logs</a></li>
                                
                            </ul>
                            </div>
                            </td></tr>
                            <tr><td class="Menu" id="Menu2"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu2');">Latest News Module</a>
                            <div class="SubMenu" id="SubMenu2">
                            <ul>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyLatestNews.php");?>">Add New News</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php");?>">List of Latest News</a></li>
                                
                            </ul>
                            </div>
                            </td></tr>
                            <tr><td class="Menu" id="Menu3"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu3');">Country States City Area Module</a>
                            <div class="SubMenu" id="SubMenu3">
                            <ul>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyCountry.php");?>">Add New Country</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php");?>">List of Countries</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyState.php");?>">Add New State</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."StateList.php");?>">List of States</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyCity.php");?>">Add New City</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."CityList.php");?>">List of Cities</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyArea.php");?>">Add New Area</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php");?>">List of Areas</a></li>
                                
                            </ul>
                            </div>
                            </td></tr>
                            <tr><td class="Menu" id="Menu4"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu4');">Doctors Module</a>
                            <div class="SubMenu" id="SubMenu4">
                            <ul>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyDoctor.php");?>">Add New Doctor</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php");?>">List of Doctors</a></li>
                                
                            </ul>
                            </div>
                            </td></tr>
                            <tr><td class="Menu" id="Menu5"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu5');">Hospitals Module</a>
                            <div class="SubMenu" id="SubMenu5">
                            <ul>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyHospital.php");?>">Add New Hospital</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php");?>">List of Hospitals</a></li>
                                
                            </ul>
                            </div>
                            </td></tr>
							 <tr><td class="Menu" id="Menu6"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu6');">Pathology Center Module</a>
                            <div class="SubMenu" id="SubMenu6">
                            <ul>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathology.php");?>">Add New Pathology Center</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php");?>">List of Pathology Centers</a></li>
                                
                            </ul>
                            </div>
                            </td></tr>
							<tr><td class="Menu" id="Menu7"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu7');">Pathology Test Information Module</a>
                            <div class="SubMenu" id="SubMenu7">
                            <ul>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathologyTestType.php");?>">Add New Pathology Test Type</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php");?>">List of Pathology Test Types</a></li>
								<li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathologyTestName.php");?>">Add New Pathology Test Name</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php");?>">List of Pathology Test Name</a></li>
                                
                            </ul>
                            </div>
                            </td></tr>
                            <tr><td class="Menu" id="Menu8"><a href="javascript:void(0);" onclick="javascript:showsubmenu('SubMenu8');">Health Insurance Company Module</a>
                            <div class="SubMenu" id="SubMenu8">
                            <ul>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyInsuranceCompany.php");?>">Add New Insurance Company</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php");?>">List of Insurance Company</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."ModifyInsuranceTPA.php");?>">Add New Insurance TPA</a></li>
                                <li><a href="<?php echo $globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php");?>">List of Insurance TPA</a></li>
                             </ul>
                            </div>
                            </td></tr>
						</table>