<!--aggiungo la tupla nella relazione 'preferenza'-->

<?php
	session_start();
	require_once("comuni/utility.php"); //devo accedere al DB

	/*echo "SESSION: ";
	print_r($_SESSION);
	echo "<br/>";
	echo "POST: ";
	print_r($_POST);*/

	$email=$_SESSION["email"];
	$autore=$_POST["autore"];
	$id=$_POST["id"];

	$con=connect_db(); //aggiungo nel database la relazione
	$query="UPDATE utente
		SET autore_preferito='$autore', id_preferito=$id
		WHERE email='$email'";$query_res=pg_query($con, $query);
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	header ("location: ".$_SERVER['HTTP_REFERER']); //torna alla pagina prima (bacheca)
?>