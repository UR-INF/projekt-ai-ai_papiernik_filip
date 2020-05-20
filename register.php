<?php
session_start();
$con = mysqli_connect('localhost','root','root');
mysqli_select_db($con, 'projekt');

$login = $_POST['login'];
$haslo = $_POST['haslo'];
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$email = $_POST['email'];
$kraj = $_POST['kraj'];
$miasto = $_POST['miasto'];
$adres = $_POST['adres'];

$s = "SELECT * FROM uzytkownikinfo WHERE login = '$login'";
$result = mysqli_query($con, $s);

$num = mysqli_num_rows($result);
if($num == 1){
  echo "Login jest juz zajęty";
}
else{
  $reg = "INSERT INTO uzytkownikinfo (login, haslo, imie, nazwisko, email, kraj, miasto, adres) VALUES ('$login','$haslo','$imie','$nazwisko','$email','$kraj','$miasto','$adres')";
  mysqli_query($con,$reg);
  echo "Zarejestrowano pomyślnie!";
}
mysqli_close($con);
?>
