<?php 
	/**
	* modelo de tabla Proveedor --> Proveedor
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Proveedor {

		private $id;
		private $numproveedor;		
    	private $rfc; 
    	private $razonsocial;		
		private $direccion; 	
		private $cp; #cp
		private $aliascomercial;
		private $email; 
		private $contacto; 
		private $tel1;
		private $tel2;
		private $comunidad;
		private $pais; 		
		private $filecaratula; 
		private $filecedula;
		private $aba;
		private $swift;		
		private $activo;
		private $tipo;
		//////TABLA PAIS
		private $c_pais;
		private $nombre_pais;

		private $cadena;
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
		
		public function listarProveedores(){
			$sql="SELECT * FROM proveedor WHERE activo <>'no' ORDER BY activo ASC";
			// WHERE activo ='si'
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function listarProveedoresAuto(){
			$sql="SELECT * FROM proveedor WHERE activo <>'no' ORDER BY activo ASC";
			// AND tipo IN ({$this->tipo})
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function filtraProveedor(){
			$sql="SELECT * FROM proveedor WHERE activo <>'no' AND (numproveedor LIKE '%{$this->cadena}%' OR razon_social LIKE '%{$this->cadena}%' OR alias_comercial LIKE '%{$this->cadena}%') ORDER BY activo ASC";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function filtraProveedorTipo(){
			$sql="SELECT * FROM proveedor WHERE activo <>'no' AND tipo = '{$this->tipo}' ORDER BY activo ASC";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function registraProveedor(){
			$sql="INSERT INTO proveedor 
			(numproveedor,rfc_taskid,razon_social,direccion,cp,alias_comercial,correo, 
			contacto,tel,tel2,comunidad,pais,archivo_caratula,archivo_cedula,aba,swift,activo,tipo)
			VALUES
			('{$this->numproveedor}','{$this->rfc}','{$this->razonsocial}','{$this->direccion}','{$this->cp}',
			'{$this->aliascomercial}','{$this->email}','{$this->contacto}',
			'{$this->tel1}','{$this->tel2}','{$this->comunidad}','{$this->pais}','{$this->filecaratula}','{$this->filecedula}',
			'{$this->aba}','{$this->swift}','{$this->activo}','{$this->tipo}');";
			//return $this->cmd->Ejecuta($sql);
			return $this->cmd-> EjecutaId($sql);
		}
		public function consultaProveedor(){
			$sql="SELECT * from proveedor where id='{$this->id}'";
			$datos=$this->cmd->Ejecuta($sql);

			$array=mysqli_fetch_array($datos);
			if($array){
				$this->id 				= $array['id'];
				$this->numproveedor		= $array['numproveedor'];
				$this->rfc				= $array['rfc_taskid'];
				$this->razonsocial 		= $array['razon_social'];				
				$this->direccion 		= $array['direccion'];				
				$this->cp 		 		= $array['cp'];#nuevo
				$this->aliascomercial 	= $array['alias_comercial'];
				$this->email 			= $array['correo'];
				$this->contacto 		= $array['contacto'];
				$this->tel1 			= $array['tel'];
				$this->tel2 			= $array['tel2'];
				$this->comunidad 		= $array['comunidad'];
				$this->pais 			= $array['pais'];				
				$this->filecaratula 	= $array['archivo_caratula'];
				$this->filecedula		= $array['archivo_cedula'];
				$this->aba 				= $array['aba'];	
				$this->swift 			= $array['swift'];	
				$this->tipo    			= $array['tipo'];
				
			}
		}
		public function modificaProveedor(){
			$sql="UPDATE proveedor set 
						numproveedor='', 
						rfc_taskid='{$this->rfc}', 
						razon_social='{$this->razonsocial}',						 
						direccion='{$this->direccion}',						
						cp='{$this->cp}',
						alias_comercial='{$this->aliascomercial}', 
						correo='{$this->email}', 
						contacto='{$this->contacto}',  
						tel='{$this->tel1}',
						tel2='{$this->tel2}',
						comunidad='{$this->comunidad}',
						pais='{$this->pais}',
						archivo_caratula='{$this->filecaratula}', 
						archivo_cedula='{$this->filecedula}',
						aba='{$this->aba}',
						swift='{$this->swift}',
						activo='{$this->activo}',
						tipo='{$this->tipo}'
					where id='{$this->id}' ";

			return $this->cmd->Ejecuta($sql);
		}
		public function desactivaProveedor(){
			$sql="UPDATE proveedor set activo='no' where id='{$this->id}'";
			// $sql="DELETE FROM proveedor where id='{$this->id}'";
			return $this->cmd->Ejecuta($sql);
		}

		public function comboPais(){
			$sql="SELECT * FROM pais";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function consultaNombrePais(){
			$sql="SELECT * FROM pais WHERE c_pais = '{$this->c_pais}'";			
			$datos=$this->cmd->Ejecuta($sql);

			$array=mysqli_fetch_array($datos);
			if($array){				
				$this->nombre_pais = $array['nombre'];
			}
		}
		public function nuevosProveedores(){
			$sql="SELECT * FROM proveedor WHERE activo = 're' ORDER BY activo ASC";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function consultaIdProveedor(){
			$sql = "SELECT id FROM proveedor WHERE numproveedor = '{$this->numproveedor}'";
			$datos=$this->cmd->Ejecuta($sql);
		 
			$array=mysqli_fetch_array($datos);
			if($array){    
			 $this->idProveedor = $array['id'];
			}
		 
		}

		public function updateArchivos(){
			$sql="UPDATE proveedor SET archivo_caratula = '{$this->filecaratula}', archivo_cedula = '{$this->filecedula}' WHERE id ='{$this->id}'";
			// $sql="DELETE FROM proveedor where id='{$this->id}'";
			return $this->cmd->Ejecuta($sql);
		}

		public function verificaProveedor(){

			$sql="SELECT * FROM proveedor WHERE numproveedor = '{$this->numproveedor}'";			
			$datos=$this->cmd->Ejecuta($sql);
            if (mysqli_num_rows($datos) > 0) {
                return false;//Ya existe proveedor con ese numero de proveeedor
            }else{
				return true;//No existe proveedor con ese numero de proveeedor
			}

		}

		public function rfcExistente(){
			$sql = "SELECT * FROM proveedor WHERE rfc_taskid = '{$this->rfc}'";
			$datos=$this->cmd->Ejecuta($sql);

			if (mysqli_num_rows($datos) > 0) {
                return false;//Ya existe proveedor con ese RFC
            }else{
				return true;//No existe proveedor con ese RFC
			}

		}

		public function razonSocialExistente(){
			$sql = "SELECT * FROM proveedor WHERE razon_social = '{$this->razonsocial}'";
			$datos=$this->cmd->Ejecuta($sql);

			if (mysqli_num_rows($datos) > 0) {
                return false;//Ya existe proveedor con ese RFC
            }else{
				return true;//No existe proveedor con ese RFC
			}

		}



	}
 ?>