<?php

    // importo la connessione col file db (db.php)
    require 'db.php';

    // prendo id del contatto da eliminare (id)
    $id = $_GET['id'];

    // eseguo la query per eliminare il contatto
    mysqli_query($conn, "DELETE FROM clienti WHERE id = $id");

    // dopo aver eliminato il contatto torna a clienti.php
    header("Location: clienti.php");

?>