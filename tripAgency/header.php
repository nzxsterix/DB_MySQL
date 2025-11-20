
<?php 

    //recupero il nome della pagina corrente
    $currentPage = basename($_SERVER['PHP_SELF']);
    //questo restituisce la pagina corrente e evidenzia la nav


?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIP_AGENCY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">

            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img class="logo" src="./img/logo.png" alt="">
                Trip-Agency
            </a>

            <!-- Hamburger btn -->
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse align-items-end" id="navbarNav">
                <div class="navbar-nav align-items-end item_right">

                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'clienti.php') ? 'active' : '' ?>" href="clienti.php">Clienti</a>
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'destinazioni.php') ? 'active' : '' ?>" href="destinazioni.php">Destinazioni</a>
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'Prenotazioni.php') ? 'active' : '' ?>" href="Prenotazioni.php">Prenotazioni</a>
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'Ricerca.php') ? 'active' : '' ?>" href="Ricerca.php">Ricerca</a>
                    <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'Statistiche.php') ? 'active' : '' ?>" href="Statistiche.php">Statistiche</a>

                </div>
            </div>

        </div>
    </nav>



    <main>
    









