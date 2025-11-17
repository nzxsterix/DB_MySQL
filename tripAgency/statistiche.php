<?php include 'header.php'; ?>
<?php include 'db.php'; ?>

<h2 class="mt-3 mb-3">Statistiche</h2>

<!-- Form-->
<div class="card mb-4 bg-light">
    <div class="card-body">
        <form action="" method="GET">
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="fw-bold" for="anno">Anno:</label>
                    <input type="number" id="anno" name="anno" class="form-control" placeholder="Inserisci l'anno" required>
                </div>

                <div class="col-md-3">
                    <label class="fw-bold" for="destinazione">Destinazione:</label>
                    <input type="text" id="destinazione" name="destinazione" class="form-control" placeholder="Inserisci la destinazione" required>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary" type="submit">Aggiorna</button>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <a href="statistiche.php" class="btn btn-outline-success">Esporta in CSV</a>
                </div>

            </div>
        </form>
    </div>
</div>