<?php include 'navbarAdmin.php';
$loginA = '';
$hasloA = '';
$imieA = '';
$nazwiskoA = '';
$emailA = '';
$krajA = '';
$miastoA = '';
$adresA = '';
$funkcjaA = '';
$update = false;
$correct = true;

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Pracownicy</title>
    <style>
      .error{
        color: red;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <?php
    if(isset($_SESSION['message'])):
     ?>
     <div class="alert alert-<?=$_SESSION['msg_type']?>">
       <?php
       echo $_SESSION['message'];
       unset($_SESSION['message']);
        ?>
     </div>
     <?php
   endif; ?>
    <?php
    require_once "connect.php";
    $conn = new mysqli($adres, $login, $haslo, $baza);

    if($conn->connect_error)
    die("Bład połaczenia".$conn->connect_error());
    // uzupelnij tabele rekordami
    $result = $conn->query("SELECT * FROM uzytkownikinfo") or die($conn->error);

    function pre_r($array)
    {
      echo '<pre>';
      print_r($array);
      echo '</pre>';
    }
    ?>
    <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Login</th>
            <th scope="col">Haslo</th>
            <th scope="col">Imie</th>
            <th scope="col">Nazwisko</th>
            <th scope="col">Email</th>
            <th scope="col">Kraj</th>
            <th scope="col">Miasto</th>
            <th scope="col">Adres</th>
            <th scope="col">Funkcja</th>
            <th colspan="2">Akcja</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['login'] ?></td>
           <td><?php echo $row['haslo'] ?></td>
           <td><?php echo $row['imie'] ?></td>
           <td><?php echo $row['nazwisko'] ?></td>
           <td><?php echo $row['email'] ?></td>
           <td><?php echo $row['kraj'] ?></td>
           <td><?php echo $row['miasto'] ?></td>
           <td><?php echo $row['adres'] ?></td>
           <td><?php echo $row['id_funkcja'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="edytuj" class="btn btn-warning" value="Edytuj">
                <input type="submit" name="usun" class="btn btn-danger" value="Usuń">
                <input type="hidden" value="<?php echo $row['id_uzytkownikinfo']; ?>" name="id"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
    <?php
    // edytuj uzytkownika z bazy
    if(isset($_POST['edytuj'])){
      $id = $_POST['id'];
      $result = $conn->query("SELECT * FROM uzytkownikinfo WHERE id_uzytkownikinfo = $id") or die($conn->error);
        $update = true;
        $row = $result->fetch_array();
        $loginA = $row['login'];
        $hasloA = $row['haslo'];
        $imieA = $row['imie'];
        $nazwiskoA = $row['nazwisko'];
        $emailA = $row['email'];
        $krajA = $row['kraj'];
        $miastoA = $row['miasto'];
        $adresA = $row['adres'];
        $funkcjaA = $row['id_funkcja'];
    }
    if(isset($_POST['aktualizuj'])){
      $idDR = $_POST['idDR'];
      $loginA = $_POST['login'];
      $hasloA = $_POST['haslo'];
      $imieA = $_POST['imie'];
      $nazwiskoA = $_POST['nazwisko'];
      $emailA = $_POST['email'];
      $krajA = $_POST['kraj'];
      $miastoA = $_POST['miasto'];
      $adresA = $_POST['adres'];
      $funkcjaA = $_POST['funkcja'];
      $conn->query("UPDATE uzytkownikinfo SET login = '$loginA',haslo = '$hasloA',imie = '$imieA',nazwisko = '$nazwiskoA',email = '$emailA',kraj = '$krajA',miasto = '$miastoA',adres = '$adresA',id_funkcja = '$funkcjaA' WHERE id_uzytkownikinfo=$idDR") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Użytkownik został zaktualizowany!";
      $_SESSION['msg_type'] = "warning";
    }
     ?>
    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <input type="hidden" name="idDR" value="<?php echo $id; ?>">
      <div class="form-group">
      <label>Login</label>
      <input type="text" name="login" value ="<?php echo $loginA; ?>" placeholder="login" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladLogin']))
        {
          echo '<div class="error">'.$_SESSION['bladLogin'].'</div><br>';
          unset($_SESSION['bladLogin']);
        }
      ?>
      <div class="form-group">
      <label>Haslo</label>
      <input type="text" name="haslo" value ="<?php echo $hasloA; ?>" placeholder="haslo" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Imie</label>
      <input type="text" name="imie" value ="<?php echo $imieA; ?>" placeholder="imie" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladImie']))
        {
          echo '<div class="error">'.$_SESSION['bladImie'].'</div><br>';
          unset($_SESSION['bladImie']);
        }
      ?>
      <div class="form-group">
      <label>Nazwisko</label>
      <input type="text" name="nazwisko" value ="<?php echo $nazwiskoA; ?>" placeholder="nazwisko" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladNazwisko']))
        {
          echo '<div class="error">'.$_SESSION['bladNazwisko'].'</div><br>';
          unset($_SESSION['bladNazwisko']);
        }
      ?>
      <div class="form-group">
      <label>E-mail</label>
      <input type="text" name="email" value ="<?php echo $emailA; ?>" placeholder="email" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladEmail']))
        {
          echo '<div class="error">'.$_SESSION['bladEmail'].'</div><br>';
          unset($_SESSION['bladEmail']);
        }
      ?>
      <div class="form-group">
      <label>Kraj</label>
      <input type="text" name="kraj" value ="<?php echo $krajA; ?>" placeholder="kraj" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladKraj']))
        {
          echo '<div class="error">'.$_SESSION['bladKraj'].'</div><br>';
          unset($_SESSION['bladKraj']);
        }
      ?>
      <div class="form-group">
      <label>Miasto</label>
      <input type="text" name="miasto" value ="<?php echo $miastoA; ?>" placeholder="miasto" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladMiasto']))
        {
          echo '<div class="error">'.$_SESSION['bladMiasto'].'</div><br>';
          unset($_SESSION['bladMiasto']);
        }
      ?>
      <div class="form-group">
      <label>Adres</label>
      <input type="text" name="adres" value ="<?php echo $adresA; ?>" placeholder="adres" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Funkcja</label>
      <select name="funkcja" class="form-control form-control-lg">
                            <option value="1">1-Pracownik</option>
                            <option value="2">2-Admin</option>
                            <option value="3">3-Kurier</option>
      </select>
      </div>
      <div class="form-group">
      <?php
      if($update==true):
       ?>
      <button type="submit" class="btn btn-warning"name="aktualizuj">Aktualizuj</button>
    <?php else: ?>
      <button type="submit" class="btn btn-success"name="zapisz">Dodaj</button>
    <?php endif; ?>
      </div>
      </div>
    </div>
    </form>

    <?php
    // usun uzytkownika z bazy
    if(isset($_POST['usun'])){
      $id = $_POST['id'];
      $conn->query("DELETE FROM uzytkownikinfo WHERE id_uzytkownikinfo = $id") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Usunięto użytkownika z bazy danych!";
      $_SESSION['msg_type'] = "danger";
    }

    // dodaj uzytkownika do bazy
     if(isset($_POST['zapisz'])){
       $loginA = $_POST['login'];
       $hasloA = $_POST['haslo'];
       $imieA = $_POST['imie'];
       $nazwiskoA = $_POST['nazwisko'];
       $emailA = $_POST['email'];
       $krajA = $_POST['kraj'];
       $miastoA = $_POST['miasto'];
       $adresA = $_POST['adres'];
       $funkcjaA = $_POST['funkcja'];

       $rezultat = $conn->query("SELECT id_uzytkownikinfo FROM uzytkownikinfo WHERE login='$loginA'");
       if(!$rezultat) throw new Exception($conn->error); //błąd

       $ile_loginow = $rezultat->num_rows;
       if($ile_loginow>0)
       {
         $correct=false;
         $_SESSION['bladLogin']="Taki login już istnieje!";
       }
       if (!filter_var($emailA, FILTER_VALIDATE_EMAIL)) {
         $correct=false;
         $_SESSION['bladEmail']="Nie prawidlowy format e-mailu!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$imieA)) {
            $correct=false;
            $_SESSION['bladImie']="Pole 'Imie' może zawierać tylko litery!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$nazwiskoA)) {
            $correct=false;
            $_SESSION['bladNazwisko']="Pole 'Nazwisko' może zawierać tylko litery!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$krajA)) {
            $correct=false;
            $_SESSION['bladKraj']="Pole 'Kraj' może zawierać tylko litery!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$miastoA)) {
            $correct=false;
            $_SESSION['bladMiasto']="Pole 'Miasto' może zawierać tylko litery!";
        }

       if($correct == true){
       $conn->query("INSERT INTO uzytkownikinfo (login,haslo,imie,nazwisko,email,kraj,miasto,adres,id_funkcja) VALUES('$loginA','$hasloA','$imieA','$nazwiskoA','$emailA','$krajA','$miastoA','$adresA','$funkcjaA')") or die($conn->error);
       $_SESSION['message'] = "Dodano użytkownika do bazy danych!";
       $_SESSION['msg_type'] = "success";
       }
       echo("<meta http-equiv='refresh' content='0'>");
     }
?>
  </body>
</html>
