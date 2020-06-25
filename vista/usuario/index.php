<?php 
session_start();
if(isset($_SESSION['idEmpresa']) && isset($_SESSION['roleUsuario'])){
  if($_SESSION['roleUsuario'] != 'ROLE_USER'){
    header('Location: ./vista/admin/index.php');
  }
}else{
  header('Location: ../../index.php');
}

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Dashboard</title>
  <!-- Favicon -->
  <link href="./../../assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="./../../assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="./../../assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="./../../assets/css/argon.css?v=1.0.0" rel="stylesheet">
  <!-- CustomModalFullScreen -->
  <link type="text/css" href="./../../assets/css/argon.css?v=1.0.0" rel="stylesheet">

  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="./../../assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="./../../assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Argon JS -->
  <script src="./../../assets/js/argon.js?v=1.0.0"></script>
  <!-- Ajax -->
  <script src="./../../assets/js/usuario/index.js"></script>  
  <script src="./../../assets/js/validaciones.js"></script>    
  <!-- Sweet Alert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.min.css" rel="stylesheet"/>
</head>

<body>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.php">Dashboard</a>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <!-- Imagen de perfil -->
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="../../assets/img/icons/iconUsuario.png">
                </span>
                <div class="media-body ml-2 d-none d-lg-block">
                  <span class="mb-0 text-sm  font-weight-bold">Opciones</span>
                </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <a id="btnCerrarSesion" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Cerrar Sesión</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-7">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <!-- Icon Products Panel -->
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Productos</h5>
                      <span id="cantidadProductos" class="h2 font-weight-bold mb-0">0</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="ni ni-app"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span href="#modalProductos" data-toggle="modal" class="text-success mr-2"><i class="ni ni-bold-right"></i>Ver Más</span>
                    <span href="#modalAgregarProducto" data-toggle="modal" class="text-success mr-2"><i class="ni ni-bold-right"></i>Agregar</span>
                  </p>                  
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div href="#modalVentas" data-toggle="modal" class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Ventas</h5>
                      <span id="cantidadVentas" class="h2 font-weight-bold mb-0">0</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="ni ni-cart"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="ni ni-bold-right"></i>Ver Más</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div  class="card card-stats mb-4 mb-xl-0">
                <div href="#modalVentasCompletadas" data-toggle="modal" class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Ventas Completas</h5>
                      <span id="cantidadVentasPagadas" class="h2 font-weight-bold mb-0">0</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                        <i class="ni ni-check-bold"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="ni ni-bold-right"></i>Ver Más</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div href="#modalVentasPendientes" data-toggle="modal" class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Ventas Pendientes</h5>
                      <span id="cantidadVentasPendientes" class="h2 font-weight-bold mb-0">0</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="ni ni-fat-delete"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="ni ni-bold-right"></i>Ver Más</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <div class="row mt-4">
        <div class="col-xl-8 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Ultimas Ventas</h3>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table id="tabVentas" class="table align-items-center table-flush">
                <thead class="thead-light">
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Realizar Venta</h3>
                  <h2 id="totalVenta" class="mb-0">$00.00</h2>
                </div>                
                <div class="col text-right">
                  <a href="#modalProductosVenta" data-toggle="modal" class="btn btn-sm btn-primary">Seleccionar Producto</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <form id="formVender">
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Cliente</label>
                        <input type="text" id="clienteVender" name="clienteVender" class="form-control form-control-alternative" placeholder="Cliente" required>
                        <span class="help-block"></span>                        
                      </div>
                    </div>
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Producto</label>
                        <input type="text" id="productoVender" name="productoVender" class="form-control form-control-alternative" placeholder="Producto" required disabled="true">
                        <span class="help-block"></span>                        
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Cantidad</label>
                        <input type="number" id="cantidadVender" name="cantidadVender" class="form-control form-control-alternative" placeholder="Cant." required>
                        <span class="help-block"></span>                                                  
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Precio c/u</label>
                        <input type="text" id="precioVender" name="precioVender" class="form-control form-control-alternative" placeholder="Precio $0.00" required disabled="true">
                        <span class="help-block"></span>                                                  
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Pagado</label>
                        <input type="text" id="pagadoVender" name="pagadoVender" class="form-control form-control-alternative" placeholder="Pagado $0.00" required>
                        <span class="help-block"></span>                                                  
                      </div>
                    </div>
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Email</label>
                        <input type="email" id="emailVender" name="emailVender" class="form-control form-control-alternative" placeholder="Email" required>
                        <span class="help-block"></span>                                                  
                      </div>
                    </div>                    
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name"></label>
                        <button id=btnModalImprimir type="button" class="form-control btn btn-success">Imprimir</button>
                      </div>
                    </div>                     
                  </div>
                </div>                   
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Ventas Pendientes -->
    <div class="modal" id="modalVentasPendientes" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Ventas Pendientes</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4">
            <p>Aquí podras ver a detalle las ventas que se encuentran pendientes de pagar.</p>
            <div class="row">
              <div class="table-responsive">
                <table id="tabVentasPendientes" class="table align-items-center table-flush">
                  <thead class="thead-light">               
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Ventas Completadas -->
    <div class="modal" id="modalVentasCompletadas" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Ventas Completadas</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4" >
            <p>Aquí podras ver a detalle las ventas que han completado el pago.</p>
            <div class="row">
              <div class="table-responsive">
                <table id="tabVentasCompletadas" class="table align-items-center table-flush">
                  <thead class="thead-light">               
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Productos -->
    <div class="modal" id="modalProductos" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Productos</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4" >
            <p>Aquí podras ver todos los productos con los que cuentas.</p>
            <div class="row">
              <div class="table-responsive">
                <table id="tabProductos" class="table align-items-center table-flush">
                  <thead class="thead-light">               
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Ventas -->
    <div class="modal" id="modalVentas" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Ventas</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4" >
            <p>Aquí podras ver todas los ventas que haz realizado.</p>
            <div class="row">
              <div class="table-responsive">
                <table id="tabVentasFull" class="table align-items-center table-flush">
                  <thead class="thead-light">               
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Productos para Venta -->
    <div class="modal" id="modalProductosVenta" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Productos</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4" >
            <p>Selecciona el producto que deseas vender.</p>
            <div class="row">
              <div class="table-responsive">
                <table id="tabProductosVenta" class="table align-items-center table-flush">
                  <thead class="thead-light">               
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal ABONAR Venta Pendiente-->
    <div class="modal" id="modalAbonarVentaPendiente" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Realizar Abono</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4" >
            <div class="row">
              <div class="col">
                <label>
                  Producto:
                  <label id="productoAbono" class="form-control-label"></label>
                </label>
              </div>
              <div class="col">
                <label>
                  Cliente:
                  <label id="clienteAbono" class="form-control-label"></label>
                </label> 
              </div>
              <div class="col">
                <label>
                  Total:
                  <label id="totalAbono" name="totalAbono" class="form-control-label"></label>
                </label>
              </div>
              <div class="col">
                <label>
                  Resto:
                  <label id="restoAbono" class="form-control-label"></label>
                </label>
              </div>
              <div class="col">
                <label>
                  Email:
                  <label id="emailAbono" class="form-control-label"></label>
                </label>
              </div>              
            </div>
            <label class="form-control-label" for="input-first-name">Abono:</label>
            <input id="montoAbonar" name="montoAbonar" type="number"  class="form-control form-control-alternative" placeholder="0.00" required="true"/>
            <span class="help-block"></span>     
            <br/>           
            <div class="row">
              <div class="table-responsive">
                <table id="tabAbonosVenta" class="table align-items-center table-flush">
                  <thead class="thead-light">               
                  </thead>
                  <tbody>
                  </tbody>
                </table>                
              </div>
            </div>        
          </div>
          <div class="modal-footer">
            <button id="btnModalConfirmarAbono" type="button" class="btn btn-success">Imprimir</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>          
        </div>
      </div>
    </div>    

    <!-- Modal Agregar Producto -->
    <div class="modal" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Agregar Producto</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4">
            <p>En esta sección usted podra agregar su producto.</p>
            <div class="row">
              <!-- Projects table -->
              <form id="formAgregarProducto">
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Producto</label>
                        <input id="agregarNombre" name="agregarNombre" type="text" class="form-control form-control-alternative" placeholder="Producto" required>
                        <br/>
                        <span class="help-block"></span>                          
                      </div>
                    </div>                        
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Precio</label>
                        <input id="agregarPrecio" name="agregarPrecio" type="number"  class="form-control form-control-alternative" placeholder="0.00" required>
                        <br/>
                        <span class="help-block"></span>                          
                      </div>
                    </div>                  
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button id=btnAgregarProducto type="button" class="btn btn-success">Aceptar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Agregar Producto -->
    <div class="modal" id="modalModificarProducto" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Modificar Producto</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4">
            <p>En esta sección usted podra modificar su producto.</p>
            <div class="row">
              <!-- Projects table -->
              <form id="formAgregarProducto">
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Producto</label>
                        <input id="modificarNombre" name="modificarNombre" type="text" class="form-control form-control-alternative" placeholder="Producto" required>
                        <br/>
                        <span class="help-block"></span>                          
                      </div>
                    </div>                        
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Precio</label>
                        <input id="modificarPrecio" name="modificarPrecio" type="number"  class="form-control form-control-alternative" placeholder="0.00" required>
                        <br/>
                        <span class="help-block"></span>                          
                      </div>
                    </div>                  
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button id=btnModificarProducto type="button" class="btn btn-success">Aceptar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Confirmar Imprimir Venta -->
    <div class="modal" id="modalConfirmarVenta" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title">Confirmar Venta</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">X</span>
            </button>
          </div>
          <div class="modal-body p-4" >
            <p>Por favor, confirme la información de la venta.</p>
            <div class="row">
              <form id="formVender">
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Cliente</label>
                        <input type="text" id="clienteConfirmar" name="clienteConfirmar" class="form-control form-control-alternative" placeholder="Cliente" disabled="true">
                      </div>
                    </div>
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Producto</label>
                        <input type="text" id="productoConfirmar" name="productoConfirmar" class="form-control form-control-alternative" placeholder="Producto" disabled="true">
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Cantidad</label>
                        <input type="number" id="cantidadConfirmar" name="cantidadConfirmar" class="form-control form-control-alternative" placeholder="Cant." disabled="true">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Precio c/u</label>
                        <input type="text" id="precioConfirmar" name="precioConfirmar" class="form-control form-control-alternative" placeholder="Precio $0.00" disabled="true">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Pagado</label>
                        <input type="text" id="pagadoConfirmar" name="pagadoConfirmar" class="form-control form-control-alternative" placeholder="Pagado $0.00" disabled="true">
                      </div>
                    </div>
                    <div class="col-lg-11">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">Email</label>
                        <input type="text" id="emailConfirmar" name="emailConfirmar" class="form-control form-control-alternative" placeholder="Email" disabled="true">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group">
                       <h2 class="modal-title">Total: <h2 id="totalConfirmar"> $0.00</h2></h2>
                     </div>
                   </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button id=btnConfirmarImprecion type="button" class="btn btn-success">Aceptar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="row align-items-center justify-content-xl-between">
      <div class="col-xl-6">
        <div class="copyright text-center text-xl-left text-muted">
          &copy; 2018 <a href="http://www.jaggedmexicans.com" class="font-weight-bold ml-1" target="_blank">Jagged Mexicans</a>
        </div>
      </div>
      <div class="col-xl-6">
        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
          <li class="nav-item">
            <a href="http://www.jaggedmexicans.com" class="nav-link" target="_blank">Pagina Oficial</a>
          </li>
          <li class="nav-item">
            <a href="https://www.facebook.com/jaggedmexicans/" class="nav-link" target="_blank">Facebook</a>
          </li>
        </ul>
      </div>
    </div>
  </footer>
</body>

</html>