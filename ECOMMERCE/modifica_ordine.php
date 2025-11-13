<?php
    
    // importo la connessione col file db (db.php)
    require 'db.php';


    // controllo se il form è stato inviato
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $prodotto = $_POST['prodotto'];
        $quantita = $_POST['quantita'];
        $data_di_ordine = $_POST['data_di_ordine'];
        
        if ($id) {
            // aggiorno il database
            mysqli_query($conn, "UPDATE ordini SET prodotto='$prodotto', quantita='$quantita', data_di_ordine='$data_di_ordine' WHERE id=$id");

            // Dopo aver aggiornato, torno alla lista ordini
            header("Location: ordini.php");
            exit;
        }
    }

    // prendo l'id dell'ordine da modificare
    $id = $_GET['id'] ?? null;

    // ottengo i dati dell'ordine
    $result = mysqli_query($conn, "SELECT * FROM ordini WHERE id = $id");

    // recupero i dati del singolo ordine
    $row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Ordine</title>
    <link rel="stylesheet" href="style.css?v=<?= time() ?>">
</head>
<body>

    <div class="container">

        <h1>Modifica Ordine</h1>

        <form method="POST">
            
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="prodotto" value="<?= htmlspecialchars($row['prodotto']) ?>" required>
            <input type="number" name="quantita" value="<?= htmlspecialchars($row['quantita']) ?>" required>
            <input type="date" name="data_di_ordine" value="<?= htmlspecialchars($row['data_di_ordine']) ?>" required>
            <input type="hidden" name="contatto_id" value="<?= htmlspecialchars($row['contatto_id']) ?>">

            <button type="submit" class="buttonSave">Salva</button>
        </form>
        <a href="ordini.php" class="button">Torna alla lista ordini</a>
    </div>

</body>
</html>