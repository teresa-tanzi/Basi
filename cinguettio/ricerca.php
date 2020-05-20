<!--pagina che esegue la ricerca secondo i parametri del GET e ne restituisce i risultati-->

<?php
	require_once("comuni/utility.php");
	print_banner();
	require_once("comuni/header.php"); //avvia già la sessione: non devo fare ancora session_start()
?>

<html>
	<head>
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

<?php
	if (!checksession()) { //header già chiama utility
		autenticazione();
		exit;
	}
?>

	<body>

<?php
	$email=$_SESSION["email"];

	$mex=""; //i campi qui possono essere vuoti: controllo solo che i dati inseriti siano consistenti
	if (!is_numeric($_GET["età"]) and (!($_GET["età"]==""))) {
		$mex=$mex."L'età non corrisponde al formato corretto<br/>";
	} else {
		$età=$_GET["età"];
		$età_iniziale=$età." years";
		$età_finale=($età+1)." years";
	}

	if (isset($_GET["sesso"])) {
		if (($_GET["sesso"]!='f') and ($_GET["sesso"]!='m') and (!is_null($_GET["sesso"]))) { //controllo che il sesso sia 'm' o 'f'
			$mex=$mex."Il sesso non corrisponde al formato corretto<br/>";
		} else {
			$sesso=$_GET["sesso"];
		}
	}

	if ((strlen($_GET["provincia"])!=2) and (!($_GET["provincia"]==""))) { //controllo che la provincia sia lunga 2
		$mex=$mex."La provincia non corrisponde al formato corretto<br/>";
	} else {
		$provincia=$_GET["provincia"];
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

	/*print_r($_GET); //uso GET
	echo "<br/>";*/

	$nome=htmlspecialchars($_GET["nome"], ENT_QUOTES); //assegno tutte le altre variabili su cui non ho dovuto fare controlli
	$cognome=htmlspecialchars($_GET["cognome"], ENT_QUOTES);
	$luogo_n=htmlspecialchars($_GET["luogo_n"], ENT_QUOTES);
	$città=htmlspecialchars($_GET["città"], ENT_QUOTES);
	$stato=htmlspecialchars($_GET["stato"], ENT_QUOTES);

	$con=connect_db();

	//query base che restituisce tutti
	$query="SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente";
	if ($nome!="") { //per ogni elemento della ricerca faccio una query a se ed interseco con quella di partenza (salvo poi nella stessa variabile)
		$query=$query." INTERSECT
		SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE lower(u.nome)=lower('$nome')"; //lower serve per rendere la ricerca case insensitive
	}
	if ($cognome!="") {
		$query=$query." INTERSECT
		SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE lower(u.cognome)=lower('$cognome')";
	}
	if ($età!="") {
		$query=$query." INTERSECT
			SELECT *
			FROM utente u LEFT JOIN profilo p on u.email=p.utente
			WHERE age(p.data_n)>='$età_iniziale' and age(p.data_n)<'$età_finale'";
	}
	if (isset($_GET["sesso"])) {
		$query=$query." INTERSECT
		SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE p.sesso='$sesso'";
	}
	if ($luogo_n!="") {
		$query=$query." INTERSECT
		SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE lower(p.luogo_n)=lower('$luogo_n')";
	}
	if ($città!="") {
		$query=$query." INTERSECT
		SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE lower(p.città)=lower('$città')";
	}
	if ($provincia!="") {
		$query=$query." INTERSECT
		SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE lower(p.provincia)=lower('$provincia')";
	}
	if ($stato!="") {
		$query=$query." INTERSECT
		SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE lower(p.stato)=lower('$stato')";
	}

	$query=$query." ORDER BY nome, cognome";

	/*echo $query;
	echo "<br/>";*/

	$query_res=pg_query($con, $query);
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}
?>

		<p align=center><font size="6">Risultati ricerca:</font><br/></p>
			<table id="form" cellpadding="15" align=center>

<?php
	if (!($row=pg_fetch_assoc($query_res))) {
		echo "<tr><td colspan=2>Nessun risultato</td></tr>";
	} else { //se non stampo la prima poi dal ciclo mi stamperebbe solo dalla seconda in poi: ormai la funzione l'ho chiamata
		$profilo=$row["email"] //email del profilo da visualizzare ($email è la variabile che contiene l'email dell'utente in sessione)
		?>
			
				<form action="dati_utente.php" method="GET">
					<tr>
						<td><p id="inmaiuscolo"><?php echo $row["nome"].' '.$row["cognome"]; ?></p></td>
						<td>
							<input type="hidden" name="email" value="<?php echo $profilo ?>">
							<input type="image" title="Visualizza profilo" src="images/profilo.png" onMouseOver="this.src='images/profilo2.png'" onMouseOut="this.src='images/profilo.png'" border="0" height="30" width="auto"/>
						</td>
					</tr>
				</form>

		<?php
	}

	while ($row=pg_fetch_assoc($query_res)) { //posso avere più risultati: devo ciclare
		$profilo=$row["email"] //email del profilo da visualizzare ($email è la variabile che contiene l'email dell'utente in sessione)
		?>
			
				<form action="dati_utente.php" method="GET">
					<tr>
						<td><p id="inmaiuscolo"><?php echo $row["nome"].' '.$row["cognome"]; ?></p></td>
						<td>
							<input type="hidden" name="email" value="<?php echo $profilo ?>">
							<input type="image" title="Visualizza profilo" src="images/profilo.png" onMouseOver="this.src='images/profilo2.png'" onMouseOut="this.src='images/profilo.png'" border="0" height="30" width="auto"/>
						</td>
					</tr>
				</form>

		<?php
	}
	echo "</table>
			</body>
		</html>";
?>
