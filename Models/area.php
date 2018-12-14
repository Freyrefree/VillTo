<?php 
	/**
	* modelo de tabla area --> area
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Area {

		private $id;
		private $nombreArea;
		private $activo;

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
		
		public function listarAreas(){
			$sql="SELECT * FROM area where activo='si'";
			return $this->cmd->Ejecuta($sql);
		}

		public function registraArea(){
			$sql="INSERT INTO area(nombreArea,ceco,activo)
			VALUES ('{$this->nombreArea}','{$this->ceco}','si')";
			return $this->cmd->Ejecuta($sql);
		}

		public function consultaArea(){
			$sql="SELECT * from area where id='{$this->id}'";
			$datos=$this->cmd->Ejecuta($sql);

			$array=mysqli_fetch_array($datos);
			if($array){
				$this->id 			= $array['id'];
				$this->nombreArea   = $array['nombreArea'];
				$this->ceco 		= $array['ceco'];
			}
		}
		public function modificaArea(){
			$sql="UPDATE area set 
						nombreArea='{$this->nombreArea}',
						ceco='{$this->ceco}'
			where id='{$this->id}' ";

			return $this->cmd->Ejecuta($sql);
		}
		public function eliminaArea(){
			$sql="DELETE FROM AREA WHERE id='{$this->id}'";
			return $this->cmd->Ejecuta($sql);
		}
	}
 ?>