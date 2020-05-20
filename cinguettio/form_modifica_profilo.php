<!--form che prende in input le modifiche da fare ai dati dell'utente-->

<?php
	require_once("comuni/utility.php");
	print_banner();
	require_once("comuni/header.php");
?>

<html>
	<head >
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

<?php
	if (!checksession()) {
		autenticazione();
		exit;
	}
	
	$email=$_SESSION["email"];
	
	$con=connect_db();
	$query="SELECT *
		FROM utente u LEFT JOIN profilo p on u.email=p.utente
		WHERE p.utente='$email'";
	$query_res=pg_query($con, $query); //esegue la query
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}
	$row=pg_fetch_assoc($query_res);
	
	$data=$row["data_n"];
	$luogo=$row["luogo_n"];
	$sesso=$row["sesso"];
	$città=$row["città"];
	$provincia=$row["provincia"];
	$stato=$row["stato"];
?>

	<body>
		<p align=center><font size="6">Modifica profilo</font></p>
		<form action="modifica_profilo.php" method="POST">
			<table cellpadding="7" align=center id="form">
				<tr>
					<td>Nuova password</td>
					<td><input type="password" name="n_password"></td>
				</tr>
				<tr>
					<td>Data di nascita</td>
					<td><input type="date" name="n_data_n" min="1900-01-01" max="2017-01-01" value="<?php echo $data; ?>"></td>
				</tr>
				<tr>
					<td>Luogo di nascita</td>
					<td><input type="text" name="n_luogo_n" placeholder="<?php echo ucwords($luogo); ?>"></td> <!--ucwords rende maiuscola la prima lettera di ogni parola della stringa-->
				</tr>
				<tr>
					<td>Sesso</td>
					<td>
						<input type="radio" name="n_sesso" value="m" <?php if ($sesso=='m') echo "checked"; ?>/>M
						<input type="radio" name="n_sesso" value="f" <?php if ($sesso=='f') echo "checked"; ?>/>F
					</td>
				</tr>
				<tr>
					<td>Citt&agrave</td> <!--&agrave: carattere speciale per "à"-->
					<td><input type="text" name="n_città" placeholder="<?php echo ucwords($città); ?>"></td>
				</tr>
				<tr>
					<td>Provincia</td>
					<td><input type="text" name="n_provincia" placeholder="<?php echo $provincia; ?>"></td>
				</tr>
				<tr>
					<td>Stato</td>
					<td><input type="text" name="n_stato" placeholder="<?php echo ucwords($stato); ?>"></td>
				</tr>
				<tr>
					<td><input id="input" type="submit" value="Modifica"></td>
					<td><input id="input" type="reset" value="Annulla"></td>
				</tr>
			</table>
		</form>
	</body>
</html>