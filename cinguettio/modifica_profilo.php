<!--modifica i campi di 'utente' e 'profilo' secondo quanto detto nel form-->

<?php
	require_once("comuni/utility.php"); //devo connettermi al DB
	print_banner();
	require_once("comuni/header.php");
?>
	<html>
		<head >
			<link rel="stylesheet" href="comuni/stile.css" type="text/css">
		</head>
	</html>

<?php
	if (!checksession()) { //header già chiama utility
		autenticazione();
		exit;
	}
	
	$email=$_SESSION["email"];

	/*print_r($_POST);
	echo "<br/>";*/

	$mex=""; //i campi qui possono essere vuoti: controllo solo che i dati inseriti siano consistenti
	if ((!preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $_POST["n_data_n"])) and (!($_POST["n_data_n"]==""))) { //controllo che la data sia di formato "date"
		$mex=$mex."La data di nascita non corrisponde al formato corretto<br/>"; //se è vuota non devo dare errore
	} else {
		$n_data_n=$_POST["n_data_n"];
	}

	if (($_POST["n_sesso"]!='f') and ($_POST["n_sesso"]!='m') and (!is_null($_POST["n_sesso"]))) { //controllo che il sesso sia 'm' o 'f'
		$mex=$mex."Il sesso non corrisponde al formato corretto<br/>";
	} else {
		$n_sesso=$_POST["n_sesso"];
	}

	if ((strlen($_POST["n_provincia"])!=2) and (!($_POST["n_provincia"]==""))) { //controllo che la provincia sia lunga 2
		$mex=$mex."La provincia non corrisponde al formato corretto<br/>";
	} else {
		$n_provincia=$_POST["n_provincia"];
	}

	if ($mex!="") {
		?>

	<p><div id="attenzione">Attenzione!</div></p>
		<table id="form" cellpadding="7" align=center>
			<tr><td><?php echo $mex; ?></td></tr>
			<tr><td>Tornare indietro e controllare</td></tr>
			<tr><td><form><p align=center><input id="input" type="button" value="Indietro" onClick="history.go(-1);"></p></form></td></tr>
		</table>

		<?php
		exit;
	}

	$n_password=$_POST["n_password"];
	$n_luogo_n=htmlspecialchars($_POST["n_luogo_n"], ENT_QUOTES);
	$n_città=htmlspecialchars($_POST["n_città"], ENT_QUOTES);
	$n_stato=htmlspecialchars($_POST["n_stato"], ENT_QUOTES);

	$con=connect_db(); //crea la connessione al database

	#devo per prima cosa controllare se nella tabella 'profilo' c'è già l'email dell'utente (essendo tutti campi opzionali potrebbe non essere)
	$q_ricerca="SELECT *
		FROM profilo
		WHERE utente='$email'";
	$q_ricerca_res=pg_query($con, $q_ricerca); //esegue la query
	if (!$q_ricerca_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	$row_ricerca=pg_fetch_assoc($q_ricerca_res); //se non ci sono risulati è vuoto: l'email va aggointa a 'profilo' come campo 'utente'
	if (!$row_ricerca) {
		$q_inserimento="INSERT INTO profilo (utente)
			VALUES ('$email')";
		$q_inserimento_res=pg_query($con, $q_inserimento); //inserisce l'email
		if (!$q_inserimento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	if (!($n_password=="")) { //modifico la password (aggiungo lo stesso l'utente nella tabella 'profilo', anche se non metto nessun dato lì)
		$q_aggiornamento="UPDATE utente 
			SET psw='$n_password'
			WHERE email='$email'";
		$q_aggiornamento_res=pg_query($con, $q_aggiornamento);
		if (!$q_aggiornamento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	if (!($n_data_n=="")) { //modifico la data di nascita (se è stata cambiata)
		$q_aggiornamento="UPDATE profilo 
			SET data_n='$n_data_n'
			WHERE utente='$email'";
		$q_aggiornamento_res=pg_query($con, $q_aggiornamento);
		if (!$q_aggiornamento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	if (!($n_luogo_n=="")) { //modifico il luogo di nascita
		$q_aggiornamento="UPDATE profilo 
			SET luogo_n='$n_luogo_n'
			WHERE utente='$email'";
		$q_aggiornamento_res=pg_query($con, $q_aggiornamento);
		if (!$q_aggiornamento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	if (!is_null($n_sesso)) { //aggiorno il sesso
		$q_aggiornamento="UPDATE profilo 
			SET sesso='$n_sesso'
			WHERE utente='$email'";
		$q_aggiornamento_res=pg_query($con, $q_aggiornamento);
		if (!$q_aggiornamento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	if (!($n_città=="")) { //aggiorno la città
		$q_aggiornamento="UPDATE profilo 
			SET città='$n_città'
			WHERE utente='$email'";
		$q_aggiornamento_res=pg_query($con, $q_aggiornamento);
		if (!$q_aggiornamento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	if (!($n_provincia=="")) { //aggiorno la provincia
		$q_aggiornamento="UPDATE profilo 
			SET provincia='$n_provincia'
			WHERE utente='$email'";
		$q_aggiornamento_res=pg_query($con, $q_aggiornamento);
		if (!$q_aggiornamento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	if (!($n_stato=="")) { //aggiorno lo stato
		$q_aggiornamento="UPDATE profilo 
			SET stato='$n_stato'
			WHERE utente='$email'";
		$q_aggiornamento_res=pg_query($con, $q_aggiornamento);
		if (!$q_aggiornamento_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}
	
	header("location: dati_utente.php"); //fatte le modifice rimanda al profilo, così che siano visibili
?>