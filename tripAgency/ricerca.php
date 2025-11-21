<?php  include 'header.php' ?>

<?php  include 'db.php' ?>


<?php

    //impaginazione
    $perPagina = 10;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $perPagina;


    //salvo in varibaili le GET

    $nome_cliente = $_GET['nome_cliente'] ?? '';
    $paese = $_GET['paese'] ?? '';
    $città = $_GET['città'] ?? '';
    $prezzo_max = $_GET['prezzo_max'] ?? '';
    $data = $_GET['data'] ?? '';
    


    //Costruzione della QUERY

    $where = "WHERE 1=1"; // PARTO DA UNA CONDIZIONE CHE è SEMPRE VERA
    $params = []; //CONTIENE I VALORI PER ? (PLACEHOLDER DELLA QUERY)
    $types = ''; // CONTINENE IL BINDING (ssid)

    //Se sto facendo la ricerca per nome
    if($nome_cliente !== ''){

        $where .= " AND (c.nome LIKE ? OR c.cognome LIKE ?)";
        $params[] = "%$nome_cliente%";
        $params[] = "%$nome_cliente%";
        $types .= 'ss';

    }
    if($paese !== ''){

        $where .= " AND (d.paese LIKE ?)";
        $params[] = "%$paese%";
        $types .= 's';

    }
    if($città !== ''){

        $where .= " AND (d.città LIKE ?)";
        $params[] = "%$città%";
        $types .= 's';

    }
    if($prezzo_max !== ''){

        $where .= " AND (d.prezzo <= ? )";
        $params[] = floatval($prezzo_max);
        $types .= 'd';

    }
    if($data !== ''){

        $where .= " AND (p.data_prenotazione = ? )";
        $params[] = $data;
        $types .= 's';

    }
 


    //Conteggio totale
    $stmt = $conn->prepare("SELECT COUNT(*) as total 
                            FROM prenotazioni p
                            JOIN clienti c ON p.id_cliente = c.id
                            JOIN destinazioni d ON p.id_destinazione = d.id
                            $where");
    if($types !== '') $stmt->bind_param($types, ...$params);

    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];
    $totalPages = ceil($total / $perPagina);


    //Risultati impaginati
    $stmt = $conn->prepare("SELECT p.id, c.nome, c.cognome, d.città, d.paese, d.prezzo, p.data_prenotazione
                            FROM prenotazioni p
                            JOIN clienti c ON p.id_cliente = c.id
                            JOIN destinazioni d ON p.id_destinazione = d.id
                            $where ORDER BY p.id DESC LIMIT ? OFFSET ?");
    
    $params[] = $perPagina;
    $params[] = $offset;
    $types .= "ii";
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();



?>


<h2>Ricerca prenotazioni</h2>

    <div class="card mb-4 cl">
        <div class="card-body">
            <form action="" method="GET">
                <div class="row g-3">

                    <div class="col-md-6"><input type="text" name="nome_cliente" value="<?= htmlspecialchars($nome_cliente) ?>" class="form-control" placeholder="Cliente"></div>
                    <div class="col-md-6"><input type="text" name="paese" value="<?= htmlspecialchars($paese) ?>" class="form-control" placeholder="Paese"></div>
                    <div class="col-md-6"><input type="text" name="città" value="<?= htmlspecialchars($città) ?>" class="form-control" placeholder="Città"></div>
                    <div class="col-md-6"><input type="number" name="prezzo_max" value="<?= htmlspecialchars($prezzo_max) ?>" class="form-control" placeholder="Prezzo max euro"></div>
                    <div class="col-md-6"><input type="date" name="data" value="<?= htmlspecialchars($data) ?>" class="form-control"></div>
                    
                    <button class="btn btn-info">Cerca 🔍</button>
                    
                    <!--Anulla btn-->
                    <a href="ricerca.php" class="btn btn-secondary">Annulla</a>
                </div>

            </form>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Paese</th>
                <th class="text-center">Città</th>
                <th class="text-center">Prezzo</th>
                <th class="text-center">Data</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                    
                <tr>
                    <td class="text-center"><?= $row['id'] ?></td>
                    <td class="text-center"><?= $row['nome'] ?></td>
                    <td class="text-center"><?= $row['paese'] ?></td>
                    <td class="text-center"><?= $row['città'] ?></td>
                    <td class="text-center"><?= $row['prezzo'] ?></td>
                    <td class="text-center"><?= $row['data_prenotazione'] ?></td>   
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>






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