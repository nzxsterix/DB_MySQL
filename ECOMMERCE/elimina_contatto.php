<?php

    // importo la connessione col file db (db.php)
    require 'db.php';

    // prendo id del contatto da eliminare da index(id)
    $id = $_GET['id'];

    // eseguo la query per eliminare il contatto
    mysqli_query($conn, "DELETE FROM contatti WHERE id = $id");

    // dopo aver eliminato il contatto torna ad index.php
    header("Location: index.php");

?>