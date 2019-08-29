
DROP TABLE IF EXISTS Animation ;

CREATE TABLE Animation (
    idAnimation SERIAL PRIMARY KEY,
    dateCreation DATE NOT NULL ,
    userCreation INT REFERENCES Utilisateur(idUtilisateur),
    nomA VARCHAR(200) NOT NULL,
    typeA SET('interieur','exterieur','veillee','jeuCourt','jeuCoop','grandJeu'),
    ageMin INT,
    ageMax INT,
    duree INT,
    nbJoueurMin INT,
    nbJoueurMax INT,
    objPeda VARCHAR(300),
    objSpi VARCHAR(300),
    butJeu VARCHAR(300),
    regles VARCHAR(20000),
    materiel VARCHAR(500),
    docPJ VARCHAR(100)
);
