<!--header richiamato nelle pagine del sito: barra dei menu oppure richiesta di autenticazione-->

<?php
	session_start();
	require_once("utility.php"); //serve checksession()

	if (checksession()) { //se la sessione è attiva stampo il menu di navigazione
		?>

			<div id="navigation">
				<hr noshade/>
				<table>
					<tr>
						<td bgcolor="#5fa3e5"><a href="dati_utente.php">Profilo</a></td>
						<td bgcolor="#5a90d9"><a href="seguaci.php">Chi mi segue</a></td>
						<td bgcolor="#537ccc"><a href="seguiti.php">Chi seguo</a></td>
						<td bgcolor="#4d6ac0"><a href="form_ricerca.php">Ricerca</a></td>
						<td bgcolor="#4657b3"><a href="bacheca.php">Bacheca</a></td>
						<td bgcolor="#4043a6"><a href="form_pubblicazione.php">Pubblica cinguettio</a></td>
						<td bgcolor="#3a319a"><a href="logout.php">Logout</a></td>
					</tr>
				</table>
			</div>

		<?php
	} else {
		?>

			<hr id="riga" noshade/>
			<div id="autenticare">
				Per accedere alla pagina è necessario <a href="index.php">autenticarsi</a>
			</div>

		<?php
	}
?>