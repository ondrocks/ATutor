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
define('AT_INCLUDE_PATH', '../include/');
require (AT_INCLUDE_PATH.'vitals.inc.php');

authenticate(AT_PRIV_POLLS);

if ($_POST['cancel']) {
	Header('Location: '.$_base_href.'editor/polls.php?f='.urlencode_feedback(AT_FEEDBACK_CANCELLED));
	exit;
}

if ($_POST['delete_poll'] && (authenticate(AT_PRIV_POLLS, AT_PRIV_RETURN))) {
	$_POST['pid'] = intval($_POST['pid']);

	$sql = "DELETE FROM ".TABLE_PREFIX."polls WHERE poll_id=$_POST[pid] AND course_id=$_SESSION[course_id]";
	$result = mysql_query($sql, $db);

	$sql = "DELETE FROM ".TABLE_PREFIX."polls_members WHERE poll_id=$_POST[pid] AND course_id=$_SESSION[course_id]";
	$result = mysql_query($sql, $db);

	Header('Location: polls.php?f='.urlencode_feedback(AT_FEEDBACK_POLL_DELETED));
	exit;
}

$_section[0][0] = _AT('tools');
$_section[0][1] = 'tools/index.php';
$_section[1][0] = _AT('polls');
$_section[1][1] = 'editor/polls.php';
$_section[2][0] = _AT('delete_poll');

require(AT_INCLUDE_PATH.'header.inc.php');

print_errors($errors);

echo'<h3>';
if ($_SESSION['prefs'][PREF_CONTENT_ICONS] != 2) {
	echo '<img src="images/icons/default/forum-large.gif" width="42" height="38" border="0" alt="" class="menuimageh3" />';
}
echo _AT('delete_poll').'</h3>';

$_GET['pid'] = intval($_GET['pid']); 

$sql = "SELECT * FROM ".TABLE_PREFIX."polls WHERE poll_id=$_GET[pid] AND course_id=$_SESSION[course_id]";

$result = mysql_query($sql,$db);
if (mysql_num_rows($result) == 0) {
	$errors[]=AT_ERROR_POLL_NOT_FOUND;
} else {
	$row = mysql_fetch_assoc($result);
?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<input type="hidden" name="delete_poll" value="true">
	<input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">

	<?php
	$warnings[]=array(AT_WARNING_DELETE_POLL, AT_print($row['question'], 'polls.question'));
	print_warnings($warnings);

	?>

	<br />
	<input type="submit" name="submit" value="<?php echo _AT('yes_delete'); ?>" class="button"> -
	<input type="submit" name="cancel" value="<?php echo _AT('no_cancel'); ?>" class="button">
	</form>
<?php
}
require(AT_INCLUDE_PATH.'footer.inc.php');
?>