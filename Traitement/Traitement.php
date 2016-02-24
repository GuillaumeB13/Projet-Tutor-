<?php

?>
<!DOCTYPE html>
<html>
	<head>
		<title>MyOCR - Modification de l'image</title>
		<meta charset="utf-8"/>
		
		<script type="text/javascript" src="./camanjs/dist/caman.full.js"></script>
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script type="text/javascript" src="traitement.js"></script>
	</head>
	<body>
		<h1><center>Réglages de l'image</center></h1>
		<div style="text-align:center">
			<table>
			<tr>
				<td>
				<h2>Fenetre d'aperçu du scan</h2>
				<canvas id="canvas"></canvas>
			</td>
				
			<td>
				<h2>Paramétrage image</h2>
				<table style="display:inline-block">
					<form id="silderInput">
						<tr>
							<td>
							<label for="luminosite">Luminosité</label>
							</td>
							<td>
							<input id="luminosite" name="luminosite" type="range" min="-50" max="50" value="0">
							</td>
						</tr>
						<tr>
							<td>
							<label for="contraste">Contraste</label>
							</td>
							<td>
							<input id="contraste" name="contraste" type="range" min="-50" max="50" value="0">
							</td>
						</tr>
						<tr>
							<td>
							<input type="button" value="+" name="plus" id="rotp">
							</td>
							<td>
							<p>Rotation </p>
							</td>
							<td>
							<input type="button" value="-" name="moins" id="rotm">
							</td>
						</tr>
					</form>
				</table>
					
			</td>
		</tr>
		</table>
			<section>
			<h2>Choix du type de document</h2>
				<div class="menu">
					<select name="select">
						<option value="value1">Carte d'identité</option> 
						<option value="value2">Livret de famille</option>
						<option value="value3">Facture edf</option>
					</select>
				</div>
			</section>
			<section>
				<h2>Lancer la reconnaissance ?</h2>
				<div class="oui"> <input type="button" value="OK" name="plus" id="valider"></div>
				<div class="cancel"> <input type="button" value="Cancel" name="plus"></div>		
			</section>
		</div>




	</body>
</html>