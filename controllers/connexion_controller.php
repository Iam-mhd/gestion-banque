<?php
session_start();
require '../_config/connexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $typeCompte = $_POST['typeCompte'];

    if ($typeCompte === 'client') {
        $numeroCompte = $_POST['numeroCompte'];

        $query = "SELECT * FROM client WHERE firstname = :prenom AND lastname = :nom AND numeroDeCompte = :numeroCompte";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':numeroCompte', $numeroCompte);
        $stmt->execute();
        $client = $stmt->fetch();

        if ($client) {
            $_SESSION['id_client'] = $client['id'];
            $_SESSION['prenom'] = $client['firstname'];
            $_SESSION['nom'] = $client['lastname'];
            header('Location: acceuil_controller.php');
            exit;
        } else {
            $message = "Informations client incorrectes.";
        }
    } elseif ($typeCompte === 'gestionnaire') {
        $email = $_POST['email'];
        $motDePasse = $_POST['motDePasse'];

        $query = "SELECT * FROM Employer WHERE email = :email AND mot_de_pass = :motDePasse";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':motDePasse', $motDePasse);
        $stmt->execute();
        $employe = $stmt->fetch();

        if ($employe) {
            $_SESSION['id_employee'] = $employe['id'];
            $_SESSION['email'] = $employe['email'];
            header('Location: gestion_controller.php');
            exit;
        } else {
            $message = "Les informations saisies sont incorrectes.";
        }
    }
}



 if (isset($message)) : ?>
    <div><?php echo $message; ?></div>
<?php endif; 
?>


        

        
