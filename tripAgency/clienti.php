    <?php include 'header.php'; ?>
    <?php include 'db.php'; ?>

    <h2 class="mt-3 mb-3">Clienti</h2>

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
                            <input type="file" name="documento" class="form-control" placeholder="Inserisci il documento" required>
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

            </tbody>
        </table>



        <?php include 'footer.php'; ?>