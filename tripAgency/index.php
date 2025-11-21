<?php include 'header.php'; ?>


    <div class="text-center py-4">

        <h1 class="display-4">Benvenuti in Trip-Agency</h1>
        <p class="lead">esplora le nostre destinazioni, gestisci i clienti e monitora le prenotazioni</p>

    </div>

    <div class="d-flex align-items-center justify-content-center mb-5 flex-wrap">

        <img src="./img/family.png" alt="img famiglia" class="img-card">
        <img src="./img/mappa.png" alt="img mappa" class="img-card">
        <img src="./img/booking.png" alt="img booking" class="img-card">

    </div>

     <!--SEZIONE CARD-->
    <div class="row justify-content-center ms-5 me-5 g-3 mb-5">

        <div class="col-md-4">
            <div class="card cl shadow-sm h-100">
                <div class="card-body text-center">
                   <h5 class="card-title">Clienti</h5>
                   <p class="card-text">Gestisci le informazioni dei tuoi clienti</p>
                   <a href="clienti.php" class="btn btn-primary">Vai ai Clienti</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card cl shadow-sm h-100">
                <div class="card-body text-center">
                   <h5 class="card-title">Destinazioni</h5>
                   <p class="card-text">Consulta o aggiungi nuove mete turistiche</p>
                   <a href="destinazioni.php" class="btn btn-success">Vai alle Destinazioni</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card cl shadow-sm h-100">
                <div class="card-body text-center">
                   <h5 class="card-title">Prenotazioni</h5>
                   <p class="card-text">Visualizza e registra le prenotazioni dei tuoi clienti</p>
                   <a href="prenotazioni.php" class="btn btn-warning">Vai alle prenotazioni</a>
                </div>
            </div>
        </div>
                        
        
    </div>

<?php include 'footer.php'; ?>