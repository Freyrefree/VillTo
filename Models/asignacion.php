<?php 
	/**
	* modelo de tabla asignacion --> asignacion
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Asignacion {

		private $id;
		private $idusuario;
        private $idgerente;
		private $nombreGerente;
		private $tipo;

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
		
		public function listarAsignacion(){
			$sql="SELECT * FROM asignacion WHERE idusuario='{$this->idusuario}'";
			return $this->cmd->Ejecuta($sql);
		}
		
		public function listarAsignacionGerente(){
			$sql="SELECT * FROM asignacion WHERE idgerente='{$this->idgerente}'";
			return $this->cmd->Ejecuta($sql);

		}


		public function listarCorreosAsignacion(){
			$sql="SELECT a.nombreGerente,u.correo,a.idgerente AS idg FROM asignacion a INNER JOIN usuario u ON a.idgerente = u.id WHERE a.idusuario='{$this->idusuario}'";
			return $this->cmd->Ejecuta($sql);
		}
		
		public function listarAsignados(){
			$sql="SELECT idusuario FROM asignacion WHERE idgerente='{$this->idusuario}'";
			return $this->cmd->Ejecuta($sql);
		}
		
        public function asignarGerente(){
			$sql="INSERT INTO asignacion
			(idusuario,
			idgerente,
			nombreGerente,
			tipo) 
            VALUES ('{$this->idusuario}',
			'{$this->idgerente}',
			'{$this->nombreGerente}',
			'{$this->tipo}')";
			return $this->cmd->Ejecuta($sql);
        }
        public function eliminaAsignacion(){
			$sql="DELETE FROM asignacion WHERE id='{$this->id}'";
			return $this->cmd->Ejecuta($sql);
		}
		public function buscarGerente(){
			$sql="SELECT idusuario FROM asignacion WHERE idgerente='{$this->idgerente}' AND idusuario='{$this->idusuario}'";
			$datos = $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);
			if($array){
				return true;
			}else{
				return false;
			}
		}

		public function reasignarGerente(){
			$sql="UPDATE asignacion SET
			idgerente = '{$this->idgerente}',
			nombreGerente = '{$this->nombreGerente}'
			WHERE id = '{$this->id}'";
			return $this->cmd->Ejecuta($sql);
		}
		
		public function consultaTipoSolicitud(){
			$sql = "SELECT * FROM asignacion WHERE idusuario = '{$this->idusuario}'";
			return $this->cmd->Ejecuta($sql);
		}

		public function consultaGerentes(){
			$sql = "SELECT * FROM asignacion WHERE idusuario = '{$this->idusuario}' AND tipo = '{$this->tipo}';";
			return $this->cmd->Ejecuta($sql);
		}

		public function nombreGerente(){
			$sql = "SELECT CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) AS nombreGerente FROM usuario WHERE id = '{$this->idGerente}'";
			$datos = $this->cmd->Ejecuta($sql);
			if(mysqli_num_rows($datos)>0){
				$dato = mysqli_fetch_array($datos);

				$this->nombreGerente = $dato['nombreGerente'];
			}
		}

		public function verificaAsignacion(){
			$sql = "SELECT * FROM asignacion WHERE idusuario = '{$this->idusuario}' AND idgerente = '{$this->idgerente}' AND tipo = '{$this->tipo}'";
			$datos = $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function getByIdAsignacionGerente(){

			$sql= "SELECT 
			a.idgerente,
			u.correo,
			u.nombre,
			u.apellidoPaterno,
			u.apellidoMaterno 
			FROM asignacion a
			INNER JOIN usuario u ON a.idgerente = u.id
			WHERE a.id = '{$this->id}'; ";


			$datos = $this->cmd->Ejecuta($sql);

			$row=mysqli_fetch_array($datos);
		    
			$this->idgerente		= utf8_encode($row['idgerente']);
			$this->correo			= utf8_encode($row['correo']);
			$this->nombre			= utf8_encode($row['nombre']);
			$this->apellidoPaterno	= utf8_encode($row['apellidoPaterno']);
			$this->apellidoMaterno	= utf8_encode($row['apellidoMaterno']);
		}


		public function getByIdAsignacionConsultor(){

			$sql= "SELECT 
			a.idusuario,
			u.correo,
			u.nombre,
			u.apellidoPaterno,
			u.apellidoMaterno 
			FROM asignacion a
			INNER JOIN usuario u ON a.idusuario = u.id
			WHERE a.id = '{$this->id}'; ";


			$datos = $this->cmd->Ejecuta($sql);

			$row=mysqli_fetch_array($datos);
		    
			$this->idusuario		= utf8_encode($row['idusuario']);
			$this->correo			= utf8_encode($row['correo']);
			$this->nombre			= utf8_encode($row['nombre']);
			$this->apellidoPaterno	= utf8_encode($row['apellidoPaterno']);
			$this->apellidoMaterno	= utf8_encode($row['apellidoMaterno']);
		}



	}
 ?>