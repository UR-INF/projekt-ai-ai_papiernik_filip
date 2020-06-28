<?php include 'navbarAdmin.php';
$nazwaA = '';
$wagaA = '';
$typA = '';
$ubezpA = '';
$kosztA = '';
$statusA = '';
$correctPaczki = true;

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Paczki</title>
    <style>
      .error{
        color: red;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <div class = "tytul">
      Paczki
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
    $result = $conn->query("SELECT * FROM przesylka") or die($conn->error);

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
            <th scope="col">Nazwa przesyłki</th>
            <th scope="col">Waga</th>
            <th scope="col">Typ przesyłki</th>
            <th scope="col">Ubezpieczenie</th>
            <th scope="col">Koszt</th>
            <th scope="col">Status</th>
            <th colspan="2">Akcja</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['nazwa_przesylki'] ?></td>
           <td><?php echo $row['waga'] ?></td>
           <td><?php echo $row['typ_przesylki'] ?></td>
           <td><?php echo $row['ubezpieczenie'] ?></td>
           <td><?php echo $row['koszt'] ?></td>
           <td><?php echo $row['status'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="edytuj" class="btn btn-warning" value="Edytuj">
                <input type="submit" name="usun" class="btn btn-danger" value="Usuń">
                <input type="hidden" value="<?php echo $row['id_przesylka']; ?>" name="id"/>
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
      $result = $conn->query("SELECT * FROM przesylka WHERE id_przesylka = $id") or die($conn->error);
        $update = true;
        $row = $result->fetch_array();
        $nazwaA = $row['nazwa_przesylki'];
        $wagaA = $row['waga'];
        $typA = $row['typ_przesylki'];
        $ubezpA = $row['ubezpieczenie'];
        $kosztA = $row['koszt'];
        $statusA = $row['status'];
    }
    if(isset($_POST['aktualizuj'])){
      $idDR = $_POST['idDR'];
      $nazwaA = $_POST['nazwa'];
      $wagaA = $_POST['waga'];
      $typA = $_POST['typ'];
      $ubezpA = $_POST['ubezp'];
      $kosztA = $_POST['koszt'];
      $statusA = $_POST['status'];

      if(!is_numeric($wagaA))
      {
       $correctPaczki=false;
       $_SESSION['bladWaga']="Pole 'Waga' może zawierać tylko cyfry!";
      }
      if(!is_numeric($kosztA))
      {
       $correctPaczki=false;
       $_SESSION['bladKoszt']="Pole 'Koszt' może zawierać tylko cyfry!";
      }

      if($correctPaczki == true){
      $conn->query("UPDATE przesylka SET nazwa_przesylki = '$nazwaA', waga = '$wagaA', typ_przesylki = '$typA', ubezpieczenie = '$ubezpA', koszt = '$kosztA', status = '$statusA'  WHERE id_przesylka=$idDR") or die($conn->error);
      $_SESSION['message'] = "Przesyłka została zaktualizowana!";
      $_SESSION['msg_type'] = "warning";
      echo("<meta http-equiv='refresh' content='0'>");
      }
    }
     ?>
    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <input type="hidden" name="idDR" value="<?php echo $id; ?>">
      <div class="form-group">
      <label>Nazwa</label>
      <input type="text" name="nazwa" value ="<?php echo $nazwaA; ?>" placeholder="nazwa" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Waga</label>
      <input type="text" name="waga" value ="<?php echo $wagaA; ?>" placeholder="waga" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladWaga']))
        {
          echo '<div class="error">'.$_SESSION['bladWaga'].'</div><br>';
          unset($_SESSION['bladWaga']);
        }
      ?>
      <div class="form-group">
      <label>Typ</label>
      <input type="text" name="typ" value ="<?php echo $typA; ?>" placeholder="typ" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Ubezpieczenie</label>
      <input type="text" name="ubezp" value ="<?php echo $ubezpA; ?>" placeholder="ubezpieczenie" class="form-control" required>
      </div>
      <div class="form-group">
      <label>Koszt</label>
      <input type="text" name="koszt" value ="<?php echo $kosztA; ?>" placeholder="koszt" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladKoszt']))
        {
          echo '<div class="error">'.$_SESSION['bladKoszt'].'</div><br>';
          unset($_SESSION['bladKoszt']);
        }
      ?>
      <div class="form-group">
      <label>Status</label>
      <input type="text" name="status" value ="<?php echo $statusA; ?>" placeholder="status" class="form-control" required>
      </div>

      <div class="form-group">
      <button type="submit" class="btn btn-warning"name="aktualizuj">Aktualizuj</button>
      </div>
      </div>
    </div>
    </form>

    <?php
    // usun uzytkownika z bazy
    if(isset($_POST['usun'])){
      $id = $_POST['id'];
      $conn->query("DELETE FROM przesylka WHERE id_przesylka = $id") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Usunięto przesyłke z bazy danych!";
      $_SESSION['msg_type'] = "danger";
    }
    ?>
  </body>
</html>
