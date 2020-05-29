<?php
session_start();
	//walidacja - sprawdzanie poprawności sprawdzania danych
	if(isset($_POST['login']))
	{
		//Udana walidacja
		$ok = true;

		$nazwa = $_POST['login'];
		//sprawdzenie długości nicku
		if(strlen($nazwa)<1)
		{
			$ok=false;
			$_SESSION['e_login']="Podaj swoją nazwe!";
		}

		$haslo = $_POST['haslo'];
		$haslo2 = $_POST['haslo2'];

		if(strlen($haslo)<1)
		{
			$ok = false;
			$_SESSION['e_haslo']="Podaj swoje hasło!";
		}

		if($haslo!=$haslo2)
		{
			$ok = false;
			$_SESSION['e_haslo']="Hasła nie są identyczne !";
		}


		$imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		$adres2 = $_POST['adres'];
		$pesel = $_POST['pesel'];
		$telefon = $_POST['telefon'];
		//imie
		if(strlen($imie)<1)
		{
			$ok = false;
			$_SESSION['e_imie']="Podaj imie!";
		}

		//nazwisko
		if(strlen($nazwisko)<1)
		{
			$ok = false;
			$_SESSION['e_nazwisko']="Podaj nazwisko !";
		}

		//adres
		if(strlen($adres2)<1)
		{
			$ok = false;
			$_SESSION['e_adres']="Podaj adres !";
		}

		//pesel
		if(strlen($pesel)<1)
		{
			$ok = false;
			$_SESSION['e_pesel']="Podaj pesel !";
		}
		//telefon
		if(strlen($telefon)<1)
		{
			$ok = false;
			$_SESSION['e_telefon']="Podaj telefon !";
		}


		//akceptacja regulaminu
		if(!isset($_POST['regulamin']))
		{
			$ok = false;
			$_SESSION['e_regulamin']="Muisz zaakceptować regulamin !";
		}

		require_once "connect.php";

		//nowy sposób łączenia z bazą i wyświetlania błędów
		mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie błędów o wyjątki, bez pokazywania ostrzeżen

		try
		{
			$conn = new mysqli($adres, $login, $haslo, $baza);
			if($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//czy login istnieje
				$rezultat = $conn->query("SELECT ID FROM klienci_logowanie WHERE login='$nazwa'");
				if(!$rezultat) throw new Exception($conn->error); //błąd

				$ile_loginow = $rezultat->num_rows;
				if($ile_loginow>0)
				{
					$ok=false;
					$_SESSION['e_login']="Taki login już istnieje!";
				}

				$rezultat = $conn->query("SELECT Pesel FROM klienci_dane WHERE Pesel='$pesel'");
				if(!$rezultat) throw new Exception($conn->error); //błąd

				$ile_pesel = $rezultat->num_rows;
				if($ile_pesel>0)
				{
					$ok=false;
					$_SESSION['e_pesel']="Taki pesel już istnieje!";
				}

				$rezultat = $conn->query("SELECT ID FROM pracownik_logowanie WHERE login='$nazwa'");
				if(!$rezultat) throw new Exception($conn->error); //błąd

				$ile_loginow = $rezultat->num_rows;
				if($ile_loginow>0)
				{
					$ok=false;
					$_SESSION['e_login']="Taki login już istnieje!";
				}

				$rezultat = $conn->query("SELECT Pesel FROM pracownik_dane WHERE Pesel='$pesel'");
				if(!$rezultat) throw new Exception($conn->error); //błąd

				$ile_pesel = $rezultat->num_rows;
				if($ile_pesel>0)
				{
					$ok=false;
					$_SESSION['e_pesel']="Taki pesel już istnieje!";
				}

				if($ok==true)
				{
					//wszystko zaliczone
					if($conn->query("INSERT INTO klienci_logowanie (login,Haslo) VALUES ('$nazwa','$haslo2')")===TRUE)
					{
						if($conn->query("INSERT INTO klienci_dane (Imie,Nazwisko,Adres,Pesel,Telefon,Login) VALUES ('$imie','$nazwisko','$adres2','$pesel','$telefon','$nazwa')")===TRUE)
						{
							$_SESSION['udana_rejestracja']=true;
							header("Location: index.php");
						}
						else
						{
							throw new Exception($conn->error);
						}
					}
					else
					{
						throw new Exception($conn->error);
					}
				}



				$conn->close();
			}
		}
		catch(Exception $error)
		{
			echo 'Błąd serwera!';
			echo '<br/>Informacja dewelopreska: '.$error;
		}
	}
?>

<!DOCTYPE HTML>
<html lang="pl_PL">
	<head>
		<meta charset="utf-8"/>
		<title>Rejestracja</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="rejestracja">
			<form method="post">
				Login<br/><input type="text" name="login"/><br/>
				<?php
					if(isset($_SESSION['e_login']))
					{
						echo '<div class="error">'.$_SESSION['e_login'].'</div><br>';
						unset($_SESSION['e_login']);
					}
				?>

				Haslo<br/><input type="password" name="haslo"/><br/>
				<?php
					if(isset($_SESSION['e_haslo']))
					{
						echo '<div class="error">'.$_SESSION['e_haslo'].'</div><br>';
						unset($_SESSION['e_haslo']);
					}
				?>
				Powtórz hasło<br/><input type="password" name="haslo2"/><br/>

				<br><br>
				Imie<br/><input type="text" name="imie"/><br/>
				<?php
					if(isset($_SESSION['e_imie']))
					{
						echo '<div class="error">'.$_SESSION['e_imie'].'</div><br>';
						unset($_SESSION['e_imie']);
					}
				?>
				Nazwisko<br/><input type="text" name="nazwisko"/><br/>
				<?php
					if(isset($_SESSION['e_nazwisko']))
					{
						echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div><br>';
						unset($_SESSION['e_nazwisko']);
					}
				?>
				Adres<br/><input type="text" name="adres"/><br/>
				<?php
					if(isset($_SESSION['e_adres']))
					{
						echo '<div class="error">'.$_SESSION['e_adres'].'</div><br>';
						unset($_SESSION['e_adres']);
					}
				?>
				Pesel<br/><input type="text" name="pesel" maxlength="11"/><br/>
				<?php
					if(isset($_SESSION['e_pesel']))
					{
						echo '<div class="error">'.$_SESSION['e_pesel'].'</div><br>';
						unset($_SESSION['e_pesel']);
					}
				?>
				Telefon<br/><input type="text" name="telefon" maxlength="9"/><br/>
				<?php
					if(isset($_SESSION['e_telefon']))
					{
						echo '<div class="error">'.$_SESSION['e_telefon'].'</div><br>';
						unset($_SESSION['e_telefon']);
					}
				?>

				<label> <!-- działanie na wszystko co w label -->
				<input type="checkbox" name="regulamin"/> Akceptuję regulamin
				</label>
				<?php
					if(isset($_SESSION['e_regulamin']))
					{
						echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
						unset($_SESSION['e_regulamin']);
					}
				?>
				<br/>
				<input type="submit" value="zarejestruj">
			</form>
			<a href="index.php">Powrót</a>
		</div>
	</body>
</html>
