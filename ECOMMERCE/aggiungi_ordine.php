<?php
    require 'db.php';

    //se il form è stato inviato tramite POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $prodotto = $_POST['prodotto'];
        $quantita = $_POST['quantita'];
        $data_di_ordine = $_POST['data_di_ordine'];
        $contatto = $_POST['contatto'];

        //query di inserimento
        $sql = "INSERT INTO ordini (prodotto, quantita, data_di_ordine, contatto) VALUES ('$prodotto', '$quantita', '$data_di_ordine', '$contatto')";

        mysqli_query($conn, $sql);

        //reindirizzo alla lista ordini
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
            Contatto id: <input type="number" name="contatto" required>

            <button type="submit">Salva</button>
        </form>

        <a href="ordini.php" class="button">Torna alla lista ordini</a>
    </div>

</body>
</html>
