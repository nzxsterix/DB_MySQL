    <?php include 'header.php'; ?>
    <?php include 'db.php'; ?>

    <h2 class="mt-3 mb-3">Destinazioni</h2>

        <!--form-->
        <div class="card mb-4 bg-light">
            <div class="card-body">
                <form action="" method="POST">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="fw-bold">Città :</label>
                            <input type="text" name="citta" class="form-control" placeholder="Inserisci il nome" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Paese :</label>
                            <input type="text" name="paese" class="form-control" placeholder="Inserisci il nome" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Prezzo :</label>
                            <input type="number" name="prezzo" class="form-control" placeholder="Inserisci il nome" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Data di partenza :</label>
                            <input type="date" name="data_partenza" class="form-control" placeholder="Inserisci il nome" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold">Data di ritorno :</label>
                            <input type="date" name="data_ritorno" class="form-control" placeholder="Inserisci il nome" required>
                        </div>

                         <div class="col-md-12">
                            <button class="btn btn-success mt-3" type="submit">Salva</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>

         <!--Tabella-->
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

            </tbody>
        </table>




     <?php include 'footer.php'; ?>