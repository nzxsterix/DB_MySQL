<?php

    //importo il file db

    require 'db.php';

    //salvo in una variabile $result, i risultati della query

    $resultOrdini = mysqli_query($conn,'SELECT * FROM ordini'); //query per prendere tutta la tabella degli ordini


?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v<?= time() ?>">
    <title>Lista ordini</title>
</head>
<body>

    <div class="container">

        <h1>Lista ordini</h1>
        <a href="aggiungi_ordine.php" class="button">Aggiungi ordine</a>
        <a href="index.php" class="button">Torna ai contatti</a>

        <table>
            <thead>
                <tr>
                    <th>Prodotto</th>
                    <th>Quantità</th>
                    <th>Data ordine</th>
                    <th>Contatto</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php while($rowOrdini = mysqli_fetch_assoc($resultOrdini)) : ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($rowOrdini['prodotto']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($rowOrdini['quantita']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($rowOrdini['data_di_ordine']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($rowOrdini['contatto_id']) ?>
                        </td>
                        <td class="actions">
                            <a href="modifica_ordine.php?id=<?= $rowOrdini['id'] ?>">🖊️</a>
                            <a href="elimina_ordine.php?id=<?= $rowOrdini['id'] ?>"onclick="return confirm('Eliminare questo ordine?');">🗑️</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    </div>

</body>
</html>
