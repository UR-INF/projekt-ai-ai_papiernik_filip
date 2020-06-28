<?php include 'navbarKurier.php';
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
    $result = $conn->query("SELECT * FROM przesylka WHERE status = 'Rejestracja' OR status ='W transporcie'") or die($conn->error);

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
      $nazwa = $_POST['nazwa'];
      $statusA = $_POST['transport'];
      if($correctPaczki == true){
      $conn->query("UPDATE przesylka SET status = '$statusA'  WHERE id_przesylka=$idDR") or die($conn->error);
      $_SESSION['message'] = "Przesyłka została zaktualizowana!";
      $_SESSION['msg_type'] = "warning";
      echo("<meta http-equiv='refresh' content='0'>");
      }
    }
     ?>
    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <div class="form-group">
      <input type="hidden" name="idDR" value="<?php echo $id; ?>">
    </div>
      <div class="form-group">
        <label>Nazwa</label>
        <input type="text" name="nazwa" value ="<?php echo $nazwaA; ?>" placeholder="nazwa" class="form-control" required>
        </div>
      <label>Status</label>
      <div class="form-group">
      <select name="transport" class="form-control form-control-lg">
                            <option value="Awizo">Awizo</option>
                            <option value="Dostarczona">Dostarczona</option>
                            <option value="W transporcie">W transporcie</option>
      </select>
      </div>
      <div class="form-group">
      <button type="submit" class="btn btn-warning"name="aktualizuj">Aktualizuj</button>
      </div>
    </div>

    </form>
  </body>
</html>
