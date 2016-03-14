<?php
	session_start();
	$canvasSize = getimagesize("identite.jpg");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ajout de masque</title>
    <script type="text/javascript" src="gestion.js"></script>
  </head>
  <body onload="init()">
    <div id="container">
<?php
      echo "<canvas id=\"canvas1\" width=\"$canvasSize[0]\" height=\"$canvasSize[1]\" style=\"border: 1px solid black;\">";
?>
		This text is displayed if your browser does not support HTML5 Canvas.
      </canvas>
    </div>
	<div>
		<form name="f">
			<p>ID: <input type="text" name="id" onchange="CanvasState.prototype.update()" onkeydown="testForEnter();"/></p>
			<p>Type: <select name="type" onchange="CanvasState.prototype.update()" onkeydown="testForEnter();">
				<option value="texte">Texte</option>
				<option value="date">Date</option>
				<option value="image">Image</option>
			</select>
			</p>
			<p>Nom du champ: <input type="text" name="nom_champ" onchange="CanvasState.prototype.update()" /></p>
			<p> x1: <input type="text" name="x" onchange="CanvasState.prototype.update()" /> y1:<input type="text" name="y" onchange="CanvasState.prototype.update()"/> </p>
			<p> x2: <input type="text" name="w" onchange="CanvasState.prototype.update()"/> y2:<input type="text" name="h" onchange="CanvasState.prototype.update()" /> </p>
			<p>Nom du Masque: <input type="text" name="nom_masque" /></p>
			
		</form>
		<button>Créer le masque</button>
	</div>
    <div style="font-family: Verdana; font-size: 12px;">
      <p>Cliquer pour sélectionner. Cliquer sur les poignées de sélection pour ajuster la taille. Double cliquer pour créer un nouveau champ. Appuyer sur la touche "suppr" pour supprimer un champ<br/>Appuyer sur Entrée après une modification pour l'appliquer</p>
    </div>
  </body>
</html>






<font>ID: <input type=\"text\" name=\"id\" onchange=\"CanvasState.prototype.update()\" onkeydown=\"testForEnter();\"/></font>