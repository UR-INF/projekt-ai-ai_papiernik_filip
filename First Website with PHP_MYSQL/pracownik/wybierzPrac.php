$result = $conn->query("SELECT * FROM uzytkownikinfo WHERE id_funkcja = 3") or die($conn->error);
    $result1 = $conn->query("SELECT * FROM odbiorca") or die($conn->error);

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
                <input type="submit" name="wybierz" class="btn btn-success" value="Wybierz">
                <input type="hidden" value="<?php echo $row['id_uzytkownikinfo']; ?>" name="id"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>


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
                <input type="submit" name="wybierzodbiorca" class="btn btn-success" value="Wybierz">
                <input type="hidden" value="<?php echo $row['id_odbiorca']; ?>" name="idOdbiorca"/>
            </form>
           </td>
         <?php endwhile; ?>
         </tr>
         </tbody>
      </table>
    </div>
