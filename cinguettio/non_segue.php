<!--pagina che modifica la relazione 'segue' quando si decide di smettere di seguire un utente-->

<?php
	session_start();
	require_once("comuni/utility.php"); //mi serve la connessione con il database

	echo "POST: ";
	print_r($_POST);
	echo "<br/>";
	echo "SESSION: ";
	print_r($_SESSION);

	$seguace=$_SESSION["email"]; //chi mette il 'segue' è l'utente in sessione
	$seguito=$_POST["email"]; //chi viene seguito è il possessore del profilo

	$con=connect_db();
	$query="DELETE FROM segue
		WHERE seguace='$seguace' and seguito='$seguito'";
	$query_res=pg_query($con, $query);
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	//controllo se l'utente che ho defollowato ora non è più esperto: devo guardare quanti follower ha
	$q_promo="SELECT count (seguace)
		FROM segue
		WHERE seguito='$seguito'
		GROUP BY seguito";
	$q_promo_res=pg_query($con, $q_promo);
	if (!$q_promo_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}
	$row=pg_fetch_array($q_promo_res);
	$n_seguaci=$row[0];

	//se a questo punto il count è uguale a 2 devo rimuovere la data di promozione
	if ($n_seguaci==2) {
		$q_promo="UPDATE utente 
			SET data_promozione=NULL
			WHERE email='$seguito'";
		$q_promo_res=pg_query($con, $q_promo);
		if (!$q_promo_res) {
			echo "Errore: ".pg_last_error($con);
			exit;
		}
	}

	header("location: ".$_SERVER['HTTP_REFERER']); //rimanda alla pagina precedente ed aggiorna, quindi rimanda al prifilo e fa vedere incrementato il numero di seguaci
?>