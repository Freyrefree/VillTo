<?php 
	/**
	* modelo de tabla ceco --> ceco
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Ceco {

		private $id;
		private $ceco;

		public function __construct(){
			#default conecta con la base de datos
			$this->cmd = new Conexion();
		}

		public function set($atributo, $contenido){
			$this->$atributo = $contenido;
		}

		public function get($atributo){
			return $this->$atributo;
		}
		
		public function listarCecos(){
			$sql="SELECT * FROM ceco";
			return $this->cmd->Ejecuta($sql);
		}

		public function registraCecos(){
			$sql="INSERT INTO area(nombreArea,activo)
			VALUES ('{$this->nombreArea}','si')";
			return $this->cmd->Ejecuta($sql);
		}

		public function consultaCecos(){
			$sql="SELECT * from area where id='{$this->id}'";
			$datos=$this->cmd->Ejecuta($sql);

			$array=mysqli_fetch_array($datos);
			if($array){
				$this->id 			= $array['id'];
				$this->nombreArea   = $array['nombreArea'];
			}
		}
		public function modificaCecos(){
			$sql="UPDATE area set 
						nombreArea='{$this->nombreArea}'
			where id='{$this->id}' ";

			return $this->cmd->Ejecuta($sql);
		}
	}
 ?>