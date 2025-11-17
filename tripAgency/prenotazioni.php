<?php include 'header.php'; ?>

<h2 class="mt-3 mb-3">Prenotazione</h2>

<!-- Form di prenotazione -->
<div class="card mb-4 bg-light">
    <div class="card-body">
        <form action="" method="POST">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="fw-bold">ID Cliente :</label>
                    <input type="text" name="id_cliente" class="form-control" placeholder="Inserisci ID Cliente" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">ID Destinazione :</label>
                    <input type="text" name="id_destinazione" class="form-control" placeholder="Inserisci ID Destinazione" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Data Prenotazione :</label>
                    <input type="date" name="data_prenotazione" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Acconto :</label>
                    <input type="number" name="acconto" class="form-control" placeholder="Inserisci l'acconto" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Numero di Persone :</label>
                    <input type="number" name="numero_persone" class="form-control" placeholder="Inserisci il numero di persone" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Assicurazione :</label>
                    <div>
                        <label>
                            <input type="checkbox" name="assicurazione" value="1"> Assicurazione
                        </label>
                    </div>
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
            <th>ID Cliente</th>
            <th>ID Destinazione</th>
            <th>Data Prenotazione</th>
            <th>Acconto</th>
            <th>Numero Persone</th>
            <th>Assicurazione</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

<?php include 'footer.php'; ?>
