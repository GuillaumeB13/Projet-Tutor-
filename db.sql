CREATE DATABASE MYOCR;

CREATE TABLE IF NOT EXISTS Users
(
	id_Users SERIAL PRIMARY KEY,
	login varchar (255) UNIQUE,
	pwd varchar(255),
	mail varchar (50),
	nom varchar (25),
	prenom varchar (25),
	tel int,
	super_User boolean
);

CREATE TABLE IF NOT EXISTS Masks
(
	id_Masks SERIAL PRIMARY KEY,
	nom_Masks varchar (25),
	id_Docs SERIAL

);


CREATE TABLE IF NOT EXISTS Champs 
(
	id_Champs SERIAL PRIMARY KEY,
	id_Masks SERIAL,
	type_Champs type,
	x1 int,
	x2 int,
	x3 int,
	x4 int
)INHERITS (Masks);


CREATE TABLE IF NOT EXISTS Documents
(
	id_Doc SERIAL PRIMARY KEY,
	nom_Doc varchar (25),
	id_Masks SERIAL

);

CREATE TABLE IF NOT EXISTS CNI
(
	id_CNI SERIAL
)INHERITS (Documents);

CREATE TABLE IF NOT EXISTS Livret_Famille
(
	id_Livret SERIAL
)INHERITS (Documents);

CREATE TABLE IF NOT EXISTS Feuille_Impo
(
	id_Impot SERIAL
)INHERITS (Documents);

CREATE TABLE IF NOT EXISTS Feuille_Soin
(
	id_Soin SERIAL
)INHERITS (Documents);


ALTER TABLE Masks ADD CONSTRAINT fk_Mask_Doc FOREIGN KEY id_Doc REFERENCES Documents (id_Doc) 
ALTER TABLE Documents ADD CONSTRAINT fk_Doc_Mask FOREIGN KEY id_Masks REFERENCES Masks (id_Masks) 
ALTER TABLE Champs ADD CONSTRAINT fk_Champ_Mask FOREIGN KEY id_Masks REFERENCES Masks (id_Masks) 

