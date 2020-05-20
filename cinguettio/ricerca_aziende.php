<!--pagina nuova creata per l'esame-->

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
	
	//controllo che la città sia stata inserita
	$mex="";
	if ($_GET["città"]=="") {
		$mex=$mex."Non è stata inserita alcuna città<br/>";
	} else {
		$città=htmlspecialchars($_GET["città"], ENT_QUOTES); //mi permette di inserire caratteri speciali come l'apostrofo
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

	$con=connect_db();

	$query="SELECT a.nome, count(data_inizio)-count(data_fine) as n_dipendenti
		FROM impiego i JOIN azienda a on i.azienda=a.email
		WHERE lower(a.città)=lower('$città')
		GROUP BY a.email, a.nome";

	$query_res=pg_query($con, $query);
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}
?>

		<p align=center><font size="6">Risultati ricerca:</font><br/>
			Per la città: <span id="inmaiuscolo"><?php echo $città; ?></span>
		</p>
			<table id="form" cellpadding="15" align=center>

<?php
	if (!($row=pg_fetch_assoc($query_res))) {
		echo "<tr><td colspan=2>Nessun risultato</td></tr>";
	} else { //se non stampo la prima poi dal ciclo mi stamperebbe solo dalla seconda in poi: ormai la funzione l'ho chiamata
		$azienda=$row["nome"];
		$n=$row["n_dipendenti"];
		?>
		
		<tr>
			<th>Azienda</th>
			<th>Numero dipendenti</th>
		</tr>
		<tr>
			<td><p id="inmaiuscolo"><?php echo $azienda; ?></p></td>
			<td><?php echo $n; ?></td>
		</tr>
		
		<?php
	}

	while ($row=pg_fetch_assoc($query_res)) { //posso avere più risultati: devo ciclare
		$azienda=$row["nome"];
		$n=$row["n_dipendenti"];
		?>
		
		<tr>
			<td><p id="inmaiuscolo"><?php echo $azienda; ?></p></td>
			<td><?php echo $n; ?></td>
		</tr>
		
		<?php
	}
	echo "</table>
			</body>
		</html>";
?>
