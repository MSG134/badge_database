<?php require_once('Connections/badgesdbcon.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "access_denied.html";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php require_once('include/getsqlvaluestring.php'); ?>
<?php

$colname_etc = "-1";
if (isset($_POST['id'])) {
  $colname_etc = $_POST['id'];
}
 
$query_etc = sprintf("SELECT * FROM executabletcs WHERE id = %s", GetSQLValueString($badgesdbcon, $colname_etc, "int"));
$etc = mysqli_query($badgesdbcon, $query_etc) or die(mysqli_error());
$row_etc = mysqli_fetch_assoc($etc);
$totalRows_etc = mysqli_num_rows($etc);$colname_etc = "-1";
if (isset($_POST['id'])) {
  $colname_etc = $_POST['id'];
}
 
$query_etc = sprintf("SELECT * FROM executabletcs WHERE id = %s", GetSQLValueString($badgesdbcon, $colname_etc, "int"));
$etc = mysqli_query($badgesdbcon, $query_etc) or die(mysqli_error());
$row_etc = mysqli_fetch_assoc($etc);
$totalRows_etc = mysqli_num_rows($etc);

 
$query_atcs = "SELECT * FROM abstracttcs";
$atcs = mysqli_query($badgesdbcon, $query_atcs) or die(mysqli_error());
$row_atcs = mysqli_fetch_assoc($atcs);
$totalRows_atcs = mysqli_num_rows($atcs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Executable Test Case</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Edit Executable Test Case</h1>
<form id="form1" name="form1" method="post" action="etc_edit_proc.php">
<p>Description: <br />
  <label for="description"></label>
  <textarea name="description" id="description" cols="45" rows="5"><?php echo $row_etc['Description']; ?></textarea>
  </p>
<p>Classname: 
  <label for="classname"></label>
  <input name="classname" type="text" id="classname" value="<?php echo $row_etc['classname']; ?>" />
</p>
<p>Version: 
  <label for="version"></label>
  <input name="version" type="text" id="version" value="<?php echo $row_etc['version']; ?>" />
</p>
<p>Abstract Test Case: 
  <label for="atc"></label>
  <select name="atc" id="atc">
    <?php
do {  
?>
    <option value="<?php echo $row_atcs['id']?>"<?php if (!(strcmp($row_atcs['id'], $row_etc['abstracttcs_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_atcs['identifier']?></option>
    <?php
} while ($row_atcs = mysqli_fetch_assoc($atcs));
  $rows = mysqli_num_rows($atcs);
  if($rows > 0) {
      mysqli_data_seek($atcs, 0);
	  $row_atcs = mysqli_fetch_assoc($atcs);
  }
?>
  </select>
</p>
</form>
<p>[ <a href="editor_start.php">Editor Home</a> ]</p>
</body>
</html>
<?php
mysqli_free_result($etc);

mysqli_free_result($atcs);
?>
