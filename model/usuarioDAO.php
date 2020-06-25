<?php

setlocale(LC_TIME, 'es_MX.UTF-8');
date_default_timezone_set ('America/Mexico_city');
//echo 'Fecha actual: '.strftime("%Y-%m-%d %X").'<br/>';

require_once '../conexion/conexionBD.php';
require_once 'encryptDAO.php';
require_once 'cantidadLetra.php';

require_once '../assets/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

class UsuarioDAO{

	private $con;
	private $query;

	public function __construct(){
		try {
			$this->abrirConexion();
		} catch (Exception $e) {
			die('Error UsuarioDAO '.$e);
		}
	}

	public function abrirConexion(){
		$conexionDAO = new Conexion();
		$conexion = $conexionDAO->obtenerConexion();
		$this->con=$conexion;
	}

	public function cerrarSesion(){
		session_start();
		unset($_SESSION['idEmpresa']);
		unset($_SESSION['roleUsuario']);
		session_destroy();
	}

	



	// Consultar el usuario, para realizar login.
	public function login($valores){
		//Cifrar la contraseña.
		$enc = new EncryptDao();
		$contrasenaEncrypt = $enc->encrypt_decrypt('encrypt', $valores['contrasena']);
		//Llamar el store procedure.
		//echo $contrasenaEncrypt.'_______'.$valores['contrasena'];
		$resultado = $this->con->prepare("CALL login(?,?,@idEmpresa,@roleUsuario)");
  		//Se cambian los '?', por los valores que recibirá el store procedure
		$resultado->bind_param('ss', $valores['email'],$contrasenaEncrypt);

		//Se executa el store procedure.
		$resultado->execute();

		//Se crea el query para obtener los resultados que retorna
		//el store procedure
		$queryOut = "SELECT @idEmpresa AS idEmpresa, @roleUsuario AS roleUsuario";

		//Executar el query.
		$resuladoProcedure = $this->con->query($queryOut);

		//Se obtienen los resultados en formato de array.
		$resultadoView = $resuladoProcedure->fetch_assoc();

		//Se cierra la conexión a la base de datos.
		$this->con->close();
		//var_dump($resultadoView);

		if ( ($resultadoView['idEmpresa'] != null) || ($resultadoView['idEmpresa'] != 0) ) {
			$idEncrypt = $enc->encrypt_decrypt('encrypt', $resultadoView['idEmpresa']);
			session_start();
			$_SESSION["idEmpresa"] = $idEncrypt;
			$_SESSION["roleUsuario"] = $resultadoView['roleUsuario'];
			return json_encode(array('resultado' => $resultadoView['roleUsuario']), JSON_PRETTY_PRINT);
		}else{
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Consultar las ventas recientes que ha realizado la empresa
	public function ventasRecientesXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL ventasRecientesXEmpresa(?);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$resultadoVista = $resultado->get_result();
			$ventas = array();
			while ($row = $resultadoVista->fetch_assoc()) {
				$row['total'] = '$'.number_format($row['total'],2);
				$ventas[] = $row;
			}
			$this->con->close();
			return $ventas;
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Consultar las ventas recientes que ha realizado la empresa
	public function ventasPendientesXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL ventasPendientesXEmpresa(?);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$resultadoVista = $resultado->get_result();
			$ventas = array();
			while ($row = $resultadoVista->fetch_assoc()) {
				$row['ventaId'] = $enc->encrypt_decrypt('encrypt', $row['ventaId']);
				$row['total'] = '$'.number_format($row['total'],2);
				$row['pagado'] = '$'.number_format($row['pagado'],2);								
				$ventas[] = $row;
			}
			$this->con->close();
			return $ventas;
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Contar las ventas pendientes que tiene la empresa
	public function contarVentasPendientesXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL contarVentasPendientesXEmpresa(?,@totalVentasPendientes);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @totalVentasPendientes AS totalVentasPendientes";
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			return json_encode($resultadoVista['totalVentasPendientes'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Contar las ventas pagadas que ha realizado la empresa
	public function contarVentasPagadasXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL contarVentasPagadasXEmpresa(?,@totalVentasPagadas);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @totalVentasPagadas AS totalVentasPagadas";
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			return json_encode($resultadoVista['totalVentasPagadas'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}	

	//Contar los productos con los que cuenta la empresa
	public function contarProductosXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL contarProductosXEmpresa(?,@productosTotales);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @productosTotales AS productosTotales";
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			return json_encode($resultadoVista['productosTotales'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}	

	//Contar las ventas totales con los que cuenta la empresa
	public function contarVentasTotalesXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL contarVentasTotalesXEmpresa(?,@totalVentas);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @totalVentas AS totalVentas";
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			return json_encode($resultadoVista['totalVentas'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}	

	//Consultar los productos de la empresa.
	public function verProductoXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL verProductoXEmpresa(?);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$resultadoVista = $resultado->get_result();
			$productos = array();
			while ($row = $resultadoVista->fetch_assoc()) {
				$row['id'] = $enc->encrypt_decrypt('encrypt', $row['id']);		
				$row['precioNeto'] = '$'.number_format($row['precioNeto'],2);
				$productos[] = $row;
			}
			$this->con->close();
			return $productos;
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Consultar todas las ventas de la empresa.
	public function ventasXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL ventasXEmpresa(?);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$resultadoVista = $resultado->get_result();
			$productos = array();
			while ($row = $resultadoVista->fetch_assoc()) {
				$row['ventaId'] = $enc->encrypt_decrypt('encrypt', $row['ventaId']);	
				$row['total'] = '$'.number_format($row['total'],2);
				$productos[] = $row;
			}
			$this->con->close();
			return $productos;
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}	

	//Consultar todas las ventas PAGADAS de la empresa.
	public function verVentasPagadasXEmpresa(){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL verVentasPagadasXEmpresa(?);");
			$resultado->bind_param('d', $idEmpresaDecrypt);
			$resultado->execute();
			$resultadoVista = $resultado->get_result();
			$ventas = array();
			while ($row = $resultadoVista->fetch_assoc()) {
				$row['ventaId'] = $enc->encrypt_decrypt('encrypt', $row['ventaId']);		
				$row['total'] = '$'.number_format($row['total'],2);
				$ventas[] = $row;
			}
			$this->con->close();
			return $ventas;
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}	

	//Agregar el producto dependiendo la empresa en la sesión
	public function agregarProductoXEmpresa($producto){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL agregarProducto(?,?,?,@result);");
			$precio = bcdiv($producto['precio'], '1', 2);
			$nombre = mb_strtoupper($producto['nombre'],'UTF-8');
			$resultado->bind_param('sdd', $nombre ,$precio , $idEmpresaDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @result AS resultado";			
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			return json_encode($resultadoVista['resultado'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Eliminar producto PENDIENTE
	public function eliminarProducto($idProducto){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idProductoDecrypt = $enc->encrypt_decrypt('decrypt', $idProducto);
			$resultado = $this->con->prepare("CALL eliminarProducto(?,@result);");
			$resultado->bind_param('d',$idProductoDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @result AS resultado";	
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			return json_encode($resultadoVista['resultado'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}
	
	//Agregar venta, VentaDetalle, Calcular Folio
	public function agregarVenta($venta){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$nombreClienteV = mb_strtoupper($venta['cliente'],'UTF-8');
			$cantidadV = $venta['cantidad'];//ya
			//Total de la venta, suma de todos los productos
			$totalV = $venta['total'];//ya
			//Total de la venta, suma de todos los productos EN LETRA
			$totalLetraV = cambiarCantidadALetra($totalV);			
			//RESTO de la venta a pagar    total - pagado
			$pagadoV = $venta['pagado'];//ya
			$estadoDeudaV = 'Pendiente';			
			if ($pagadoV == $totalV ) {
				$estadoDeudaV = 'Pagada';
				$pagadoV = $totalV;
			}
			//determinar cuanto falta por pagar del pago
			$restoPagoV = ($totalV - $pagadoV);
			//emailCliente
			$emailCliente = mb_strtoupper($venta['email'],'UTF-8');
			$Producto_idV = $enc->encrypt_decrypt('decrypt', $venta['idProducto']);//ya
			$idEmpresaV = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);//ya
			//orden: estadoDeudaV
			//abono que realizo el cliente a la venta
			$fechaV = strftime("%Y-%m-%d %X");
			//cantidad que el cliente abono a la venta
			//RECORDATORIO: Cambiar en algun futuro el nombre de este campo a uno más especifico.
			$totalPagadoV = $venta['pagado'];
			$resultado = $this->con->prepare("CALL agregarVentaNueva(?,?,?,?,?,?,?,?,?,?,?,?,@result);");
			$resultado->bind_param('ddsddsddssds',$Producto_idV,$idEmpresaV,$estadoDeudaV,$pagadoV,$restoPagoV,$totalLetraV,$totalV,$cantidadV,$nombreClienteV,$fechaV,$totalPagadoV,$emailCliente);
			$resultado->execute();
			$queryProcedure = "SELECT @result AS resultado";
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			if (is_numeric($resultadoVista['resultado'])) {
				$resultadoVista['resultado'] = $enc->encrypt_decrypt('encrypt', $resultadoVista['resultado']);
			}			
			return json_encode($resultadoVista['resultado'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Ver los abonos realizados a una venta en especifico
	public function verAbonosXVenta($idVenta){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idVentaDecrypt = $enc->encrypt_decrypt('decrypt', $idVenta);
			$resultado = $this->con->prepare("CALL verAbonosXVenta(?);");
			$resultado->bind_param('d', $idVentaDecrypt);
			$resultado->execute();
			$resultadoVista = $resultado->get_result();
			$ventas = array();
			while ($row = $resultadoVista->fetch_assoc()) {
				$row['ventaId'] = $enc->encrypt_decrypt('encrypt', $row['ventaId']);		
				$row['total'] = '$'.number_format($row['total'],2);
				$row['pagado'] = '$'.number_format($row['pagado'],2);
				$row['restoPago'] = '$'.number_format($row['restoPago'],2);
				$row['totalPagado'] = '$'.number_format($row['totalPagado'],2);
				$ventas[] = $row;
			}
			$this->con->close();
			return $ventas;
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	public function modificarProducto($idProducto,$nombre,$precio){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idProductoDecrypt = $enc->encrypt_decrypt('decrypt', $idProducto);
			$nombre = mb_strtoupper($nombre,'UTF-8');;//ya
			$precio = bcdiv($precio, '1', 2);
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$resultado = $this->con->prepare("CALL modificarProducto(?,?,?,?,@result);");
			$resultado->bind_param('dsdd',$idProductoDecrypt,$nombre,$precio,$idEmpresaDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @result AS resultado";
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			return json_encode($resultadoVista['resultado'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}

	//Agregar venta, VentaDetalle, Calcular Folio
	public function abonarMontoAVenta($idVenta,$montoAbonar){
		session_start();
		if (isset($_SESSION["idEmpresa"])) {
			$enc = new EncryptDao();
			$idVentaDecrypt = $enc->encrypt_decrypt('decrypt', $idVenta);
			$idEmpresaDecrypt = $enc->encrypt_decrypt('decrypt', $_SESSION["idEmpresa"]);
			$fechaV = strftime("%Y-%m-%d %X");
			$totalPagadoV = $montoAbonar;

			$resultado = $this->con->prepare("CALL realizarAbono(?,?,?,?,@result);");
			$resultado->bind_param('sddd',$fechaV,$totalPagadoV,$idVentaDecrypt,$idEmpresaDecrypt);
			$resultado->execute();
			$queryProcedure = "SELECT @result AS resultado";
			$resultadoProcedure = $this->con->query($queryProcedure);
			$resultadoVista  = $resultadoProcedure->fetch_assoc();
			$this->con->close();
			if (is_numeric($resultadoVista['resultado'])) {
				$resultadoVista['resultado'] = $enc->encrypt_decrypt('encrypt', $resultadoVista['resultado']);
			}
			return json_encode($resultadoVista['resultado'], JSON_PRETTY_PRINT);
		}else{
			$this->con->close();
			return json_encode(array('resultado' => false), JSON_PRETTY_PRINT);
		}
	}
}
?>