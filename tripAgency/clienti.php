<?php
    include 'header.php';
    include 'db.php';

    // Impostazioni per la paginazione
    $perPagina = 10; // Mostro 10 risultati per pagina
    $paginaCorrente = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Ottieni la pagina corrente (di default la prima)
    $offset = ($paginaCorrente - 1) * $perPagina; // Calcola l'offset per la query

    // Verifica se il modulo è stato inviato
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])) {

        // Preparo lo stato stmt per l'inserimento cliente
        $stmt = $conn->prepare("INSERT INTO clienti (nome, cognome, email, telefono, nazione, codice_fiscale, documento) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Bind dei parametri e tipizzo "in questo caso erano 7 stringhe 's'"
        $stmt->bind_param("sssssss", $_POST["nome"], $_POST["cognome"], $_POST["email"], $_POST["telefono"],
                            $_POST["nazione"], $_POST["codice_fiscale"], $_POST["documento"]);

        // Esecuzione dello statement
        $stmt->execute();
        echo "<div class='alert alert-success'>Cliente Aggiunto</div>";
    }

    // numero totale di clienti per la paginazione
    $queryTotale = "SELECT COUNT(*) as t FROM clienti";
    $resultTotale = $conn->query($queryTotale);
    $total = $resultTotale->fetch_assoc()['t'];

    // Calcola il numero totale di pagine
    $totalPagine = ceil($total / $perPagina);

    // clienti dal DB con ordinamento crescente per ID e 10$perPagina
    $query = "SELECT * FROM clienti ORDER BY id ASC LIMIT $perPagina OFFSET $offset";
    $result = mysqli_query($conn, $query);

    $clienti = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $clienti[] = $row;
        }
    }
?>

    <h2 class="mt-3 mb-3">Clienti</h2>

    <!-- Form-->
    <div class="card mb-4 bg-light">
        <div class="card-body">
            <form action="" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Nome :</label>
                        <input type="text" name="nome" class="form-control" placeholder="Inserisci il nome" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Cognome :</label>
                        <input type="text" name="cognome" class="form-control" placeholder="Inserisci il cognome" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Email :</label>
                        <input type="email" name="email" class="form-control" placeholder="Inserisci l'email" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Telefono :</label>
                        <input type="text" name="telefono" class="form-control" placeholder="Inserisci il telefono" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Nazione :</label>
                        <input type="text" name="nazione" class="form-control" placeholder="Inserisci la nazione" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Codice Fiscale :</label>
                        <input type="text" name="codice_fiscale" class="form-control" placeholder="Inserisci il codice fiscale" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Documento :</label>
                        <input type="text" name="documento" class="form-control" placeholder="Inserisci il nome del documento" required>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-success mt-3" type="submit">Salva</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Tabella dei clienti -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Nazione</th>
                <th>Codice Fiscale</th>
                <th>Documento</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($clienti) > 0): ?>
                <?php foreach ($clienti as $cliente): ?>
                    <tr>
                        <td><?= $cliente['id'] ?></td>
                        <td><?= $cliente['nome'] ?></td>
                        <td><?= $cliente['cognome'] ?></td>
                        <td><?= $cliente['email'] ?></td>
                        <td><?= $cliente['telefono'] ?></td>
                        <td><?= $cliente['nazione'] ?></td>
                        <td><?= $cliente['codice_fiscale'] ?></td>
                        <td><?= $cliente['documento'] ?></td>
                        <td>
                            <a href="editcliente.php?id=<?= $cliente['id'] ?>" class="btn btn-warning">🖊️</a>
                            <a href="deleteclienti.php?id=<?= $cliente['id'] ?>" class="btn btn-danger">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="text-center">Nessun cliente trovato</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginazione -->
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPagine; $i++): ?>
                <li class="page-item <?= $i == $paginaCorrente ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

<?php include 'footer.php'; ?>
