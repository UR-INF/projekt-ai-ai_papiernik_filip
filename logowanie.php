<?php
if(isset($_POST['login']) && isset($_POST['haslo']))
{


					require_once "connect.php";
					$conn = new mysqli($adres, $login, $haslo, $baza);

if($conn->connect_error)
	die("Bład połaczenia".$conn->connect_error());


$login = $_POST['login'];
$haslo = $_POST['haslo'];
$correctReg = true;
//admin
	$sql = "SELECT * FROM uzytkownikinfo WHERE id_funkcja = 2;";
	$results = $conn->query($sql);

	if($results->num_rows>0){
		while($row = $results->fetch_assoc())
		{
			if(($login==$row['login']) && ($haslo==$row['haslo']))
			{
				$_SESSION['zalogowany']="admin";
				header("Location: index.php?page=admin");
				exit();
			}
		}
		$_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";
	}
	else{
		$_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";
	}

	//pracownik
		$sql = "SELECT * FROM uzytkownikinfo WHERE id_funkcja = 1;";
		$results = $conn->query($sql);

		if($results->num_rows>0){
			while($row = $results->fetch_assoc())
			{
				if(($login==$row['login']) && ($haslo==$row['haslo']))
				{
					$_SESSION['zalogowany']="pracownik";
					header("Location: index.php?page=informacje");
					exit();
				}
			}
			$_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";
		}
		else{
			$_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";
		}

		//klient
			$sql = "SELECT * FROM uzytkownikinfo WHERE id_funkcja = 3;";
			$results = $conn->query($sql);

			if($results->num_rows>0){
				while($row = $results->fetch_assoc())
				{
					if(($login==$row['login']) && ($haslo==$row['haslo']))
					{
						$_SESSION['zalogowany']="klient";
						$_SESSION['KlientID'] = $row['id_uzytkownikinfo'];
						echo $row['id_uzytkownikinfo'];
						header("Location: index.php?page=klient");
						exit();
					}
				}
				$_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";
			}
			else{
				$_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";
			}

		//Kurier
			$sql = "SELECT * FROM uzytkownikinfo WHERE id_funkcja = 4;";
			$results = $conn->query($sql);

			if($results->num_rows>0){
				while($row = $results->fetch_assoc())
				{
					if(($login==$row['login']) && ($haslo==$row['haslo']))
					{
						$_SESSION['zalogowany']="kurier";
						header("Location: index.php?page=kurier");
						exit();
					}
				}
            $_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";

			}
			else{
				$_SESSION['bladLogowanieR']="Login lub hasło jest błędne!";
			}



}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<title>index</title>
	<style>
	*{
	  margin: 0;
	  padding: 0;
	  color: white;
	}
	body{
	  font-family: sans-serif;
	  letter-spacing: 1px;
	}
	.hero{
	  height: 100%;
	  width: 100%;
	  position: absolute;
	}
	.form-box{
	  width: 380px;
	  height: 430px;
	  position: relative;
	  margin: 6% auto;
	  padding: 5px;
	  background-color: #3A3A3A;
	  box-shadow: 0 0 20px 2px black;
	  overflow: hidden;
	}
	.button-box{
	  width: 250px;
	  margin: 35px auto;
	  position: relative;
	  border-radius: 30px;
	  color: white;
	}
	.toggle-btn{
	  padding: 10px 30px;
	  cursor: pointer;
	  background: transparent;
	  border: 0;
	  outline: none;
	  position: relative;
	  font-size: 14px;
	}
	#btn{
	  top: 0;
	  left: 0;
	  position: absolute;
	  width: 110px;
	  height: 100%;
	  background: linear-gradient(to right, #FF105F, #FFAD06);
	  border-radius: 30px;
	  transition: .5s;
	}
	.input-group{
	  top: 180px;
	  position: absolute;
	  width: 280px;
	  transition: .5s;
	}
	.input-value{
	  font-size: 20px;
	  width: 100%;
	  padding: 10px 0;
	  margin: 5px 0;
	  border-left: 0;
	  border-right: 0;
	  border-top: 0;
	  border-bottom: 1px solid orange;
	  outline: none;
	  background: transparent;
	}
	.sumbit-btn{
	    width: 85%;
	    padding:10px 30px;
	    cursor: pointer;;
	    display: block;
	    margin: 20px auto;
	    background: linear-gradient(to right, #FF105F, #FFAD06);
	    border: 0;
	    outline: none;
	    border-radius: 30px;
	    font-size: 15px;
	}
	.sumbit-btn:hover{
	  border-radius: 100rem;
	  padding: 1rem;
	  padding: .5rem 3rem;
	  color: white;
	  box-shadow: 0 0 6px 0 rgba(157, 96, 212, 0.5);
	  border: solid 3px transparent;
	  background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0)), linear-gradient(101deg, #FF105F, #FFAD06);
	  background-origin: border-box;
	  background-clip: content-box, border-box;
	  box-shadow: 2px 1000px 1px #3A3A3A inset;
	}
	#login{
	  left:50px;
	}
	#register{
	  left:450px;
	}
	.error{
		color: red;
	}
	.success{
		color:green;
	}
	<?php
	if(isset($_POST['zarejestruj']))
	{
		$imieA = $_POST['imie'];
		$nazwiskoA = $_POST['nazwisko'];
		$adresA = $_POST['adres'];
		$emailA = $_POST['email'];
		$loginA = $_POST['login'];
		$hasloA = $_POST['haslo'];
		$krajA = $_POST['kraj'];
		$miastoA = $_POST['miasto'];


		$rezultat1 = $conn->query("SELECT login FROM uzytkownikinfo WHERE login='$loginA'");
		if(!$rezultat1) throw new Exception($conn->error); //błąd

		$ile_loginow = $rezultat->num_rows;
		if($ile_loginow>0)
		{
			$correctReg=false;
			$_SESSION['bladLoginR']="Taki login już istnieje!";
		}
		$emailA = $_POST['email'];
		if (!filter_var($emailA, FILTER_VALIDATE_EMAIL)) {
			$correctReg=false;
			$_SESSION['bladEmailR']="Nie prawidlowy format e-mailu!";
		 }
		 if ( !preg_match ("/^[a-zA-Z\s]+$/",$imieA)) {
		 		$correctReg=false;
		 		$_SESSION['bladImieR']="Pole 'Imie' może zawierać tylko litery!";
		 }
		 if ( !preg_match ("/^[a-zA-Z\s]+$/",$nazwiskoA)) {
				 $correctReg=false;
				 $_SESSION['bladNazwiskoR']="Pole 'Imie' może zawierać tylko litery!";
		 }
		 if ( !preg_match ("/^[a-zA-Z\s]+$/",$krajA)) {
				 $correctReg=false;
				 $_SESSION['bladKrajR']="Pole 'Imie' może zawierać tylko litery!";
		 }
		 if ( !preg_match ("/^[a-zA-Z\s]+$/",$miastoA)) {
				 $correctReg=false;
				 $_SESSION['bladMiastoR']="Pole 'Imie' może zawierać tylko litery!";
		 }

		 if($correctReg == true)
		 {
			 $conn->query("INSERT INTO uzytkownikinfo (login,haslo,imie,nazwisko,email,kraj,miasto,adres,id_funkcja) VALUES ('$loginA','$hasloA','$imieA','$nazwiskoA','$emailA','$krajA','$miastoA','$adresA',3)");
			 $_SESSION['Rejestracja']="Rejestracja udana!";
		 }
	}
	 ?>
	</style>
	</head>
	<div class="hero">
        <div class="form-box" id="fb">
          <div class="button-box">
            <div id="btn"></div>
              <button type="button" class="toggle-btn" onclick = "login()">Login</button>
              <button type="button" class="toggle-btn" onclick = "register()">Zarejetruj się</button>
          </div>
          <form id = "login" class="input-group" method="post">
						<?php
						if(isset($_SESSION['bladLogowanieR']))
						{
							echo '<div class="error">'.$_SESSION['bladLogowanieR'].'</div><br>';
							unset($_SESSION['bladLogowanieR']);
						} ?>
            <input type="text"  class="input-value" name = "login" placeholder="Login" required>
            <input type="password"  class="input-value" name = "haslo" placeholder="Hasło" required>
            <button type="submit" class="sumbit-btn" value ="submit" name = "submit">Login</button>
          </form>
          <form id = "register" class="input-group"  method="post">
						<?php
			        if(isset($_SESSION['Rejestracja']))
			        {
			          echo '<div class="success">'.$_SESSION['Rejestracja'].'</div><br>';
			          unset($_SESSION['Rejestracja']);
			        }
			      ?>
            <input type="text" class="input-value" name="login" placeholder="Login" required>
						<?php
			        if(isset($_SESSION['bladLoginR']))
			        {
			          echo '<div class="error">'.$_SESSION['bladLogin'].'</div><br>';
			          unset($_SESSION['bladLoginR']);
			        }
			      ?>
            <input type="password" class="input-value" name="haslo" placeholder="Hasło" required>
            <input type="text" class="input-value" name="imie" placeholder="Imie" required>
						<?php
			        if(isset($_SESSION['bladImieR']))
			        {
			          echo '<div class="error">'.$_SESSION['bladImieR'].'</div><br>';
			          unset($_SESSION['bladImieR']);
			        }
			      ?>
            <input type="text" class="input-value" name="nazwisko" placeholder="Nazwisko" required>
						<?php
			        if(isset($_SESSION['bladNazwiskoR']))
			        {
			          echo '<div class="error">'.$_SESSION['bladNazwiskoR'].'</div><br>';
			          unset($_SESSION['bladNazwiskoR']);
			        }
			      ?>
            <input type="text" class="input-value" name="email" placeholder="E-mail" required>
						<?php
			        if(isset($_SESSION['bladEmailR']))
			        {
			          echo '<div class="error">'.$_SESSION['bladEmailR'].'</div><br>';
			          unset($_SESSION['bladEmailR']);
			        }
			      ?>
            <input type="text" class="input-value" name="kraj" placeholder="Kraj" required>
						<?php
			        if(isset($_SESSION['bladKrajR']))
			        {
			          echo '<div class="error">'.$_SESSION['bladKrajR'].'</div><br>';
			          unset($_SESSION['bladKrajR']);
			        }
			      ?>
            <input type="text" class="input-value" name="miasto" placeholder="Miasto" required>
						<?php
			        if(isset($_SESSION['bladMiastoR']))
			        {
			          echo '<div class="error">'.$_SESSION['bladMiastoR'].'</div><br>';
			          unset($_SESSION['bladMiastoR']);
			        }
			      ?>
            <input type="text" class="input-value" name="adres" placeholder="Adres" required>
            <button type="submit" class="sumbit-btn" name = "zarejestruj">Zarejestruj</button>
          </form>
     </div>
   </div>
		<script>
   var log = document.getElementById("login");
   var reg = document.getElementById("register");
   var btn = document.getElementById("btn");
   var fb = document.getElementById("fb");
   function register(){
     log.style.left = "-400px"
     reg.style.left = "50px"
     btn.style.left = "110px"
     fb.style.height = "1000px"
   }
   function login(){
     log.style.left = "50px"
     reg.style.left = "450px"
     btn.style.left = "0"
     fb.style.height = "430px"
   }
   </script>
	</body>
</html>
