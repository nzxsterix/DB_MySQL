<?php
    require 'db.php';

    // controllo se il form è stato inviato
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $nazione = $_POST['nazione'];
        $codice_fiscale = $_POST['codice_fiscale'];
        $documento = $_POST['documento'];

        if ($id) {
            // aggiorno il database
            mysqli_query($conn, "UPDATE clienti SET nome='$nome', cognome='$cognome', email='$email', telefono='$telefono', nazione='$nazione', codice_fiscale='$codice_fiscale', documento='$documento' WHERE id=$id");

            // Dopo aver aggiornato, torno alla lista clienti
            header("Location: clienti.php");
        }
    }

    // prendo l'id del cliente da modificare
    $id = $_GET['id'];

    // ottengo i dati del cliente
    $result = mysqli_query($conn, "SELECT * FROM clienti WHERE id = $id");

    // recupero i dati del singolo cliente
    $row = mysqli_fetch_assoc($result);
?>

<?php include 'header.php'; ?>

<h2 class="mt-3 mb-3">Modifica Cliente</h2>

<div class="card mb-4 bg-light">
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="fw-bold" for="nome">Nome:</label>
                    <input type="text" name="nome" class="form-control" value="<?= $row['nome'] ?>" placeholder="Inserisci il nome" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold" for="cognome">Cognome:</label>
                    <input type="text" name="cognome" class="form-control" value="<?= $row['cognome'] ?>" placeholder="Inserisci il cognome" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold" for="email">Email:</label>
                    <input type="email" name="email" class="form-control" value="<?= $row['email'] ?>" placeholder="Inserisci l'email" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold" for="telefono">Telefono:</label>
                    <input type="text" name="telefono" class="form-control" value="<?= $row['telefono'] ?>" placeholder="Inserisci il telefono" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold" for="nazione">Nazione:</label>
                    <input type="text" name="nazione" class="form-control" value="<?= $row['nazione'] ?>" placeholder="Inserisci la nazione" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold" for="codice_fiscale">Codice Fiscale:</label>
                    <input type="text" name="codice_fiscale" class="form-control" value="<?= $row['codice_fiscale'] ?>" placeholder="Inserisci il codice fiscale" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold" for="documento">Documento:</label>
                    <input type="text" name="documento" class="form-control" value="<?= $row['documento'] ?>" placeholder="Inserisci il documento" required>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-success mt-3" type="submit">Salva</button>
                </div>
            </div>
        </form>

        <a href="clienti.php" class="btn btn-secondary mt-3">Torna alla lista clienti</a>
    </div>
</div>

<?php include 'footer.php'; ?>
