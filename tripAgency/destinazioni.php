<?php 
    include 'header.php'; 
    include 'db.php'; 

    // Logica per impaginazione
    $perPagina = 10;  // Numero di elementi per pagina
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $perPagina;

    // Logica di aggiunta
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])) {
        // Preparo lo statement per l'inserimento di una destinazione
        $stmt = $conn->prepare("INSERT INTO destinazioni (città, paese, prezzo, data_partenza, data_ritorno, posti_disponibili) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        // Binding dei parametri
        $stmt->bind_param("ssdssi", $_POST['città'], $_POST['paese'], $_POST['prezzo'], $_POST['data_partenza'], $_POST['data_ritorno'], $_POST['posti_disponibili']);
        
        // Esecuzione dello statement
        $stmt->execute();

        echo "<div class='alert alert-success'>Destinazione Aggiunta!</div>";
    }

    // Logica di modifica
    $destinazione_modifica = null;
    if (isset($_GET['modifica'])) {
        $res = $conn->query("SELECT * FROM destinazioni WHERE id = " . intval($_GET['modifica']));
        $destinazione_modifica = $res->fetch_assoc();
    }

    // Logica per il salvataggio delle modifiche
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['salva_modifica'])) {
        // Preparo lo statement per aggiornare la destinazione
        $stmt = $conn->prepare("UPDATE destinazioni SET città=?, paese=?, prezzo=?, data_partenza=?, data_ritorno=?, posti_disponibili=? WHERE id=?");

        // Binding dei parametri CORRETTO
        $stmt->bind_param("ssdssii", 
            $_POST['città'], 
            $_POST['paese'], 
            $_POST['prezzo'], 
            $_POST['data_partenza'], 
            $_POST['data_ritorno'], 
            $_POST['posti_disponibili'],
            $_POST['id']
        );

        // Esecuzione dello statement
        $stmt->execute();
        
        echo "<div class='alert alert-info'>Destinazione Modificata correttamente</div>";
    }

    // Logica di cancellazione
    if (isset($_GET['elimina'])) {
        $id = intval($_GET['elimina']);
        $conn->query("DELETE FROM destinazioni WHERE id = $id");
        echo "<div class='alert alert-info'>Destinazione cancellata correttamente</div>";
    }

    // Query per ottenere il totale delle destinazioni e la paginazione
    $total = $conn->query("SELECT COUNT(*) as t FROM destinazioni")->fetch_assoc()['t'];
    $totalPages = ceil($total / $perPagina); // Numero di pagine della navigazione

    // Query per recuperare le destinazioni in ordine crescente, con paginazione
    $result = $conn->query("SELECT * FROM destinazioni ORDER BY id ASC LIMIT $perPagina OFFSET $offset");
?>

<h2 class="mt-3 mb-3">Destinazioni</h2>

    <!-- Form di inserimento e modifica destinazione -->
    <div class="card mb-4 cl">
        <div class="card-body">
            <form action="" method="POST">

                <?php if ($destinazione_modifica): ?>
                    <input type="hidden" name="id" value="<?= $destinazione_modifica['id'] ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Città: </label>
                        <input type="text" name="città" class="form-control" placeholder="es.: Roma" 
                            value="<?= $destinazione_modifica['città'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Paese: </label>
                        <input type="text" name="paese" class="form-control" placeholder="es.: Italia" 
                            value="<?= $destinazione_modifica['paese'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Prezzo: </label>
                        <input type="number" step="0.01" name="prezzo" class="form-control" placeholder="es.: 99.99" 
                            value="<?= $destinazione_modifica['prezzo'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Data di Partenza: </label>
                        <input type="date" name="data_partenza" class="form-control" 
                            value="<?= $destinazione_modifica['data_partenza'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Data di Ritorno: </label>
                        <input type="date" name="data_ritorno" class="form-control" 
                            value="<?= $destinazione_modifica['data_ritorno'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Posti disponibili </label>
                        <input type="number" name="posti_disponibili" class="form-control" 
                            value="<?= $destinazione_modifica['posti_disponibili'] ?? '' ?>" required>
                    </div>

                   <div class="col-12">
                        <button name="<?= $destinazione_modifica ? 'salva_modifica' : 'aggiungi' ?>" 
                                class="btn <?= $destinazione_modifica ? 'btn-warning' : 'btn-success' ?>" type="submit">
                            <?= $destinazione_modifica ? 'Salva' : 'Aggiungi' ?>
                        </button>
                        
                        <?php if ($destinazione_modifica): ?>
                            <a href="destinazioni.php" class="btn btn-secondary">
                                Annulla Modifica
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabella delle destinazioni -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Città</th>
                <th>Paese</th>
                <th>Prezzo</th>
                <th>Data Partenza</th>
                <th>Data Ritorno</th>
                <th>Posti disponibili</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['città'] ?></td>
                    <td><?= $row['paese'] ?></td>
                    <td><?= $row['prezzo'] ?></td>
                    <td><?= $row['data_partenza'] ?></td>
                    <td><?= $row['data_ritorno'] ?></td>
                    <td><?= $row['posti_disponibili'] ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="?modifica=<?= $row['id'] ?>">🖊️</a>
                        <a class="btn btn-sm btn-danger" href="?elimina=<?= $row['id'] ?>" onclick="return confirm('Se cancelli la destinazione le prenotazioni verranno cancellate')">🗑️</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Paginazione -->
    <nav>
        <ul class="pagination justify-content-center">

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>   
            <?php endfor; ?>

        </ul>
    </nav>

<?php include 'footer.php'; ?>
