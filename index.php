<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: rgba(0, 0, 0, 0.5); /* Fond noir semi-transparent */
        }

        .index-background-slider {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .index-background-slider img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: slide 10s linear infinite;
        }

        @keyframes slide {
            0% { opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; }
        }

        .index-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px; /* Largeur du formulaire */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Ombre pour effet 3D */
            background-color: rgba(255, 255, 255, 0.8); /* Fond blanc semi-transparent */
        }

        .index-h1 {
            text-align: center;
            color: #000; /* Couleur du texte */
        }

        .index-champ {
            margin-bottom: 15px;
        }

        .index-champ label {
            display: block;
            margin-bottom: 5px;
            color: #000; /* Couleur du texte */
        }

        .index-champ input[type="text"],
        .index-champ input[type="email"],
        .index-champ input[type="password"],
        .index-champ input[type="number"],
        .index-champ input[type="radio"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .index-champ button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .index-champ button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .index-toggle-buttons {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .index-toggle-buttons input[type="radio"] {
            display: none;
        }

        .index-toggle-buttons label {
            display: block;
            width: 48%; /* Ajustez la largeur selon vos préférences */
            padding: 10px;
            text-align: center;
            background-color: #fff;
            color: #000;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .index-toggle-buttons input[type="radio"]:checked + label {
            background-color: #007bff;
            color: #fff;
        }
    </style>
    <script>
        function toggleFields() {
            var typeCompte = document.querySelector('input[name="typeCompte"]:checked').value;
            var emailField = document.getElementById('index-emailField');
            var passwordField = document.getElementById('index-passwordField');
            var accountField = document.getElementById('index-accountField');

            if (typeCompte === 'client') {
                emailField.style.display = 'none';
                passwordField.style.display = 'none';
                accountField.style.display = 'block';
            } else if (typeCompte === 'gestionnaire') {
                emailField.style.display = 'block';
                passwordField.style.display = 'block';
                accountField.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="index-background-slider">
        <!-- Ajoutez vos images pour le slide horizontal ici -->
        <img src="assets/img/image1.jpg" alt="Image 1">
        <img src="assets/img/image2.jpg" alt="Image 2">
        <img src="assets/img/image3.jpg" alt="Image 3">
    </div>
    <div class="index-container">
        <h1 class="index-h1">Bienvenue à MalMo Bank</h1>
        <form action="controllers/connexion_controller.php" method="post">
            <div class="index-champ">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="index-champ">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="index-champ">
                <h4>Vous êtes :</h4>
                <div class="index-toggle-buttons">
                    <input type="radio" id="gestionnaire" name="typeCompte" value="gestionnaire" required onchange="toggleFields()">
                    <label for="gestionnaire">Gestionnaire</label>
                    <input type="radio" id="client" name="typeCompte" value="client" required onchange="toggleFields()">
                    <label for="client">Client</label>
                </div>
            <div class="index-champ" id="index-emailField" style="display:none;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="index-champ" id="index-passwordField" style="display:none;">
                <label for="motDePasse">Mot de passe:</label>
                <input type="password" id="motDePasse" name="motDePasse">
            </div>

            <div class="index-champ" id="index-accountField" style="display:none;">
                <label for="numeroCompte">Numéro de compte:</label>
                <input type="number" id="numeroCompte" name="numeroCompte">
            </div>

            <div class="index-champ">
                <button type="submit">Connexion</button>
            </div>
            </form>
            </div>
</body>
</html>
