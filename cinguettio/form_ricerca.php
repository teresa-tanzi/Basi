<!--form per inserire le variabili di ricerca degli altri utenti-->

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
		<p align=center><font size="6">Ricerca</font><br/>
		Ricerca utenti per:<br/>
		<small>(Lasciare vuoto per ottenere tutti gli utenti)</small></p>
		<form action="ricerca.php" method="GET"> <!--GET per poter condividere i risultati della ricerca-->
			<table id="form" cellpadding="7" align=center>
				<tr>
					<td>Nome</td>
					<td><input type="text" name="nome"></td>
				</tr>
				<tr>
					<td>Cognome</td>
					<td><input type="text" name="cognome"></td>
				</tr>
					<td>Et&agrave</td>
					<td><input type="number" name="età" min="0" max="120"></td>
				</tr>
				<tr>
					<td>Luogo di nascita</td>
					<td><input type="text" name="luogo_n"></td>
				</tr>
				<tr>
					<td>Sesso</td>
					<td>
						<input type="radio" name="sesso" value="m"/>M
						<input type="radio" name="sesso" value="f"/>F
					</td>
				</tr>
				<tr>
					<td>Citt&agrave</td>
					<td><input type="text" name="città"></td>
				</tr>
				<tr>
					<td>Provincia</td>
					<td><input type="text" name="provincia"></td>
				</tr>
				<tr>
					<td>Stato</td>
					<td><input type="text" name="stato"></td>
				</tr>
				<tr>
					<td><p align=center><input type="submit" id="input" value="Cerca"></p></td>
					<td><p align=center><input type="reset" id="input" value="Annulla"></p></td>
				</tr>
			</table>
		</form>
		
		<!--inizio parte d'esame-->
		<p align=center>Ricerca aziende:<br/>
		<form action="ricerca_aziende.php" method="GET"> <!--GET per poter condividere i risultati della ricerca-->
			<table id="form" cellpadding="7" align=center>
				<tr>
					<td>Citt&agrave</td>
					<td><input type="text" name="città"></td>
				</tr>
				<tr>
					<td><p align=center><input type="submit" id="input" value="Cerca"></p></td>
					<td><p align=center><input type="reset" id="input" value="Annulla"></p></td>
				</tr>
			</table>
		</form>
		<!--fine parte d'esame-->
	</body>
</html>