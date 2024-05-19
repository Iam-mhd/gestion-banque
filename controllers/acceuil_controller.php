<?php
require_once '../_config/connexion.php';
require_once '../_classes/client.php';

session_start();

if (!isset($_SESSION['id_client'])) {

    header('Location: ../index.php');
    exit;
}

$id_client = $_SESSION['id_client'];

$sql = "SELECT * FROM client WHERE id = ?";
$stmt = $connect->prepare($sql);
$stmt->execute([$id_client]);
$clientData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$clientData) {
    echo "Client non trouvé.";
    exit;
}

$numeroDeCompte = $clientData['numeroDeCompte'];

$client = new Client($connect, $clientData);

$historique = $client->voirHistorique($numeroDeCompte);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil Client</title>
    <style>
        body {
            background-image: url('../assets/img/img4.jpg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            animation: slideshow 9s infinite; 
            font-size: 20px; 
        }

        @keyframes slideshow {
            0% { background-image: url('../assets/img/img1.jpg'); }
            33% { background-image: url('../assets/img/img2.jpg'); }
            66% { background-image: url('../assets/img/img3.jpg'); }
        }

        #header {
            background-color: rgba(255, 255, 255, 0.8);
            text-align: right;
        }

        #header img {
            max-width: 200px;
            float: right;
        }

        #deconnexion {
            background-color: #ff0000;
            color: #fff; 
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-size: 24px;
            margin-top: 10px;
            display: inline-block;
            float: left; 
        }

        #solde {
            background-color: rgba(0, 0, 0, 0.5); 
            color: #fff; 
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div id="header">
    
    <a id="deconnexion" href="../views/includes/deconnexion.php">Déconnexion</a>
</div>
<div id="solde">
    <h1>Bienvenue, <?php echo htmlspecialchars($clientData['firstname'] . ' ' . $clientData['lastname']); ?>!</h1>
    <h2>Votre solde :</h2>
    <div>
        <?php echo $client->voirSolde($numeroDeCompte); ?>
    </div>
</div>

<h2>Historique des transactions :</h2>
<div>
    <?php if ($historique) : ?>
        <table>
            <thead>
                <tr>
                    <th>Montant</th>
                    <th>Type de transaction</th>
                    <th>Date de transaction</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historique as $transaction) : ?>
                    <tr>
                        <td><?php echo $transaction["montant"]; ?></td>
                        <td><?php echo $transaction["typeTransaction"]; ?></td>
                        <td><?php echo $transaction["dateTransaction"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucune transaction trouvée pour le compte numéro <?php echo $numeroDeCompte; ?>.</p>
    <?php endif; ?>
</div>
</body>
</html>
