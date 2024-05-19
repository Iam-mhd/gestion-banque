

CREATE TABLE Client (
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    addresse VARCHAR(255) NOT NULL,
    telephone INT(250) NOT NULL,
    typeDeCompte VARCHAR(250);
    numeroDeCompte INT(250) NOT NULL
    
);

CREATE TABLE CompteBancaire(
    numeroDeCompte INT(250) PRIMARY KEY NOT NULL,
    solde INT(250),
    proprietaire VARCHAR(255) NOT NULL,
    typeDeCompte VARCHAR(255) NOT NULL,
    DateCreation DATE DEFAULT NOW()
);

CREATE TABLE Employer(
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone INT(250) NOT NULL,
    niveauEtude VARCHAR(255) NOT NULL,
    mot_de_pass VARCHAR(255) NOT NULL
);

CREATE TABLE Transaction (
    numeroDeCompte INT(250) NOT NULL,
    montant INT(250) NOT NULL,
    typeTransaction ENUM('depot', 'retrait', 'virement') NOT NULL,
    dateTransaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (numeroDeCompte) REFERENCES CompteBancaire(numeroDeCompte)
);


<div class="champ">
            <h4>Vous êtes :</h4>
            <input type="radio" id="gestionnaire" name="typeCompte" value="gestionnaire" required onchange="toggleFields()">
            <label for="gestionnaire">Gestionnaire</label><br>
            <input type="radio" id="client" name="typeCompte" value="client" required onchange="toggleFields()">
            <label for="client">Client</label><br>
        </div>  