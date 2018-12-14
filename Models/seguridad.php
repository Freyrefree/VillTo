<?php 
	/**
	* modelo de tabla usuario --> usuario [seguridad de acceso]
	*/
	include_once 'app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Usuario {

		private $id;
		private $nombre;
		private $apellidop;
		private $apellidom;
		private $email;
		private $password;
		private $perfil;
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
		
		public function validaExistencia(){
			// $sql = "SELECT * FROM usuario 
			// 		WHERE correo='$this->email' AND contrasena='$this->password' AND activo='si'";
			$sql = "SELECT u.*,a.ceco FROM usuario u
						INNER JOIN AREA a ON u.idarea = a.id
						WHERE u.correo='$this->email' AND u.contrasena='$this->password' AND u.activo='si'";
			$datos = $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);

			if ($array){
				
				$this->id        = $array['id'];
				$this->nombre    = $array['nombre'];
				$this->apellidop = $array['apellidoPaterno'];
				$this->apellidom = $array['apellidoMaterno'];
				$this->perfil    = $array['perfil'];
				$this->estatus 	 = $array['estatusPass'];
				$this->ceco 	 = $array['ceco'];
			}
		}
	}
 ?>