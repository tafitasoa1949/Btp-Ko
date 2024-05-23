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
    numero varchar(10) unique not null
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


create table detail_maison(
    id serial primary key,
    maison_id varchar(10) references maison(id),
    description varchar(50) not null
);

create table unite(
    id serial primary key,
    nom varchar(50) not null
);


create table compte(
    id serial primary key,
    maison_id varchar(10) references maison(id),
    code varchar(10) not null,
    nom varchar(50) not null,
    unite_id integer references unite(id),
    quantite numeric(20,2) not null default 1,
    pu numeric(20,2) not null
);


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


-- mbol mis finition
CREATE OR REPLACE FUNCTION generate_unite()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN
  INSERT INTO unite (nom)
  SELECT DISTINCT (unite) FROM csv_maison;
END;
$$;


CREATE OR REPLACE FUNCTION generate_client()
RETURNS VOID
LANGUAGE plpgsql
AS $$
BEGIN
  INSERT INTO client (numero)
  SELECT DISTINCT client FROM csv_devis;
END;
$$;


CREATE OR REPLACE FUNCTION generate_finition()
RETURNS VOID
LANGUAGE plpgsql
AS $$
BEGIN
  INSERT INTO finition (nom, pourcentage)
  SELECT DISTINCT f.finition, f.taux_finition
  FROM csv_devis f;
END;
$$;



create table finition(
    id serial primary key,
    nom varchar(10) not null,
    pourcentage varchar(50) not null
);


create table csv_devis(
    id serial primary key,
    client VARCHAR(13),
    reference varchar(50) not null,
    maison varchar(10) not null,
    finition varchar(50) ,
    taux_finition numeric(20,2),
    datedevis date,
    datedebut date,
    lieu varchar(50)
);

create table devis_maison(
    id serial primary key,
    reference VARCHAR(10) not null,
    client_id integer references client(id),
    maison_id varchar(10) references maison(id),
    finition_id integer references finition(id),
    taux_finition numeric(20,2) not null,
    datedevis date not null,
    datedebut date not null,
    lieu varchar(50) not null,
    etat integer default 0 not null,
);

create table detail_devis(
    id serial primary key,
    devis_maison_id integer references devis_maison(id),
    compte_id integer references compte(id),
    quantite numeric(20,2) not null default 1,
    pu numeric(20,2) not null
);

create table paiement(
    id serial primary key,
    devis_maison_id integer references devis_maison(id),
    reference VARCHAR(50) not null,
    montant numeric(20,2) not null,
    date date
);

create or replace view montant_payer as
select devis_maison_id,sum(montant) as payer
from paiement
group by devis_maison_id;

select p.*
from paiement as p
join devis_maison  as de on de.id = p.devis_maison_id
where de.client_id = 1;


create or replace view montant_brute as
select devi.id,sum(det.quantite*det.pu) as montant_total
from devis_maison as devi
join detail_devis as det on det.devis_maison_id =devi.id
join finition as f on f.id = devi.finition_id
group by devi.id;

create or replace view montant_net as
select brute.id,
COALESCE (((brute.montant_total)+(brute.montant_total*dd.taux_finition)/100),0) as total_prix,
dd.datedevis as datedevis
from montant_brute as brute
join devis_maison as dd on dd.id=brute.id;


select
EXTRACT(MONTH FROM datedevis) as mois,
COALESCE(sum(montant_net.total_prix),0) as total
from montant_net
where EXTRACT(YEAR FROM datedevis) = 2024
GROUP BY
mois order by mois asc;


SELECT
    EXTRACT(MONTH FROM date) AS mois,
    COALESCE(SUM(montant), 0) AS total
FROM
    paiement
where EXTRACT(YEAR FROM date) = 2024
GROUP BY
    mois
ORDER BY
    mois ASC;



select DISTINCT(EXTRACT(YEAR FROM datedevis)) from devis_maison;


CREATE OR REPLACE FUNCTION re()
RETURNS void
LANGUAGE plpgsql
AS $$
BEGIN

TRUNCATE TABLE paiement;
TRUNCATE TABLE detail_devis;
TRUNCATE TABLE devis_maison cascade;
TRUNCATE TABLE csv_devis;
TRUNCATE TABLE finition cascade;
TRUNCATE TABLE csv_maison;
TRUNCATE TABLE compte cascade;
TRUNCATE TABLE unite cascade;
TRUNCATE TABLE detail_maison cascade;
TRUNCATE TABLE maison cascade;
ALTER SEQUENCE maison_sequence RESTART WITH 1;
TRUNCATE TABLE client cascade;

END;
$$;











-- CREATE OR REPLACE FUNCTION generate_client()
-- RETURNS VOID
-- LANGUAGE plpgsql
-- AS $$
-- BEGIN
--   INSERT INTO client (numero)
--   SELECT CONCAT('0', client) FROM csv_devis;
-- END;
-- $$;


