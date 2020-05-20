<!--profilo degli altri utenti: ci arrivo tramite la ricerca-->

<?php
	require_once("comuni/utility.php");
	print_banner();
	require_once("comuni/header.php"); //già starta la sessione e utility (non devo farlo nuovamente)
?>

<html>
	<head>
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

<?php
	if (!checksession()) { //se la sessione non è attiva stampo la mancanza di autorizzazione
		autenticazione();
		exit; //chiude lo script
	}

	$email=$_SESSION["email"]; //email dell'utente in sessione

	/*print_r($_GET);
	echo "<br/>";*/

	if (isset($_GET["email"])) {
		$profilo=$_GET["email"]; //email del prorpietario del profilo
	} else { //vuol dire che sto accedendo al mio profilo dalla barra
		$profilo=$_SESSION["email"]; //prendo la sessione
	}

	$con=connect_db();
	$query="SELECT u.email, u.nome, u.cognome, p.data_n, p.luogo_n, p.sesso, p.città, p.provincia, p.stato, s1.numero_seguaci, s2.numero_seguiti, l.latitudine, l.longitudine
		FROM (((utente u LEFT JOIN profilo p on u.email=p.utente)
			LEFT JOIN luogo l on u.autore_preferito=l.autore and u.id_preferito=l.id)
			LEFT JOIN (SELECT seguito, COUNT (seguace) as numero_seguaci
				FROM segue
				GROUP BY seguito) s1 on u.email=s1.seguito)
			LEFT JOIN (SELECT seguace, COUNT (seguito) as numero_seguiti
				FROM segue
				GROUP BY seguace) s2 on u.email=s2.seguace
		WHERE u.email='$profilo'"; //restituisce un solo risultato: quello dell'utente loggato
	$query_res=pg_query($con, $query); //eseguo la query
	if (!$query_res) { //controllo se ci sono stati errori
		echo "Errore: ".pg_last_error($con);
		exit; //esce dallo script
	}

	$row=pg_fetch_assoc($query_res); //assegno il risultato della query (già ho i dati di 'utente' nelle variabili di sessione)
	$nome=$row["nome"];
	$cognome=$row["cognome"];
	$data_n=$row["data_n"];
	$luogo_n=$row["luogo_n"];
	$sesso=$row["sesso"];
	$città=$row["città"];
	$provincia=$row["provincia"];
	$stato=$row["stato"];
	$n_seguaci=$row["numero_seguaci"];
	$n_seguiti=$row["numero_seguiti"];
	$latitudine=$row["latitudine"];
	$longitudine=$row["longitudine"];

	/*echo "Risultato query: ";
	print_r($row);
	echo "<br/>";*/
?>



	<body>
		<p align=center id="inmaiuscolo"><font size="6"><?php echo $nome." ".$cognome; ?></font></p>
		<table id="form" cellpadding="15" align=center>
		<tr>
			<?php
				echo "<td>#seguaci: ";
				if (is_null($n_seguaci)) { //se il valore è nullo
					echo "0</td>";
				} else { //se il valore esiste
					echo $n_seguaci."</td>";
				}

				echo "<td>#seguiti: ";
				if (is_null($n_seguiti)) {
					echo "0</td>";
				} else {
					echo $n_seguiti."</td>";
				}
			?>
		</tr>

		<?php
			//controllo se il profilo è il mio, in quel caso devo mandare il pulsante 'modifica profilo'
			if ($profilo==$email) {
				?>

				<tr><td colspan=2>
					<a href="form_modifica_profilo.php"><p align=center><button type="button" id="input">Modifica profilo</button></p></a>
				</td></tr>

				<?php
			} else { //altrimenti devo poter seguire l'utente
				$seguace=$email; //chi mette il 'segue' è l'utente in sessione
				$seguito=$profilo; //chi viene seguito è il possessore del profilo

				$q_segue="SELECT *
					FROM segue
					WHERE seguace='$seguace' and seguito='$seguito'";
				$q_segue_res=pg_query($con, $q_segue);
				if (!$q_segue_res) {
					echo "Errore: ".pg_last_error($con);
					exit;
				}

				/*echo $q_segue;*/

				$row=pg_fetch_assoc($q_segue_res);
				if (!$row) { //se non ha dato risultati significa che il primo untente ancora non segue l'altro e quindi devo dargli la possibilità di seguirlo
					?>

					<tr><td colspan="2">
						<form action="segue.php" method="POST"> <!--devo inviare i dati dell'utente da seguire-->
							<input type="hidden" name="email" value="<?php echo $profilo ?>">
							<p align=center><input id="input" type="submit" value="Segui"></p>
						</form>
					</td></tr>

					<?php
				} else { //se ha dato risultati l'utente già segue l'altro: deve poter rimuoverlo dai seguiti
					?>

					<tr><td colspan=2>
						<form action="non_segue.php" method="POST"> <!--devo inviare i dati dell'utente da seguire-->
							<input type="hidden" name="email" value="<?php echo $profilo ?>">
							<p align=center><input id="input" type="submit" value="Non seguire più"></p>
						</form>
					</td></tr>

					<?php
				}
			}
		?>

			<tr><td>
				<?php
					if (!is_null($data_n))
						echo 'Data di nascita: '.$data_n."<br/>";
					if (!is_null($luogo_n))
						echo 'Luogo di nascita: <span id="inmaiuscolo">'.$luogo_n."</span><br/>"; //span: tag vuoto
					if (!is_null($sesso))
						echo "Sesso: ".$sesso."<br/>";
					if (!is_null($città))
						echo 'Città di residenza: <span id="inmaiuscolo">'.$città."</span><br/>";
					if (!is_null($provincia))
						echo "Provincia: ".$provincia."<br/>";
					if (!is_null($stato))
						echo 'Stato: <span id="inmaiuscolo">'.$stato."</span><br/>";
					if (!is_null($latitudine) and !is_null($longitudine))
						echo "Luogo preferito: ".$latitudine.", ".$longitudine."<br/>";
				?>
			</td></tr>
		</table>
	</body>
</html>