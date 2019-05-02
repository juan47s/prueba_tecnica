<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Prueba técnica</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">	
</head>
<body>
	<div class="contenedor">
		<div class="entrada_de_datos">
			<form method="post" action="../Backend/procesar.php" id="formulario" name="formulario">

				<textarea form="formulario" class="caja" name="texto" id="texto"><?php 
					$datos_recibidos = $_GET;
					if (isset($datos_recibidos["ejemplo"])){
						echo "3 6
1 3 2
1 1
1 2
1 3
2 2
2 3
3 3";
					}
				?></textarea>
				<input type="submit" class="boton" name="procesar" value="Procesar" id="procesar">
			</form>
			<form method="get" action="index.php" id="formulario_ejemplo">
				<input type="submit" class="boton" name="ejemplo" id="ejemplo" value = "Ejemplo">
			</form>
		</div>		
	</div>
</body>
</html>