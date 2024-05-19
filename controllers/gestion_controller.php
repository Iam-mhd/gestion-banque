<?php
require_once '../_config/connexion.php';
require_once '../_classes/operationBancaire.php';
require_once '../models/gestion_model.php';

session_start();

if (!isset($_SESSION['id_employee'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['operation'])) {
    $operation = $_POST['operation'];
    $numeroCompte = $_POST['numeroDepot'] ?? $_POST['numeroRetrait'] ?? $_POST['numeroSource'];
    $montant = $_POST['montantDepot'] ?? $_POST['montantRetrait'] ?? $_POST['montantVirement'];

    $operationBancaire = new OperationBancaire($connect);

    switch ($operation) {
        case 'depot':
            $result = $operationBancaire->effectuerDepot($numeroCompte, $montant);
            break;
        case 'retrait':
            $result = $operationBancaire->effectuerRetrait($numeroCompte, $montant);
            break;
        case 'virement':
            $numeroDestinataire = $_POST['numeroDestinataire'];
            $result = $operationBancaire->effectuerVirement($numeroCompte, $numeroDestinataire, $montant);
            break;
        default:
            $result = "Opération invalide";
    }

    echo "<p>Résultat: $result</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
    <div class="header">
        <div class="logo">MalMo Bank</div>
        <a class="logout" href="../views/includes/deconnexion.php">Déconnexion</a>
    </div>
    <div class="container">
        <div class="sidebar">
            <button type="button" id="btn-depot">Dépôt</button>
            <button type="button" id="btn-retrait">Retrait</button>
            <button type="button" id="btn-virement">Virement</button>
            <a href="creerCompte_controller.php"><button type="button">Créer Un Compte</button></a>
        </div>
        <div class="main-content">
            <h1>Opérations bancaires</h1>
            <?php
            require_once '../_config/connexion.php';
            $sql = "SELECT numeroDeCompte, solde, proprietaire, typeDeCompte, DateCreation
                    FROM CompteBancaire";
            $result = $connect->query($sql);

            echo '<table>';
            echo '<tr><th>Numéro de compte</th><th>Solde</th><th>Propriétaire</th><th>Type de compte</th><th>Date de création</th><th>Actions</th></tr>';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $numeroDeCompte = $row['numeroDeCompte'];
                $solde = $row['solde'];
                $proprietaire = $row['proprietaire'];
                $typeDeCompte = $row['typeDeCompte'];
                $dateCreation = $row['DateCreation'];

                // Dans le bloc HTML qui affiche les comptes
                echo "<tr>
                <td>$numeroDeCompte</td>
                <td>$solde</td>
                <td>$proprietaire</td>
                <td>$typeDeCompte</td>
                <td>$dateCreation</td>
                <td>
                    <a class='btn-modifier' href='modifier_controller.php?numeroDeCompte=$numeroDeCompte'>Modifier</a>
                    <a class='btn-supprimer' href='supprimer_controller.php?numeroDeCompte=$numeroDeCompte'>Supprimer</a>
                </td>
                </tr>";

            }
            echo '</table>';
            ?>
        </div>
    </div>


</body>
</html>

