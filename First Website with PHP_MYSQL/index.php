<!DOCTYPE HTML>
<html lang="pl">
    <head>

        <meta charset="utf-8"/>
        <meta name="description" content="Firma Transportowa">
        <meta name="author" content="Filip Papiernik">
        <title>Firma Transportowa</title>



        <!--------------------------CSS--------------------->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

        <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" />
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <!--------------------------SCRIPTS------------------>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style>
        body {
            background-image: url('img/bg.jpg');
            height: 100%;
            background-color: #6D6D6D;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            color: white;
}
             }
        </style>


    </head>
    <body>
        <?php


        session_start();


        $current_page = isset($_GET['page']) ? $_GET['page'] : null;



        switch ($current_page)
        {
            case 'logowanie':
            default;
                include 'logowanie.php';
                break;
            case 'admin':
                include 'admin/navbarAdmin.php';
                break;
            case 'paczki':
                include 'admin/paczki.php';
                break;
            case 'pojazdy':
                include 'admin/pojazdy.php';
                break;
            case 'pracownicy':
                include 'admin/pracownicy.php';
                break;
            case 'ceny':
                include 'admin/ceny.php';
                break;
            case 'pracownik':
                include 'pracownik/navbarPracownik.php';
                break;
            case 'wybierzPrac':
                include 'pracownik/wybierzPrac.php';
                break;
            case 'wybierzOdb':
                include 'pracownik/wybierzOdb.php';
                break;
            case 'informacje':
                include 'pracownik/informacje.php';
                break;
            case 'kurier':
                include 'kurier/paczki.php';
                break;
            case 'klient':
                include 'klient/navbarKlient.php';
                break;
            case 'aktywne':
                include 'klient/aktywne.php';
                break;
            case 'historia':
                include 'klient/historia.php';
                break;
        }

        ?>

    </body>
</html>
