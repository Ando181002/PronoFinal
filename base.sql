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

insert into Personnel(trigramme,nom,datenaissance,idgenre,email,mdp,telephone,idTypePersonnel,idDepartement) values ('ANY','Ando','18-10-2002','2','andofalimanantsoa.stg@orange.com','0324567890','STG','DTI');
insert into Personnel(trigramme,nom,datenaissance,idgenre,email,mdp,telephone,idTypePersonnel,idDepartement) values ('MIA','Miantsa','08-07-2004','1','afalimanantsoa@gmail.com','0321234543','CDI','DF');

create table Compte(
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

create table PeriodePronostic(
    idPeriodePronostic serial primary key,
    numJour int not null unique check (numJour>0 and numJour<=7),
    nomJour varchar not null unique,
    limite int not null
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

create table TypeTournoi(
    idTypeTournoi serial primary key,
    nomTypeTournoi varchar not null unique,
    dureeminute int not null
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

create table ResultatPris(
    idResultatPris serial primary key,
    idTournoi int not null unique references Tournoi(idTournoi),
    idMatch int not null references Matchs(idMatch)
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

create or replace view v_idequipe_partournoi as
    SELECT idtournoi,idequipe1 AS idequipe FROM matchs
    UNION distinct
    SELECT idtournoi,idequipe2 AS idequipe FROM matchs;

create or replace view v_equipe_parTournoi as
    select v.*,nomequipe from v_idequipe_partournoi v join equipe e on v.idequipe=e.idequipe;

create or replace view V_Resultat as
    select m.idmatch,greatest(score1,score2) as score,
        CASE
            WHEN score1 > score2 THEN idequipe1
            WHEN score2 > score1 THEN idequipe2
			WHEN score1 = score2 THEN 0
            ELSE NULL
        END AS resultat
    from matchs m join resultatmatch r on m.idmatch=r.idmatch;

create or replace view V_Pronostic as
    select m.idmatch,ptscore,ptresultat,idinscription,greatest(prono1,prono2) as scoreProno,
        CASE
            WHEN prono1 > prono2 THEN idequipe1
            WHEN prono2 > prono1 THEN idequipe2
			WHEN prono1 = prono2 THEN 0
            ELSE NULL
        END AS resultatProno
    from matchs m join pronostic r on m.idmatch=r.idmatch;

create or replace view v_point_parMatch as
select p.idmatch,idinscription,
    CASE
        WHEN resultat=resultatprono THEN ptresultat
        ELSE 0
    END AS pointresultat,
	CASE
        WHEN score=scoreprono THEN ptscore
        ELSE 0
    END AS pointscore 
    from v_resultat r join v_pronostic p on r.idmatch=p.idmatch;

create or replace view v_match as
select 
	m.idmatch,m.idtournoi,m.datematch,m.finmatch,m.stade,m.avecresultat,m.ptscore,m.ptresultat,
	CASE 
        WHEN EXTRACT(DOW FROM datematch) IN (0, 6) THEN datematch - INTERVAL '48 hours'
        ELSE datematch - INTERVAL '24 hours'
    END AS datelimite,
	e1.nomequipe AS nomequipe1, m.idequipe2,e2.nomequipe AS nomequipe2,
	p.idinscription,
	pr.idpronostic,pr.prono1,pr.prono2,
	CASE
		WHEN idpronostic is not null THEN 1
		else 0
    END AS etat,
    rm.score1,rm.score2,
	CASE 
        WHEN pointresultat is null THEN coalesce(0,pointresultat)
        ELSE pointresultat
    END AS pointresultat,
	CASE 
        WHEN pointscore is null THEN coalesce(0,pointscore)
        ELSE pointscore
    END AS pointscore,
	e1.imageequipe AS imageequipe1,e2.imageequipe AS imageequipe2
    from matchs m
    JOIN equipe e1 ON m.idequipe1 = e1.idequipe
    JOIN equipe e2 ON m.idequipe2 = e2.idequipe
    left join inscription p on m.idtournoi=p.idtournoi
    LEFT JOIN pronostic pr ON m.idmatch=pr.idmatch and pr.idinscription=p.idinscription
    LEFT JOIN resultatmatch rm ON m.idmatch=rm.idmatch
    LEFT JOIN v_point_parMatch vp ON m.idmatch=vp.idmatch and p.idinscription=vp.idinscription;

create or replace view classement as
select vp.idmatch,vp.idinscription,(pointresultat+pointscore) as total,
	p.prono1,p.prono2
from v_point_parMatch vp
join pronostic p on vp.idmatch=p.idmatch and vp.idinscription=p.idinscription;

create or replace view v_matchFinal as
    select idmatch,idtournoi,idequipe1,idequipe2 from matchs m join typematch tm on m.idtypematch=tm.idtypematch where nomtypematch='finale';

create or replace view v_pointSupp as
select idinscription,p.idtournoi,
    CASE
        WHEN idequipe1=equipe1G and idequipe2=equipe2G THEN 50
        ELSE 0
    END AS pointSupp
from inscription p join v_matchFinal mf on p.idtournoi=mf.idtournoi;

create or replace view v_point_parTournoi as
    select idtournoi,idinscription,sum(pointresultat) as pointresultat,sum(pointscore) as pointscore,(sum(pointresultat)+sum(pointscore)) as total 
    from v_point_parMatch v join matchs m on v.idmatch=m.idmatch 
    group by idtournoi,idinscription;

create or replace view v_pointFinal as 
    select pt.*,pointsupp,
        CASE
            WHEN pointSupp is not null THEN total+pointsupp
            ELSE total
        END AS finale
    from v_point_parTournoi pt 
    left join v_pointSupp ps on pt.idtournoi=ps.idtournoi and pt.idinscription=ps.idinscription;

create or replace view v_frais_pardate_partournoi as
    select DATE(dateinscription) as dateinscription,i.idtournoi,sum(frais) as frais 
    from inscription i join tournoi t on i.idtournoi=t.idtournoi 
    group by DATE(dateinscription),i.idtournoi;

create or replace view v_datetournoi as
    SELECT TO_DATE(TO_CHAR(generate_series(datepublication::date, fintournoi::date, '1 day'::interval), 'YYYY-MM-DD'), 'YYYY-MM-DD') AS date,idtournoi
    FROM tournoi;

create or replace view v_frais as
    select date,v.idtournoi,coalesce(frais,0) as frais from v_datetournoi v 
    left join v_frais_pardate_partournoi vf on v.date=vf.dateinscription and v.idtournoi=vf.idtournoi;
	
create or replace view v_participation as
    select i.idinscription,i.trigramme,c.iddepartement,t.idtypetournoi,nomtypetournoi,t.idtournoi
    from inscription i 
    join tournoi t on i.idtournoi=t.idtournoi
    join typetournoi tt on t.idtypetournoi=tt.idtypetournoi
    join compte c on i.trigramme=c.trigramme;

create or replace view v_nbInscription_parTypeTournoi as
    select nomtypetournoi,count(idinscription) as nbinscription from v_participation group by nomtypetournoi;

create or replace view v_nbInscription_typetournoi as
select tt.nomtypetournoi,coalesce(nbinscription,0) as nbinscription from typetournoi tt left join v_nbInscription_parTypeTournoi v on v.nomtypetournoi=tt.nomtypetournoi;

create or replace view v_nbInscription_parDepartement as
    select iddepartement,idtypetournoi,count(idinscription) as nbinscription from v_participation group by iddepartement,idtypetournoi;

create or replace view v_nbInscription_departement as
    select d.iddepartement,tt.idtypetournoi ,coalesce(nbinscription,0) as nbinscription from departement d
	left join typetournoi tt on 1=1
	left join v_nbInscription_pardepartement v on v.iddepartement=d.iddepartement and v.idtypetournoi=tt.idtypetournoi;

create table TypeActivite(
    idTypeActivite serial primary key,
    nomTypeActivite varchar not null unique
);

create table Activite(
    idActivite serial primary key,
    nomActivite varchar not null unique,
    idTypeActivite int not null references TypeActivite(idTypeActivite)
);

create table Lieu(
    idLieu serial primary key,
    nomLieu varchar not null unique,
    imageLieu text,
    latitude numeric(9,6),
    longitude numeric(9,6)
);

create table Evenement(
    idEvenement serial primary key,
    nomEvenement varchar not null unique,
    dateEvenement date not null,
    finInscription timestamp not null,
    idLieu int not null references Lieu(idLieu)
);