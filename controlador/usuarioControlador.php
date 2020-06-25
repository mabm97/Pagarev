<?php
require_once '../model/usuarioDAO.php';

$dao = new UsuarioDAO();

switch ($_POST['opt']) {
 		case 1://login
 		$valores = array(
 			'email' => $_POST['email'],
 			'contrasena' => $_POST['contrasena']
 		);
 		$resultado = $dao->login($valores);
 		echo json_encode($resultado);
 		break;
 		
 		case 2:
 		$dao->closeSession();
 		break;

 		case 3:
 		$resultado = $dao->ventasRecientesXEmpresa();
 		echo json_encode($resultado);
 		break; 		

 		case 4:
 		$resultado = $dao->ventasPendientesXEmpresa();
 		echo json_encode($resultado);
 		break; 		   

 		case 5:
 		$resultado = $dao->contarVentasPendientesXEmpresa();
 		echo json_encode($resultado);
 		break; 	

 		case 6:
 		$resultado = $dao->contarVentasPagadasXEmpresa();
 		echo json_encode($resultado);
 		break; 	 		

 		case 7:
 		$resultado = $dao->contarProductosXEmpresa();
 		echo json_encode($resultado);
 		break; 	 		

 		case 8:
 		$resultado = $dao->contarVentasTotalesXEmpresa();
 		echo json_encode($resultado);
 		break; 	 		

 		case 9:
 		$resultado = $dao->verProductoXEmpresa();
 		echo json_encode($resultado);
 		break;	 		

 		case 10:
 		$resultado = $dao->ventasXEmpresa();
 		echo json_encode($resultado);
 		break;

 		case 11:
 		$resultado = $dao->verVentasPagadasXEmpresa();
 		echo json_encode($resultado);
 		break;

 		case 12:
 		$producto = array(
 			'nombre' => $_POST['agregarNombre'],
 			'precio' => $_POST['agregarPrecio']
 		);
 		$resultado = $dao->agregarProductoXEmpresa($producto);
 		echo json_encode($resultado);
 		break;

 		case 13:
 		$venta = array(
 			'cliente' => $_POST['cliente'],
 			'idProducto' => $_POST['idProducto'],
 			'cantidad' => $_POST['cantidad'],
 			'pagado' => $_POST['pagado'],
 			'total' => $_POST['total'],
 			'email' => $_POST['emailCliente'] 			
 		);
 		$resultado = $dao->agregarVenta($venta);
 		echo json_encode($resultado);
 		break; 	

 		case 14:
 		$resultado = $dao->eliminarProducto($_POST['idProducto']);
 		echo json_encode($resultado);
 		break; 	

 		case 15:
 		$resultado = $dao->generarPDF($_POST['folio']);
 		echo json_encode($resultado);
 		break; 

 		case 16:
 		$resultado = $dao->verAbonosXVenta($_POST['idVenta']);
 		echo json_encode($resultado);
 		break; 

 		case 17:
 		$resultado = $dao->abonarMontoAVenta($_POST['idVenta'],$_POST['montoAbonar']);
 		echo json_encode($resultado);
 		break; 

		case 18:
 		$resultado = $dao->modificarProducto($_POST['idProducto'],$_POST['nombre'],$_POST['precio']);
 		echo json_encode($resultado);
 		break; 

 		case 69:
 		$resultado = $dao->cerrarSesion();
 		break; 	 			
 		
 	}


 	?>