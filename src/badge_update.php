<?php require_once('Connections/badgesdbcon.php'); ?>
<?php $target_dir = "badge_graphics/"; ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php require_once('include/getsqlvaluestring.php'); ?>
<?php

$colname_badge = "-1";
if (isset($_POST['id'])) {
  $colname_badge = $_POST['id'];
}
 
$query_badge = sprintf("SELECT * FROM badges WHERE id = %s", GetSQLValueString($badgesdbcon, $colname_badge, "int"));
$badge = mysqli_query($badgesdbcon, $query_badge) or die(mysqli_error());
$row_badge = mysqli_fetch_assoc($badge);
$totalRows_badge = mysqli_num_rows($badge);

$colname_badge = "-1";
if (isset($_POST['id'])) {
  $colname_badge = $_POST['id'];
}
 
$query_badge = sprintf("SELECT * FROM badges WHERE id = %s", GetSQLValueString($badgesdbcon, $colname_badge, "int"));
$badge = mysqli_query($badgesdbcon, $query_badge) or die(mysqli_error());
$row_badge = mysqli_fetch_assoc($badge);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Badge</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Badge Update</h1>
<form action="badge_update_action.php" method="POST" enctype="multipart/form-data" name="updateform" id="updateform">
  <p>Identifier: 
    <label for="identifier"></label>
  <input name="identifier" type="text" id="identifier" value="<?php echo $row_badge['identifier']; ?>" />
  <input name="id" type="hidden" id="id" value="<?php echo $row_badge['id']; ?>" />
  <br />
  Description: 
  <br />
  <label for="description"></label>
  <textarea name="description" id="description" cols="45" rows="5"><?php echo $row_badge['description']; ?></textarea>
  <br />
  <br /><img src="<?php echo $target_dir . $row_badge['graphicfile'] ?>" width="100" height="137"/>
  <input name="oldgraphic" type="hidden" id="hiddenField" value="<?php echo $row_badge['graphicfile']; ?>" />
  <br />
  Graphic: 
  <label for="graphic"></label>
  <input type="file" name="graphic" id="graphic" />
  <br />
  <br />
</p>
  <p>
    <input type="submit" name="submit" id="submit" value="Update" />
    <br />
  </p>
</form>
<hr />
<p><form action="badge_dependancies.php" method="post" enctype="multipart/form-data" id="editbd">
<input name="id" type="hidden" value="<?php echo $row_badge['id']; ?>" />
<input type="submit" name="button" id="button" value="Edit Badge Dependencies" /></form>

<br />
<form action="badge_requirements.php" method="post" enctype="multipart/form-data" name="editreqs" id="editreqs">
  <input name="id" type="hidden" id="id" value="<?php echo $row_badge['id']; ?>" />
    <input type="submit" name="button2" id="button2" value="Edit Interoperability Requirements" />
  </form>
<p>[ <a href="editor_start.php">Editor home</a> | <a href="<?php echo $logoutAction ?>">Log out</a> ]</p>
</body>
</html>
<?php
mysqli_free_result($badge);
?>
