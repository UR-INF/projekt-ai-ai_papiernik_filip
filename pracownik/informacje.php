<?php include 'navbarPracownik.php';
$update = 1;
$correctInfo = true;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Pracownicy</title>
    <style>
      .error{
        color: red;
      }
    </style>
  </head>
  <body>
    <div class = "tytul">
      Pracownicy
    </div>
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
      $id = $_POST['id'];
      $update = 0;
    }
    if(isset($_POST['wybierzOdbiorca'])){
      $idOdbiorca = $_POST['idOdbiorca'];
      $update = 2;
    }
  if(isset($_POST['dodaj'])){

    $kosztP = $_POST['koszt'];
    $wagaP = $_POST['waga'];
    $typP = $_POST['typ'];
    $ubezpieczenieP = $_POST['ubezpieczenie'];

    if(!is_numeric($wagaP))
    {
     $correctInfo=false;
     $_SESSION['bladWaga']="Pole 'Waga' może zawierać tylko cyfry!";
    }
    if(!is_numeric($kosztP))
    {
     $correctInfo=false;
     $_SESSION['bladKoszt']="Pole 'Koszt' może zawierać tylko cyfry!";
    }

    if($correctInfo == true)
    {
      $conn->query("INSERT INTO przesylka (id_odbiorca,id_klient,id_pojazd,nazwa_przesylki,) VALUES('$markaA','$modelA')") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Dodano pojazd do bazy danych!";
      $_SESSION['msg_type'] = "success";
      $update = 1;
    }
    else {
      $update = 2;

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
  <?php elseif($update==2): ?>
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
      <label>Typ przesyłki</label>
      <input type="text" name="typ" value ="" placeholder="typ przesylki" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Ubezpieczenie</label>
      <input type="text" name="ubezpieczenie" value ="" placeholder="ubezpieczenie" class="form-control" required>
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
