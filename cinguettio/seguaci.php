<?php
	require_once("comuni/utility.php");
	print_banner();
	require_once("comuni/header.php"); //già starta la sessione e utility (non devo farlo nuovamente)
?>

<html>
	<head >
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

<?php
	if (!checksession()) { //se la sessione non è attiva stampo la mancanza di autorizzazione
		autenticazione();
		exit; //chiude lo script
	}
?>

	<body>
		<p align=center><font size="6">Chi mi segue</font><br/></p>
		<table id="form" cellpadding="15" align=center>

<?php
	$email=$_SESSION["email"];

	$con=connect_db();
	$query="SELECT *
		FROM segue s join utente u on s.seguace=u.email
		WHERE s.seguito='$email'";
	$query_res=pg_query($con, $query);
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	if (!$row=pg_fetch_assoc($query_res)) {
		echo "<tr><td>Non hai seguaci</td></tr>";
	} else { //invio il primo risultato (il while richiama pg_fetch e quindi cambia riga, prendendo la seconda)
		$nome=$row["nome"];
		$cognome=$row["cognome"]; //se li invio tramite GET posso rimandare a dati_utente.php
		$profilo=$row["email"];

		?>

		<form action="dati_utente.php" method="GET">
				<tr>
					<td><p id="inmaiuscolo"><?php echo $nome.' '.$cognome; ?></p></td>
					<td>
						<input type="hidden" name="email" value="<?php echo $profilo ?>">
						<input type="image" title="Visualizza profilo" src="images/profilo.png" onMouseOver="this.src='images/profilo2.png'" onMouseOut="this.src='images/profilo.png'" border="0" height="30" width="auto"/>
					</td>
				</tr>
		</form>

		<?php
		while ($row=pg_fetch_assoc($query_res)) {
			$nome=$row["nome"];
			$cognome=$row["cognome"]; //se li invio tramite GET posso rimandare a dati_utente.php
			$profilo=$row["email"];

			?>

			<form action="dati_utente.php" method="GET">
					<tr>
						<td><?php echo $nome.' '.$cognome; ?></td>
						<td>
							<input type="hidden" name="email" value="<?php echo $profilo ?>">
							<input type="image" title="Visualizza profilo" src="images/profilo.png" onMouseOver="this.src='images/profilo2.png'" onMouseOut="this.src='images/profilo.png'" border="0" height="30" width="auto"/>
						</td>
					</tr>
			</form>

			<?php
		}
	}
?>
		</table>
	</body>
</html>