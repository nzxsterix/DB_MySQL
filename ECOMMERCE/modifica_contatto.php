<?php

    // importo la connessione col file db (db.php)
    require 'db.php';

    // controllo se il form è stato inviato
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        if ($id) {

            // aggiornamento dati nel database
            mysqli_query($conn, "UPDATE contatti SET nome='$nome', telefono='$telefono', email='$email' WHERE id=$id");

            // dopo aver aggiornato torno ad index
            header("Location: index.php");
            
        }
    }

    // prendo id del contatto
    $id = $_GET['id'] ?? null;

  
    // ottengo i dati del contatto
    $result = mysqli_query($conn, "SELECT * FROM contatti WHERE id = $id");

    $row = mysqli_fetch_assoc($result);

  
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifica contatto</title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>

    <div class="container">
        <h1>modifica contatto</h1>

        <form method="POST">
            
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            
            <input type="text" name="nome" value="<?= htmlspecialchars($row['nome']) ?>">
            
            <input type="text" name="telefono" value="<?= htmlspecialchars($row['telefono']) ?>">
            
            <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>">
            
            <button type="submit" class="buttonSave">salva</button>
        </form>

        <a href="index.php" class="button">Torna ai contatti</a>
    </div>

</body>
</html>
