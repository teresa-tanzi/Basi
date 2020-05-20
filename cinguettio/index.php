<!--pagina iniziale: richiede di iscriversi o di loggare (se si è già loggati rimanda alla bacheca)-->

<?php
	session_start();
	require_once("comuni/utility.php"); //mi serve la funzione che controlla la sessione

	print_banner();

	if (checksession()) { //se la sessione è attiva
		header ("location: bacheca.php");
	}
?>

<html>
	<head >
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

	<body>
		<table cellpadding="30" align=center>
			<tr>
				<td colspan=2 align="center"><font size="7">Benvenuto su Cinguettio</font></td> <!--font size da 1 a 7-->
			</tr>
			<tr>
				<td align="center">
					<font size="2">Sei nuovo?</font><br/>
					<a href="form_iscrizione.php"><button type="button" id="home">Iscriviti</button></a>
				</td>
				<td align="center">
					<font size="2">Hai già un account?</font><br/>
					<a href="form_login.php"><button type="button" id="home">Autenticati</button></a>
				</td>
			</tr>
			<!--<tr>
				<td align="center" valign="top"><a href="form_iscrizione.php"><button type="button" id="home">Iscriviti</button></a></td>
				<td align="center"><a href="form_login.php"><button type="button" id="home">Autenticati</button></a></td>
			</tr>-->
		</table>
	</body>
</html>

<?php
	/*echo "<br/>";
	print_r($_SESSION);*/
?>