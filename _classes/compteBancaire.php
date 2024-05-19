<?php
require_once '../_config/connexion.php';

class CompteBancaire {

    private $numeroDeCompte;
    private $solde;
    private $proprietaire;
    private $typeDeCompte;
    private $DateCreation; 
    private $connect; 
 
    public function __construct($connect, $row=null){
        $this->connect = $connect;
        if($row!=null){
            $this->hydrate($row);
        }
    }

    public function hydrate($row) {
        $this->numeroDeCompte = $row["numeroDeCompte"];
        $this->solde = $row["solde"];
        $this->proprietaire = $row["proprietaire"];
        $this->typeDeCompte = $row["typeDeCompte"];
        $this->DateCreation = $row["DateCreation"];
    }

    public function creerCompte($numeroDeCompte, $solde, $proprietaire, $typeDeCompte) {
       
        $sql = "INSERT INTO CompteBancaire (numeroDeCompte, solde, proprietaire, typeDeCompte)
                 VALUES (:numeroDeCompte, :solde, :proprietaire, :typeDeCompte)";
        
        $stmt = $this->connect->prepare($sql);
    
        $stmt->bindParam(':numeroDeCompte', $numeroDeCompte, PDO::PARAM_INT);
        $stmt->bindParam(':solde', $solde, PDO::PARAM_INT);
        $stmt->bindParam(':proprietaire', $proprietaire, PDO::PARAM_STR);
        $stmt->bindParam(':typeDeCompte', $typeDeCompte, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo "Compte créé avec succès! Numéro de compte: $numeroDeCompte\n";
        } else {
            echo "Erreur lors de la création du compte : " . $stmt->errorInfo()[2] . "\n";
        }
        
        $stmt->closeCursor(); 
    }
        
    
    public function modifierCompte($numeroDeCompte, $nouveauxDonnees) {
       
        $sql = "UPDATE CompteBancaire 
                SET solde = :solde, proprietaire = :proprietaire, typeDeCompte = :typeDeCompte
                WHERE numeroDeCompte = :numeroDeCompte";
        

        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':solde', $nouveauxDonnees['solde'], PDO::PARAM_INT);
        $stmt->bindParam(':proprietaire', $nouveauxDonnees['proprietaire'], PDO::PARAM_STR);
        $stmt->bindParam(':typeDeCompte', $nouveauxDonnees['typeDeCompte'], PDO::PARAM_STR);
        $stmt->bindParam(':numeroDeCompte', $numeroDeCompte, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo "Compte $numeroDeCompte modifié avec succès!\n";
        } else {
            echo "Erreur lors de la modification du compte : " . $stmt->errorInfo()[2] . "\n";
        }
        
        $stmt->closeCursor();
    }

    public function supprimerCompte($numeroDeCompte) {

        $sql = "DELETE FROM CompteBancaire WHERE numeroDeCompte = :numeroDeCompte";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':numeroDeCompte', $numeroDeCompte, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo "Compte $numeroDeCompte supprimé avec succès!\n";
        } else {
            echo "Erreur lors de la suppression du compte : " . $stmt->errorInfo()[2] . "\n";
        }
        
        $stmt->closeCursor();
    }
    
}
?>
