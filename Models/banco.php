<?php 
	/**
	* modelo de tabla banco --> banco
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Banco {
		private $id;
        private $banco;
        private $claveSantander;
        private $claveSat;

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
		
		public function listarBancos(){
			$sql="SELECT * FROM banco";
			return $this->cmd->Ejecuta($sql);
        }
        public function datosBanco(){
			$sql="SELECT * FROM banco WHERE banco = '{$this->banco}'";
            $datos = $this->cmd->Ejecuta($sql);
            $array=mysqli_fetch_array($datos);
			if($array){
				$this->claveSantander = $array['claveSantander'];
				$this->claveSat = $array['claveSat'];
			}
		}
	}
 ?>