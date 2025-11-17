<?php include 'header.php'; ?>
<?php include 'db.php'; ?>

<?php
    // Verifica se il modulo è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera i dati dal form
        $città = $_POST['città'];   // Usa 'città' con l'accento
        $paese = $_POST['paese'];
        $prezzo = $_POST['prezzo'];
        $data_partenza = $_POST['data_partenza'];
        $data_ritorno = $_POST['data_ritorno'];

        // Inserisco i dati nel database
        $query = "INSERT INTO destinazioni (città, paese, prezzo, data_partenza, data_ritorno) 
                  VALUES ('$città', '$paese', '$prezzo', '$data_partenza', '$data_ritorno')";

        if (mysqli_query($conn, $query)) {
            echo "Destinazione aggiunta con successo";
        } else {
            echo "Errore: " . mysqli_error($conn);
        }
    }

    // Recupera tutte le destinazioni dal database
    $query = "SELECT * FROM destinazioni";
    $result = mysqli_query($conn, $query);

    // Recupera i risultati in un array
    $destinazioni = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $destinazioni[] = $row;
        }
    }
?>

<h2 class="mt-3 mb-3">Destinazioni</h2>

<!-- Form-->
<div class="card mb-4 bg-light">
    <div class="card-body">
        <form action="" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="fw-bold">Città :</label>
                    <input type="text" name="città" class="form-control" placeholder="Inserisci il nome della città" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Paese :</label>
                    <input type="text" name="paese" class="form-control" placeholder="Inserisci il nome del paese" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Prezzo :</label>
                    <input type="number" name="prezzo" class="form-control" placeholder="Inserisci il prezzo" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Data di partenza :</label>
                    <input type="date" name="data_partenza" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Data di ritorno :</label>
                    <input type="date" name="data_ritorno" class="form-control" required>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-success mt-3" type="submit">Salva</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabella-->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Città</th>
            <th>Paese</th>
            <th>Prezzo</th>
            <th>Data di partenza</th>
            <th>Data di ritorno</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($destinazioni) > 0): ?>
            <?php foreach ($destinazioni as $destinazione): ?>
                <tr>
                    <td><?= $destinazione['id'] ?></td>
                    <td><?= $destinazione['città'] ?></td>
                    <td><?= $destinazione['paese'] ?></td>
                    <td><?= $destinazione['prezzo'] ?> €</td>
                    <td><?= $destinazione['data_partenza'] ?></td>
                    <td><?= $destinazione['data_ritorno'] ?></td>
                    <td>
                        <a href="editdestinazione.php?id=<?= $destinazione['id'] ?>" class="btn btn-warning">🖊️</a>
                        <a href="deletedestinazione.php?id=<?= $destinazione['id'] ?>" class="btn btn-danger">🗑️</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Nessuna destinazione trovata</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
