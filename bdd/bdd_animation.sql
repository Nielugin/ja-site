
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



CREATE TABLE FicheTechniqueAnimation (
    idFTA SERIAL PRIMARY KEY,
    nomActivite VARCHAR(200) NOT NULL,
    dureeActivite INT, --duree en minutes
    zoneActivite ENUM('Locale','Regionale','Federale'),
    dateActivite DATE,
    publicVise SET('Bourgeons','Tisons','Explos','Compagnons','Aines'),
    raisonActivite VARCHAR(500),
    texteMedit VARCHAR(100),
    objectifsVises VARCHAR(500),
    themeActivite VARCHAR(300),
    typeActivite VARCHAR(300),
    nombreAnims INT,
    deplacement BOOLEAN,
    fonctionnementEn SET('Individuel','Equipe'),
    constitutionEquipe VARCHAR(100),
    lieuDebutActivite VARCHAR(100),
    lieuFinActivite VARCHAR(100),
    typeDeFin VARCHAR(100),
    trameGenerale VARCHAR(1000),
    deroulementActivite  VARCHAR(20000),
    materiel VARCHAR(500),
    docPJ VARCHAR(100)
);
