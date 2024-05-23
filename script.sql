create database btp;

\c btp

create table profil(
    id serial primary key,
    nom varchar(255) not null
);

insert into profil (nom) values
    ('Admin'),
    ('Client');

create table client(
    id serial primary key,
    nom varchar(255) not null,
    prenoms varchar(255) not null,
    numero varchar(10) unique not null
);
INSERT INTO client (nom, prenoms, numero) VALUES ('Dupont', 'Jean', '0346940402');
INSERT INTO client (nom, prenoms, numero) VALUES ('Martin', 'Marie', '0385533833');
INSERT INTO client (nom, prenoms, numero) VALUES ('Lefevre', 'Paul', '0323233332');


CREATE SEQUENCE poste_sequence START WITH 1 INCREMENT BY 1;

CREATE OR REPLACE FUNCTION gen_poste_id() RETURNS text AS $$
DECLARE
next_id integer;
    formatted_id text;
BEGIN
    next_id := nextval('poste_sequence');
    formatted_id := 'PST' || lpad(next_id::text, 3, '0');
RETURN formatted_id;
END;
$$ LANGUAGE plpgsql;


create table poste(
     id varchar(10) primary key,
     nom varchar(50) not null
);

CREATE SEQUENCE employe_sequence START WITH 1 INCREMENT BY 1;

CREATE OR REPLACE FUNCTION gen_employe_id() RETURNS text AS $$
DECLARE
next_id integer;
    formatted_id text;
BEGIN
    next_id := nextval('employe_sequence');
    formatted_id := 'EMP' || lpad(next_id::text, 3, '0');
RETURN formatted_id;
END;
$$ LANGUAGE plpgsql;


create table employe(
    id varchar(10) primary key,
    poste_id varchar(10) references poste(id),
    nom varchar(50) not null,
    prenoms varchar(20) not null,
    datenaissance date not null
);


CREATE SEQUENCE maison_sequence START WITH 1 INCREMENT BY 1;

CREATE OR REPLACE FUNCTION gen_maison_id() RETURNS text AS $$
DECLARE
next_id integer;
    formatted_id text;
BEGIN
    next_id := nextval('maison_sequence');
    formatted_id := 'MAI' || lpad(next_id::text, 3, '0');
RETURN formatted_id;
END;
$$ LANGUAGE plpgsql;


create table maison(
    id varchar(10) primary key,
    nom varchar(50) not null,
    surface numeric(20,2) not null default 0,
    detail varchar(200),
    duree numeric(20,2)
);



CREATE SEQUENCE detail_maison_sequence START WITH 1 INCREMENT BY 1;

CREATE OR REPLACE FUNCTION gen_det_maison_id() RETURNS text AS $$
DECLARE
next_id integer;
    formatted_id text;
BEGIN
    next_id := nextval('detail_maison_sequence');
    formatted_id := 'DETMAI' || lpad(next_id::text, 3, '0');
RETURN formatted_id;
END;
$$ LANGUAGE plpgsql;


create table detail_maison(
    id varchar(10) primary key,
    maison_id varchar(10) references maison(id),
    description varchar(200) not null
);

INSERT INTO detail_maison(id, maison_id, description) VALUES
('DETMAI001', 'MAI001', '4 chambres'),
('DETMAI002', 'MAI001', '2 Douche et WC à l''interieur');







create table compte(
    id serial primary key,
    maison_id varchar(10) primary key
    code varchar(10) not null,
    nom varchar(50) not null

);


create table unite_travail(
    id serial primary key,
    nom varchar(50) not null
);



CREATE TABLE travail(
    id serial primary key,
    compte_id integer references compte(id),
    unite_travail_id integer references unite_travail(id),
    code varchar(10) not null,
    nom varchar(50) not null,
    pu numeric(20,2)
);


CREATE TABLE detail_travail(
    id serial primary key,
    travail_id integer references travail(id),
    unite_travail_id integer references unite_travail(id),
    nom varchar(50) not null,
    pu numeric(20,2)
);

