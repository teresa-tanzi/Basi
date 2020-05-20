#verificare l'esistenza di un utente che cerca di loggare
SELECT *
FROM utente
WHERE email='aryastark@gmail.com' and psw='noone1' #se restituisce una riga allora le credenziali sono corrette

#inserire un nuovo utente
INSERT INTO utente
VALUES ('teresa.tanzi@yahoo.it', 'teresa', 'tanzi', '123')

#selezionare i dati di un utente
SELECT *
FROM utente u LEFT JOIN profilo p on u.email=p.utente #devo inserire anche chi non ha dati
WHERE u.email='teresa.tanzi@yahoo.it'

SELECT u.email, u.nome, u.cognome, p.data_n, p.luogo_n, p.sesso, p.città, p.provincia, p.stato, s1.numero_seguaci, s2.numero_seguiti
FROM ((utente u LEFT JOIN profilo p on u.email=p.utente)
	LEFT JOIN (SELECT seguito, COUNT (seguace) as numero_seguaci
		FROM segue
		GROUP BY seguito) s1 on u.email=s1.seguito)
	LEFT JOIN (SELECT seguace, COUNT (seguito) as numero_seguiti
		FROM segue
		GROUP BY seguace) s2 on u.email=s2.seguace
WHERE u.email='teresa.tanzi@yahoo.it'

#inserire un utente nella tabella 'profilo' per poter poi aggiungere i campi opzionali
INSERT INTO profilo (utente)
VALUES ('teresa.tanzi@yahoo.it')

#aggiornamento dei campi opzionali
UPDATE profilo 
SET data_n='1994-12-04'
WHERE utente='teresa.tanzi@yahoo.it'

#recuperare i cinguetii da mostrare in bacheca
SELECT s.seguace, c.autore, u.nome, u.cognome, c.id, c.data, c.ora, t.testo, l.latitudine, l.longitudine, f.url, f.descrizione
FROM utente u join
	(((((SELECT * FROM segue UNION SELECT autore as seguace, autore FROM cinguettio) s
	join cinguettio c on s.seguito=c.autore)
	LEFT JOIN testo t on c.autore=t.autore and c.id=t.id)
	LEFT JOIN luogo l on c.autore=l.autore and c.id=l.id)
	LEFT JOIN foto f on c.autore=f.autore and c.id=f.id) on u.email=c.autore
WHERE s.seguace='aryastark@gmail.com'
ORDER BY s.seguace, c.data desc, c.ora desc

#ricerca di utenti (senza campi)
SELECT *
FROM utente u LEFT JOIN profilo p on u.email=p.utente

SELECT *
FROM utente u LEFT JOIN profilo p on u.email=p.utente
INTERSECT
SELECT *
FROM utente u LEFT JOIN profilo p on u.email=p.utente
WHERE u.nome='jon'

#ricerca di un utente data l'età (qui 29)
SELECT *
FROM utente u LEFT JOIN profilo p on u.email=p.utente
WHERE age(p.data_n)>'29 years' and age(p.data_n)<'30 years'

#seguire qualcuno
INSERT INTO segue
VALUES ('teresa.tanzi@yahoo.it', 'giacomo.marino@gmail.com')

#controllare se un utente già ne segue un altro
SELECT *
FROM segue
WHERE seguace='teresa.tanzi@yahoo.it' and seguito='giacomo.marino@gmail.com'

#cancellare un follow
DELETE FROM segue
WHERE seguace='teresa.tanzi@yahoo.it' and seguito='tyrionlannister@gamil.com'

#cerco se un utente ha già pubblicato cinguettii (per poterne incrementare l'id)
SELECT *
FROM cinguettio
WHERE autore='jonsnow@gmail.com'
ORDER BY id desc

#inserimento di un cinguettio di tipo testo
INSERT INTO cinguettio
VALUES ('teresa.tanzi@yahoo.it', 1, '2016-06-06', '15:25')

INSERT INTO testo
VALUES ('teresa.tanzi@yahoo.it', 1, 'ciao')

#promozione di un utente
UPDATE utente 
SET data_promozione='2016-06-06'
WHERE email='teresa.tanzi@yahoo.it'

#controllo se la segnalazione è già avvenuta
SELECT *
FROM segnala
WHERE (utente='teresa.tanzi@yahoo.it' and autore='tyrionlannister@gamil.com' and id_testo=1)

#aggiungere una segnalazione
INSERT INTO segnala
VALUES ('teresa.tanzi@yahoo.it', 'tyrionlannister@gamil.com', 4)

#controllo se un utente è esperto
SELECT *
FROM utente
WHERE email='teresa.tanzi@yahoo.it' and (data_promozione is not NULL)

#controllo se un utente è diventato esperto
SELECT count (seguace)
FROM segue
WHERE seguito='jonsnow@gmail.com'
GROUP BY seguito

#rimuovo un utente dalo stato di esperto
UPDATE utente 
SET data_promozione=NULL
WHERE email='$seguito'

#controllo se ci sono segnalazioni inerenti un testo per stampare la lista di tali
SELECT *
FROM segnala
WHERE autore='teresa.tanzi@yahoo.it' and id_testo=1

#lista delle persone che seguito
SELECT *
FROM segue s join utente u on s.seguito=u.email
WHERE s.seguace='teresa.tanzi@yahoo.it'

#lista delle persone che mi seguono
SELECT *
FROM segue s join utente u on s.seguace=u.email
WHERE s.seguito='jonsnow@gmail.com'

#aggiungere un luogo prefertio
UPDATE utente
SET autore_preferito='teresa.tanzi@yahoo.it', id_pref=4
WHERE email='giacomo.marino@gmail.com'

#recuperare un post di tipo foto
SELECT *
FROM foto
WHERE autore='teresa.tanzi@yahoo.it' and id=3