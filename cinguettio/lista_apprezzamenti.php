<!--lista degli utenti che hanno apprezzato un determinato post, con il dato messaggio-->

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

	$autore=$_GET["autore"];
	$id=$_GET["id"];
?>

	<body>
		<p align=center><font size="6">Lista apprezzamenti</font></p>
		<p align=center>Utenti che hanno apprezzato questo cinguettio:</p>

		<?php
		$con=connect_db();	

		//query che certituisce tutti gli apprezzamenti fatti alla foto
		$q_lista_app="SELECT *
			FROM utente u join apprezzamento a on u.email=a.utente
			WHERE a.autore='$autore' and a.id_foto=$id";
		$q_lista_app_res=pg_query($con, $q_lista_app);
		if (!$q_lista_app_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
		while($row=pg_fetch_assoc($q_lista_app_res)) {
			$nome=$row["nome"];
			$cognome=$row["cognome"];
			$data=$row["data"];
			$ora=$row["ora"];
			$testo=$row["testo"];
			?>

			<div id="post" align="justify">
				<table cellpadding="7">
					<tr><td>
						<div id="nome"><font color="#547fce"><p id="inmaiuscolo"><?php echo $nome.' '.$cognome?></p></font></div>
						<div id="small"><?php echo $data." ".$ora?></div>
					</td></tr>
					<tr><td><?php echo $testo ?></td></tr>
				</table>
			</div>

			<?php
		}
	echo "</p>";
?>

		<div id="reindirizzamento"><p align=center>Torna alla <a href="bacheca.php">bacheca</a></p></div>
	</body>
</html>