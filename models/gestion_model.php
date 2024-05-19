<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <title>Opérations bancaires</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        section {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="number"],
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<form action="gestion_controller.php" method="post">
    <section class="depot" style="display: none;">
        <label for="numeroDepot">Numéro de compte :</label>
        <input type="number" id="numeroDepot" name="numeroDepot">
        <br>
        <label for="montantDepot">Montant :</label>
        <input type="number" id="montantDepot" name="montantDepot">
        <br>
        <button type="submit" name="operation" value="depot">Effectuer un dépôt</button>
    </section>

    <section class="retrait" style="display: none;"> 
        <label for="numeroRetrait">Numéro de compte :</label>
        <input type="number" id="numeroRetrait" name="numeroRetrait">
        <br>
        <label for="montantRetrait">Montant :</label>
        <input type="number" id="montantRetrait" name="montantRetrait">
        <br>
        <button type="submit" name="operation" value="retrait">Effectuer un retrait</button>
    </section>

    <section class="virement" style="display: none;">
        <label for="numeroSource">Compte source :</label>
        <input type="number" id="numeroSource" name="numeroSource" >
        <br>
        <label for="numeroDestinataire">Compte destinataire :</label>
        <input type="number" id="numeroDestinataire" name="numeroDestinataire" >
        <br>
        <label for="montantVirement">Montant :</label>
        <input type="number" id="montantVirement" name="montantVirement">
        <br>
        <button type="submit" name="operation" value="virement">Effectuer un virement</button>
    </section>
</form>

<script>
    $(document).ready(function(){
        $("#btn-depot").click(function(){
            $(".depot").show();
            $(".retrait, .virement").hide();
        });
        $("#btn-retrait").click(function(){
            $(".retrait").show();
            $(".depot, .virement").hide();
        });
        $("#btn-virement").click(function(){
            $(".virement").show();
            $(".depot, .retrait").hide();
        });
    });
</script>
</body>
</html>
