<?php
require 'db.php';

// prendo l'id del contatto dalla query string, se esiste
$contatto_id = $_GET['contatto_id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $prodotto = $_POST['prodotto'];
    $quantita = $_POST['quantita'];
    $data_di_ordine = $_POST['data_di_ordine'];
    $contatto = $_POST['contatto']; // questo è il valore nascosto

    // query di inserimento
    $sql = "INSERT INTO ordini (prodotto, quantita, data_di_ordine, contatto_id) 
            VALUES ('$prodotto', '$quantita', '$data_di_ordine', '$contatto')";

    mysqli_query($conn, $sql);

    // reindirizzo alla lista ordini
    header("Location: ordini.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v<?= time() ?>">
    <title>Aggiungi ordine</title>
</head>
<body>
<div class="container">
    <h1>Aggiungi ordine</h1>

    <form action="" method="POST">
        
        Prodotto: <input type="text" name="prodotto" required>
        Quantità: <input type="number" name="quantita" min="1" required>
        Data di ordine: <input type="date" name="data_di_ordine" required>

        
        <input type="hidden" name="contatto" value="<?= htmlspecialchars($contatto_id) ?>">

        <button type="submit" class="buttonSave">Salva</button>

    </form>

    <a href="ordini.php" class="button">Torna alla lista ordini</a>
</div>
</body>
</html>
