<?php
require_once '../_config/connexion.php';
require_once '../_classes/compteBancaire.php';

session_start();

if (!isset($_SESSION['id_employee'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numeroDeCompte = $_POST['numeroDeCompte'];
    $nouveauxDonnees = [
        'solde' => $_POST['solde'],
        'proprietaire' => $_POST['proprietaire'],
        'typeDeCompte' => $_POST['typeDeCompte']
    ];

    $compteBancaire = new CompteBancaire($connect);
    $result = $compteBancaire->modifierCompte($numeroDeCompte, $nouveauxDonnees);
    echo "<p>Résultat: $result</p>";
} else {
    $numeroDeCompte = $_GET['numeroDeCompte'];
    // Récupérer les détails du compte pour pré-remplir le formulaire
    $sql = "SELECT * FROM CompteBancaire WHERE numeroDeCompte = :numeroDeCompte";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':numeroDeCompte', $numeroDeCompte, PDO::PARAM_INT);
    $stmt->execute();
    $compte = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    if (!$compte) {
        echo "Compte non trouvé.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Compte Bancaire</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #007bff
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            text-align: left;
        }

        input[type="number"],
        input[type="text"] {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier Compte Bancaire</h1>
        <form method="post" action="modifier.php">
            <input type="hidden" name="numeroDeCompte" value="<?php echo $numeroDeCompte; ?>">
            <label for="solde">Solde:</label>
            <input type="number" name="solde" value="<?php echo $compte['solde']; ?>" required>
            <label for="proprietaire">Propriétaire:</label>
            <input type="text" name="proprietaire" value="<?php echo $compte['proprietaire']; ?>" required>
            <label for="typeDeCompte">Type de compte:</label>
            <input type="text" name="typeDeCompte" value="<?php echo $compte['typeDeCompte']; ?>" required>
            <button type="submit">Modifier</button>
        </form>
        <a href="gestion_controller.php">Retour à la liste des comptes</a>
    </div>
</body>
</html>
