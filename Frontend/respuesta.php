<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Respuesta</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">	
</head>
<body>
	<div class="contenedor">
		<div class="entrada_de_datos">
			<form action="index.php" id="formulario" name="formulario">
				<?php					
					$datos_recibidos = $_GET;
					$respuesta = "";
					if (!isset($datos_recibidos[0])){
						header("location: index.php");
					} elseif ((int)$datos_recibidos[0] == -1){
						$respuesta = "Error:".$datos_recibidos[1];
					} else {
						foreach ($datos_recibidos as $valor){
							$respuesta = $respuesta . $valor . "\n";
						}
					}				
					echo "<textarea disabled class='caja'>".$respuesta."</textarea>";
				?>
				<input type="submit" class="boton" name="atras" value="Atras" id="atras">
			</form>
		</div>		
	</div>
</body>
</html>

