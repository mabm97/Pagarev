  $( document ).ready(function() { 
    obtenerVentasReciente();
    obtenerVentasPendientes();
    contarVentasPendientesXEmpresa();
    contarVentasTotalesXEmpresa();
    contarProductoXEmpresa();
    contarVentasPagadasXEmpresa();
    verProductoXEmpresa();
    ventasXEmpresa();
    verVentasPagadasXEmpresa();
    verProductoParaVenta();
    $( "#btnAgregarProducto" ).click(function() {
      agregarProducto();
    });

    $( "#btnModalImprimir" ).click(function() {
      validarFormRealizarVenta();
    });
    $('#cantidadVender').on('change', function() {
      calcularVentaInputCantidad();
    });
  });


  $(document).on('click','#btnVenderProducto',function(){
  	venderProducto($(this));    
  });
  $(document).on('click','#btnConfirmarImprecion',function(){
    imprimir();
  });


  $(document).on('click','#btnCerrarSesion',function(){
    $.ajax({        
      type: "POST",
      url: './../../controlador/usuarioControlador.php',
      data: "opt="+69,
      success: function(){
        window.location.href = './../../index.php';
      },
      error : function(xhr, status) {
        console.log(xhr);
      }
    }); 
  });
  $(document).on('click','#btnProductoEliminar',function(){
    mensajeEliminarProducto($(this));
  });

  $(document).on('click','#btnModalProductoModificar',function(){
    abrirModalModificarProducto($(this));    
  });
  
  $(document).on('click','#btnModificarProducto',function(){
    mensajeModificarProducto($(this));    
  });
  
  $(document).on('click','#btnModalAbonar',function(){
    //mandar a llamar la venta con sus abonos/ventadetalle 
    abrirModalAbonosVenta($(this));
  });

  $(document).on('click','#btnModalConfirmarAbono',function(){
    //mandar a llamar la venta con sus abonos/ventadetalle 
    abrirModalConfirmarAbono($(this));
  });
  
  $(document).on('click','#btnVenta',function(){
    var idVenta = $(this).parents("tr").find("th").eq(6).find('a').attr('value');
    verAbonosXVentaReporte(idVenta,1);
  });  

  $(document).on('click','#btnModalVerMasVentaCompletada',function(){
    var idVenta = $(this).parents("tr").find("th").eq(5).find('a').attr('value');
    verAbonosXVentaReporte(idVenta,1);
  });

  $(document).on('click','#btnVentaEmail',function(){
    var idVenta = $(this).parents("tr").find("th").eq(7).find('a').attr('value');    
    verAbonosXVentaReporte(idVenta,2);
  });  

  $(document).on('click','#btnModalEmailVentaCompletada',function(){
    var idVenta = $(this).parents("tr").find("th").eq(6).find('a').attr('value');
    verAbonosXVentaReporte(idVenta,2);
  });  

  function abrirModalModificarProducto(contexto){
    var nombre = contexto.parents("tr").find("th").eq(0).html();
    var precio = cambiarDineroADecimal(contexto.parents("tr").find("th").eq(1).html());
    var idProducto = contexto.parents("tr").find("th").eq(2).find('a').attr('value');
    $("#modificarNombre").val(nombre);
    $("#modificarPrecio").val(precio);
    $("#btnModificarProducto").val(idProducto);

    $('#modalModificarProducto').modal('show');
    $('#modalProductos').modal('toggle');    
  }

  function mensajeModificarProducto(contexto){
    var verNombre = verificarNombre('modificarNombre',' Nombre');
    var verPrecio = verificarFormatoDecimal('modificarPrecio',' Precio');
    if (verPrecio && verNombre) {
      var idProducto = document.getElementById('btnModificarProducto').value;
      var nombre = (document.getElementById('modificarNombre').value);
      var precio = (document.getElementById('modificarPrecio').value);
      swal({
        title: "¡Aviso!",
        text: "¿Seguro que deseas MODIFICAR el producto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "¡Si, modificar!",
        cancelButtonText: "¡No, cancelar!",
        confirmButtonColor: '#008000',
        cancelButtonColor: '#FF0000',
      }).then(function(isConfirm) {
        if (isConfirm) {
          modificarProducto(idProducto,nombre,precio);
        } else {
          swal().close();
        }
      }).catch(swal.noop);
    }
  }

  function modificarProducto(idProducto,nombre,precio) {
   $.ajax({        
    type: "POST",
    url: './../../controlador/usuarioControlador.php',
    data: "idProducto="+idProducto+"&nombre="+nombre+"&precio="+precio+"&opt="+18,
    dataType: "json",
    success: function(retorno){
      var json = jQuery.parseJSON(retorno);
      if (json) {
        swal({
          type: "success",
          title: "Producto modificado correctamente ",
          showConfirmButton: false,
          timer: 1500
        })
        .then(function() {})
        .catch(swal.noop);
        $('#modalModificarProducto').modal('toggle');        
        verProductoXEmpresa();
        contarProductoXEmpresa();
        verProductoParaVenta();
      }else{
        swal({
         type: "error",
         title: "Lo sentimos, ocurrio un error",
         showConfirmButton: false,
         timer: 1500
       })
        .then(function() {})
        .catch(swal.noop);
      }
    },
    error : function(xhr, status) {
     console.log(xhr);
   }
 });  
 }

 function eliminarProducto(idProducto){
  $.ajax({        
    type: "POST",
    url: './../../controlador/usuarioControlador.php',
    dataType: "json",      
    data: "idProducto="+idProducto+"&opt="+14,
    success: function(retorno){
      var json = jQuery.parseJSON(retorno);
      if (json) {
        swal({
          type: "success",
          title: "Producto borrado correctamente ",
          showConfirmButton: false,
          timer: 1500
        })
        .then(function() {})
        .catch(swal.noop);
        verProductoXEmpresa();
        contarProductoXEmpresa();
        verProductoParaVenta();
      }else{
        swal({
         type: "error",
         title: "Lo sentimos, ocurrio un error",
         showConfirmButton: false,
         timer: 1500
       })
        .then(function() {})
        .catch(swal.noop);
      }
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });     
}

function mensajeEliminarProducto(contexto){
  var idProducto = contexto.parents("tr").find("th").eq(3).find('a').attr('value');
  swal({
    title: "¿Seguro que deseas ELIMINAR el producto?",
    text: "¡Recuerda que no podras recuperarlo!",
    type: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn-danger",
    confirmButtonText: "¡Si, borrarlo!",
    cancelButtonText: "¡No, cancelar!",
    confirmButtonColor: '#008000',
    cancelButtonColor: '#FF0000',
  })
  .then(function(isConfirm) {
    if (isConfirm) {
      eliminarProducto(idProducto);
    } else {
      swal().close();
    }

  })
  .catch(swal.noop);
}

function obtenerVentasReciente(){
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+3,
  dataType: "json",
  success: function(retorno){
   let body = $('#tabVentas');
   let content = '<tr><th scope="col">Folio</th><th scope="col">Fecha</th><th scope="col">Cliente</th><th scope="col">Total</th><th scope="col">Estado</th></tr>';
   for (var i = 0; i < retorno.length; i++) {
    content += '<tr>';
    content += '<th id="price" scope="row">' + retorno[i]['folio'] + '</th>';
    content += '<th id="price" scope="row">' + retorno[i]['fecha'] + '</th>';
    content += '<th id="price" scope="row">' + retorno[i]['nombreCliente'] + '</th>';
    content += '<th id="price" scope="row">' + retorno[i]['total'] + '</th>';
    content += '<th id="price" scope="row">' + retorno[i]['estadoDeuda'] + '</th>';
    content += '</tr>';
  }                        
  body.html(content);
},error : function(xhr, status) {
 console.log(xhr);
}});     
}

