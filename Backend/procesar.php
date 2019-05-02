<?php 	
	class maximos{
		public $n = 0; //longitud vector
		public $m = 0; //cantidad consultas
		public $vector = array(); 
		public $Li = array(); //inicio subsegmentos i
		public $Ri = array(); //fin subsegmentos i
		public $error = 0;		
		public $respuesta = array();
		public $MAXIMO_M = 135000;
		public $MINIMO_NUMERO = -1000000000;
		public $MAXIMO_NUMERO = 1000000000;
		public $i = 0;//ubica cada consulta
		public $Li_set = false;
		public $Ri_set = false;

		function __construct($texto){
			$this->obtener_datos($texto);
		}

		public function primera_linea($numero){
			if ($this->n == 0) {
				if ($numero >= 1){
					$this->n = $numero;
				} else {
					$this->error = 5; //debe cumplirse que n>=1
				}				
			} elseif ($this->m == 0){
				if ($numero >= 1 and $numero <= $this->MAXIMO_M){
					$this->m = $numero;
				} else {
					$this->error = 6; //debe cumplirse que 1<=m<=135000
				}
			}else{
				$this->error = 1; //más de 2 números obtenidos en la primera línea
			}			
		}

		public function segunda_linea($numero){
			if ($indice_vector <= $this->n - 1){ //n - 1: indice ultimo elemento del vector
				if ($numero <= $this->MAXIMO_NUMERO and $numero >= $this->MINIMO_NUMERO){				
					array_push($this->vector, $numero);
					$indice_vector = $indice_vector + 1;
				} else {
					$this->error = 7; //se debe cumplir para todo elemento del vector que -10^9 <= ai <= 10^9
				}
			} else {
				$this->error = 4; //el tamaño del vector supera el valor n dado
			}	
		}

		public function lineas_restantes($numero){
			if ($this->m - 1 >= $this->i){ //m - 1: indice última consulta
				if (!$this->Li_set){
					array_push($this->Li, $numero);
					$this->Li_set = true;
				} elseif (!$this->Ri_set){
					array_push($this->Ri, $numero);
					$this->Ri_set = true;
					$this->i = $this->i + 1;
				} else {
					$this->error = 9; // se esperan sólo parejas de números a partir de la tercera línea.
				}
			} else {
				$this->error = 8; //la cantidad de consultas excede el valor m dado
			}		
		}

		public function obtener_datos($texto){
			$caracteres = str_split($texto);
			array_push($caracteres, " ");
			$numero_cadena = "";
			$numero = 0;
			$linea = 0;
			$indice_vector = 0;			
			$caracter = "";
			for ($j = 0; $j < count($caracteres) && $this->error == 0; $j++) {		
				$caracter = $caracteres[$j];		
				if (is_numeric($caracter)){
		    		$numero_cadena = $numero_cadena . $caracter;
		    	} elseif ($caracter == " " or $caracter == "\n"){	
		    		if ($numero_cadena != "") {
		    			$numero = (int)$numero_cadena;
		    			$numero_cadena = "";		    		
			    		if ($linea == 0){
			    			$this->primera_linea($numero);		    			
			    		} elseif ($linea == 1) {
			    			$this->segunda_linea($numero);
			    		} else {
							$this->lineas_restantes($numero);
			    		}
			    	} else {
		    			$this->error = 2; //se han encontrado 2 espacios seguidos
		    		}
		    		if ($caracter == "\n"){
			    		$linea = $linea + 1;
			    		$this->Li_set = false;
			    		$this->Ri_set = false;
			    	}
		    	} elseif ($caracter != "" and $caracter != "\r") {
		    		$this->error = 3; //caracter ilegal
		    	}		    	
			}
			if ($this->n == 0 or
			 	$this->m == 0 or 
			 	count($this->Li) != count($this->Ri) or 
			 	count($this->Li) != $this->m or 
			 	count($this->vector) != $this->n)
			{			
				$this->error = 10; //faltan datos en alguna línea
			}
		}

		public function resolver(){
			for ($i = 0; $i <= $this->m - 1; $i++){
				$suma = 0;
				for ($j = $this->Li[$i] - 1; $j <= $this->Ri[$i] - 1; $j++){
					for ($k = $j; $k <= $this->Ri[$i] - 1; $k++){
						$suma = $suma + max(array_slice($this->vector, $j, 1 + $k - $j));
					}						
				}
				array_push($this->respuesta, $suma);
			}
		}		
		public function get_errores(){
			return $this->traducir_error();
		}
		public function get_respuesta(){
			$this->resolver();
			return $this->respuesta;
		}
		public function traducir_error(){
			$error_traducido = "";
			if ($this->error == 1){
				$error_traducido = "Más de 2 números obtenidos en la primera fila";
			} elseif ($this->error == 2){
				$error_traducido = "Se esperaba un número";
			} elseif ($this->error == 3){
				$error_traducido = "Caracter no permitido";
			} elseif ($this->error == 4){
				$error_traducido = "El tamaño del vector supera el valor n dado";
			} elseif ($this->error == 5){
				$error_traducido = "Debe cumplirse que n>=1";
			} elseif ($this->error == 6){
				$error_traducido = "Se esperaba un número";
			} elseif ($this->error == 7){
				$error_traducido = "Se debe cumplir para todo elemento del vector que -10^9 <= ai <= 10^9";
			} elseif ($this->error == 8){
				$error_traducido = "La cantidad de consultas excede el valor m dado";
			} elseif ($this->error == 9){
				$error_traducido = "Se esperan sólo parejas de números a partir de la tercera línea";
			} elseif ($this->error == 10){
				$error_traducido = "Datos inconsistenes al formato planteado";
			}
			return $error_traducido;
		}
	}

	$datos_recibidos = $_POST;
	if (isset($datos_recibidos["procesar"])) { //si la solicitud viene de Frontend/index.php click en el botón procesar		
		$maximos1 = new maximos($datos_recibidos["texto"]);
		$errores = $maximos1->get_errores();
		$url = "../Frontend/respuesta.php?";
		if ($errores == ""){			
			$respuesta = $maximos1->get_respuesta();
			for ($indice = 0; $indice < count($respuesta); $indice++){
				$url = $url . $indice . "=" . $respuesta[$indice] . "&";
			}	
		} else {
			$url = $url . "0=-1&1=" . $errores; 
		}	
		header("location: " . $url);	
	} else {
		header("location: ../Frontend/index.php");
	}
?>