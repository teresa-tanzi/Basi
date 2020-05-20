<!--lista degli utenti che hanno segnalato un determinato post-->

<?php
	require_once("comuni/utility.php");
	print_banner();

	require_once("comuni/header.php"); //avvia già la sessione: non devo fare ancora session_start()
?>

<html>
	<head >
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

<?php
	if (!checksession()) { //header già chiama utility
		autenticazione();
		exit;
	}
	require_once("comuni/utility.php");

	$autore=$_GET["autore"];
	$id=$_GET["id"];
?>
	<body>
		<p align=center><font size="6">Lista segnalazioni</font></p>
		<p align=center>Utenti che hanno segnalato questo cinguettio:</p>
		<table id="form" align=center cellpadding="7">

	<?php
	$con=connect_db();
	$q_lista_segn="SELECT *
		FROM utente u join segnala s on u.email=s.utente
		WHERE s.autore='$autore' and s.id_testo=$id";
	$q_lista_segn_res=pg_query($con, $q_lista_segn);
	if (!$q_lista_segn_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}
	while($row=pg_fetch_assoc($q_lista_segn_res)) {
		echo '<tr><td><p id="inmaiuscolo">';
		echo $row["nome"]." ".$row["cognome"];
		echo '</p></td></tr>';
	}
?>

		</table>
			<div id="reindirizzamento"><p align=center>Torna alla <a href="bacheca.php">bacheca</a></p></div>
	</body>
</html>