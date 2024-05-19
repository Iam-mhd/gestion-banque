<?php

require_once '../_config/connexion.php';

class Client {
    private $firstName;
    private $lastName;
    private $addresse;
    private $telephone;
    private $typeDeCompte;
    private $numeroDeCompte;
    private $connect;

    public function __construct($connect, $row = null) {
        $this->connect = $connect;
        if ($row != null) {
            $this->hydrate($row);
        }
    }

    public function hydrate($row) {
        $this->firstName = $row["firstname"];
        $this->lastName = $row["lastname"];
        $this->addresse = $row["addresse"];
        $this->telephone = $row["telephone"];
        $this->typeDeCompte = $row["typeDeCompte"];
        $this->numeroDeCompte = $row["numeroDeCompte"];
    }

    public function voirSolde($numeroDeCompte) {
      $sql = "SELECT solde FROM CompteBancaire WHERE numeroDeCompte = ?";
      $stmt = $this->connect->prepare($sql); 
      $stmt->execute([$numeroDeCompte]); 
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC); 
  
      if ($result) {
          $balance = $result["solde"];
          return $balance;
      } else {
          return null;
      }
  }
  
  public function voirHistorique($numeroDeCompte) {
      $sql = "SELECT * FROM Transaction WHERE numeroDeCompte = ?";
      $stmt = $this->connect->prepare($sql); 
      $stmt->execute([$numeroDeCompte]);
  
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
  
      return $result;
  }
  

}
?>
