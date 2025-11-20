<?php 
    include 'header.php'; 
    include 'db.php'; 


    //Logica per impaginazione
    $perPagina = 5;  // n elementi mostrati per pagina
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $perPagina;





    //LOGICA DI AGGIUNTA
    //chiamata POST che prende il gancio del bottone aggiugi del form, prendendo i valori inseriti nei vari campi
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])){

        $upload = null;

        //controllo del documento se effetivamente esiste
        //$_FILES contiene tutti i file caricati tramite input
        //$_FILES['documento']['name'] nome originale scelto dal utente
        //if(!empty) se non è vuoto quindi il file è stato caricato se è vuoto non si fa l'upload
        if(!empty($_FILES['documento']['name'])){

            //estrae il nome del file senza percorso
            //viene tolto il path e preso solo il nome del file
            $upload = time() . "_" . basename($_FILES['documento']['name']); //nomefile
            //sposto il file da cartella tmp alla cartella uploads/ 
            move_uploaded_file($_FILES['documento']['tmp_name'], "uploads/" . $upload);
        };

        //Preparo lo stato stmt -> statement 
        $stmt = $conn->prepare("INSERT INTO clienti (nome, cognome, email, telefono, nazione, codice_fiscale, documento) 
                                VALUES  (?, ?, ?, ?, ?, ?, ?)");
        //Binding dei parametri e tipizzo
        $stmt->bind_param("sssssss", $_POST['nome'], $_POST['cognome'], $_POST['email'], $_POST['telefono'], $_POST['nazione'], $_POST['codice_fiscale'], $_POST['documento']);
        
        //eseguo lo statement
        $stmt->execute();

        echo "<div class='alert alert-success'>Cliente Aggiunto!</div>";

         echo "
            <script>
    
                setTimeout(function () {

                    window.location.href = 'clienti.php'

                }, 3000);
    
            </script> ";

        
        exit;


    }
    




    //LOGICA DI MODIFICA
    $cliente_modifica = null;

    if (isset($_GET['modifica'])){


        $res = $conn->query("SELECT * FROM clienti WHERE id = " . intval($_GET['modifica']));

        $cliente_modifica = $res->fetch_assoc();

    }





    //MODIFICA DEL DATO, SALVATAGGIO 
    if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['salva_modifica'])){


        if(!empty($_FILES['documento']['name'])){

            //estrae il nome del file senza percorso
            //viene tolto il path e preso solo il nome del file
            $NuovoDocumento = time() . "_" . basename($_FILES['documento']['name']); //nomefile
            //sposto il file da cartella tmp alla cartella uploads/ 
            move_uploaded_file($_FILES['documento']['tmp_name'], "uploads/" . $NuovoDocumento);

        }else {

            $NuovoDocumento = $_POST['documento_esistente'];
        };

        //PREPARE
        $stmt = $conn->prepare("UPDATE clienti SET nome=?, cognome=?, email=?, telefono=?, nazione=?, codice_fiscale=?, documento=? WHERE id=?");
        //BINDING
        $stmt->bind_param("sssssssi" ,$_POST['nome'],$_POST['cognome'],$_POST['email'],$_POST['telefono'],$_POST['nazione'],$_POST['codice_fiscale'], $NuovoDocumento, $_POST['id']);
        //ESECUZIONE QUERY
        $stmt->execute();
        //messaggio
        echo "<div class='alert alert-info'>Cliente Modificato correttamente</div>";

        echo "
            <script>
    
                setTimeout(function () {

                    window.location.href = 'clienti.php'

                }, 3000);
    
            </script> ";

        
        exit;
    }





    //CANCELLAZIONE CLIENTE
    if(isset($_GET['elimina'])){

        $id = intval($_GET['elimina']);
        $conn->query("DELETE FROM clienti WHERE id = $id");

        echo "<div class='alert alert-info'>Cliente Cancellato correttamente</div>";
    }

    
 ?>





