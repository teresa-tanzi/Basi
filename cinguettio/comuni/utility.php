<!--funzioni chiamate dalle altre pagine (devo richiamare la pagina)-->

<?php
	//controllo le variabili di sessione
	function checksession() {
		if (isset($_SESSION["email"])) { //email è il mio identificatore: uso questa per controllare la sessione
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//creo la connessione al database
	function connect_db() {
		$con=pg_connect("host=localhost port=5432 dbname=cinguettio user=postgres password=unimi");
		if (!$con) { //se ho problemi nella connessione
			echo "Errore nella connessione al database: ".pg_last_error($con); //stampa l'errore
			exit; //termina ed esce dallo script
		}
		return $con;
	}

	//salvo la data di oggi 
	function today_date() {
		if (!ini_get('date_timezione')) { //ini_get ritorna FALSE se il valore non esiste, quindi controllo se esiste
			date_default_timezone_set('Europe/Rome'); //applico il fuso orario di Roma
		}
		$data=date('Y-m-d'); //date ritorna la timezione di adesso: applico il formato che mi serve per fare gli inserimenti di una data nel database
		return $data;
	}

	//salvo l'ora 
	function current_hour() {
		if (!ini_get('date_timezione')) { //ini_get ritorna FALSE se il valore non esiste, quindi controllo se esiste
			date_default_timezone_set('Europe/Rome'); //applico il fuso orario di Roma
		}
		$ora=date('H:i:s'); //date ritorna la timezione, e quindi anche l'ora: applico il formato per ricavare ora, minuti e secondi
		return $ora;
	}

	//stampo il banner
	function print_banner() {
		echo '<html>
			<head>
				<link rel="stylesheet" href="stile.css" type="text/css">
			</head>

			<body>
				<div id="banner">
					<div id="uccellino"><a href="index.php" title="Homepage"><img src="images/uccellino.png" height="100"></a></div>
					<div id="cinguettio" height="130">Cinguettio</div>
				</div>
			</body>
		</html>';
	}

	function autenticazione() {
		echo '<p align=center><font size="3">Pagina riservata agli utenti del servizio</font></p>';
	}
?>