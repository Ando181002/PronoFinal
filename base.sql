create table Admin(
    idAdmin serial primary key,
    email varchar not null unique,
    mdp varchar not null
);

insert into Admin(email,mdp) values ('admin@gmail.com','mdpadmin');

create table Genre(
    idGenre serial primary key,
    nomGenre varchar(50) not null unique
);

insert into Genre(nomGenre) values ('Homme');
insert into Genre(nomGenre) values ('Femme');

create table Departement(
    idDepartement char(5) primary key,
    nomDepartement varchar not null unique
);

insert into Departement(idDepartement,nomDepartement) values ('DG','Direction générale');
insert into Departement(idDepartement,nomDepartement) values ('DRC','Direction Relation Client');
insert into Departement(idDepartement,nomDepartement) values ('DTI','Direction Technique et Informatique');
insert into Departement(idDepartement,nomDepartement) values ('DMCC','Direction Marketing et Communication Commerciale');
insert into Departement(idDepartement,nomDepartement) values ('SG','Secrétariat général');
insert into Departement(idDepartement,nomDepartement) values ('OM','Orange Money');
insert into Departement(idDepartement,nomDepartement) values ('DCE','Direction Commerciale Entreprise');
insert into Departement(idDepartement,nomDepartement) values ('DF','Direction Financière');
insert into Departement(idDepartement,nomDepartement) values ('DCVD','Direction Commerciale Vente et Distribution');
insert into Departement(idDepartement,nomDepartement) values ('DRH','Directiondes Ressources Humaines');

create table TypePersonnel(
    idTypePersonnel char(5) primary key,
    nomTypePersonnel varchar not null unique
);

insert into TypePersonnel(idTypePersonnel,nomTypePersonnel) values ('CDI','Salarié fixe');
insert into TypePersonnel(idTypePersonnel,nomTypePersonnel) values ('TMP','Temporaire');
insert into TypePersonnel(idTypePersonnel,nomTypePersonnel) values ('STG','Stagiaire');

create table Personnel(
    trigramme char(3) primary key,
    nom varchar not null,
    datenaissance date not null,
    idGenre int not null references Genre(idGenre),
    email varchar not null unique,
    mdp varchar not null,
    telephone char(10) not null unique,
    idTypePersonnel char(5) not null references TypePersonnel(idTypePersonnel),
    idDepartement char(5) not null references Departement(idDepartement)
);

create table Compte(
    trigramme char(3) primary key,
    nom varchar not null,
    datenaissance date not null,
    idGenre int not null references Genre(idGenre),
    email varchar not null unique,
    mdp varchar not null,
    telephone char(10) not null unique,
    idTypePersonnel char(5) not null references TypePersonnel(idTypePersonnel),
    idDepartement char(5) not null references Departement(idDepartement),
    datecreation timestamp not null,
    dateexpiration timestamp
);

create table PhaseJeu(
    idPhase serial primary key,
    nomPhase varchar not null unique
);

create table TypeMatch(
    idTypeMatch serial primary key,
    nomTypeMatch varchar not null unique,
    idphase int not null references PhaseJeu(idphase)
);

create table PeriodePronostic(
    idPeriodePronostic serial primary key,
    numJour int not null unique check (numJour>0 and numJour<=7),
    nomJour varchar not null unique,
    limite int not null
);

create table TypeTournoi(
    idTypeTournoi serial primary key,
    nomTypeTournoi varchar not null unique,
    dureeminute int not null,
    dureeprolongation int not null,
    imagetypetournoi text not null
);

create table Equipe(
    idEquipe serial primary key,
    nomEquipe varchar not null unique,
    imageEquipe text not null
);

create table Equipe_TypeTournoi(
    idEquipe int not null references Equipe(idEquipe),
    idTypeTournoi int not null references TypeTournoi(idTypeTournoi)
);

create table Tournoi(
    idTournoi serial primary key,
    nomTournoi varchar not null unique,
    idTypeTournoi int not null references TypeTournoi(idTypeTournoi),
    debutTournoi date not null,
    finTournoi date not null,
    descri text not null,
    frais decimal(10,2) not null,
    question text not null,
    imageTournoi text not null,
    rang1 int check(rang1<=100), 
    rang2 int check(rang2<=100),
    rang3 int check(rang3<=100),
    rang4 int check(rang4<=100),
    rang5 int check(rang5<=100),
    datepublication date not null
);

create table Matchs(
    idMatch serial primary key,
    idTournoi int not null references Tournoi(idTournoi),
    idTypeMatch int not null references TypeMatch(idTypeMatch),
    dateMatch timestamp not null,
    finmatch timestamp not null,
    idEquipe1 int not null references Equipe(idEquipe),
    idEquipe2 int not null references Equipe(idEquipe),
    stade varchar not null,
    ptResultat int not null,
    ptScore int not null,
    avecResultat int not null
);

create table ResultatMatch(
    idResultatMatch serial primary key,
    idMatch int not null references Matchs(idMatch),
    dateResultat timestamp not null,
    score1 int not null,
    score2 int not null
);

create table Inscription(
    idInscription serial primary key,
    idTournoi int not null references Tournoi(idTournoi),
    dateInscription timestamp not null,
    trigramme char(3) not null references Compte(trigramme),
    idEquipe1g int not null references Equipe(idEquipe),
    idEquipe2g int not null references Equipe(idEquipe),
    reponseQuestion text not null
);

create table Pronostic(
    idPronostic serial primary key,
    idMatch int not null references Matchs(idMatch),
    datePronostic timestamp not null,
    idInscription int not null references Inscription(idInscription),
    prono1 int not null,
    prono2 int not null
);

create table Vainqueur(
    idVainqueur serial primary key,
    idtournoi int not null references Tournoi(idtournoi),
    trigramme char(3) not null references Compte(trigramme),
    montant decimal(10,2),
    points int not null,
    rang int not null
);

--Récupérer le frais de participation par date pour un tournoi
create or replace view v_frais_pardate_partournoi as
    select DATE(dateinscription) as dateinscription,i.idtournoi,sum(frais) as frais 
    from inscription i join tournoi t on i.idtournoi=t.idtournoi 
    group by DATE(dateinscription),i.idtournoi;

--Récupérer le frais de participation obtenu par jour d'un tournoi dès la date de publication jusqu'à la fin du tournoi
create or replace view v_datetournoi as
    SELECT TO_DATE(TO_CHAR(generate_series(datepublication::date, fintournoi::date, '1 day'::interval), 'YYYY-MM-DD'), 'YYYY-MM-DD') AS date,idtournoi
    FROM tournoi;

--Si il n'y a pas de paiement pour une date donnée, elle sera remplacée par 0
create or replace view v_frais as
    select date,v.idtournoi,coalesce(frais,0) as frais from v_datetournoi v 
    left join v_frais_pardate_partournoi vf on v.date=vf.dateinscription and v.idtournoi=vf.idtournoi;

--Récupérer l'id des equipes participantes d'un tournoi
create or replace view v_idequipe_partournoi as
    SELECT idtournoi,idequipe1 AS idequipe FROM matchs
    UNION distinct
    SELECT idtournoi,idequipe2 AS idequipe FROM matchs;

--Récupérer les informations de l'équipe
create or replace view v_equipe_parTournoi as
    select v.*,nomequipe from v_idequipe_partournoi v join equipe e on v.idequipe=e.idequipe;