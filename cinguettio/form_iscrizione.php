<!--form che richiede i dati per iscriversi al sito-->

<?php
	require_once("comuni/utility.php");

	print_banner();

	if (checksession()) { //se la sessione è attiva
		header ("location: bacheca.php"); //manda alla bacheca
	}
?>

<html>
	<head >
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

	<body>
		<p align=center><font size="6">Iscrizione</font></p>
			<form action="iscrizione.php" method="POST">
				<table id="form" cellpadding="7" align=center>
					<tr>
						<td>Nome</td>
						<td><input type="text" name="nome"></td>
					</tr>
					<tr>
						<td>Cognome</td>
						<td><input type="text" name="cognome"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="email"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="password"></td>
					</tr>
					<tr>
						<td colspan=2><p align=center><input id="input" type="submit" value="Iscriviti"></p></td>
					</tr>
				</table>
			</form>
	</body>
</html>