function obtenerVentasPendientes(){
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+4,
  dataType: "json",
  success: function(retorno){
   let body = $('#tabVentasPendientes');
   let content = '<tr><th scope="col">Folio</th><th scope="col">Fecha</th><th scope="col">Cliente</th><th scope="col">Total</th><th scope="col">Pagado</th><th scope="col"></th></tr>';
   for (var i = 0; i < retorno.length; i++) {
    content += '<tr>';
    content += '<th scope="row">' + retorno[i]['folioVenta'] + '</th>';
    content += '<th scope="row">' + retorno[i]['fecha'] + '</th>';
    content += '<th scope="row">' + retorno[i]['nombreCliente'] + '</th>';  				
    content += '<th scope="row">' + retorno[i]['total'] + '</th>';
    content += '<th scope="row">' + retorno[i]['pagado'] + '</th>';  				
    content += '<th scope="row"><a id="btnModalAbonar" value="'+retorno[i]['ventaId']+'" role="button" class="btn btn-success" data-toggle="modal">Abonar</a>' + '</th>';
    content += '</tr>';
  }                        
  body.html(content);
},
error : function(xhr, status) {
 console.log(xhr);
}
});     
}  

function abrirModalConfirmarAbono(contexto){  
  var validarMontoAbono = verificarFormatoDecimal('montoAbonar',' Monto');
  if (validarMontoAbono) {
    var montoAbonarValor = Number(document.getElementById('montoAbonar').value);
    var montoResto = cambiarDineroADecimal($('#restoAbono').text());
    if (montoAbonarValor>montoResto) {
      mensajeDivs('montoAbonar',' El abono es mayor al total');
    }else{
      if (montoAbonarValor >=0.50)  {        
        var idVenta = contexto.attr('value');
        abonarMontoAVenta(idVenta,montoAbonarValor);
      }else{
        mensajeDivs('montoAbonar',' El abono debe de ser mayor a $0.50');
      }
    }
  }
}

