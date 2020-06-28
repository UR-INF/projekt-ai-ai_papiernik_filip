<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php?page=pracownik">OrangeBox Panel Pracownika</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
        <form class="form-inline my-2 my-lg-2 float-right" method="post">
            <button class="btn btn-secondary" name="wyloguj" type="submit">Wyloguj</button>
        </form>
    </div>
</nav>
<?php
if ($_SESSION['zalogowany'] == 'pracownik'){
  if(isset($_POST['wyloguj'])){
    $_SESSION = array();
    session_destroy();
    header("Location: index.php?page=logowanie");
}
}else{
header("Location: index.php?page=logowanie");
}
?>
