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
    $compteBancaire = new CompteBancaire($connect);
    $result = $compteBancaire->supprimerCompte($numeroDeCompte);
    echo "<p>Résultat: $result</p>";
    echo "<a href='gestion_controller.php'>Retour à la liste des comptes</a>";
} else {
    $numeroDeCompte = $_GET['numeroDeCompte'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer Compte Bancaire</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
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

        p {
            margin-bottom: 20px;
            color: #555;
            font-size: 16px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        button {
            padding: 12px;
            background-color: #ff4b2b;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #d7381f;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #ff4b2b;
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
        <h1>Supprimer Compte Bancaire</h1>
        <p>Êtes-vous sûr de vouloir supprimer le compte numéro <?php echo $numeroDeCompte; ?> ?</p>
        <form method="post" action="supprimer.php">
            <input type="hidden" name="numeroDeCompte" value="<?php echo $numeroDeCompte; ?>">
            <button type="submit">Supprimer</button>
        </form>
        <a href="gestion_controller.php">Annuler</a>
    </div>
</body>
</html>