function abonarMontoAVenta(idVenta,montoAbonar) {
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "idVenta="+idVenta+"&montoAbonar="+montoAbonar+"&opt="+17,
  dataType: "json",
  success: function(retorno){
    verAbonosXVentaReporte(retorno,1);
  },
  error : function(xhr, status) {
   console.log(xhr);
 }
}); 
}

function abrirModalAbonosVenta(contexto) {
  var idVenta = contexto.parents("tr").find("th").eq(5).find('a').attr('value');
  $.ajax({        
    type: "POST",
    url: './../../controlador/usuarioControlador.php',
    data: "idVenta="+idVenta+"&opt="+16,
    dataType: "json",
    success: function(retorno){
      let body = $('#tabAbonosVenta');
      let content = '<tr><th scope="col">Fecha</th><th scope="col">Folio</th><th scope="col">Monto Pagado</th></tr>';
      for (var i = 0; i < retorno.length; i++) {
        content += '<tr>';
        content += '<th scope="row">' + retorno[i]['fecha'] + '</th>';
        content += '<th scope="row">' + retorno[i]['folio'] + '</th>';
        content += '<th scope="row">' + retorno[i]['totalPagado'] + '</th>';
        content += '</tr>';
      }
      body.html(content);
      $("#productoAbono").text(retorno[0]['descripcion']);
      $("#clienteAbono").text(retorno[0]['nombreCliente']);
      $("#totalAbono").text(retorno[0]['total']);
      $("#restoAbono").text(retorno[0]['restoPago']);

      if (retorno[0]['emailCliente'] != '') {
        $("#emailAbono").text(retorno[0]['emailCliente']);
      }else{
        $("#emailAbono").text('Sin Email');        
      }

      $("#btnModalConfirmarAbono").val(retorno[0]['ventaId']);

      $('#modalAbonarVentaPendiente').modal('show');
      $('#modalVentasPendientes').modal('toggle');
    },
    error : function(xhr, status) {
     console.log(xhr);
   }
 });
}


function contarVentasPendientesXEmpresa(){
 $.ajax({        
  type: "POST",	
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+5,
  dataType: "json",
  success: function(retorno){
   var json = jQuery.parseJSON(retorno);
   $('#cantidadVentasPendientes').text(json);
 },
 error : function(xhr, status) {
   console.log(xhr);
 }
});     
}  

function contarVentasPagadasXEmpresa(){
 $.ajax({        
  type: "POST",	
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+6,
  dataType: "json",
  success: function(retorno){
   var json = jQuery.parseJSON(retorno);
   $('#cantidadVentasPagadas').text(json);
 },
 error : function(xhr, status) {
   console.log(xhr);
 }
});     
}  

function contarProductoXEmpresa(){
 $.ajax({        
  type: "POST",	
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+7,
  dataType: "json",
  success: function(retorno){
   var json = jQuery.parseJSON(retorno);
   $('#cantidadProductos').text(json);
 },
 error : function(xhr, status) {
   console.log(xhr);
 }
});     
} 

