<html>
    <link rel="stylesheet" href="bootstrap.css" media="screen">
    <link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css"/>
    <head>
        <title>Detainee List</title>
    </head>
        <body bgcolor="#FFFFCC">
<?php
session_start();
require_once 'connect.php';
require_once 'member.php';

$auth = isset($_SESSION['username']) && isEmployee($_SESSION['username']);
if ($auth == false) {
    header("Location: nope.php");
    die();
}

?>
<center>
<img src="Animated-handcuffs.gif" />
<h1 style="display:inline">Detainee List</h>
<img src="Animated-handcuffs.gif" />
</center>
<br>
<br>
<center>
<?php if (isWarden($_SESSION['username'])) { ?>
<a href="add_detainee.php">Add more prisoners todayyyyyy</a>
<br>
<br>
<?php } ?>
<table cellpadding="5" border=1>
<tr>
<th>Username</th><th>Name</th><th>Birthdate</th><th>Release date</th>
<th>Cell</th>
</tr>
<?php
global $con;
$query = "SELECT * FROM ((SELECT * FROM people NATURAL JOIN detainee) AS T)
    INNER JOIN livesin ON T.uname=livesin.d_uname";
$result = mysqli_query($con,$query) or die(mysqli_error($con));
while (($r = $result->fetch_row())) {?>
<tr>
<td><?php echo $r[0] ?></td>
<td><?php echo $r[3] . ", " . $r[2] ?></td>
<td><?php echo $r[4] ?></td>
<td><?php echo $r[5] ?></td>
<td><?php echo "Section " .$r[8].", Cell ".$r[7] ?></td> 
<?php if (isWarden($_SESSION['username'])) { ?>
<td>
<form method="post" action="viewcontacts.php">
<input type="submit" value="View Non-Contacts" />
<input type="hidden" name="username" value="<?php echo $r[0] ?>" />
</form>
</td>
<td>
<form method="post" action="detainee_management.php">
<input type="submit" value="EDIT" />
<input type="hidden" name="username" value="<?php echo $r[0] ?>" />
</form>
</td>
<?php } ?>
</tr>
<?php } ?>
</table>
<br>
<a href='memberpage.php'>Go Back</a>
</center>

