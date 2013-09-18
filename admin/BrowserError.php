<?php
require("includes/connection.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Javascript Disabled in Browser</title>
<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."head.php");?>
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" id="MainTable" class="MainTable">
	<tr>
		<td>
			<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."header.php");?>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" id="InnerTable" class="InnerTable">
				<tr>
					<td id="leftpanel" class="leftpanel">
						<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."leftmenu.php");?>
					</td>
					<td id="rightpanel" class="rightpanel">
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr><td class="PageHeading">Javascript Disabled in your Browser </td></tr>
							<tr>
								<td>
                                <h1>
		How to enable scripting in your browser</h1>
</div>
<p>
	<strong>This Web site uses scripting to enhance your browsing experience. </strong></p>
<h5>
	To allow all Web sites in the Internet zone to run scripts, use the steps that apply to your browser:</h5>
<h5>
	Windows Internet Explorer</h5>
<p>
	(all versions except <u>Pocket Internet Explorer</u>)<strong>Note</strong> To allow scripting on this Web site only, and to leave scripting disabled in the Internet zone, <u>add this Web site to the <strong>Trusted sites</strong> zone.</u></p>
<blockquote>
	If you have to customize your Internet security settings, follow these steps:<br />
	a. Click <strong>Custom Level</strong>.<br />
	b. In the <strong>Security Settings &ndash; Internet Zone</strong> dialog box, click <strong>Enable</strong> for <strong>Active Scripting</strong> in the <strong>Scripting</strong> section.</blockquote>
<ol>
	<li>
		On the <strong>Tools</strong> menu, click <strong>Internet Options</strong>, and then click the <strong>Security</strong> tab.</li>
	<li>
		Click the <strong>Internet</strong> zone.</li>
	<li>
		If you do not have to customize your Internet security settings, click <strong>Default Level</strong>. Then do step 4</li>
	<li>
		Click the <strong>Back</strong> button to return to the previous page, and then click the <strong>Refresh</strong> button to run scripts.</li>
</ol>
<h5>
	Mozilla Corporation&rsquo;s Firefox version 2</h5>
<ol>
	<li>
		On the <strong>Tools</strong> menu, click <strong>Options</strong>.</li>
	<li>
		On the <strong>Content</strong> tab, click to select the <strong>Enable JavaScript</strong> check box.</li>
	<li>
		Click the <strong>Go back one page</strong> button to return to the previous page, and then click the <strong>Reload current page</strong> button to run scripts.</li>
</ol>
<h5>
	Opera Software&rsquo;s Opera version 9</h5>
<ol>
	<li>
		On the <strong>Tools</strong> menu, click <strong>Preferences</strong>.</li>
	<li>
		On the <strong>Advanced</strong> tab, click <strong>Content</strong>.</li>
	<li>
		Click to select the <strong>Enable JavaScript</strong> check box, and then click <strong>OK</strong>.</li>
	<li>
		Click the <strong>Back</strong> button to return to the previous page, and then click the <strong>Reload</strong> button to run scripts.</li>
</ol>
<h5>
	Netscape browsers</h5>
<ol>
	<li>
		Select <strong>Edit</strong>, <strong>Preferences</strong>,<strong>Advanced</strong></li>
	<li>
		Click to select <strong>Enable JavaScript</strong> option.</li>
</ol>
</div>
                                </td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."footer.php");?>
		</td>
	</tr>
</table>
</body>
</html>