function contarVentasTotalesXEmpresa(){
 $.ajax({
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+8,
  dataType: "json",
  success: function(retorno){
   var json = jQuery.parseJSON(retorno);
   $('#cantidadVentas').text(json);
 },
 error : function(xhr, status) {
   console.log(xhr);
 }
});
}

function verProductoXEmpresa(){
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+9,
  dataType: "json",
  success: function(retorno){
   let body = $('#tabProductos');
   let content = '<tr><th scope="col">Nombre</th><th scope="col">Precio</th><th scope="col"></th><th scope="col"></th></tr>';
   for (var i = 0; i < retorno.length; i++) {
    content += '<tr>';
    content += '<th scope="row">' + retorno[i]['descripcion'] + '</th>';
    content += '<th scope="row">' + retorno[i]['precioNeto'] + '</th>';                
    content += '<th scope="row"><a id="btnModalProductoModificar" value="'+retorno[i]['id']+'" role="button" class="btn btn-info" data-toggle="modal">Modificar</a>' + '</th>';
    content += '<th scope="row"><a id="btnProductoEliminar" value="'+retorno[i]['id']+'" role="button" class="btn btn-danger" data-toggle="modal">Eliminar</a>' + '</th>';  				
    content += '</tr>';
  }                        
  body.html(content);
},
error : function(xhr, status) {
 console.log(xhr);
}
});       	
}

function verProductoParaVenta(){
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+9,
  dataType: "json",
  success: function(retorno){
   let body = $('#tabProductosVenta');
   let content = '<tr><th scope="col">Nombre</th><th scope="col">Precio</th><th scope="col"></th></tr>';
   for (var i = 0; i < retorno.length; i++) {
    content += '<tr>';
    content += '<th scope="row">' + retorno[i]['descripcion'] + '</th>';
    content += '<th scope="row">' + retorno[i]['precioNeto'] + '</th>';
    content += '<th scope="row"><a id=btnVenderProducto value="'+retorno[i]['id']+'" role="button" class="btn btn-info" data-toggle="modal">Agregar</a>' + '</th>';
    content += '</tr>';
  }                        
  body.html(content);
},
error : function(xhr, status) {
 console.log(xhr);
}
});       	
}

function ventasXEmpresa(){
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+10,
  dataType: "json",
  success: function(retorno){
    let body = $('#tabVentasFull');
    let content = '<tr><th scope="col">Folio</th><th scope="col">Fecha</th><th scope="col">Cliente</th><th scope="col">Total</th><th scope="col">Estado</th><th scope="col">Email</th><th scope="col">Imprimir</th><th scope="col">Enviar</th></tr>';
    for (var i = 0; i < retorno.length; i++) {
      content += '<tr>';
      content += '<th id="price" scope="row">' + retorno[i]['folioVenta'] + '</th>';
      content += '<th id="price" scope="row">' + retorno[i]['fecha'] + '</th>';
      content += '<th id="price" scope="row">' + retorno[i]['nombreCliente'] + '</th>';
      content += '<th id="price" scope="row">' + retorno[i]['total'] + '</th>';  				
      content += '<th id="price" scope="row">' + retorno[i]['estadoDeuda'] + '</th>';        		
      content += '<th id="price" scope="row">' + retorno[i]['emailCliente'] + '</th>';            
      content += '<th scope="row"><a id="btnVenta" value="'+retorno[i]['ventaId']+'" role="button" class="btn btn-success" data-toggle="modal">Imprimir</a>' + '</th>';
      if (retorno[i]['emailCliente'] != '') {
        content += '<th scope="row"><a id="btnVentaEmail" value="'+retorno[i]['ventaId']+'" role="button" class="btn btn-success" data-toggle="modal">Email</a>' + '</th>';
      }else{
        content += '<th scope="row"></th>';        
      }
      content += '</tr>';
    }                        
    body.html(content);
  },
  error : function(xhr, status) {
   console.log(xhr);
 }
});       	
}

