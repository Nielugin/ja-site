-- Parent (idParent, nom, prenom, adressePostale, email, numeroTel)
-- Adherent(idAdherent, nom, prenom, adressePostale, email, numeroTel, dateNaissance, #idPere, #idMere, #idSection, aPaye)
-- SectionJA (idSection, libelle)
-- Animateur(#idSection, #idAdherent, aBAFA)

DROP TABLE Animateur;
DROP TABLE Utilisateur;
DROP TABLE Adherent;
DROP TABLE Parent;
DROP TABLE Adresse;
DROP TABLE ActiviteJA;
DROP TABLE SectionJA;


CREATE TABLE SectionJA (idSection SERIAL PRIMARY KEY,
libelle VARCHAR(20) NOT NULL);

INSERT INTO SectionJA(libelle) VALUES('tison'),('explorateur'),('compagnon');

CREATE TABLE ActiviteJA (idActivite SERIAL PRIMARY KEY,
dateSamedi DATE NOT NULL,
descCourt VARCHAR(50) DEFAULT 'Activité JA',
descLong VARCHAR(300),
idSection INT REFERENCES SectionJA(idSection)
);

CREATE TABLE Adresse (idAdresse SERIAL PRIMARY KEY,
adressePostale VARCHAR(80) NOT NULL,
adresseCP INT NOT NULL,
adresseVille VARCHAR(30) NOT NULL
);

CREATE TABLE Parent (idParent SERIAL PRIMARY KEY,
nom VARCHAR(30),
prenom VARCHAR(30),
adresse INT REFERENCES Adresse(idAdresse),
email VARCHAR(50),
numeroTel VARCHAR(15)
);


CREATE TABLE Adherent (idAdherent SERIAL PRIMARY KEY,
civilite SET(  'M',  'Mme',  'Mlle' ) NOT NULL,
nom VARCHAR(30) NOT NULL,
nomJeuneFille VARCHAR(30),
prenom VARCHAR(30) NOT NULL,
nationalite VARCHAR(30) DEFAULT 'Française',
adresse INT REFERENCES Adresse(idAdresse),
email VARCHAR(50),
numeroTel VARCHAR(15),
dateNaissance DATE NOT NULL,
lieuNaissance VARCHAR(30) NOT NULL,
departementNaissance INT NOT NULL,
numSecu VARCHAR(30),
nomCaisse VARCHAR(30), 
aPaye BOOLEAN  DEFAULT FALSE,
idPere INT REFERENCES Parent(idParent),
idMere INT REFERENCES Parent(idParent),
idSection INT REFERENCES SectionJA(idSection),
okInterventionMedicale BOOLEAN  DEFAULT TRUE,
okPhotos BOOLEAN  DEFAULT TRUE,
okComuniquerRenseignements BOOLEAN  DEFAULT TRUE
);



CREATE TABLE Animateur (
idSection INT REFERENCES SectionJA(idSection),
idAdherent INT REFERENCES Adherent(idAdherent),
aBAFA BOOLEAN DEFAULT FALSE
);

-- Droits : AT, AE, AC, RT, RE, RC, RJ
CREATE TABLE Utilisateur (
idUtilisateur SERIAL PRIMARY KEY,
login VARCHAR(30) NOT NULL,
mdp VARCHAR(30) NOT NULL,
droits VARCHAR(6) NOT NULL,
idAdherent INT REFERENCES Adherent(idAdherent)
);

