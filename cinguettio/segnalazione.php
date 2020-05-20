<!--aggiungo la tupla nella relazione 'segnala'-->

<?php
	session_start();
	require_once("comuni/utility.php"); //devo accedere al DB

	/*echo "SESSION: ";
	print_r($_SESSION);
	echo "<br/>";
	echo "POST: ";
	print_r($_POST);*/

	$utente=$_SESSION["email"];
	$autore=$_POST["autore"];
	$id=$_POST["id"];

	$con=connect_db(); //aggiungo nel database la relazione
	$query="INSERT INTO segnala
		VALUES ('$utente', '$autore', $id)";
	$query_res=pg_query($con, $query);
	if (!$query_res) {
		echo "Errore: ".pg_last_error($con);
		exit;
	}

	header ("location: ".$_SERVER['HTTP_REFERER']); //torna alla pagina prima (bacheca)
?>