function verVentasPagadasXEmpresa(){
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "opt="+11,
  dataType: "json",
  success: function(retorno){
   let body = $('#tabVentasCompletadas');
   let content = '<tr><th scope="col">Folio</th><th scope="col">Fecha</th><th scope="col">Cliente</th><th scope="col">Total</th><th scope="col">Email</th><th scope="col">Imprimir</th><th scope="col">Enviar</th></tr>';
   for (var i = 0; i < retorno.length; i++) {
    content += '<tr>';
    content += '<th scope="row">' + retorno[i]['folioVenta'] + '</th>';
    content += '<th scope="row">' + retorno[i]['fecha'] + '</th>';
    content += '<th scope="row">' + retorno[i]['nombreCliente'] + '</th>';
    content += '<th scope="row">' + retorno[i]['total'] + '</th>';
    content += '<th scope="row">' + retorno[i]['emailCliente'] + '</th>';
    content += '<th scope="row"><a id="btnModalVerMasVentaCompletada" value="'+retorno[i]['ventaId']+'" role="button" class="btn btn-success" data-toggle="modal">Imprimir</a>' + '</th>';      
    if (retorno[i]['emailCliente'] != '') {
      content += '<th scope="row"><a id="btnModalEmailVentaCompletada" value="'+retorno[i]['ventaId']+'" role="button" class="btn btn-success" data-toggle="modal">Email</a>' + '</th>';      
    }else{
      content += '<th scope="row"></th>';        
    }
    content += '</tr>';
  }                        
  body.html(content);
},
error : function(xhr, status) {
 console.log(xhr);
}
});       	
}

function agregarProducto() {
 var nombre = verificarNombre('agregarNombre',' Nombre');
 var precio = verificarFormatoDecimal('agregarPrecio',' Precio');
 if (nombre && precio) {
  var producto = $('#formAgregarProducto').serialize();
  var precioValue = document.getElementById("agregarPrecio").value;
  if (precioValue>=0.50) {
    servicioAgregarProducto(producto);
  }else{
    mensajeDivs('agregarPrecio','El precio debe ser mayor a $0.50');
  }
}
}

function servicioAgregarProducto(producto){
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: producto+"&opt="+12,
  dataType: "json",
  success: function(retorno){
   var json = jQuery.parseJSON(retorno);
   if (json) {
    swal({
     type: "success",
     title: "Producto Agregado",
     showConfirmButton: false,
     timer: 1500
   })
    .then(function() {})
    .catch(swal.noop);
    verProductoXEmpresa();
    contarProductoXEmpresa();
    verProductoParaVenta();
    $('#formAgregarProducto').trigger("reset");
    $('#modalAgregarProducto').modal('toggle');  				
  }else{
    swal({
     type: "error",
     title: "Lo sentimos, ocurrio un error",
     showConfirmButton: false,
     timer: 1500
   })
    .then(function() {})
    .catch(swal.noop);
  }
},
error : function(xhr, status) {
 console.log(xhr);
}
});
}

function calcularVentaInputCantidad(){
  var precioVenta = Number(cambiarDineroADecimal(document.getElementById('precioVender').value));
  var cantidadVenta = Number(document.getElementById('cantidadVender').value);
  var totalVenta = calcularTotalVenta(precioVenta,cantidadVenta);
  $('#totalVenta').text(cambiarDecimalADinero(totalVenta));    
}

function venderProducto(contexto){
 var nombre = contexto.parents("tr").find("th").eq(0).html();
 var precio = contexto.parents("tr").find("th").eq(1).html();
 var idProducto = contexto.parents("tr").find("th").eq(2).find('a').attr('value');

 $('#totalVenta').text(precio);

 $("#productoVender").val(nombre);
 $("#precioVender").val(precio);
 $("#btnModalImprimir").val(idProducto);
}


function validarFormRealizarVenta(){
 var cliente = verificarNombre('clienteVender',' Cliente');
 var pagado = verificarFormatoDecimal('pagadoVender',' Pagado');
 var cantidad = verificarNumeroEntero('cantidadVender',' Cantidad');
 var inputEmail = verificarEmailEnviar('emailVender',' Email Opcional');


 if (cliente && pagado && cantidad) {
  var precioVenta = Number(cambiarDineroADecimal(document.getElementById('precioVender').value));
  var cantidadVenta = Number(document.getElementById('cantidadVender').value);
  var totalVenta = calcularTotalVenta(precioVenta,cantidadVenta);
  var pagadoVenta = Number(document.getElementById('pagadoVender').value);
  $('#totalVenta').text(cambiarDecimalADinero(totalVenta));
  var emailVenta = document.getElementById('emailVender').value;

  if (pagadoVenta > totalVenta) {
    mensajeDivs('pagadoVender',' El abono es mayor al costo');
  }else{
    if (pagadoVenta>=0.50) {
      $('#modalConfirmarVenta').modal('show');
      abrirConfirmarImpresion();
    }else{
      mensajeDivs('pagadoVender',' El abono debe ser mayor a $0.50');
    }
  }
}
}

