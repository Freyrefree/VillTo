<?php 
	/**
	* modelo de tabla Cuenta --> Cuenta
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Cuenta {

		private $id;
		private $id_proveedor;		
    	private $num_cuenta; 
    	private $banco; 
		private $clabeInterbancaria;

		private $claveSAT;
		private $codigoSantander;
		private $divisa;

		private $sucursal;
		private $conveniocie;
		private $referenciacie1;
		private $referenciacie2;

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
		
		public function listarCuentas(){
			$sql="SELECT * FROM cuenta WHERE id_proveedor ='{$this->id}'";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function eliminaCuenta(){
			$sql = "DELETE FROM cuenta WHERE id = '{$this->id}'";
			$datos = $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function registraCuenta(){
			// $sql="INSERT INTO cuenta(id_proveedor,num_cuenta,banco,clabeInterbancaria) VALUES ('{$this->id_proveedor}','{$this->num_cuenta}','{$this->banco}','{$this->clabeInterbancaria}',);";
			
			$sql="INSERT INTO cuenta(id_proveedor,num_cuenta,banco,clabeInterbancaria,clave_sat,codigo_santander,divisa,sucursal,conveniocie,referenciacie1,referenciacie2) 
					VALUES ('{$this->id_proveedor}','{$this->num_cuenta}','{$this->banco}','{$this->clabeInterbancaria}','{$this->claveSAT}','{$this->codigoSantander}','{$this->divisa}','{$this->sucursal}','{$this->conveniocie}','{$this->referenciacie1}','{$this->referenciacie2}');";
			return $this->cmd->Ejecuta($sql);
		}

		public function obtieneClabeInterbancaria(){
			$sql="SELECT * FROM cuenta WHERE id ='{$this->id}'";
			$datos = $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);
			if($array){
				$this->num_cuenta = $array['num_cuenta'];
				$this->banco = $array['banco'];
				$this->clabeInterbancaria = $array['clabeInterbancaria'];
				$this->claveSAT = $array['clave_sat'];
				$this->codigoSantander = $array['codigo_santander'];

				$this->sucursal = $array['sucursal'];
				$this->conveniocie = $array['conveniocie'];
				$this->referenciacie1 = $array['referenciacie1'];
				$this->referenciacie2 = $array['referenciacie2'];
			}
		}
	}
 ?>