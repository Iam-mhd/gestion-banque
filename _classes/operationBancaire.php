<?php
require_once '../_config/connexion.php';

class OperationBancaire {
    private $connect;

    public function __construct($connexion) {
        $this->connect = $connexion;
    }

 
    public function verificationCompte($numeroDeCompte) {
        try {
            $sql = "SELECT * FROM CompteBancaire WHERE numeroDeCompte = :numeroDeCompte";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute(['numeroDeCompte' => $numeroDeCompte]);

            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function retournerSolde($numeroDeCompte) {
        try {
            $sql = "SELECT solde FROM CompteBancaire WHERE numeroDeCompte = :numeroDeCompte";
            $stmt = $this->connect->prepare($sql);
            $stmt->execute(['numeroDeCompte' => $numeroDeCompte]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? $result['solde'] : "Solde non disponible";
        } catch (PDOException $e) {
            return "Erreur lors de la récupération du solde : " . $e->getMessage();
        }
    }

    public function effectuerDepot($numeroDeCompte, $montant) {
   
        if (!$this->verificationCompte($numeroDeCompte)) {
            return "Le compte n'existe pas";
        }

        
        $typeTransaction = 'depot';
        $sqlInsertTransaction = "INSERT INTO Transaction (numeroDeCompte, montant, typeTransaction) VALUES (:numeroCompte, :montant, :typeTransaction)";
        $stmtInsertTransaction = $this->connect->prepare($sqlInsertTransaction);
        $stmtInsertTransaction->execute(['numeroCompte' => $numeroDeCompte, 'montant' => $montant, 'typeTransaction' => $typeTransaction]);

       
        $sqlUpdateSolde = "UPDATE CompteBancaire SET solde = solde + :montant WHERE numeroDeCompte = :numeroCompte";
        $stmtUpdateSolde = $this->connect->prepare($sqlUpdateSolde);
        $stmtUpdateSolde->execute(['montant' => $montant, 'numeroCompte' => $numeroDeCompte]);

        return "Dépôt réussi.";
    }


    public function effectuerRetrait($numeroDeCompte, $montant) {
        if (!$this->verificationCompte($numeroDeCompte)) {
            return "Le compte n'existe pas";
        }

        $solde = $this->retournerSolde($numeroDeCompte);
        if ($solde === "Solde non disponible") {
            return $solde;
        }

        if ($solde < $montant) {
            return "Solde insuffisant";
        }

        try {
           
            $this->connect->beginTransaction();

            
            $sqlInsertTransaction = "INSERT INTO Transaction (numeroDeCompte, montant, typeTransaction) VALUES (:numeroDeCompte, :montant, 'retrait')";
            $stmtInsertTransaction = $this->connect->prepare($sqlInsertTransaction);
            $stmtInsertTransaction->execute(['numeroDeCompte' => $numeroDeCompte, 'montant' => $montant]);
            $sqlUpdateSolde = "UPDATE CompteBancaire SET solde = solde - :montant WHERE numeroDeCompte = :numeroDeCompte";
            $stmtUpdateSolde = $this->connect->prepare($sqlUpdateSolde);
            $stmtUpdateSolde->execute(['montant' => $montant, 'numeroDeCompte' => $numeroDeCompte]);

           
            $this->connect->commit();

            return "Retrait effectué avec succès";
        } catch (PDOException $e) {
            $this->connect->rollBack();
            return "Erreur lors du retrait : " . $e->getMessage();
        }
    }

    

    public function effectuerVirement($compteSource, $compteDestinataire, $montant) {
        if (!$this->verificationCompte($compteSource) || !$this->verificationCompte($compteDestinataire)) {
            return "Un des comptes n'existe pas";
        }

        $solde = $this->retournerSolde($compteSource);
        if ($solde === "Solde non disponible") {
            return $solde;
        }

        if ($solde < $montant) {
            return "Solde insuffisant pour effectuer le virement";
        }

        try {
            $this->connect->beginTransaction();
            $retraitResult = $this->effectuerRetrait($compteSource, $montant);
            if ($retraitResult !== "Retrait effectué avec succès") {

                $this->connect->rollBack();
                return $retraitResult;
            }

            $depotResult = $this->effectuerDepot($compteDestinataire, $montant);
            if ($depotResult !== "Dépôt réussi.") {
                $this->effectuerDepot($compteSource, $montant);
                $this->connect->rollBack();
                return $depotResult;
            }
            $this->connect->commit();

            return "Virement effectué avec succès";
        } catch (PDOException $e) {
            $this->connect->rollBack();
            return "Erreur lors du virement : " . $e->getMessage();
        }
    }
}
?>
