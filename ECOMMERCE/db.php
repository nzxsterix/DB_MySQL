<?php

    //CONNESSIONE AL DB MySQL USANDO MYSQLI

    //PARAMETRI DI CONNESSIONE AL DATABASE

    $host = "localhost";        //HOSTNAME
    $user = "root";            //USERNAME
    $password = "";           //PASSWORD (viene chiesta durante installazione XAMPP)
    $database = "ecommerce"; //NOME DATABASE di phpmyadmin
    
    //CREAZIONE DELLA CONNESSIONE

    $conn = new mysqli($host, $user, $password, $database);

    //CONTROLLO DELLA CONNESSIONE

    if (!$conn){

        //ERRORE NELLA CONNESSIONE stampa messaggio di errore e termina l'esecuzione dello script
        die("Connessione fallita: " . mysqli_connect());
    }

?>