insert into detail_travail values
(default,8,2,'Semelles isolée',573215.80),
(default,8,2,'Amorces poteuax',573215.80),
(default,8,2,'Chainage bas de 20x20',573215.80);

CREATE SEQUENCE devis_sequence START WITH 1 INCREMENT BY 1;

CREATE OR REPLACE FUNCTION gen_devis_id() RETURNS text AS $$
DECLARE
next_id integer;
    formatted_id text;
BEGIN
    next_id := nextval('devis_sequence');
    formatted_id := 'DEV' || lpad(next_id::text, 3, '0');
RETURN formatted_id;
END;
$$ LANGUAGE plpgsql;


create table devis_maison(
    id varchar(10) primary key,
    maison_id varchar(10) references maison(id),
    duree double precision not null,
    date date not null
);

insert into devis_maison values
('DEV001','MAI001',40,'2024-04-23');


create table compte_devis_maison(
    id serial primary key,
    devis_maison_id varchar(10) references devis_maison(id),
    compte_id integer references compte(id)
);

insert into compte_devis_maison (devis_maison_id,compte_id) values
('DEV001',1),
('DEV001',2),
('DEV001',3);


create table detail_devis(
    id serial primary key,
    compte_devis_maison_id integer references compte_devis_maison(id),
    travail_id integer references travail(id),
    quantite numeric(20,2),
    pu numeric(20,2)
);

insert into detail_devis values
(default,1,1,26.98,190000),
(default,2,2,101.36,3072.87),
(default,2,3,101.36,3736.26),
(default,2,5,24.44,9390.93),
(default,2,4,15.59,37563.26),
(default,2,6,1,152656),
(default,3,7,9.62,172114.40),
(default,3,8,default,default),
(default,3,9,15.59,37563.26),
(default,3,10,7.80,73245.40),
(default,3,11,5.46,487815.40),
(default,3,12,77.97,33566.54);

create table ss_detail(
    id serial primary key,
    detail_devis_id integer references detail_devis(id),
    detail_travail_id integer references detail_travail(id),
    quantite numeric(20,2) not null default 0,
    pu numeric(20,2) not null default 0
);

insert into ss_detail values
(default,8,1,0.53,573215.80),
(default,8,2,0.56,573215.80),
(default,8,3,2.44,573215.80);

create or replace view v_ss as
select detail_devis_id,sum(quantite) as quantite_total,sum(quantite*pu) as total
from ss_detail group by detail_devis_id;


create table finition(
    id serial primary key,
    nom varchar(10) not null,
    pourcentage varchar(50) not null
);

insert into finition values
(default,'Standard',1),
(default,'Gold',30),
(default,'Premium',50),
(default,'VIP',60);

CREATE TABLE achat(
    id SERIAL PRIMARY KEY,
    client_id INTEGER references client(id),
    devis_maison_id VARCHAR(10) REFERENCES devis_maison(id),
    datechat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    datedebut DATE NOT NULL,
    etat integer default 0 NOT NULL
);


create table tarif_achat(
    id serial primary key,
    achat_id integer references achat(id),
    finition_id integer references finition(id),
    pourcentage numeric(20,2) not null,
    prix_finition numeric(20,2) not null default 0,
    montant_total numeric(20,2)
);


create table paiement(
    id serial primary key,
    client_id INTEGER references client(id),
    achat_id INTEGER references achat(id),
    montant numeric(20,2) not null,
    reference VARCHAR(50) not null,
    date TIMESTAMP not null DEFAULT CURRENT_TIMESTAMP
);

create or replace view montant_payer as
select achat_id,sum(montant) as payer
from paiement
group by devis_maison_id;


create or replace view total_devis as
select sum(tarif.montant_total) as total
from achat as a
join tarif_achat as tarif on tarif.achat_id = a.id;


