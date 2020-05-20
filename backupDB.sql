--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.2
-- Dumped by pg_dump version 9.5.2

-- Started on 2016-06-22 12:25:02

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12355)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2202 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 181 (class 1259 OID 16394)
-- Name: apprezzamento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE apprezzamento (
    utente character varying NOT NULL,
    data date NOT NULL,
    ora time without time zone NOT NULL,
    testo character varying(50) NOT NULL,
    autore character varying NOT NULL,
    id_foto numeric NOT NULL
);


ALTER TABLE apprezzamento OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 16529)
-- Name: azienda; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE azienda (
    email character varying NOT NULL,
    nome character varying NOT NULL,
    via character varying NOT NULL,
    "città" character varying NOT NULL,
    cap numeric(5,0) NOT NULL,
    CONSTRAINT azienda_email_check CHECK (((email)::text ~~ '%@%.%'::text))
);


ALTER TABLE azienda OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 16400)
-- Name: cinguettio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE cinguettio (
    autore character varying NOT NULL,
    id numeric DEFAULT 0 NOT NULL,
    data date NOT NULL,
    ora time without time zone NOT NULL
);


ALTER TABLE cinguettio OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 16407)
-- Name: foto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE foto (
    autore character varying NOT NULL,
    id numeric NOT NULL,
    url character varying NOT NULL,
    descrizione character varying(20) NOT NULL
);


ALTER TABLE foto OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 16538)
-- Name: impiego; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE impiego (
    utente character varying NOT NULL,
    azienda character varying NOT NULL,
    data_inizio date NOT NULL,
    data_fine date
);


ALTER TABLE impiego OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 16413)
-- Name: luogo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE luogo (
    autore character varying NOT NULL,
    id numeric NOT NULL,
    latitudine numeric NOT NULL,
    longitudine numeric NOT NULL
);


ALTER TABLE luogo OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 16419)
-- Name: profilo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE profilo (
    utente character varying NOT NULL,
    data_n date,
    luogo_n character varying,
    sesso character(1),
    "città" character varying,
    provincia character varying,
    stato character varying,
    CONSTRAINT profilo_sesso_check CHECK (((sesso = 'm'::bpchar) OR (sesso = 'f'::bpchar)))
);


ALTER TABLE profilo OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16426)
-- Name: segnala; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE segnala (
    utente character varying NOT NULL,
    autore character varying NOT NULL,
    id_testo numeric NOT NULL
);


ALTER TABLE segnala OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 16432)
-- Name: segue; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE segue (
    seguace character varying NOT NULL,
    seguito character varying NOT NULL
);


ALTER TABLE segue OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16438)
-- Name: testo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE testo (
    autore character varying NOT NULL,
    id numeric NOT NULL,
    testo character varying(100) NOT NULL
);


ALTER TABLE testo OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 16444)
-- Name: utente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE utente (
    email character varying NOT NULL,
    nome character varying NOT NULL,
    cognome character varying NOT NULL,
    psw character varying NOT NULL,
    data_promozione date,
    autore_preferito character varying,
    id_preferito numeric,
    CONSTRAINT utente_email_check CHECK (((email)::text ~~ '%@%.%'::text))
);


ALTER TABLE utente OWNER TO postgres;

--
-- TOC entry 2184 (class 0 OID 16394)
-- Dependencies: 181
-- Data for Name: apprezzamento; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('jonsnow@gmail.com', '2016-05-23', '23:44:00', 'che triste', 'aryastark@gmail.com', 1);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('tyrionlannister@gamil.com', '2016-05-21', '12:07:00', 'verso il futuro', 'jonsnow@gmail.com', 1);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('jonsnow@gmail.com', '2016-05-23', '23:56:00', 'tornerà', 'aryastark@gmail.com', 1);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('teresa.tanzi@yahoo.it', '2016-06-06', '18:16:52', 'molto carino', 'teresa.tanzi@yahoo.it', 5);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('teresa.tanzi@yahoo.it', '2016-06-06', '19:23:03', 'somiglia a gigi', 'teresa.tanzi@yahoo.it', 5);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('teresa.tanzi@yahoo.it', '2016-06-06', '23:33:13', 'Quel gatto deve essere mio', 'teresa.tanzi@yahoo.it', 5);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('teresa.tanzi@yahoo.it', '2016-06-06', '23:35:52', 'vorrei che dormisse sui miei piedi in inverno', 'teresa.tanzi@yahoo.it', 6);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('teresa.tanzi@yahoo.it', '2016-06-07', '00:01:39', 'micio rosso *-*', 'giacomo.marino@gmail.com', 1);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('teresa.tanzi@yahoo.it', '2016-06-07', '11:10:06', 'Inserire commento.', 'teresa.tanzi@yahoo.it', 6);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('teresa.tanzi@yahoo.it', '2016-06-16', '13:48:48', 'Must not summon at all costs', 'teresa.tanzi@yahoo.it', 7);
INSERT INTO apprezzamento (utente, data, ora, testo, autore, id_foto) VALUES ('giacomo.marino@gmail.com', '2016-06-18', '18:17:03', '♥', 'teresa.tanzi@yahoo.it', 9);


