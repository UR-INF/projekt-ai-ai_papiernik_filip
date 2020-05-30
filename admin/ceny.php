<?php include 'navbarAdmin.php';
$wagaA = '';
$typA ='';
$ubezpieczenieA ='';
$correctCena=true;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ceny</title>
    <style>
      .error{
        color: red;
      }
    </style>
  </head>
  <body>
    <div class = "tytul">
      Ceny
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
    $result = $conn->query("SELECT * FROM ceny") or die($conn->error);

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
            <th>Opłata za 1kg</th>
            <th>Opłata za typ</th>
            <th>Opłata za ubezpieczenie</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['waga'] ?></td>
           <td><?php echo $row['typ'] ?></td>
           <td><?php echo $row['ubezpieczenie'] ?></td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
    <?php
    // edytuj ceny z bazy
      $result = $conn->query("SELECT * FROM ceny WHERE id_ceny = 1") or die($conn->error);
        $row = $result->fetch_array();
        $wagaA = $row['waga'];
        $typA = $row['typ'];
        $ubezpieczenieA = $row['ubezpieczenie'];

    if(isset($_POST['aktualizuj'])){
      $wagaA = $_POST['waga'];
      $typA = $_POST['typ'];
      $ubezpieczenieA = $_POST['ubezpiecznie'];

      if(!is_numeric($wagaA))
      {
       $correctCena=false;
       $_SESSION['bladWaga']="Pole 'Waga' może zawierać tylko cyfry!";
      }

      if(!is_numeric($typA))
      {
       $correctCena=false;
       $_SESSION['bladTyp']="Pole 'Typ' może zawierać tylko cyfry!";
      }


      if(!is_numeric($ubezpieczenieA))
      {
       $correctCena=false;
       $_SESSION['bladUbezpieczenie']="Pole 'Ubezpieczenie' może zawierać tylko cyfry!";
      }


      if($correctCena == true){
      $conn->query("UPDATE ceny SET waga = '$wagaA', typ = '$typA', ubezpieczenie = '$ubezpieczenieA' WHERE id_ceny=1") or die($conn->error);
      $_SESSION['message'] = "Ceny zostały zaktualizowane!";
      $_SESSION['msg_type'] = "warning";
      echo("<meta http-equiv='refresh' content='0'>");
    }

    }
     ?>
    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <div class="form-group">
      <label>Koszt za wage: (1kg)</label>
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
      <label>Koszt za typ przewozu: (Międzynarodowy/Krajowy)</label>
      <input type="text" name="typ" value ="<?php echo $typA; ?>" placeholder="typ" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladTyp']))
        {
          echo '<div class="error">'.$_SESSION['bladTyp'].'</div><br>';
          unset($_SESSION['bladTyp']);
        }
      ?>
      <div class="form-group">
      <label>Koszt za ubezpieczenie:</label>
      <input type="text" name="ubezpiecznie" value ="<?php echo $ubezpieczenieA; ?>" placeholder="ubezpiecznie" class="form-control" required>
      </div>
      <?php
        if(isset($_SESSION['bladUbezpieczenie']))
        {
          echo '<div class="error">'.$_SESSION['bladUbezpieczenie'].'</div><br>';
          unset($_SESSION['bladUbezpieczenie']);
        }
      ?>
      <div class="form-group">
      <button type="submit" class="btn btn-warning"name="aktualizuj">Aktualizuj</button>
      </div>
      </div>
    </div>
    </form>
  </body>
</html>
