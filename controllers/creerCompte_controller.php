<!DOCTYPE html>
<html>
<head>
    <title>Créer un compte bancaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #161616;
            padding: 20px;
            color: #fff;
        }

        h1 {
            text-align: center;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #1f1f1f;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #2f2f2f;
            color: #fff;
        }

        button {
            background-color:  #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="button"] {
            background-color: #f44336;
            color:  #007BFF;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        button[type="submit"] {
            margin-top: 10px;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="buttons-container">
    <button type="button"><a href="../views/includes/deconnexion.php" style="text-decoration: none; color: #fff;">Déconnexion</a></button>
    <button type="button"><a href="gestion_controller.php" style="text-decoration: none; color: #fff;">Retour</a></button>
</div>
<h1>Créer un compte bancaire</h1>

<form method="POST" action="">
    <label for="numeroDeCompte">Numéro de compte :</label>
    <input type="text" name="numeroDeCompte" id="numeroDeCompte" required><br>

    <label for="solde">Solde :</label>
    <input type="number" name="solde" id="solde" required><br>

    <label for="proprietaire">Propriétaire :</label>
    <input type="text" name="proprietaire" id="proprietaire" required><br>

    <label for="typeDeCompte">Type de compte :</label>
    <select name="typeDeCompte" id="typeDeCompte" required>
        <option value="courant">Courant</option>
        <option value="epargne">Épargne</option>
    </select><br>

    <button type="submit" name="creer_compte">Créer compte bancaire</button>
</form>
</body>
</html>
