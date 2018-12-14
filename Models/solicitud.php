<?php 
	/**
	* modelo de tabla solicitud --> solicitud
	*/
	include_once '../app/config.php'; #Configuracion
	include_once str_replace(DS,"/",ROOT.'app/Conexion.php');#inclusion de archivo
	class Solicitud {

        private $clave = 0;
        private $fecha;
        private $idproveedor;
        private $numproveedor;
        private $proveedor;
        private $cecos;
        private $localizador;
        private $concepto;
        private $monto;
        private $moneda;
        private $tipocambio;
        private $montoletra;
        private $fechalimite;
        private $facturas;
        private $importancia;
        private $idUsuario;
        private $formapago;
        private $motivo;
        private $nocomprobantes;

        private $tipoSolicitud;
		

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
		
        public function listarSolicitudes(){
            $sql="SELECT s.*,u.nombre, u.apellidoPaterno,u.oficina FROM solicitud AS s LEFT JOIN usuario AS u ON s.idusuario=u.id
            {$this->complemento} ORDER BY s.id DESC";
            #$sql="SELECT * FROM solicitud ORDER BY id DESC "; #Validaciones seccionar listado
            //$sql="SELECT s.*,u.nombre, u.apellidoPaterno,u.oficina FROM solicitud AS s INNER JOIN usuario AS u ON s.idusuario=u.id ORDER BY s.id DESC";
            // $sql="SELECT s.*,u.nombre, u.apellidoPaterno,e.razonSocial 
            //       FROM solicitud AS s 
            //       LEFT JOIN usuario AS u ON s.idusuario=u.id 
            //       INNER JOIN empresa e ON s.empresa = e.rfc {$this->complemento} ORDER BY s.id DESC";
            // WHERE u.id='{$this->id}'
			$datos= $this->cmd->Ejecuta($sql);
            return $datos;
            //return $sql;
        }

        public function filtarSolicitudes(){
            $sql="SELECT s.*,u.nombre, u.apellidoPaterno,e.razonSocial 
            FROM solicitud AS s 
            LEFT JOIN usuario AS u ON s.idusuario=u.id 
            INNER JOIN empresa e ON s.empresa = e.rfc 
            WHERE s.id LIKE '%{$this->cadena}%' OR
            u.nombre LIKE '%{$this->cadena}%' OR
            u.nombre LIKE '%{$this->cadena}%' OR
            u.apellidoPaterno LIKE '%{$this->cadena}%' OR
            e.razonSocial LIKE '%{$this->cadena}%' OR
            s.empresa LIKE '%{$this->cadena}%' OR
            s.tipoSolicitud LIKE '%{$this->cadena}%' OR
            s.fechasolicitud LIKE '%{$this->cadena}%' OR
            s.numproveedor LIKE '%{$this->cadena}%' OR
            s.proveedor LIKE '%{$this->cadena}%' OR
            s.cecos LIKE '%{$this->cadena}%' OR
            s.localizador LIKE '%{$this->cadena}%' OR
            s.concepto LIKE '%{$this->cadena}%' OR
            s.monto LIKE '%{$this->cadena}%' OR
            s.moneda LIKE '%{$this->cadena}%' OR
            s.monedaPago LIKE '%{$this->cadena}%' OR
            s.conversionPago LIKE '%{$this->cadena}%' OR
            s.montoletra LIKE '%{$this->cadena}%' OR
            s.fechalimite LIKE '%{$this->cadena}%' OR
            s.fechaUrgente LIKE '%{$this->cadena}%' OR
            s.facturas LIKE '%{$this->cadena}%' OR
            s.importancia LIKE '%{$this->cadena}%' OR
            s.estatus LIKE '%{$this->cadena}%' OR
            s.formapago LIKE '%{$this->cadena}%' OR
            s.banco LIKE '%{$this->cadena}%' OR
            s.aba LIKE '%{$this->cadena}%' OR
            s.swift LIKE '%{$this->cadena}%'
            ORDER BY s.id ASC";

            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }

        public function buscarSolicitud(){
                #$sql="SELECT * FROM solicitud ORDER BY id DESC "; #Validaciones seccionar listado
                $sql="SELECT s.*,u.nombre, u.apellidoPaterno, u.correo 
                      FROM solicitud AS s LEFT JOIN usuario AS u ON s.idusuario=u.id WHERE s.id='{$this->id}' ORDER BY s.id DESC";
                $datos= $this->cmd->Ejecuta($sql);
                return $datos;
        }
        public function actualizaEstatus(){
            $sql = "UPDATE solicitud SET estatus = '{$this->estatus}' WHERE id='{$this->id}'";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }

        public function registraReembolso(){
            $sql = "UPDATE solicitud SET estatus = '{$this->estatus}',motivoReembolso = '{$this->motivo}' WHERE id='{$this->id}'";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }

        function registraFacturas(){
            $sql = "UPDATE solicitud SET facturas = '{$this->facturas}' WHERE id='{$this->id}'";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;

        }

        function registraComprobantes(){
            $sql = "UPDATE solicitud SET estatus = '{$this->estatus}',nocomprobantes = '{$this->nocomprobantes}' WHERE id='{$this->id}'";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;

        }

        function registraTXT(){
            $sql = "UPDATE solicitud SET txt = '{$this->nomTXT}' WHERE id='{$this->id}'";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;

        }

        public function rechazarSolicitud(){
            $sql = "UPDATE solicitud SET estatus = '{$this->estatus}',motivoRechazo = '{$this->motivoRechazo}' WHERE id='{$this->id}'";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }

		public function registraSolicitud(){
			$sql="INSERT INTO solicitud 
                            (clave,
                            tipoSolicitud, 
                            fechasolicitud,
                            idproveedor, 
                            numproveedor, 
                            proveedor, 
                            cecos, 
                            localizador, 
                            concepto, 
                            monto, 
                            moneda, 
                            tipocambio,
                            monedaPago,
                            conversionPago,
                            montoletra, 
                            fechalimite, 
                            facturas, 
                            importancia,
                            estatus,
                            idusuario,
                            formapago,
                            banco,
                            cuentaBanco,
                            referencia1,
                            clabeinter,
                            aba,
                            swift
                            )
                            VALUES
                            ('{$this->clave}',
                            '{$this->tipoSolicitud}', 
                            '{$this->fecha}',
                            '{$this->idproveedor}', 
                            '{$this->numproveedor}', 
                            '{$this->proveedor}', 
                            '{$this->cecos}', 
                            '{$this->localizador}', 
                            '{$this->concepto}', 
                            '{$this->monto}', 
                            '{$this->moneda}', 
                            '{$this->tipocambio}', 
                            '{$this->monedaPago}',
                            '{$this->conversionPago}',
                            '{$this->montoletra}', 
                            '{$this->fechalimite}', 
                            '{$this->facturas}', 
                            '{$this->importancia}',
                            'pendiente',
                            '{$this->idUsuario}',
                            '{$this->formapago}',
                            '{$this->banco}',
                            '{$this->cuentaBanco}',
                            '{$this->referencia}',
                            '{$this->clabeinter}',
                            '{$this->aba}',
                            '{$this->swift}'
                            );
                        ";
                    //echo $sql;
            return $this->cmd->EjecutaId($sql);
        }

        public function detalleFolioSolicitud(){
            // ,e.razonSocial 
            $sql="SELECT s.*,u.id AS idu,u.nombre, u.apellidoPaterno
            FROM solicitud AS s 
            INNER JOIN usuario AS u ON
            s.idusuario=u.id AND s.id = '{$this->id}'";            
            // INNER JOIN empresa e ON s.empresa = e.rfc
			$datos= $this->cmd->Ejecuta($sql);
			return $datos;
        }

        public function filtrarSolicitudesFechas()
        {
            $sql = "SELECT s.*,u.nombre, u.apellidoPaterno,u.oficina FROM
            solicitud AS s LEFT JOIN usuario AS u ON s.idusuario=u.id
            {$this->complemento} 
             s.fechasolicitud BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}'
             ORDER BY s.id DESC";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }
        public function filtrarSolicitudesFechasEstatus()
        {
            $sql = "SELECT s.*,u.nombre, u.apellidoPaterno,u.oficina FROM
            solicitud AS s LEFT JOIN usuario AS u ON s.idusuario=u.id 
            {$this->complemento}
            s.fechasolicitud BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}' 
            AND estatus = '{$this->estatus}'
            ORDER BY s.id DESC";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }

        public function filtrarSolicitudesFechaslim()
        {
            $sql = "SELECT s.*,u.nombre, u.apellidoPaterno,u.oficina FROM
            solicitud AS s LEFT JOIN usuario AS u ON s.idusuario=u.id
            {$this->complemento} 
             s.fechalimite BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}'
             ORDER BY s.id DESC";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }
        public function filtrarSolicitudesFechasEstatuslim()
        {
            $sql = "SELECT s.*,u.nombre, u.apellidoPaterno,u.oficina FROM
            solicitud AS s LEFT JOIN usuario AS u ON s.idusuario=u.id 
            {$this->complemento}
            s.fechalimite BETWEEN '{$this->fecha_inicio}' AND '{$this->fecha_fin}' 
            AND estatus = '{$this->estatus}'
            ORDER BY s.id DESC";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }

        public function filtrarSolicitudesEstatus()
        {
            $sql = "SELECT s.*,u.nombre, u.apellidoPaterno,u.oficina FROM
            solicitud AS s LEFT JOIN usuario AS u ON s.idusuario=u.id
            {$this->complemento} 
            estatus = '{$this->estatus}'
            ORDER BY s.id DESC";
            $datos= $this->cmd->Ejecuta($sql);
            return $datos;
        }

        public function validarExistente(){
            $sql = "SELECT * FROM solicitud WHERE id = '{$this->id}' ";
            $datos= $this->cmd->Ejecuta($sql);

            if(mysqli_num_rows($datos) > 0){

                return true;

            }else{

                return false;

            }
            
        }
	}
 ?>