select
EXTRACT(MONTH FROM a.datechat) as mois,
COALESCE(sum(tarif.montant_total),0) as total
from achat as a
join tarif_achat as tarif on tarif.achat_id = a.id
where EXTRACT(YEAR FROM a.datechat) = 2024
GROUP BY
mois order by mois asc;





select sum(montant) as paiement_total from paiement;


create table csv_maison(
    id serial primary key,
    maison varchar(50) not null,
    description varchar(200),
    surface numeric(20,2),
    code varchar(50),
    nomcode varchar(50),
    unite varchar(50),
    pu numeric(20,2),
    quantite numeric(20,2),
    duree numeric(20,2)
);



CREATE OR REPLACE FUNCTION generate_maison()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO maison (id, nom, surface, detail, duree)
SELECT gen_maison_id(), maison, surface, description, duree
FROM (
    SELECT DISTINCT maison, surface, description, duree
    FROM csv_maison
) AS unique_maisons;
END;
$$;

CREATE OR REPLACE FUNCTION generate_unite()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
  INSERT INTO unite_travail (nom)
  SELECT DISTINCT (unite) FROM csv_maison;
END;
$$;

CREATE OR REPLACE FUNCTION generate_compte()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
  INSERT INTO unite_travail code,nom
  SELECT DISTINCT code,nomcode FROM (
  from select DISTINCT code,nomcode from csv_maison
  ) as unique_compte;
END;
$$;

CREATE OR REPLACE FUNCTION generate_compte()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
  INSERT INTO compte (maison_id, code)
  SELECT DISTINCT code, nomcode
  FROM csv_maison;
END;
$$;








-- CREATE OR REPLACE FUNCTION test() RETURNS VOID AS $$
-- DECLARE
--     i INT := 1;
-- BEGIN
--     -- Créez une table temporaire pour stocker les résultats
--     CREATE TEMPORARY TABLE temp_results (month DATE, total_amount NUMERIC);

--     WHILE i <= 12 LOOP
--         INSERT INTO temp_results (month, total_amount)
--     SELECT DATE_TRUNC('month', a.datechat)::DATE AS month, COALESCE(SUM(tarif.montant_total), 0)::NUMERIC AS total_amount
--     FROM achat AS a
--     JOIN tarif_achat AS tarif ON tarif.achat_id = a.id
--     WHERE EXTRACT(YEAR FROM a.datechat) = 2024 AND DATE_TRUNC('month', a.datechat) = i
--     GROUP BY DATE_TRUNC('month', a.datechat);


--         i := i + 1;
--     END LOOP;

--     -- Supprimez la table temporaire
--     DROP TABLE temp_results;
-- END;
-- $$ LANGUAGE plpgsql;








-- CREATE OR REPLACE FUNCTION denormaliser_devis() RETURNS TEXT AS $$
-- DECLARE
--     f_devis_id INTEGER;
--     f_quantite NUMERIC;
--     f_prix NUMERIC;
-- BEGIN
--     SELECT detail_devis_id, quantite_total, total INTO f_devis_id, f_quantite, f_prix
--     FROM v_ss;

--     UPDATE detail_devis SET quantite = f_quantite, pu = f_prix
--     WHERE id = f_devis_id;

--     RETURN 'Mise à jour effectuée';
-- END;
-- $$ LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION re()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN

TRUNCATE TABLE detail_maison;
ALTER SEQUENCE detail_maison_sequence RESTART WITH 1;
TRUNCATE TABLE maison;
ALTER SEQUENCE maison_sequence RESTART WITH 1;
TRUNCATE TABLE finition;
TRUNCATE TABLE travail;
TRUNCATE TABLE unite_travail;
TRUNCATE TABLE compte;
TRUNCATE TABLE employe;
ALTER SEQUENCE employe_sequence RESTART WITH 1;
TRUNCATE TABLE poste;
ALTER SEQUENCE poste_sequence RESTART WITH 1;
delete from users where id!=5;

END;
$$;
