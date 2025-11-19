<?php 
    include 'header.php'; 
    include 'db.php'; 

    //Logica per impaginazione
    $perPagina = 10;  // n elementi mostrati per pagina
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $perPagina;

    //QUERY PER ESTRARRE DATI PER SELECT DROPDOWN Clienti e Destinazioni
    $clienti = $conn->query("SELECT id, nome, cognome FROM clienti");
    $destinazioni = $conn->query("SELECT id, città, paese FROM destinazioni");

    //LOGICA DI AGGIUNTA
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['aggiungi'])) {
        $stmt = $conn->prepare("INSERT INTO prenotazioni (id_cliente, id_destinazione, data_prenotazione, acconto, assicurazione) 
                                VALUES  (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisii", $_POST['id_cliente'], $_POST['id_destinazione'], $_POST['data_prenotazione'], $_POST['acconto'], $_POST['assicurazione']);
        $stmt->execute();
        echo "<div class='alert alert-success'>Prenotazione Aggiunta!</div>";
    }

    //LOGICA DI MODIFICA
    $prenotazione_modifica = null;
    if (isset($_GET['modifica'])) {
        $res = $conn->query("SELECT * FROM prenotazioni WHERE id = " . intval($_GET['modifica']));
        $prenotazione_modifica = $res->fetch_assoc();
    }

    //MODIFICA DEL DATO, SALVATAGGIO 
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['salva_modifica'])) {
        $stmt = $conn->prepare("UPDATE prenotazioni SET id_cliente=?, id_destinazione=?, data_prenotazione=?, acconto=?, assicurazione=? WHERE id=?");
        $stmt->bind_param("iisiii", $_POST['id_cliente'], $_POST['id_destinazione'], $_POST['data_prenotazione'], $_POST['acconto'], $_POST['assicurazione'], $_POST['id']);
        $stmt->execute();
        echo "<div class='alert alert-info'>Prenotazione Modificata correttamente</div>";
    }

    //CANCELLAZIONE CLIENTE
    if (isset($_GET['elimina'])) {
        $id = intval($_GET['elimina']);
        $conn->query("DELETE FROM prenotazioni WHERE id = $id");
        echo "<div class='alert alert-info'>Prenotazione Cancellata correttamente</div>";
    }

    //Conteggio totale dei clienti
    $total = $conn->query("SELECT COUNT(*) as t FROM prenotazioni")->fetch_assoc()['t'];
    $totalPages = ceil($total / $perPagina); // il numero di pagine della navigazione

    //QUERY ASSOCIAZIONE JOIN TRA LE DUE TABELLE
    $stmt = $conn->prepare("SELECT p.id, c.nome, c.cognome, d.città, d.paese, p.data_prenotazione, p.acconto, p.assicurazione
                            FROM prenotazioni p
                            JOIN clienti c ON p.id_cliente = c.id
                            JOIN destinazioni d ON p.id_destinazione = d.id
                            ORDER BY p.id DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $perPagina, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<h2 class="mt-3 mb-3">Prenotazioni</h2>

    <!--Form-->
    <div class="card cl mb-4 justify-content-center">
        <div class="card-body">
            <form action="" method="POST">
                <?php if ($prenotazione_modifica): ?>
                    <input type="hidden" name="id" value="<?= $prenotazione_modifica['id'] ?>">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Cliente: </label>
                        <select name="id_cliente" class="form-select" required>
                            <option value="">Seleziona il cliente</option>
                            <?php while ($c = $clienti->fetch_assoc()) : ?>
                                <option value="<?= $c['id'] ?>" 
                                        <?= (isset($prenotazione_modifica) && $prenotazione_modifica['id_cliente'] == $c['id']) ? 'selected' : '' ?>>
                                    <?= $c['nome'] . ' ' . $c['cognome'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Destinazione: </label>
                        <div class="wrapper py-0">
                            <select name="id_destinazione" class="form-control" required>
                                <option value="">Seleziona Destinazione</option>
                                <?php while ($d = $destinazioni->fetch_assoc()) : ?>
                                    <option value="<?= $d['id'] ?>" 
                                            <?= (isset($prenotazione_modifica) && $prenotazione_modifica['id_destinazione'] == $d['id']) ? 'selected' : '' ?>>
                                        <?= $d['città'] . ' ' . $d['paese'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>    
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Data Prenotazione: </label>
                        <input type="date" name="data_prenotazione" class="form-control" 
                            value="<?= $prenotazione_modifica['data_prenotazione'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Acconto: </label>
                        <input type="number" name="acconto" class="form-control" placeholder="Es. 200" 
                            value="<?= $prenotazione_modifica['acconto'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label style="font-weight: 600;" for="">Assicurazione: </label>
                        
                        <!-- Se prenotazione_modifica['assicurazione'] è vuota o 0, lascia vuoto il campo -->
                        <input type="radio" name="assicurazione" value="1" 
                            <?= (isset($prenotazione_modifica) && $prenotazione_modifica['assicurazione'] == 1) ? 'checked' : '' ?>>
                        <label for="assicurazione">Sì</label>
                        <input type="radio" name="assicurazione" value="0" 
                            <?= (isset($prenotazione_modifica) && $prenotazione_modifica['assicurazione'] == 0) ? 'checked' : '' ?>>
                        <label for="assicurazione">No</label>
                    </div>

                    <div class="col-md-12">
                        <button name="<?= $prenotazione_modifica ? 'salva_modifica' : 'aggiungi' ?>" 
                                class="btn <?= $prenotazione_modifica ? 'btn-warning' : 'btn-success' ?>" 
                                type="submit">
                            <?= $prenotazione_modifica ? 'Salva' : 'Aggiungi' ?>
                        </button>
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
                <th>Cliente</th>
                <th>Destinazione</th>
                <th>Data</th>
                <th>Acconto</th>
                <th>Assicurazione</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['nome'] . ' ' . $row['cognome'] ?></td>
                    <td><?= $row['città'] ?></td>
                    <td><?= $row['data_prenotazione'] ?></td>
                    <td><?= $row['acconto'] ?></td>
                    <td><?= $row['assicurazione'] ? 'Sì' : 'No' ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="?modifica=<?= $row['id'] ?>">🖊️</a>
                        <a class="btn btn-sm btn-danger" href="?elimina=<?= $row['id'] ?>" onclick="return confirm('Sicuro?')">🗑️</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

   <!-- Paginazione -->
    <nav>
        <ul class="pagination justify-content-center">

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>   
            <?php endfor; ?>

        </ul>
    </nav>

    <?php include 'footer.php'; ?>