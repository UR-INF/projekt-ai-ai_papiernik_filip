<?php
session_start();
if(isSet($_SESSION['zalogowany'])){
	unset($_SESSION['zalogowany']);
}
else if(isSet($_SESSION['pracownik'])){
	unset($_SESSION['pracownik']);
}
else
{
	$_SESSION['wylogowany']=true;
	header("location:index.php");
	exit();
}
if(isset($_COOKIE[session_name()])){
	setcookie(session_name(),'', time() - 360);
}
session_destroy();
?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta http-equiv="refresh" content="1">
	<meta charset="utf-8">
	<title>logout</title>
	</head>
	<body>
		Wylogowano
	</body>
</html>