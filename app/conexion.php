<?php

	#datos de conexion a base de datos
	#Ejecucion de consultas directamente a base de datos

	class Conexion{

		// private $cadena = "Driver={SQL Server};Server=SERVISAACK;Database=juliaTravel;Integrated Security=SSPI;Persist Security Info=False;";
		// private $usuario = "sa";
		// private $clave = "N0L0$3*3050";

		// private $cadena = "Driver={SQL Server};Server=192.168.0.11\SQLEXPRESS;Database=JuliaTravelPagos;Integrated Security=SSPI;Persist Security Info=False;";
		// private $usuario = "sa";
		// private $clave = "aiko**19";

		// private $cadena = "Driver={SQL Server};Server=LENOVO-PC\SQLEXPRESS;Database=JuliaTravelPagos;Integrated Security=SSPI;Persist Security Info=False;";
		// private $usuario = "";
		// private $clave = "";

		private $cadena = "localhost";
		private $usuario = "root";
		private $clave = "";
		private $database = "villatourspagos";
		private $conexion;

		public function __construct(){
			#Inicia la conexion de la base de datos
			$this->conexion = mysqli_connect($this->cadena, $this->usuario, $this->clave, $this->database); #mysql
			// $this->conexion = odbc_connect($this->cadena, $this->usuario, $this->clave); #SQL
			#Inicia la conexion de la base de datos
		}

		public function Ejecuta($query){
			#Ejecucion query en base de datos
			return mysqli_query($this->conexion,$query); #mysql
			// $answer = odbc_exec($this->conexion,$query); #SQL
			#Ejecucion query en base de datos
		}

		public function EjecutaId($query){ // Este metodo devuelve el id de la conslta que se realizo
			mysqli_query($this->conexion,$query);

			$dato = mysqli_query($this->conexion,"SELECT @@identity AS id");
			// mysqli_query($this->conecta, $sql);
			// $dato = mysqli_query($this->conecta, "SELECT @@identity AS id");
			if ($row = mysqli_fetch_row($dato)){
				$id = trim($row[0]);
			}
			return $id;
		}

		public function __destruct(){
			#Termina la conexion de la base de datos
			//mysqli_close($this->conexion); #mysql
			// odbc_close($this->conexion); #SQL
			#Termina la conexion de la base de datos
		}
	}

?>