--
-- TOC entry 2193 (class 0 OID 16529)
-- Dependencies: 190
-- Data for Name: azienda; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO azienda (email, nome, via, "città", cap) VALUES ('gbgrassi@gmail.com', 'grassi', 'largo montenero', 'lecco', 23900);
INSERT INTO azienda (email, nome, via, "città", cap) VALUES ('unimi@gmail.com', 'unimi', 'via comelico', 'milano', 21000);
INSERT INTO azienda (email, nome, via, "città", cap) VALUES ('ticozzi@gmail.com', 'ticozzi', 'via mentana', 'lecco', 23900);
INSERT INTO azienda (email, nome, via, "città", cap) VALUES ('ibm@mail.com', 'ibm', 'via ibm', 'milano', 21000);
INSERT INTO azienda (email, nome, via, "città", cap) VALUES ('apple@mail.com', 'apple', 'via apple', 'milano', 21000);
INSERT INTO azienda (email, nome, via, "città", cap) VALUES ('google@mail.com', 'google', 'via google', 'milano', 21000);


--
-- TOC entry 2185 (class 0 OID 16400)
-- Dependencies: 182
-- Data for Name: cinguettio; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO cinguettio (autore, id, data, ora) VALUES ('tyrionlannister@gamil.com', 1, '2016-05-12', '23:22:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('tyrionlannister@gamil.com', 2, '2016-05-14', '12:06:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('tyrionlannister@gamil.com', 3, '2016-05-23', '15:22:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('tyrionlannister@gamil.com', 4, '2016-05-23', '18:56:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('jonsnow@gmail.com', 1, '2016-04-29', '23:07:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('jonsnow@gmail.com', 2, '2016-05-12', '17:45:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('jonsnow@gmail.com', 3, '2016-05-19', '21:57:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('jaquenhgar@gmail.com', 1, '2016-05-22', '19:23:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('aryastark@gmail.com', 1, '2016-05-21', '21:19:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('aryastark@gmail.com', 2, '2016-05-22', '13:01:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('ramsaybolton@gamil.com', 1, '2016-05-18', '14:37:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 1, '2016-06-06', '15:25:00');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 3, '2016-06-06', '16:30:10');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 4, '2016-06-06', '16:45:08');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 5, '2016-06-06', '18:16:52');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 6, '2016-06-06', '23:35:14');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('giacomo.marino@gmail.com', 1, '2016-06-06', '23:37:48');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('jonsnow@gmail.com', 4, '2016-06-07', '02:39:53');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 1, '2016-06-07', '10:53:06');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 2, '2016-06-07', '10:53:07');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 3, '2016-06-07', '10:53:35');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 4, '2016-06-07', '10:53:36');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 5, '2016-06-07', '10:53:37');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 6, '2016-06-07', '10:53:38');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 7, '2016-06-07', '10:56:20');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('cp@hotmail.it', 8, '2016-06-07', '10:56:38');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 7, '2016-06-08', '12:55:31');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('g_tanzi@ymail.com', 1, '2016-06-08', '22:37:31');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('madmatmirith@hotmail.it', 1, '2016-06-09', '15:08:20');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('calincalen@gmail.com', 1, '2016-06-11', '20:23:57');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('g.dannunzio@gmail.com', 1, '2016-06-17', '13:49:29');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('g.dannunzio@gmail.com', 2, '2016-06-17', '13:50:01');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('g.dannunzio@gmail.com', 3, '2016-06-17', '13:50:23');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('g.dannunzio@gmail.com', 4, '2016-06-17', '14:08:18');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('g.dannunzio@gmail.com', 5, '2016-06-17', '14:15:39');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 8, '2016-06-17', '16:14:14');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('teresa.tanzi@yahoo.it', 9, '2016-06-17', '16:46:34');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u1@mail.com', 1, '2016-06-22', '12:00:46');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u1@mail.com', 2, '2016-06-22', '12:01:45');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u2@mail.com', 1, '2016-06-22', '12:02:15');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u2@mail.com', 2, '2016-06-22', '12:02:24');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u3@mail.com', 1, '2016-06-22', '12:03:40');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u3@mail.com', 2, '2016-06-22', '12:03:51');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u4@mail.com', 1, '2016-06-22', '12:04:34');
INSERT INTO cinguettio (autore, id, data, ora) VALUES ('u4@mail.com', 2, '2016-06-22', '12:04:56');


--
-- TOC entry 2186 (class 0 OID 16407)
-- Dependencies: 183
-- Data for Name: foto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO foto (autore, id, url, descrizione) VALUES ('tyrionlannister@gamil.com', 2, 'www.mare.com/viaggio.jpeg', 'verso daeneris');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('aryastark@gmail.com', 1, 'www.cani.com/metalupo.com', 'addio nymeria');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('jonsnow@gmail.com', 1, 'http://www.videogiochi.com/wp-content/uploads/2014/09/thewall-castleblack-minecraft.jpg', 'l''inizio della guard');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('teresa.tanzi@yahoo.it', 3, 'http://www.canianimalienatura.it/wp-content/uploads/2014/11/Il-gatto-Soriano.jpg', 'Sophia');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('teresa.tanzi@yahoo.it', 5, 'http://www.animalicuccioli.it/immagini/articoli/news/mainecoon.jpg', 'GAAATTO');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('teresa.tanzi@yahoo.it', 6, 'http://www.emerald-siberiancat.it/images/gallerie/galleria/img164.jpg', 'adorabile ♥');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('giacomo.marino@gmail.com', 1, 'http://us.123rf.com/450wm/bennymarty/bennymarty1510/bennymarty151000062/46575777-rosso-e-bianco-gatto-randagio-dorme-sdraiato-sulla-roccia-all-aperto.jpg?ver=6', 'gatto rosso randagio');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('g.dannunzio@gmail.com', 4, '', '');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('teresa.tanzi@yahoo.it', 9, 'https://scontent.xx.fbcdn.net/v/t1.0-9/13445373_10201765206728579_4461341957999262492_n.jpg?oh=56fb9b53a1ebe04e2787704cfc2424a7&oe=57CCCD0B', '♥');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('teresa.tanzi@yahoo.it', 7, 'http://images-cdn.moviepilot.com/images/c_fill,h_720,w_1281/t_mp_quality/lidbjydalqttztsjtse9/easter-eggs-hint-at-bill-cipher-s-return-after-the-gravity-falls-finale-hints-that-bill-854218.jpg', 'Trust no one');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('u1@mail.com', 2, 'http://cdn3.www.html.it/wp-content/uploads/2016/05/Cattura-399x115.png', 'immagine');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('u3@mail.com', 1, 'http://cdn3.www.html.it/wp-content/uploads/2015/03/PHP-GUIDA-FEATURED-295x122-1426869583.jpg', 'foto
');
INSERT INTO foto (autore, id, url, descrizione) VALUES ('u4@mail.com', 2, 'http://cdn4.www.html.it/wp-content/uploads/2015/12/copertina_sql_2-295x122-1450694980.png', 'altra immagine');


--
-- TOC entry 2194 (class 0 OID 16538)
-- Dependencies: 191
-- Data for Name: impiego; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('teresa.tanzi@yahoo.it', 'gbgrassi@gmail.com', '2008-09-12', '2013-07-16');
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('teresa.tanzi@yahoo.it', 'unimi@gmail.com', '2014-10-01', NULL);
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('teresa.tanzi@yahoo.it', 'ticozzi@gmail.com', '2005-09-08', '2008-06-09');
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('u1@mail.com', 'ibm@mail.com', '2014-01-01', '2014-12-30');
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('u1@mail.com', 'google@mail.com', '2015-01-01', '2015-12-30');
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('u1@mail.com', 'ibm@mail.com', '2016-01-01', NULL);
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('u2@mail.com', 'google@mail.com', '2011-01-01', NULL);
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('u3@mail.com', 'apple@mail.com', '2010-01-01', '2012-12-30');
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('u3@mail.com', 'ibm@mail.com', '2013-01-01', NULL);
INSERT INTO impiego (utente, azienda, data_inizio, data_fine) VALUES ('u3@mail.com', 'google@mail.com', '2014-01-01', NULL);


--
-- TOC entry 2187 (class 0 OID 16413)
-- Dependencies: 184
-- Data for Name: luogo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('tyrionlannister@gamil.com', 3, 123, 234);
INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('jonsnow@gmail.com', 2, 318, 298);
INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('ramsaybolton@gamil.com', 1, 265, 196);
INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('teresa.tanzi@yahoo.it', 4, 45.8565698, 9.397670400000038);
INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('cp@hotmail.it', 8, 123, 34);
INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('teresa.tanzi@yahoo.it', 8, 45.454139, 9.214831);
INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('u2@mail.com', 2, 123, 456);
INSERT INTO luogo (autore, id, latitudine, longitudine) VALUES ('u3@mail.com', 2, 321, 654);


--
-- TOC entry 2188 (class 0 OID 16419)
-- Dependencies: 185
-- Data for Name: profilo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('tyrionlannister@gamil.com', '1969-06-11', 'castel granito', 'm', 'mereen', NULL, 'continente orientale');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('ramsaybolton@gamil.com', '1985-05-13', NULL, 'm', 'grande inverno', 'nord', 'continente occidentale');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('g_tanzi@ymail.com', NULL, '', NULL, 'UDINE', '', '');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('jonsnow@gmail.com', '1986-12-26', '', 'm', '', '', '');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('giacomo.marino@gmail.com', '1998-07-26', 'varese', 'm', 'varese', NULL, 'italia');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('aryastark@gmail.com', '1997-05-15', '', 'f', '', '', '');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('teresa.tanzi@yahoo.it', '1994-12-04', 'lecco', 'f', 'lecco', 'lc', 'lecco');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('cp@hotmail.it', '1994-12-12', 'MIlano', 'f', 'Milano', 'Milano', 'Italia');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('g.dannunzio@gmail.com', NULL, 'L&#039;Aquila', NULL, 'L&#039;Aquila', NULL, NULL);
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('figoTattCic@hot.com', '1997-12-22', 'reykjavik', 'm', 'reykjavik', 're', 'islanda');
INSERT INTO profilo (utente, data_n, luogo_n, sesso, "città", provincia, stato) VALUES ('gigio@gattoni.it', NULL, NULL, 'm', 'lecco', 'lc', NULL);


--
-- TOC entry 2189 (class 0 OID 16426)
-- Dependencies: 186
-- Data for Name: segnala; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO segnala (utente, autore, id_testo) VALUES ('ramsaybolton@gamil.com', 'jaquenhgar@gmail.com', 1);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('tyrionlannister@gamil.com', 'jaquenhgar@gmail.com', 1);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('teresa.tanzi@yahoo.it', 'tyrionlannister@gamil.com', 4);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('teresa.tanzi@yahoo.it', 'tyrionlannister@gamil.com', 1);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('teresa.tanzi@yahoo.it', 'teresa.tanzi@yahoo.it', 1);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('jonsnow@gmail.com', 'tyrionlannister@gamil.com', 4);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('cp@hotmail.it', 'cp@hotmail.it', 6);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('calincalen@gmail.com', 'calincalen@gmail.com', 1);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('teresa.tanzi@yahoo.it', 'g_tanzi@ymail.com', 1);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('teresa.tanzi@yahoo.it', 'cp@hotmail.it', 6);
INSERT INTO segnala (utente, autore, id_testo) VALUES ('figoTattCic@hot.com', 'g.dannunzio@gmail.com', 5);


--
-- TOC entry 2190 (class 0 OID 16432)
-- Dependencies: 187
-- Data for Name: segue; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO segue (seguace, seguito) VALUES ('aryastark@gmail.com', 'jaquenhgar@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('tyrionlannister@gamil.com', 'jonsnow@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('ramsaybolton@gamil.com', 'jonsnow@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('jaquenhgar@gmail.com', 'aryastark@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('jaquenhgar@gmail.com', 'tyrionlannister@gamil.com');
INSERT INTO segue (seguace, seguito) VALUES ('jaquenhgar@gmail.com', 'jonsnow@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('aryastark@gmail.com', 'jonsnow@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('teresa.tanzi@yahoo.it', 'g_tanzi@ymail.com');
INSERT INTO segue (seguace, seguito) VALUES ('teresa.tanzi@yahoo.it', 'jonsnow@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('giacomo.marino@gmail.com', 'teresa.tanzi@yahoo.it');
INSERT INTO segue (seguace, seguito) VALUES ('teresa.tanzi@yahoo.it', 'f.chiara.mal@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('giacomo.marino@gmail.com', 'tyrionlannister@gamil.com');
INSERT INTO segue (seguace, seguito) VALUES ('teresa.tanzi@yahoo.it', 'tyrionlannister@gamil.com');
INSERT INTO segue (seguace, seguito) VALUES ('teresa.tanzi@yahoo.it', 'giacomo.marino@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('jonsnow@gmail.com', 'tyrionlannister@gamil.com');
INSERT INTO segue (seguace, seguito) VALUES ('teresa.tanzi@yahoo.it', 'cp@hotmail.it');
INSERT INTO segue (seguace, seguito) VALUES ('teresa.tanzi@yahoo.it', 'ramsaybolton@gamil.com');
INSERT INTO segue (seguace, seguito) VALUES ('g_tanzi@ymail.com', 'teresa.tanzi@yahoo.it');
INSERT INTO segue (seguace, seguito) VALUES ('g_tanzi@ymail.com', 'cb@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('madmatmirith@hotmail.it', 'teresa.tanzi@yahoo.it');
INSERT INTO segue (seguace, seguito) VALUES ('calincalen@gmail.com', 'teresa.tanzi@yahoo.it');
INSERT INTO segue (seguace, seguito) VALUES ('gigio@gattoni.it', 'giacomo.marino@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('sophia@gattoni.com', 'giacomo.marino@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('figoTattCic@hot.com', 'sophia@gattoni.com');
INSERT INTO segue (seguace, seguito) VALUES ('figoTattCic@hot.com', 'g.dannunzio@gmail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u1@mail.com', 'u2@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u1@mail.com', 'u3@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u1@mail.com', 'u4@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u2@mail.com', 'u1@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u2@mail.com', 'u3@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u2@mail.com', 'u4@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u3@mail.com', 'u1@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u3@mail.com', 'u2@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u3@mail.com', 'u4@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u4@mail.com', 'u1@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u4@mail.com', 'u2@mail.com');
INSERT INTO segue (seguace, seguito) VALUES ('u4@mail.com', 'u3@mail.com');


--
-- TOC entry 2191 (class 0 OID 16438)
-- Dependencies: 188
-- Data for Name: testo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO testo (autore, id, testo) VALUES ('jonsnow@gmail.com', 3, 'possa la mia guardia non finire');
INSERT INTO testo (autore, id, testo) VALUES ('tyrionlannister@gamil.com', 1, 'la famiglia è sempre la famiglia');
INSERT INTO testo (autore, id, testo) VALUES ('tyrionlannister@gamil.com', 4, 'cercando fortuna altrove');
INSERT INTO testo (autore, id, testo) VALUES ('jaquenhgar@gmail.com', 1, 'il dio rosso chiede dei nomi');
INSERT INTO testo (autore, id, testo) VALUES ('aryastark@gmail.com', 2, 'la lista non è finita');
INSERT INTO testo (autore, id, testo) VALUES ('teresa.tanzi@yahoo.it', 1, 'ciao');
INSERT INTO testo (autore, id, testo) VALUES ('jonsnow@gmail.com', 4, 'nuova prova');
INSERT INTO testo (autore, id, testo) VALUES ('cp@hotmail.it', 1, 'IL MASTINOOOO');
INSERT INTO testo (autore, id, testo) VALUES ('cp@hotmail.it', 2, 'IL MASTINOOOO');
INSERT INTO testo (autore, id, testo) VALUES ('cp@hotmail.it', 3, 'Prova');
INSERT INTO testo (autore, id, testo) VALUES ('cp@hotmail.it', 4, 'Prova');
INSERT INTO testo (autore, id, testo) VALUES ('cp@hotmail.it', 5, 'Prova');
INSERT INTO testo (autore, id, testo) VALUES ('cp@hotmail.it', 6, 'Prova');
INSERT INTO testo (autore, id, testo) VALUES ('g_tanzi@ymail.com', 1, '#entroreggioescorecords is exploring new bondaries of the social media reality! #fuckthesistema');
INSERT INTO testo (autore, id, testo) VALUES ('madmatmirith@hotmail.it', 1, 'Studiando la storia medievale sono giunto ala coclusione che gli ebrei se le son meritate tutte');
INSERT INTO testo (autore, id, testo) VALUES ('calincalen@gmail.com', 1, 'fra gay');
INSERT INTO testo (autore, id, testo) VALUES ('g.dannunzio@gmail.com', 5, 'Il trionfo della morte');
INSERT INTO testo (autore, id, testo) VALUES ('u1@mail.com', 1, 'primo testo di u1');
INSERT INTO testo (autore, id, testo) VALUES ('u2@mail.com', 1, 'testo di u2');
INSERT INTO testo (autore, id, testo) VALUES ('u4@mail.com', 1, 'altro testo');


--
-- TOC entry 2192 (class 0 OID 16444)
-- Dependencies: 189
-- Data for Name: utente; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('ramsaybolton@gamil.com', 'ramsay', 'bolton', 'imthelord', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('jaquenhgar@gmail.com', 'jaquen', 'h''gar', 'nessuno1234', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('giacomo.marino@gmail.com', 'giacomo', 'marino', 'nonloso', '2016-06-18', 'teresa.tanzi@yahoo.it', 4);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('teresa.tanzi@yahoo.it', 'teresa', 'tanzi', 'abc', '2016-06-09', 'teresa.tanzi@yahoo.it', 4);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('figoTattCic@hot.com', 'Tatt', 'Cic', 'Tattibello', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('cecilia_tanzi@yahoo.it', 'cecilia', 'tanzi', 'cecilia', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('f.chiara.mal@gmail.com', 'Cipì', 'Colleoni', '123po', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('aryastark@gmail.com', 'arya', 'stark', '', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('g_tanzi@ymail.com', 'Schiallo', 'Da Sballo', '', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('tyrionlannister@gamil.com', 'tyrion', 'lannister', 'vinoh', '2016-06-06', NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('jonsnow@gmail.com', 'jon', 'snow', 'neve', '2016-05-19', NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('cp@hotmail.it', 'Claudia', 'Pariotti', 'lol', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('cb@gmail.com', 'christian', 'bale', '123', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('madmatmirith@hotmail.it', 'MadMat', 'VolpeInopportuna', 'scimmiarazzista', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('calincalen@gmail.com', 'Stefano', 'Valsecchi', 'stemmi', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('gigio@gattoni.it', 'gigo', 'miao', 'cibo', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('g.dannunzio@gmail.com', 'Gabriele', 'D&#039;Annunzio', 'poesie', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('sophia@gattoni.com', 'sophia', '♥', 'miao', NULL, NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('u4@mail.com', 'u4', 'u4', 'u4', '2016-06-22', NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('u1@mail.com', 'u1', 'u1', 'u1', '2016-06-22', NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('u2@mail.com', 'u2', 'u2', 'u2', '2016-06-22', NULL, NULL);
INSERT INTO utente (email, nome, cognome, psw, data_promozione, autore_preferito, id_preferito) VALUES ('u3@mail.com', 'u3', 'u3', 'u3', '2016-06-22', NULL, NULL);


--
-- TOC entry 2035 (class 2606 OID 16452)
-- Name: apprezzamemto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY apprezzamento
    ADD CONSTRAINT apprezzamemto_pkey PRIMARY KEY (utente, data, ora);


--
-- TOC entry 2053 (class 2606 OID 16536)
-- Name: azienda_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY azienda
    ADD CONSTRAINT azienda_pkey PRIMARY KEY (email);


--
-- TOC entry 2037 (class 2606 OID 16454)
-- Name: cinguettio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cinguettio
    ADD CONSTRAINT cinguettio_pkey PRIMARY KEY (autore, id);


--
-- TOC entry 2039 (class 2606 OID 16456)
-- Name: foto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY foto
    ADD CONSTRAINT foto_pkey PRIMARY KEY (autore, id);


--
-- TOC entry 2055 (class 2606 OID 16545)
-- Name: impiego_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY impiego
    ADD CONSTRAINT impiego_pkey PRIMARY KEY (utente, azienda, data_inizio);


--
-- TOC entry 2041 (class 2606 OID 16458)
-- Name: luogo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY luogo
    ADD CONSTRAINT luogo_pkey PRIMARY KEY (autore, id);


--
-- TOC entry 2043 (class 2606 OID 16460)
-- Name: profilo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profilo
    ADD CONSTRAINT profilo_pkey PRIMARY KEY (utente);


--
-- TOC entry 2045 (class 2606 OID 16462)
-- Name: segnala_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY segnala
    ADD CONSTRAINT segnala_pkey PRIMARY KEY (utente, autore, id_testo);


--
-- TOC entry 2047 (class 2606 OID 16464)
-- Name: segue_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY segue
    ADD CONSTRAINT segue_pkey PRIMARY KEY (seguace, seguito);


--
-- TOC entry 2049 (class 2606 OID 16466)
-- Name: testo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY testo
    ADD CONSTRAINT testo_pkey PRIMARY KEY (autore, id);


--
-- TOC entry 2051 (class 2606 OID 16468)
-- Name: utente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY utente
    ADD CONSTRAINT utente_pkey PRIMARY KEY (email);


--
-- TOC entry 2056 (class 2606 OID 16469)
-- Name: apprezzamemto_autore_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY apprezzamento
    ADD CONSTRAINT apprezzamemto_autore_fkey FOREIGN KEY (autore, id_foto) REFERENCES foto(autore, id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2057 (class 2606 OID 16474)
-- Name: apprezzamemto_utente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY apprezzamento
    ADD CONSTRAINT apprezzamemto_utente_fkey FOREIGN KEY (utente) REFERENCES utente(email) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2058 (class 2606 OID 16479)
-- Name: cinguettio_autore_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cinguettio
    ADD CONSTRAINT cinguettio_autore_fkey FOREIGN KEY (autore) REFERENCES utente(email) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2059 (class 2606 OID 16484)
-- Name: foto_autore_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY foto
    ADD CONSTRAINT foto_autore_fkey FOREIGN KEY (autore, id) REFERENCES cinguettio(autore, id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2068 (class 2606 OID 16546)
-- Name: impiego_azienda_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY impiego
    ADD CONSTRAINT impiego_azienda_fkey FOREIGN KEY (azienda) REFERENCES azienda(email) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2069 (class 2606 OID 16551)
-- Name: impiego_utente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY impiego
    ADD CONSTRAINT impiego_utente_fkey FOREIGN KEY (utente) REFERENCES utente(email) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2060 (class 2606 OID 16489)
-- Name: luogo_autore_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY luogo
    ADD CONSTRAINT luogo_autore_fkey FOREIGN KEY (autore, id) REFERENCES cinguettio(autore, id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2061 (class 2606 OID 16494)
-- Name: profilo_utente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profilo
    ADD CONSTRAINT profilo_utente_fkey FOREIGN KEY (utente) REFERENCES utente(email) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2062 (class 2606 OID 16499)
-- Name: segnala_autore_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY segnala
    ADD CONSTRAINT segnala_autore_fkey FOREIGN KEY (autore, id_testo) REFERENCES testo(autore, id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2063 (class 2606 OID 16504)
-- Name: segnala_utente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY segnala
    ADD CONSTRAINT segnala_utente_fkey FOREIGN KEY (utente) REFERENCES utente(email) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2064 (class 2606 OID 16509)
-- Name: segue_seguace_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY segue
    ADD CONSTRAINT segue_seguace_fkey FOREIGN KEY (seguace) REFERENCES utente(email) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2065 (class 2606 OID 16514)
-- Name: segue_seguito_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY segue
    ADD CONSTRAINT segue_seguito_fkey FOREIGN KEY (seguito) REFERENCES utente(email);


--
-- TOC entry 2066 (class 2606 OID 16519)
-- Name: testo_autore_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY testo
    ADD CONSTRAINT testo_autore_fkey FOREIGN KEY (autore, id) REFERENCES cinguettio(autore, id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2067 (class 2606 OID 16524)
-- Name: utente_autore_preferito_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY utente
    ADD CONSTRAINT utente_autore_preferito_fkey FOREIGN KEY (autore_preferito, id_preferito) REFERENCES luogo(autore, id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2201 (class 0 OID 0)
-- Dependencies: 7
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-06-22 12:25:02

--
-- PostgreSQL database dump complete
--

