<!--distrugge la sessione e rimanda alla home-->

<?php
	session_start(); //recupera la sessione
	session_unset(); //distrugge la sessione appena recuperata

	header("location: index.php"); //rimanda alla omepage una volta sloggati
?>