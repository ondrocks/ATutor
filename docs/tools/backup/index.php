<?php
/****************************************************************************/
/* ATutor																	*/
/****************************************************************************/
/* Copyright (c) 2002-2004 by Greg Gay, Joel Kronenberg & Heidi Hazelton	*/
/* Adaptive Technology Resource Centre / University of Toronto				*/
/* http://atutor.ca															*/
/*																			*/
/* This program is free software. You can redistribute it and/or			*/
/* modify it under the terms of the GNU General Public License				*/
/* as published by the Free Software Foundation.							*/
/****************************************************************************/
// $Id$

define('AT_INCLUDE_PATH', '../../include/');
require(AT_INCLUDE_PATH.'vitals.inc.php');

$_section[0][0] = _AT('tools');
$_section[0][1] = 'tools/';
$_section[1][0] = _AT('backup_course');
$_section[1][1] = 'tools/';

$_SESSION['done'] = 0;
session_write_close();

require(AT_INCLUDE_PATH.'header.inc.php');

	echo '<h2>';
	if ($_SESSION['prefs'][PREF_CONTENT_ICONS] != 2) {
		echo '<img src="images/icons/default/square-large-tools.gif" border="0" vspace="2" class="menuimageh2" width="42" height="40" alt="" />';
	}
	if ($_SESSION['prefs'][PREF_CONTENT_ICONS] != 1) {
		echo ' <a href="tools/" class="hide" >'._AT('tools').'</a>';
	}
	echo '</h2>';


	echo '<h3>';
	if ($_SESSION['prefs'][PREF_CONTENT_ICONS] != 2) {
		echo '&nbsp;<img src="images/icons/default/backups-large.gif" class="menuimageh3" width="42" height="38" alt="" /> ';
	}
	if ($_SESSION['prefs'][PREF_CONTENT_ICONS] != 1) {
		echo _AT('backup_course');
	}
	echo '</h3>';

	if (!authenticate(AT_PRIV_ADMIN, AT_PRIV_RETURN)) {
		require (AT_INCLUDE_PATH.'header.inc.php'); 
		$errors[] = AT_ERROR_NOT_OWNER;
		print_errors($errors);
		require (AT_INCLUDE_PATH.'footer.inc.php'); 
		exit;
	}

$help[] = AT_HELP_IMPORT_EXPORT;
$help[] = AT_HELP_IMPORT_EXPORT1;
require(AT_INCLUDE_PATH.'html/feedback.inc.php');
?>
<?php print_help($help);  ?>

<h3>Backup Manager</h3>

<h2><?php echo _AT('create_course_backup'); ?></h2>
<form name="form1" method="post" action="tools/backup/backup_import.php" enctype="multipart/form-data" onsubmit="">
	<table cellspacing="1" cellpadding="0" border="0" width="95%" summary="" align="center" class="bodyline">
	<tr>
		<td>
		To add a backup of this course (in its current state) to the list below, enter a description for the backup and select the "create" button.<br />
		
		<p align="center"><textarea cols="40" rows="3" class="formfield" id="desc" name="description" scroll="no"></textarea><br /><br />
		<input type="submit" name="create" value="<?php echo _AT('create'); ?>" class="button" />
		</p>
		</td>
	</tr>
</table>

<h2><?php echo _AT('upload_course_backup'); ?></h2>

<table cellspacing="1" cellpadding="0" border="0" width="95%" summary="" align="center" class="bodyline">
	<tr>
		<td>
		To add a backup to the list below from a file, choose the file to upload, and click the "upload" button.
		</td>
	</tr>
	<tr><td>
		<p align="center"><input type="file" name="upload_file" class="formfield" /> <input type="submit" name="upload" value="<?php echo _AT('upload'); ?>" class="button" /></p>
		</td>
	</tr>
	</table>
</form>

<br />
<h2><?php echo _AT('manage_course_backup'); ?></h2>
<form name="form1" method="post" action="tools/backup/backup_import.php" enctype="multipart/form-data" onsubmit="">
	<table cellspacing="1" cellpadding="0" border="0" class="bodyline" width="95%" summary="" align="center">
	<tr>
		<td>Name</td>
		<td>Date</td>
		<td>Size</td>
		<td>Description</td>
	</tr>
	<tr><td height="1" class="row2" colspan="4"></td></tr>
	<tr>
		<td>backup name</td>
		<td>sept 23, 2004</td>
		<td>1M</td>
		<td>bla bla bla</td>
	</tr>
	<tr><td height="1" class="row2" colspan="4"></td></tr>
	<tr>
		<td align="center" colspan="4">
			<br /><input type="submit" name="restore" value="<?php echo _AT('restore'); ?>" class="button" /> | <input type="submit" name="download" value="<?php echo _AT('download'); ?>" class="button" /> | <input type="submit" name="delete" value="<?php echo _AT('delete'); ?>" class="button" />
		</td>
	</tr>
	</table>
</form>

<?php require (AT_INCLUDE_PATH.'footer.inc.php');  ?>