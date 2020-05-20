<!--aggiorna la tabella 'apprezzamento' inserendo il commento-->

<?php
	require_once("comuni/utility.php"); //devo accedere al DB
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

	$mex="";
	if ($_POST["commento"]=="") {
		$mex=$mex."Non è stato inserito alcun commento<br/>";
	} elseif (strlen($_POST["commento"])>50) {
			$mex=$mex."Il commento è troppo lungo<br/>";
		} else {
			$commento=$_POST["commento"];
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

	/*echo "SESSION: ";
	print_r($_SESSION);
	echo "<br/>";
	echo "POST: ";
	print_r($_POST);*/

	$utente=$_SESSION["email"];
	$autore=$_POST["autore"];
	$id=$_POST["id"];

	if (!ini_get('date_timezione')) { //ini_get ritorna FALSE se il valore non esiste, quindi controllo se esiste
		date_default_timezone_set('Europe/Rome'); //applico il fuso orario di Roma
	}
	$data=date('Y-m-d'); //date ritorna la timezione di adesso: applico il formato che mi serve per fare gli inserimenti di una data nel database
	$ora=date('H:i:s'); //date ritorna la timezione, e quindi anche l'ora: applico il formato per ricavare ora, minuti e secondi

	$con=connect_db(); //aggiungo nel database la relazione
	$query="INSERT INTO apprezzamento
		VALUES ('$utente', '$data', '$ora', '$commento', '$autore', $id)";
	$query_res=pg_query($con, $query);
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	header ("location: ".$_SERVER['HTTP_REFERER']); //torna alla pagina prima (bacheca)
?>