<h2 class="mt-3 mb-3">Clienti</h2>

    <!--Form-->
    <div class="card mb-4 cl">
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">

                <?php if($cliente_modifica): ?>
                
                    <input type="hidden" name="id" value="<?= $cliente_modifica['id'] ?>">

                <?php endif; ?>

                <div class="row g-3">
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Nome : </label>
                        
                        <!--con value prendo il valore del campo inserito-->
                        <input type="text" name="nome" class="form-control" placeholder="es.: Mario"
                        
                        
                        value="<?= $cliente_modifica['nome'] ?? ''?>"
                        
                        required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Cognome : </label>
                        <input type="text" name="cognome" class="form-control" placeholder="es.: Rossi" 
                        
                        value="<?= $cliente_modifica['cognome'] ?? ''?>"

                        required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Email : </label>
                        <input type="text" name="email" class="form-control" placeholder="es.: mario.rossi@mail.it" 
                        
                        value="<?= $cliente_modifica['email'] ?? ''?>"
                        
                        required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Telefono : </label>
                        <input type="text" name="telefono" class="form-control" placeholder="es.: 393406587398" 
                        
                        value="<?= $cliente_modifica['telefono'] ?? ''?>"
                        
                        required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Nazione : </label>
                        <input type="text" name="nazione" class="form-control" placeholder="es.: Italia" 
                        
                        value="<?= $cliente_modifica['nazione'] ?? ''?>"
                        
                        required>
                    </div>
                    
                    <div class="col-md-6">
                        <label style="font-weight: 600;  color: rgb(97, 137, 137);" for="">Codice Fiscale : </label>
                        <input type="text" name="codice_fiscale" class="form-control" placeholder="Codice Fiscale di 16 cifre..." 
                        
                        value="<?= $cliente_modifica['codice_fiscale'] ?? ''?>"
                        
                        required>
                    </div>


                    <?php if ($cliente_modifica) : ?>

                        <input type="hidden" name="documento_esistente" value="<?= $cliente_modifica['documento'] ?>"> 

                    <?php endif;  ?>

                    <div class="col-md-6">
                        <label style="font-weight: 600; color: rgb(97, 137, 137);" for="">Documento : </label>
                        <input type="file" name="documento" class="form-control" placeholder="Inserisci il codice del documento del cliente..." 
                        
                        value="<?= $cliente_modifica['documento'] ?? ''?>"
                        >

                    </div>

                    <div class="col-12">
                            <button name="<?= $cliente_modifica ? 'salva_modifica' : 'aggiungi' ?>" 
                                class="btn <?= $cliente_modifica ? 'btn-warning' : 'btn-success' ?>" type="submit">
                            <?= $cliente_modifica ? 'Salva' : 'Aggiungi' ?>
                        </button>
                        
                        <?php if ($cliente_modifica): ?>
                            <a href="clienti.php" class="btn btn-secondary">
                                Annulla Modifica
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </form>
        </div>
    </div>



    <!--LOGICA RENDER -->
    <?php

        //vado a conteggiare il totale dei clienti con query
        $total = $conn->query("SELECT COUNT(*) as t FROM clienti")->fetch_assoc()['t'];
        $totalPages = ceil($total / $perPagina); // il numero di pagine della navigazione

        //QUERY PER ordinare i dati in modo DECRESCENTE IMPAGINATI PER valore di "$perPagina" 
        $result = $conn->query("SELECT * FROM clienti ORDER BY id ASC LIMIT $perPagina OFFSET $offset");

    ?>





    <!--Tabella-->
    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
                <!--Intestazione tabella-->
                <tr>

                    <th class="text-center">ID</th>
                    <th class="text-center">Nome</th>
                    <th class="text-center">Cognome</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Telefono</th>
                    <th class="text-center">Nazione</th>
                    <th class="text-center">Codice Fiscale</th>
                    <th class="text-center">Documento</th>
                    <th class="text-center">Azioni</th>

                </tr>

            </thead>
            <!--Corpo tabella-->
            <tbody>

                <?php while ($row = $result->fetch_assoc()) : ?>
                    
                    <tr>
                        <td class="text-center"><?= $row['id'] ?></td>
                        <td class="text-center"><?= $row['nome'] ?></td>
                        <td class="text-center"><?= $row['cognome'] ?></td>
                        <td class="text-center"><?= $row['email'] ?></td>
                        <td class="text-center"><?= $row['telefono'] ?></td>
                        <td class="text-center"><?= $row['nazione'] ?></td>
                        <td class="text-center"><?= $row['codice_fiscale'] ?></td>
                        <td class="text-center">
                            <?php if(!empty($row['documento'])) : ?>

                                <a style="font-size: 1.4rem; line-height: 1;" href="uploads/<?= $row>['documento'] ?>"
                                
                                    download
                                    data-bs-toggle="tooltip"
                                    title="scarica : <?= $row>['documento'] ?>">🗎

                                </a>

                            <?php else : ?>
                                <span style="font-size: 1.4rem; line-height: 1;">🗋</span>
                            <?php endif ?>
                        </td>
                        <td class="text-center">

                            <a class="btn btn-sm btn-warning mb-2" href="?modifica=<?= $row['id']  ?>">🖊️</a>
                            <a class="btn btn-sm btn-danger mb-2" href="?elimina=<?= $row['id']  ?>" onclick="return confirm ('Se cancelli il cliente anche la prenotazione verrà cancellata')">🗑️</a>


                        </td>
                    </tr>


                <?php endwhile; ?>

            </tbody>

        </table>
    </div>



     <!-- Paginazione -->
    
    <nav class="mb-3">
        <ul class="pagination pagination_personal justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>   
            <?php endfor; ?>
        </ul>
    </nav>

<?php include 'footer.php'; ?>