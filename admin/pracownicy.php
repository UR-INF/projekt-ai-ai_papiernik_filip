<?php include 'navbarAdmin.php';
echo ("pracownicy");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
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

    <div class = "row justify-content-center">
    <form class="" action="" method="post">
      <div class="form-group">
      <label>Login</label>
      <input type="text" name="login" placeholder="login" class="form-control">
      </div>
      <div class="form-group">
      <label>Haslo</label>
      <input type="text" name="haslo" placeholder="haslo" class="form-control">
      </div>
      <div class="form-group">
      <label>Imie</label>
      <input type="text" name="imie" placeholder="imie" class="form-control">
      </div>
      <div class="form-group">
      <label>Nazwisko</label>
      <input type="text" name="nazwisko" placeholder="nazwisko" class="form-control">
      </div>
      <div class="form-group">
      <label>E-mail</label>
      <input type="text" name="email" placeholder="email" class="form-control">
      </div>
      <div class="form-group">
      <label>Kraj</label>
      <input type="text" name="kraj" placeholder="kraj" class="form-control">
      </div>
      <div class="form-group">
      <label>Miasto</label>
      <input type="text" name="miasto" placeholder="miasto" class="form-control">
      </div>
      <div class="form-group">
      <label>Adres</label>
      <input type="text" name="adres" placeholder="adres" class="form-control">
      </div>
      <div class="form-group">
      <label>Funkcja</label>
      <input type="text" name="funkcja" placeholder="funkcja" class="form-control">
      </div>
      <div class="form-group">
      <button type="submit" class="btn btn-success"name="zapisz">Dodaj</button>
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
       $login = $_POST['login'];
       $haslo = $_POST['haslo'];
       $imie = $_POST['imie'];
       $nazwisko = $_POST['nazwisko'];
       $email = $_POST['email'];
       $kraj = $_POST['kraj'];
       $miasto = $_POST['miasto'];
       $adres = $_POST['adres'];
       $funkcja = $_POST['funkcja'];
       $conn->query("INSERT INTO uzytkownikinfo (login,haslo,imie,nazwisko,email,kraj,miasto,adres,id_funkcja) VALUES('$login','$haslo','$imie','$nazwisko','$email','$kraj','$miasto','$adres','$funkcja')") or die($conn->error);
       echo("<meta http-equiv='refresh' content='0'>");
       $_SESSION['message'] = "Dodano użytkownika do bazy danych!";
       $_SESSION['msg_type'] = "success";
     }

  // edytuj uzytkownika z bazy
  if(isset($_POST['edytuj'])){
    $id = $_POST['id'];

  }
?>
  </body>
</html>
