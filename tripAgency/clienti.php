<?php
include 'header.php';
include 'db.php';

// verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])) {

    //preparo lo stato stmt

    $stmt = $conn->prepare("INSERT INTO clienti (nome, cognome, email, telefono, nazione, codice_fiscale, documento) 
              VALUES (?, ?, ?, ?, ?, ?, ?)");

    //bind dei parametri e tipizzo "in questo caso erano 7 stringhe 's'"
    $stmt->bind_param("sssssss", $_POST["nome"], $_POST["cognome"], $_POST["email"], $_POST["telefono"],
                         $_POST["nazione"], $_POST["codice_fiscale"], $_POST["documento"]);
    //stato di esecuzione dello statement                     
    $stmt->execute();

    echo "<div class='alert alert-success'>Cliente Aggiunto</div>";

    // recupera i dati dal form
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $nazione = $_POST['nazione'];
    $codice_fiscale = $_POST['codice_fiscale'];
    $documento = $_POST['documento'];

    // inserisco i dati nel database
    $query = "INSERT INTO clienti (nome, cognome, email, telefono, nazione, codice_fiscale, documento) 
              VALUES ('$nome', '$cognome', '$email', '$telefono', '$nazione', '$codice_fiscale', '$documento')";

    // eseguo la query
    if (mysqli_query($conn, $query)) {
        echo "Cliente aggiunto con successo";
    } else {
        echo "Errore: " . $query . mysqli_error($conn);
    }
}

?>

<h2 class="mt-3 mb-3">Clienti</h2>

    <!-- Form di inserimento dati -->
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

    <!-- tabella dei clienti -->
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
    <?php
    // eseguo la query per recuperare i clienti dal DB
        $query = "SELECT * FROM clienti";
        $result = mysqli_query($conn, $query);

        $clienti = [];
        if (mysqli_num_rows($result) > 0) {
            // recupero i risultati nella variabile $clienti
            while ($row = mysqli_fetch_assoc($result)) {
                $clienti[] = $row;
            }
        }
    ?>

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

<?php include 'footer.php'; ?>

