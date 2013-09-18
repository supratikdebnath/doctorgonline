<?php
require("includes/connection.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin Welcome Page</title>
<?php require(ADMIN_DOCUMENT_PATH.COMMON_FOLDER."noscript.php");?>
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
							<tr><td class="PageHeading">Welcome Administrator : Guide Lines </td></tr>
							<tr>
								<td>This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.This is demo text.</td>
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
