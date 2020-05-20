<!--pagina che controlla se email e password corrispondono a quelle nel database-->

<?php
	require_once("comuni/utility.php"); //mi serve la funzione di connessione al DB
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
	if ($_POST["email"]=="") {
		$mex=$mex."Non è stata inserita l'email<br/>";
	} else {
		$email=$_POST["email"]; //recupero le variabili inviate dal form
	}

	if ($_POST["password"]=="") {
		$mex=$mex."Non è stata inserita la password<br/>";
	} else {
		$password=$_POST["password"];
	}

	if ($mex!="") { //ora faccio solo il controllo sugli inserimenti: la correttezza delle credenziali la valuto dopo
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

	/*print_r($_POST);
	echo "<br/>";*/

	$con=connect_db(); //creo la connessione al DB

	$query="SELECT *
		FROM utente
		WHERE email='$email' and psw='$password'";
	$query_res=pg_query($con, $query); //esegue la query

	if (!$query_res) { //controllo se ci sono stati errori nell'esecuzione della query
		echo "Errore: ".pg_last_error($con); //stampo l'errore
		exit; //esco dallo script
	}

	$row=pg_fetch_assoc($query_res); //creo l'array che contiene il risultato della query
	if (!$row) { //se non avessi risultati restituirebbe FALSE, quindi se i dati sono corretti ho un array
		$mex=$mex."Credenziali sbagliate<br/>";

		if ($mex!="") { //ora faccio solo il controllo sugli inserimenti: la correttezza delle credenziali la valuto dopo
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

	} else {
		$_SESSION["email"]=$email; //assegno le variabili di sessione: quelle passate col form e quelle risultanti dalla query
		$_SESSION["nome"]=$row["nome"];
		$_SESSION["cognome"]=$row["cognome"];
		$_SESSION["psw"]=$password;
		header("location: bacheca.php"); //avvenuto il login rimando alla bacheca
	}

	
?>