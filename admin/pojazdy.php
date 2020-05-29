<?php include 'navbarAdmin.php';
$markaA = '';
$modelA ='';
$update = false;

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Pojazdy</title>
  </head>
  <body>
    <div class = "tytul">
      Pojazdy
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
    $result = $conn->query("SELECT * FROM pojazdy") or die($conn->error);

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
            <th scope="col">Marka</th>
            <th scope="col">Model</th>

            <th colspan="2">Akcja</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch_assoc()):
         ?>
         <tr>
           <td><?php echo $row['marka'] ?></td>
           <td><?php echo $row['model'] ?></td>
           <td>
             <form method="POST">
                <input type="submit" name="edytuj" class="btn btn-warning" value="Edytuj">
                <input type="submit" name="usun" class="btn btn-danger" value="Usuń">
                <input type="hidden" value="<?php echo $row['id_pojazd']; ?>" name="id"/>
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
      $result = $conn->query("SELECT * FROM pojazdy WHERE id_pojazd = $id") or die($conn->error);
        $update = true;
        $row = $result->fetch_array();
        $markaA = $row['marka'];
        $modelA = $row['model'];
    }
    if(isset($_POST['aktualizuj'])){
      $idDR = $_POST['idDR'];
      $markaA = $_POST['marka'];
      $modelA = $_POST['model'];
      $conn->query("UPDATE pojazdy SET marka = '$markaA', model = '$modelA' WHERE id_pojazd=$idDR") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Pojazd został zaktualizowany!";
      $_SESSION['msg_type'] = "warning";
    }
     ?>
    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <input type="hidden" name="idDR" value="<?php echo $id; ?>">
      <div class="form-group">
      <label>Marka</label>
      <input type="text" name="marka" value ="<?php echo $markaA; ?>" placeholder="marka" class="form-control">
      </div>
      <div class="form-group">
      <label>Model</label>
      <input type="text" name="model" value ="<?php echo $modelA; ?>" placeholder="model" class="form-control">
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
      $conn->query("DELETE FROM pojazdy WHERE id_pojazd = $id") or die($conn->error);
      echo("<meta http-equiv='refresh' content='0'>");
      $_SESSION['message'] = "Usunięto pojazd z bazy danych!";
      $_SESSION['msg_type'] = "danger";
    }

    // dodaj uzytkownika do bazy
     if(isset($_POST['zapisz'])){
       $markaA = $_POST['marka'];
       $modelA = $_POST['model'];
       $conn->query("INSERT INTO pojazdy (marka,model) VALUES('$markaA','$modelA')") or die($conn->error);
       echo("<meta http-equiv='refresh' content='0'>");
       $_SESSION['message'] = "Dodano pojazd do bazy danych!";
       $_SESSION['msg_type'] = "success";
     }
?>
  </body>
</html>
