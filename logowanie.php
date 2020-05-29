<?php
if(isset($_POST['login']) && isset($_POST['haslo']))
{


					require_once "connect.php";
					$conn = new mysqli($adres, $login, $haslo, $baza);

if($conn->connect_error)
	die("Bład połaczenia".$conn->connect_error());


$login = $_POST['login'];
$haslo = $_POST['haslo'];

//pracownik
	$sql = "SELECT * FROM uzytkownikinfo;";
	$results = $conn->query($sql);

	if($results->num_rows>0){
		while($row = $results->fetch_assoc())
		{
			if(($login==$row['login']) && ($haslo==$row['haslo']))
			{
				$_SESSION['zalogowany']="pracownik";
				header("Location: index.php?page=admin");
				exit();
			}
		}
		echo "Nie ma";
	}
	else{
		echo "Podany login lub hasło jest nieprawidłowe!";
	}



}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<title>index</title>
	</head>
	<body>
		<form name="formularz" method="post">
			Login: <input type="text" name="login" value="">
			Hasło: <input type="text" name="haslo" value="">
			<input type="submit" value="Zaloguj">
		</form>
		<a href="rejestracja.php">Rejestracja</a>

	</body>
</html>
