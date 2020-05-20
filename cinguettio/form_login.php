<!--form che richiede le credenziali per accedere al servizio-->

<?php
	require_once("comuni/utility.php");

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
		<p align=center><font size="6">Login</font></p>
		<form action="login.php" method="POST" align=center>
			<table cellpadding="7" align=center id="form">
				<tr>
					<td>Email</td>
					<td><input type="text" name="email"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password"></td>
				</tr>
				<tr>
					<td colspan=2><p align=center><input id="input" type="submit" value="Login"></p></td>
				</tr>
			</table>
		</form>
	</body>
</html>