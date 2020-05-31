<?php include 'navbarPracownik.php';
$update = 1;
$correctInfo = true;
$correctInfo1 = true;
$_SESSION['koszt'] = 0;
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
    $result = $conn->query("SELECT * FROM uzytkownikinfo WHERE id_funkcja = 3") or die($conn->error);
    $result1 = $conn->query("SELECT * FROM odbiorca") or die($conn->error);
    $result2 = $conn->query("SELECT * FROM pojazdy") or die($conn->error);

    function pre_r($array)
    {
      echo '<pre>';
      print_r($array);
      echo '</pre>';
    }
    ?>
    <?php
    // edytuj uzytkownika z bazy
    if(isset($_POST['wybierzKlient'])){
      $_SESSION['id'] = $_POST['id'];
      $update = 0;
    }
    if(isset($_POST['wybierzOdbiorca'])){
      $_SESSION['idOdbiorca'] = $_POST['idOdbiorca'];
      $help = $_SESSION['idOdbiorca'];
      $result5 = $conn->query("SELECT kraj FROM odbiorca WHERE id_odbiorca = '$help'") or die($conn->error);
      $row=$result5->fetch_assoc();
      $transport = $row['kraj'];
      if($transport != 'polska' or $transport != 'Polska')
      {
        $_SESSION['transport'] = 'Międzynarodowy';
      }
      $update = 2;
    }
    if(isset($_POST['wybierzPojazd'])){
      $_SESSION['idPojazd'] = $_POST['idPojazd'];
      $update = 3;
    }

    // dodaj uzytkownika do bazy
     if(isset($_POST['zapisz'])){
       $imieA = $_POST['imie'];
       $nazwiskoA = $_POST['nazwisko'];
       $telefonA = $_POST['telefon'];
       $krajA = $_POST['kraj'];
       $miastoA = $_POST['miasto'];
       $adresA = $_POST['adres'];
       $peselA = $_POST['pesel'];
       $update = 0;

       if (!is_numeric($telefonA)) {
         $correctInfo1=false;
         $_SESSION['bladTelefon']="Telefon może zawierać tylko liczby!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$imieA)) {
            $correctInfo1=false;
            $_SESSION['bladImie']="Pole 'Imie' może zawierać tylko litery!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$nazwiskoA)) {
            $correctInfo1=false;
            $_SESSION['bladNazwisko']="Pole 'Nazwisko' może zawierać tylko litery!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$krajA)) {
            $correctInfo1=false;
            $_SESSION['bladKraj']="Pole 'Kraj' może zawierać tylko litery!";
        }
        if ( !preg_match ("/^[a-zA-Z\s]+$/",$miastoA)) {
            $correctInfo1=false;
            $_SESSION['bladMiasto']="Pole 'Miasto' może zawierać tylko litery!";
        }
        if ( !preg_match ("/^[0-9]{11}$/",$peselA)) {
            $correctInfo1=false;
            $_SESSION['bladPesel']="Pole 'Pesel' może zawierać tylko liczby i posiadac 11 cyfr!";
        }

       if($correctInfo1 == true){
       $conn->query("INSERT INTO odbiorca (imie,nazwisko,telefon,kraj,miasto,adres,pesel) VALUES('$imieA','$nazwiskoA','$telefonA','$krajA','$miastoA','$adresA','$peselA')") or die($conn->error);
       $_SESSION['message'] = "Dodano odbiorce do bazy danych!";
       $_SESSION['msg_type'] = "success";
       echo("<meta http-equiv='refresh' content='0'>");
       $update = 0;
       }
     }

  if(isset($_POST['dodaj'])){
    $wagaP = $_POST['waga'];
    $nazwaP = $_POST['nazwa'];
    $ubezpieczenieP = $_POST['ubezpieczenie'];

    if(!is_numeric($wagaP))
    {
     $correctInfo=false;
     $_SESSION['bladWaga']="Pole 'Waga' może zawierać tylko cyfry!";
    }

    if($_SESSION['transport'] == 'Międzynarodowy')
    {
      $result7 = $conn->query("SELECT typ FROM ceny WHERE id_ceny = 1") or die($conn->error);
      $row=$result7->fetch_assoc();
      $_SESSION['koszt'] = $_SESSION['koszt'] + $row['typ'];
      $typP = 'Międzynarodowy';
    }
    else{
      $typP = 'Krajowy';
    }


    if($_POST['ubezpieczenie'] == 'Tak'){
      $result4 = $conn->query("SELECT ubezpieczenie FROM ceny WHERE id_ceny = 1") or die($conn->error);
      $row=$result4->fetch_assoc();
      $_SESSION['koszt'] = $_SESSION['koszt'] + $row['ubezpieczenie'];
    }

    if($correctInfo == true)
    {
      $idOdbiorca = $_SESSION['idOdbiorca'];
      $idKlient = $_SESSION['id'];
      $idPojazd = $_SESSION['idPojazd'];

      $result10 = $conn->query("SELECT waga FROM ceny WHERE id_ceny = 1") or die($conn->error);
      $row=$result10->fetch_assoc();
      $kosztI = $_SESSION['koszt'] + $wagaP * $row['waga'];

      $conn->query("INSERT INTO przesylka (id_odbiorca,id_klient,id_pojazd,nazwa_przesylki,waga,typ_przesylki,ubezpieczenie,koszt,status) VALUES('$idOdbiorca','$idKlient','$idPojazd','$nazwaP','$wagaP','$typP','$ubezpieczenieP','$kosztI','Rejestracja')") or die($conn->error);
      $_SESSION['message'] = "Dodano przesyłke do bazy danych!";
      $_SESSION['msg_type'] = "success";
      echo("<meta http-equiv='refresh' content='0'>");
      $update = 1;
    }
    else {
      $update = 3;

    }
  }

     ?>
    <form class="" action="" method="post">
      <?php
      if($update==1):
       ?>
       <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Imie</th>
            <th scope="col">Nazwisko</th>
            <th scope="col">E-mail</th>
            <th scope="col">Kraj</th>
            <th scope="col">Miasto</th>
            <th scope="col">Adres</th>
            <th colspan="2">Akcja</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['imie'] ?></td>
           <td><?php echo $row['nazwisko'] ?></td>
           <td><?php echo $row['email'] ?></td>
           <td><?php echo $row['kraj'] ?></td>
           <td><?php echo $row['miasto'] ?></td>
           <td><?php echo $row['adres'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="wybierzKlient" class="btn btn-success" value="Wybierz">
                <input type="hidden" value="<?php echo $row['id_uzytkownikinfo']; ?>" name="id"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
  <?php elseif($update==0): ?>
      <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Imie</th>
            <th scope="col">Nazwisko</th>
            <th scope="col">Telefon</th>
            <th scope="col">Kraj</th>
            <th scope="col">Miasto</th>
            <th scope="col">Adres</th>
            <th scope="col">Pesel</th>
            <th colspan="2">Akcja</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result1->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['imie'] ?></td>
           <td><?php echo $row['nazwisko'] ?></td>
           <td><?php echo $row['telefon'] ?></td>
           <td><?php echo $row['kraj'] ?></td>
           <td><?php echo $row['miasto'] ?></td>
           <td><?php echo $row['adres'] ?></td>
           <td><?php echo $row['pesel'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="wybierzOdbiorca" class="btn btn-success" value="Wybierz">
                <input type="hidden" value="<?php echo $row['id_odbiorca']; ?>" name="idOdbiorca"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
    <div class = "row justify-content-center">
      <div>
    <div class="form-group">
    <label>Imie</label>
    <input type="text" name="imie" value ="" placeholder="imie" class="form-control" >
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
    <input type="text" name="nazwisko" value ="" placeholder="nazwisko" class="form-control" >
    </div>
    <?php
      if(isset($_SESSION['bladNazwisko']))
      {
        echo '<div class="error">'.$_SESSION['bladNazwisko'].'</div><br>';
        unset($_SESSION['bladNazwisko']);
      }
    ?>
    <div class="form-group">
    <label>Telefon</label>
    <input type="text" name="telefon" value ="" placeholder="telefon" class="form-control" >
    </div>
    <?php
      if(isset($_SESSION['bladTelefon']))
      {
        echo '<div class="error">'.$_SESSION['bladTelefon'].'</div><br>';
        unset($_SESSION['bladTelefon']);
      }
    ?>
    <div class="form-group">
    <label>Kraj</label>
    <input type="text" name="kraj" value ="" placeholder="kraj" class="form-control" >
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
    <input type="text" name="miasto" value ="" placeholder="miasto" class="form-control" >
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
    <input type="text" name="adres" value ="" placeholder="adres" class="form-control" >
    </div>
    <div class="form-group">
    <label>Pesel</label>
    <input type="text" name="pesel" value ="" placeholder="pesel" class="form-control" >
    </div>
    <?php
      if(isset($_SESSION['bladPesel']))
      {
        echo '<div class="error">'.$_SESSION['bladPesel'].'</div><br>';
        unset($_SESSION['bladPesel']);
      }
    ?>
    <div class="form-group">
    <button type="submit" class="btn btn-success"name="zapisz">Dodaj</button>
  </div>
    </div>
  </div>
  <?php elseif($update==2): ?>
      <div>
      <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Marka</th>
            <th scope="col">Model</th>

            <th colspan="2">Akcja</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result2->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['marka'] ?></td>
           <td><?php echo $row['model'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="wybierzPojazd" class="btn btn-success" value="Wybierz">
                <input type="hidden" value="<?php echo $row['id_pojazd']; ?>" name="idPojazd"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
  <?php elseif($update==3): ?>
    <div class = "row justify-content-center">
    <div>
    <form class="" action="" method="post">
      <div class="form-group">
      <label>Nazwa przesyłki</label>
      <input type="text" name="nazwa" value ="" placeholder="nazwa przesylki" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Waga</label>
      <input type="text" name="waga" value ="" placeholder="waga" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladWaga']))
        {
          echo '<div class="error">'.$_SESSION['bladWaga'].'</div><br>';
          unset($_SESSION['bladWaga']);
        }
      ?>
      <div class="form-group">
      <label>Ubezpieczenie</label>
      <select name="ubezpieczenie" class="form-control form-control-lg">
                            <option value="Tak">Tak</option>
                            <option value="Nie">Nie</option>
      </select>
      </div>
      <?php
        if(isset($_SESSION['bladKoszt']))
        {
          echo '<div class="error">'.$_SESSION['bladKoszt'].'</div><br>';
          unset($_SESSION['bladKoszt']);
        }
      ?>
      <div class="form-group">
      <input type="submit" name="dodaj" class="btn btn-success" value="Dodaj">
      </div>
    </form>
    </div>
          </div>
    <?php endif; ?>
    </form>
  </body>
</html>
