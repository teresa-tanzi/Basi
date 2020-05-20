<!--form per la pubblicazione di un cinguettio-->

<?php
	require_once("comuni/utility.php");
	print_banner();
	require_once("comuni/header.php");	
?>

<html>
	<head>
		<link rel="stylesheet" href="comuni/stile.css" type="text/css">
	</head>

<?php
	if (!checksession()) {
		autenticazione();
		exit;
	}
?>

	<body>
		<p align=center><font size="6">Pubblica cinguettio</font><br/>
			<form action="#" method="GET"> <!--form per scegliere il tipo di cinguettio da pubblicare-->

				<!--<legend>Tipo di cinguettio</legend>
				<select name="tipo" >
				<option value="testo">testo</option>
				<option value="foto">foto</option>
				<option value="luogo">luogo</option>
				</select>
				<input type="submit" value="Seleziona">: menù a tendina-->

				<table id="form" cellpadding="7" align=center>
					<tr><td>Tipo di cinguettio</td></tr>
					<tr>
						<td>
							<input type="radio" name="tipo" value="testo"/>Testo
							<input type="radio" name="tipo" value="foto"/>Foto
							<input type="radio" name="tipo" value="luogo"/>Luogo
						</td>
					</tr>
					<tr><td><p align=center><input id="input" type="submit" value="Seleziona"></p></td></tr>
				</table>

			</form>

			<?php
				//print_r($_GET);
				if (isset($_GET["tipo"])) {
					$tipo=$_GET["tipo"];
					echo '<p align=center id="inmaiuscolo"><font size="3">Tipo: '.$tipo.'</font></p>';
				}

				if (!isset($_GET["tipo"])) { //quando ancora non ho selezionato dico di fare una scelta tra i tipi: comparirà poi la form
					echo '<table id="form" cellpadding="7" align=center><tr><td>Selezionare tipo di cinguettio che si desidera pubblicare</td></tr></table>';
				} else { //il tipo è stato definito: posso pubblicare il form

					//il tipo selezionato non corrisponde a nessuno di quelli default
					$mex="";
					if (($tipo!='testo') and ($tipo!='luogo') and ($tipo!='foto')) {
						$mex=$mex."Il tipo di cinguettio non corrisponde al formato corretto<br/>";
					}
					if ($mex!="") {
						?>

						<p><div id="attenzione">Attenzione!</div></p>
						<table id="form" cellpadding="7" align=center>
							<tr><td><?php echo $mex; ?></td></tr>
							<tr><td>Tornare indietro e controllare</td></tr>
							<tr><td><form><p align=center><input id="input" type="button" value="Indietro" onClick="history.go(-1);"></p></form></td></tr>
						</table>

						<?php
						exit;
					}

					if ($tipo=="testo") {
						?>

						<form action="pubblica_testo.php" method="POST">
							<table id="form" cellpadding="7" align=center>
								<tr><td><textarea name="testo" rows="4" cols="50" maxlength="100" placeholder="Inserire il testo (max 100 caratteri)."></textarea></td></tr>
								<tr><td><p align=center><input id="input" type="submit" value="Pubblica testo"></p></td></tr>
							</table>
						</form>

						<?php
					}

					if ($tipo=="foto") {
						?>

						<form action="pubblica_foto.php" method="POST">
							<table id="form" cellpadding="7" align=center>
								<tr><td>URL: <input type="text" name="url"></td></tr>
								<tr><td><textarea name="commento" rows="2" cols="50" maxlength="20" placeholder="Inserire commento (max 20 caratteri)."></textarea></td></tr>
								<tr><td><p align=center><input id="input" type="submit" value="Pubblica foto"></p></td></tr>
							</table>
						</form>

						<?php
					}

					if ($tipo=="luogo") {
						?>

						<form action="pubblica_luogo.php" method="POST">
							<table id="form" cellpadding="7" align=center>
								<tr>
									<td>Latitudine</td>
									<td><input type="text" name="lat"></td>
								</tr>
								<tr>
									<td>Longitudine</td>
									<td><input type="text" name="long"></td>
								</tr>
								<tr><td colspan=2><p align=center><input id="input" type="submit" value="Pubblica luogo"></p></td></tr>
							</table>
						</form>

						<?php
					}
				}
			?>
	</body>
</html>