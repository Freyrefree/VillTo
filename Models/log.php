<?php 
	/**
	* modelo de tabla Proveedor --> Proveedor
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
    class Log 
    {

        //Tabla log
		private $id;
		private $folio;
		private $responsable;
		private $descripcion;
    	private $fecha;    
		private $identificador;
		
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
		
		
        public function registraLog(){
			$sql="INSERT INTO log (folio,responsable,descripcion,fecha)
						   VALUES ('{$this->folio}','{$this->responsable}','{$this->descripcion}',NOW());";
			return $this->cmd->Ejecuta($sql);
		}

		public function listarLog(){
			$sql="SELECT * FROM log WHERE folio='{$this->folio}'";
			return $this->cmd->Ejecuta($sql);
		}
	
	}
?>