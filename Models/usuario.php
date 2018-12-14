<?php 
	/**
	* modelo de tabla usuario --> usuario
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Usuario {

		private $id;
		private $nombre;
		private $apellidop;
		private $apellidom;
		private $puesto;
		private $perfil;
		private $email;
		private $password;
		private $idarea;
		private $oficina;
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

		public function validaExistenciaUsuario(){
			$retorno = false;
			$sql = "SELECT u.*,a.ceco FROM usuario u
						INNER JOIN AREA a ON u.idarea = a.id
						WHERE u.correo='$this->email' AND u.contrasena='$this->password' AND u.activo='si'";
			$datos = $this->cmd->Ejecuta($sql);
			if(mysqli_num_rows($datos) > 0){
				$retorno = true;
			}else{
				$retorno = false;
			}
			return $retorno;
			
		}
		public function actulizaPSW(){
			$sql="UPDATE usuario SET 
			contrasena = '{$this->password}',
			estatusPass = 'si'
			 WHERE id = '{$this->id}' AND correo = '{$this->email}';";
			return $this->cmd->Ejecuta($sql);

		}
		
		public function listarUsuarios(){
			#$sql="SELECT * FROM usuario where activo='si'";#AND nombre <> 'Aiko'
			$sql="SELECT u.*,a.ceco,a.nombreArea FROM usuario AS u LEFT JOIN area AS a ON u.idarea=a.id WHERE u.activo='si' AND u.id <> '1'";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function listarGerentes(){

			#ejecutivo 3
			#supervisor 2
			#administrador 1
			#empleado 4
			$sql="SELECT * FROM usuario WHERE (perfil = '2' OR perfil = '1') AND activo='si' AND nombre <> 'Aiko'";
			//AND oficina = '{$this->oficina}'";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function listarGerentesOficina(){

			#ejecutivo 3
			#supervisor 2
			#administrador 1
			#empleado 4
			$sql="SELECT * FROM usuario WHERE (perfil = '2' OR perfil = '1') AND activo='si' AND nombre <> 'Aiko'
			AND oficina = '{$this->oficina}'";
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
		}

		public function obtenerOficina(){
			$sql = "SELECT oficina FROM usuario WHERE id = '{$this->id}'";
			$datos = $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);

			if($array){
				$this->oficina 	= $array['oficina'];
			}

		}

		public function registraUsuario(){
			$sql="INSERT INTO usuario(id,nombre,apellidoPaterno,apellidoMaterno,puesto,perfil,correo,contrasena,activo,idarea,oficina)
			VALUES ('$this->id','{$this->nombre}','{$this->app}','{$this->apm}','{$this->puesto}','{$this->perfil}',
			'{$this->correo}','{$this->password}','si','{$this->area}','{$this->oficina}')";
			return $this->cmd->Ejecuta($sql);
		}
		public function consultaUsuario(){
			$sql="SELECT * from usuario where id='{$this->id}'";
			$datos=$this->cmd->Ejecuta($sql);

			$array=mysqli_fetch_array($datos);
			if($array){
				$this->id 		= $array['id'];
				$this->nombre	= $array['nombre'];
				$this->app 		= $array['apellidoPaterno'];
				$this->apm 		= $array['apellidoMaterno'];
				$this->puesto 	= $array['puesto'];
				$this->correo 	= $array['correo'];
				$this->perfil 	= $array['perfil'];
				$this->idarea 	= $array['idarea'];
				$this->oficina 	= $array['oficina'];
			}
		}
		public function modificaUsuario(){
			if($this->password != ""){
				$sql="UPDATE usuario set 
						nombre='{$this->nombre}', 
						apellidoPaterno='{$this->app}', 
						apellidoMaterno='{$this->apm}',
						correo='{$this->correo}', 
						puesto='{$this->puesto}',
						perfil='{$this->perfil}',
						contrasena='{$this->password}',
						idarea='{$this->area}',
						oficina ='{$this->oficina}'
				where id='{$this->id}' ";
			}else{
				$sql="UPDATE usuario set 
						nombre='{$this->nombre}', 
						apellidoPaterno='{$this->app}', 
						apellidoMaterno='{$this->apm}',
						correo='{$this->correo}', 
						puesto='{$this->puesto}',
						perfil='{$this->perfil}',
						idarea='{$this->area}',
						oficina ='{$this->oficina}'
				where id='{$this->id}' ";
			}
			return $this->cmd->Ejecuta($sql);
		}
		
		public function desactivaUsuario(){
			$sql="UPDATE usuario set activo='no' where id='{$this->id}'";
			return $this->cmd->Ejecuta($sql);
		}
		public function buscaCeco(){
			$sql="SELECT a.ceco FROM usuario AS u LEFT JOIN area AS a ON u.idarea=a.id WHERE u.id='{$this->id}'";
			$datos= $this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);
			if($array){
				$this->ceco = $array['ceco'];
			}

		}

		public function existenciaUsuario()
		{
			$retorno 	= false;
			$sql 		= "SELECT * FROM usuario WHERE id = '{$this->id}'";
			$datos=$this->cmd->Ejecuta($sql);
			if(mysqli_num_rows($datos) > 0){
				$retorno = false;//no se puede agregar
			}else{
				$retorno = true;//se puede agregar
			}
			return $retorno;
		}

		public function existenciaUsuarioUpdate(){
			$retorno 	= false;
			$sql 		= "SELECT * FROM usuario WHERE id = '{$this->id}'";
			$datos=$this->cmd->Ejecuta($sql);
			if(mysqli_num_rows($datos) > 0){
				$retorno = false;//no se puede agregar
			}else{
				$retorno = true;//se puede agregar
			}
			return $retorno;

		}

		public function usuarioContabilidad(){

			$sql = "SELECT * FROM usuario WHERE perfil = '5'";
			$datos=$this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);

			if($array){
				$this->nombre	= $array['nombre'];
				$this->app 		= $array['apellidoPaterno'];
				$this->apm 		= $array['apellidoMaterno'];
				$this->correoContabilidad 	= $array['correo'];
			}

		}

		public function usuarioTesoreria(){

			$sql = "SELECT * FROM usuario WHERE perfil = '6'";
			$datos=$this->cmd->Ejecuta($sql);
			$array=mysqli_fetch_array($datos);

			if($array){
				$this->nombre	= $array['nombre'];
				$this->app 		= $array['apellidoPaterno'];
				$this->apm 		= $array['apellidoMaterno'];
				$this->correoTesoreria 	= $array['correo'];
			}

		}

		public function listarOficinas(){
			$sql = "SELECT DISTINCT oficina FROM usuario WHERE oficina <> '' ";
			$datos = $this->cmd->Ejecuta($sql);
			return $datos;
		}


		public function getuserById(){
			$sql = "SELECT * FROM usuario WHERE id = '{$this->id}' ;";

			$datos = $this->cmd->Ejecuta($sql);

			$row=mysqli_fetch_array($datos);
		    
			$this->id			= utf8_encode($row['id']);
			$this->correo			= utf8_encode($row['correo']);
			$this->nombre			= utf8_encode($row['nombre']);
			$this->apellidoPaterno	= utf8_encode($row['apellidoPaterno']);
			$this->apellidoMaterno	= utf8_encode($row['apellidoMaterno']);
		}


	}
 ?>