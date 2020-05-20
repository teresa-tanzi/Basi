<!--connessione ad DB per aggiungere cinguettii di tipo luogo-->

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

	$mex="";
	if ($_POST["lat"]=="") {
		$mex=$mex."Non è stata inserita la latitudine<br/>";
	} elseif (!is_numeric($_POST["lat"])) {
			$mex=$mex."La latitudine inserita non corrisponde al formato corretto<br/>";
		} else {
			$lat=$_POST["lat"];
	}

	if ($_POST["long"]=="") {
		$mex=$mex."Non è stata inserita la longitudine<br/>";
	} elseif (!is_numeric($_POST["long"])) {
			$mex=$mex."La longitudine inserita non corrisponde al formato corretto<br/>";
		} else {
			$long=$_POST["long"];
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

	$email=$_SESSION["email"];
	/*echo "SESSION: ";
	print_r($_SESSION);
	echo "<br/>";

	echo "POST: ";
	print_r($_POST);
	echo "<br/>";*/

	
	

	if (!ini_get('date_timezone')) { //ini_get ritorna FALSE se il valore non esiste, quindi controllo se esiste
		date_default_timezone_set('Europe/Rome'); //applico il fuso orario di Roma
	}

	$data=date('Y-m-d'); //date ritorna la timezione di adesso: applico il formato che mi serve per fare gli inserimenti di una data nel database
	$ora=date('H:i:s'); //date ritorna la timezione, e quindi anche l'ora: applico il formato per ricavare ora, minuti e secondi
	echo "Data: ".$data.", ora:".$ora;

	$con=connect_db();

	//cerco se l'utente ha già pubblicato cinguettii: metto più in alto il più recente (devo incrementare l'id del cinguettio)
	$q_id="SELECT *
		FROM cinguettio
		WHERE autore='$email'
		ORDER BY id desc";
	$q_id_res=pg_query($con, $q_id);
	if (!$q_id_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	$id=1; //inizializzo id a 1, così sarà quello che si ha la prima volta che si pubblica qualcosa e non verrà modificato perché non si entra nell'if
	$row=pg_fetch_assoc($q_id_res); //mi basta controllare la prima riga perché li ho ordinati
	if ($row) { //se c'è una riga allora questa contiente l'id più alto che va incrementato
		$id=$row["id"]+1;
	}

	//inserisco i dati nella tabella 'cinguettio', dovrò poi copiare utente ed id in quella specializzata (qui luogo)
	$query_c="INSERT INTO cinguettio
		VALUES ('$email', $id, '$data', '$ora')";
	$query_c_res=pg_query($con, $query_c);
	if (!$query_c_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	echo "<br/>";
	echo $query_c;

	//inserisco i dati nella tabella 'luogo'
	$query_l="INSERT INTO luogo
		VALUES ('$email', $id, '$lat', '$long')";
	$query_l_res=pg_query($con, $query_l);
	if (!$query_l_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	echo "<br/>";
	echo $query_l;

	header("location: bacheca.php")
?>