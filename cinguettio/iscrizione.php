<!--pagina che inserisce nel database i dati del nuovo utente-->

<?php
	require_once("comuni/utility.php");
	print_banner();

	session_start();
?>
	<html>
		<head >
			<link rel="stylesheet" href="comuni/stile.css" type="text/css">
		</head>
	</html>

<?php
	$mex="";

	if ($_POST["nome"]=="") {  //prima di assegnare le variabili del post devo controllare che siano valide
		$mex=$mex."Non è stato inserito il nome<br/>";
	} else {
		$nome=htmlspecialchars($_POST["nome"], ENT_QUOTES); //salvo i dati inviati con il form
	}

	if ($_POST["cognome"]=="") {
		$mex=$mex."Non è stato inserito il cognome<br/>";
	} else {
		$cognome=htmlspecialchars($_POST["cognome"], ENT_QUOTES); //htmlspecialchars sostituisce l'apostrofo col carattere speciale che così non può essere frainteso
	}

	if ($_POST["email"]=="") {
		$mex=$mex."Non è stata inserita l'email<br/>";
	} elseif (!preg_match('/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $_POST["email"])) {
			$mex=$mex."L'email non corrisponde al formato corretto<br/>";
		} else {
		$email=$_POST["email"];
	}

	if ($_POST["password"]=="") {
		$mex=$mex."Non è stata inserita la password<br/>";
	} else {
		$password=$_POST["password"];
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

	$con=connect_db(); //creo la connessione col database

	$query="INSERT INTO utente
		VALUES ('$email', '$nome', '$cognome', '$password')";
	$query_res=pg_query($con, $query); //eseguo la query:inserisco i dati nel database

	if (!$query_res) { //controllo se ci sono stati errori nell'esecuzione della query
		echo "Errore: ".pg_last_error($con);
		exit;
	} else {
		echo "Inserimento eseguito";
	}

	$_SESSION["email"]=$email; //assegno le variabili di sessione
	$_SESSION["nome"]=$nome;
	$_SESSION["cognome"]=$cognome;
	$_SESSION["psw"]=$password;

	/*echo "SESSION: ";
	print_r ($_SESSION);*/

	header("location: dati_utente.php"); //avvenuta l'iscrizione rimanda a bacheca
?>