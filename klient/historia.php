<?php include 'navbarKlient.php';
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
    require_once "connect.php";
    $conn = new mysqli($adres, $login, $haslo, $baza);

    if($conn->connect_error)
    die("Bład połaczenia".$conn->connect_error());
    // uzupelnij tabele rekordami
    $idd = $_SESSION['KlientID'];
    $result = $conn->query("SELECT * FROM przesylka WHERE status = 'Dostarczona' OR status = 'Awizo' AND id_klient ='$idd'") or die($conn->error);

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
     ?>
  </body>
</html>
