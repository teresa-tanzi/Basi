<!--bacheca-->

<?php
	require_once("comuni/utility.php");
	print_banner();
?>

<html>
	<head >
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

	<body>

<?php
	require_once("comuni/header.php"); //avvia già la sessione: non devo fare ancora session_start()
	if (!checksession()) { //header già chiama utility
		autenticazione();
		exit;
	}

	echo '<p align=center><font size="6">Bacheca</font><br/></p>';

	/*print_r($_SESSION);
	echo "<br/>";*/
	$email=$_SESSION["email"];

	$con=connect_db(); //creo la connessione al database
	$query="SELECT s.seguace, c.autore, u.nome, u.cognome, c.id, c.data, c.ora, t.testo, l.latitudine, l.longitudine, f.url, f.descrizione
		FROM utente u join
			(((((SELECT * FROM segue UNION SELECT autore as seguace, autore FROM cinguettio) s
			join cinguettio c on s.seguito=c.autore)
			LEFT JOIN testo t on c.autore=t.autore and c.id=t.id)
			LEFT JOIN luogo l on c.autore=l.autore and c.id=l.id)
			LEFT JOIN foto f on c.autore=f.autore and c.id=f.id) on u.email=c.autore
		WHERE s.seguace='$email'
		ORDER BY s.seguace, c.data desc, c.ora desc";
	$query_res=pg_query($con, $query); //eseguo la query (restituisce più righe: dovrò poi ciclare)
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	echo '<div id="bacheca">';
	while ($row=pg_fetch_assoc($query_res)) { //per goni riga del risultato
		$autore=$row["autore"]; //mi serve per mandare l'email alla pagina della segnalazione (serve l'autore e l'id del cinguettio)
		$id=$row["id"];
		$nome=$row["nome"];
		$cognome=$row["cognome"];
		$data=$row["data"];
		$ora=$row["ora"];
		$testo=$row["testo"];
		$latitudine=$row["latitudine"];
		$longitudine=$row["longitudine"];
		$url=$row["url"];
		$descrizione=$row["descrizione"];

		/*print_r($row);
		echo "<br/>";*/
		
		echo '<div id="post" align="justify">';
		echo "<p>";
		?>

		<font size="4" color="#547fce"><span id="inmaiuscolo"><?php echo $nome." ".$cognome; ?></span></font>
		
		<!--inizio parte dell'esame-->
		<?php
			//dopo il nome dell'utente devo stampare il numero di impieghi corrente
			$q_impiego_corrente="SELECT count(azienda) as n_impieghi_correnti
				FROM impiego
				WHERE data_fine is null and utente='$autore'
				GROUP BY utente";
			$q_impiego_corrente_res=pg_query($con, $q_impiego_corrente);
			if (!$q_impiego_corrente) {
				echo "Errore: ".pg_last_error($con);
				exit;
			}
			$row_ic=pg_fetch_assoc($q_impiego_corrente_res);
			
			//se non ha dato risultati vuol dire che non ho impieghi correnti
			$ic=0;
			if ($row_ic) { //ho dei risultati: cabio il numero di impieghi correnti che di default era 0
				$ic=$row_ic["n_impieghi_correnti"];
			}
			
			if ($ic==1) {
			?>
				 (<?php echo $ic; ?> impiego corrente <!--per il sigolare cambiano le parole da scrivere-->
			<?php
			} else {
			?>
				 (<?php echo $ic; ?> impieghi correnti
			<?php
			}
			
			$q_impiego_passato="SELECT count(azienda) as n_impieghi_passati
				FROM impiego
				WHERE data_fine is not null and utente='$autore'
				GROUP BY utente";
			$q_impiego_passato_res=pg_query($con, $q_impiego_passato);
			if (!$q_impiego_passato) {
				echo "Errore: ".pg_last_error($con);
				exit;
			}
			$row_ip=pg_fetch_assoc($q_impiego_passato_res);
			
			//se non ha dato risultati vuol dire che non ho impieghi passati
			$ip=0;
			if ($row_ip) { //ho dei risultati: cabio il numero di impieghi correnti che di default era 0
				$ip=$row_ip["n_impieghi_passati"];
			}
			
			if ($ip==1) {
			?>
				 - <?php echo $ip; ?> impiego terminato) <!--per il sigolare cambiano le parole da scrivere-->
			<?php
			} else {
			?>
				 - <?php echo $ip; ?> impieghi terminati)
			<?php
			}
			?>
			<!--fine parte dell'esame-->
		
		<br/>
		<small><?php echo $data." ".$ora; ?></small>
		
		<table id="profilo">
			<form action="dati_utente.php" method="GET">
				<tr>
					<td><div id="alprofilo">Visualizza<br/>profilo &#8594</div></td>
					<td>
						<input type="hidden" name="email" value="<?php echo $autore ?>">
						<input type="image" title="Visualizza profilo" src="images/profilo.png" onMouseOver="this.src='images/profilo2.png'" onMouseOut="this.src='images/profilo.png'" border="0" height="30" width="auto"/> <!--voglio associarlo ad un'immagine-->
					</td>
				</tr>
			</form>
		</table>

		<?php
		//TESTO
		if (!is_null($testo)){ //per i cinguettii di tipo testo
			echo '<p id="testo">'.$testo.'</p>';
			//prima di stampare il pulsante di segnalazione controllo se è già stata fatta da questo utente per questo post
			$q_segnala="SELECT *
				FROM segnala
				WHERE (utente='$email' and autore='$autore' and id_testo=$id)";
			$q_segnala_res=pg_query($con, $q_segnala);
			if (!$q_segnala_res) {
				echo "Errore: ".pg_last_error($con);
				exit;
			}
		?>

		<table id="bacheca">
			<tr><td>

		<?php
			$row=pg_fetch_assoc($q_segnala_res); //se c'è una riga come risultato allora l'utente ha già segnalato quel post
			if ($row) {
				echo '<div id="premuto">Segnalato</div>';
			} elseif ($autore!=$email) {
				?>

				<!--bottone per la segnalazione-->
				<form action="segnalazione.php" method="POST">
					<input type="hidden" name="autore" value="<?php echo $autore ?>">
					<input type="hidden" name="id" value="<?php echo $id ?>">
					<input id="input" type="submit" value="Segnala">
				</form>

				<?php
			}
			echo "</td>";

			//controllo se ci sono delle segnalazioni, in caso affermativo mando il link alla lista
			$q_lista_segn="SELECT *
				FROM segnala
				WHERE autore='$autore' and id_testo=$id";
			$q_lista_segn_res=pg_query($con, $q_lista_segn);
			if (!$q_lista_segn_res) {
				echo "Errore: ".pg_last_error($con);
				exit;
			}
			$row=pg_fetch_assoc($q_lista_segn_res); //se ci sono dei risultati allora il post è stato segnalato
			if ($row) {
				?>

				<td>
					<form action="lista_segnalazioni.php" method="GET">
						<input type="hidden" name="autore" value="<?php echo $autore ?>">
						<input type="hidden" name="id" value="<?php echo $id ?>">
						<input id="input" type="submit" value="Visualizza segnalazioni">
					</form>
				</td>
			</tr>

				<?php
			}
			echo "</table>";
		}

		//LUOGO
		if (!is_null($latitudine)){ //per i cinguettii di tipo luogo
			echo '<p id="testo">';
			echo "Posizione geografica:";
			echo "<br/>";
			echo "Lat: ".$latitudine;
			echo "<br/>";
			echo "Long: ".$longitudine; //da cercare se c'è un modo per convertirli
			echo "</p>";

			//prima di stampare il pulsante di preferenza controllo se è già stata fatta da questo utente per questo post
			$q_preferenza="SELECT *
				FROM utente
				WHERE (email='$email' and autore_preferito='$autore' and id_preferito=$id)"; //SE POSSO PREFERIRE SOLO UN LUOGO ALLORA CERCO SOLO $email
			$q_preferenza_res=pg_query($con, $q_preferenza);
			if (!$q_preferenza_res) {
				echo "Errore: ".pg_last_error($con);
				exit;
			}
		?>

		<table id="bacheca">
			<tr><td>

		<?php
			$row=pg_fetch_assoc($q_preferenza_res); //se c'è una riga come risultato allora l'utente ha già messo questo luogo come preferito
			if ($row) {
				echo '<div id="premuto">Preferito</div>';
				echo "</td></tr></table>";
			} else {
				?>

				<!--bottone per la preferenza-->
				<form action="preferenza.php" method="POST">
					<input type="hidden" name="autore" value="<?php echo $autore ?>">
					<input type="hidden" name="id" value="<?php echo $id ?>">
					<input id="input" type="submit" value="Preferisci">
				</form>
				</td></tr></table>

				<?php
			}
		}

		//FOTO
		if (!is_null($url)) { //per i cinguettii di tipo foto
			echo '<p id="testo">';
			echo '<img src="'.$url.'" style="max-width: 580px; height: auto;"><br/>'; //ridimensiono bene nel css
			echo '<br/>'.$descrizione;
			echo '</p>';
		?>

		<table id="bacheca">
			<tr><td>

		<?php
			//per le foto non devo fare il controllo: un utente puù fare un apprezzamento più volte
			//devo però controllare se l'utente è esperto (controllo se ha data_promozione in 'utente')
			$q_esperto="SELECT *
				FROM utente
				WHERE email='$email' and (data_promozione is not NULL)";
			$q_esperto_res=pg_query($con, $q_esperto);
			if (!$q_esperto_res) {
				echo "Errore: ".pg_last_error($con);
				exit;
			}

			$row=pg_fetch_assoc($q_esperto_res); //se c'è una riga come risultato allora l'utente è esperto: può apprezzare una foto lasciando un commento
			if ($row) {
				?>

				<!--form per fare un apprezzamento e lasciare un commento-->
				<form action="apprezzamento.php" method="POST">
					<input type="hidden" name="autore" value="<?php echo $autore ?>">
					<input type="hidden" name="id" value="<?php echo $id ?>">
					<table>
						<tr><td><textarea name="commento" rows="2" cols="50" maxlength="50" placeholder="Inserire commento (max 50 caratteri)." ></textarea></td></tr>
						<tr><td><input id="input" type="submit" value="Apprezza"></td></tr>
					</table>
				</form>
				</td></tr>

				<?php
			}

			//controllo se ci sono degli apprezzamenti, in caso affermativo mando il link alla lista
			$q_lista_app="SELECT *
				FROM apprezzamento
				WHERE autore='$autore' and id_foto=$id";
			$q_lista_app_res=pg_query($con, $q_lista_app);
			if (!$q_lista_app_res) {
				echo "Errore: ".pg_last_error($con);
				exit;
			}
			$row=pg_fetch_assoc($q_lista_app_res); //se ci sono dei risultati allora il post è stato apprezzato
			if ($row) {
				?>

				<tr><td>
				<form action="lista_apprezzamenti.php" method="GET">
					<input type="hidden" name="autore" value="<?php echo $autore ?>">
					<input type="hidden" name="id" value="<?php echo $id ?>">
					<input id="input" type="submit" value="Visualizza apprezzamenti">
				</form>
				</td></tr></table>

				<?php
			}
			echo "</table>";
		}
		echo "</p>";
		echo "</div>";
		echo "</body>";
		echo "</html>";
	}
	echo '</div>';
?>