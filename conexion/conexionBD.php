<?php
	/**
	 * Clase encargada de realizar la conexión a la Base de Datos.
	 */
	class Conexion{


		private $host;
		private $baseDatos;
		private $usuario;
		private $contrasena;

		//Constructor
		//Cuando es llamado inicializa las variables, con los del archivo.
		public function __construct(){
			$db_cfg = require_once 'datos.php';
			$this->host=$db_cfg["host"];
			$this->baseDatos=$db_cfg["baseDatos"];
			$this->usuario=$db_cfg["usuario"];
			$this->contrasena=$db_cfg["contrasena"];
		}

		//Método que retorna la conexión a la Base de Datos.
		//return => conexion : Conexión a la base de datos.
		//return => null : Ocurrió algo durante la conexión.
		public function obtenerConexion(){
			try {
				$conexion = mysqli_connect($this->host,$this->usuario,$this->contrasena,$this->baseDatos);
				if ($conexion != null) {
					return $conexion;
				}else{
					return null;
				}
			} catch (Exception $e) {
				die("Error Conexión: ".$e);
			}
		}

		
	}

?>