function calcularTotalVenta(precioVenta,cantidadVenta){
  return (Number(precioVenta) * Number(cantidadVenta));
}

function abrirConfirmarImpresion(){
  var idProducto = document.getElementById('btnModalImprimir').value;
  var nombre = document.getElementById('productoVender').value;
  var cliente = document.getElementById('clienteVender').value;
  var cantidad = document.getElementById('cantidadVender').value;
  var precio = document.getElementById('precioVender').value;
  var pagado = document.getElementById('pagadoVender').value;
  var total = $('#totalVenta').text();
  var emailVenta = document.getElementById('emailVender').value;
  $("#productoConfirmar").val(nombre);
  $("#emailConfirmar").val(emailVenta);
  $("#clienteConfirmar").val(cliente);
  $("#cantidadConfirmar").val(cantidad);
  $("#precioConfirmar").val(precio);
  $("#pagadoConfirmar").val(cambiarDecimalADinero(pagado));    
  $("#totalConfirmar").text(total);
  $("#btnConfirmarImprecion").val(idProducto);
}

function imprimir(){
  var cliente = document.getElementById('clienteConfirmar').value;
  var idProducto = document.getElementById('btnConfirmarImprecion').value;
  var cantidad = document.getElementById('cantidadConfirmar').value;    
  var pagado = cambiarDineroADecimal(document.getElementById('pagadoConfirmar').value);
  var total = cambiarDineroADecimal($('#totalConfirmar').text());
  var email = document.getElementById('emailVender').value;

  $.ajax({        
    type: "POST",
    url: './../../controlador/usuarioControlador.php',
    data: "cliente="+cliente+"&idProducto="+idProducto+"&cantidad="+cantidad+"&pagado="+pagado+"&total="+total+"&emailCliente="+email+"&opt="+13,
    dataType: "json",
    success: function(retorno){
      console.log("imprimir");
      console.log(retorno);
      var json = jQuery.parseJSON(retorno);
      if (json!=false) {
        //if (email.length === 0 || email === '' ) {
        //Imprimir, solo PDF
        verAbonosXVentaReporte(retorno,1);
        //}else{
        //Enviar correo
        //  verAbonosXVentaReporte(retorno,2);
        //}
      }else{
        swal({
         type: "error",
         title: "Lo sentimos, ocurrio un error",
         showConfirmButton: false,
         timer: 1500
       })
        .then(function() {})
        .catch(swal.noop);          
      }
    },
    error : function(xhr, status) {
      console.log(xhr);
    }
  });
}

function verAbonosXVentaReporte(idVenta,opcionDeEnvioImprimir) {
 $.ajax({        
  type: "POST",
  url: './../../controlador/usuarioControlador.php',
  data: "idVenta="+idVenta+"&opt="+16,
  dataType: "json",
  success: function(retorno){    
    retorno[0].opcionDeEnvioImprimir = opcionDeEnvioImprimir;    
    
    OpenWindowWithPost('../../assets/html2pdf/pdf/alsanaViajes/reporteAlsana.php','reporteAlsana',"width=1000, height=600, left=100, top=100, resizable=yes, scrollbars=yes",JSON.stringify(retorno),opcionDeEnvioImprimir);
  },
  error : function(xhr, status) {
   console.log(xhr);
 }
});
}

function OpenWindowWithPost(url, windowoption, name, params, opcionDeEnvioImprimir){

  var form = document.createElement("form");
  form.setAttribute("method", "post");
  form.setAttribute("action", url);
  form.setAttribute("target", name);
  var input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'venta';
  input.value = params;
  form.appendChild(input);
  document.body.appendChild(form);
  if (opcionDeEnvioImprimir === 1) {
    window.open("index.php", name, windowoption);
    form.submit();
    document.body.removeChild(form);
    window.location.reload();
  }else{
    form.submit();
    document.body.removeChild(form);
    swal({
     type: "success",
     title: "Comprobante Enviado",
     showConfirmButton: false,
     timer: 1500
   })
    .then(function() {})
    .catch(swal.noop);
    //window.location.reload();

  }

}

