$(document).on("click", "#btnLogin", function() {

	var email = verificarEmail($("#email").val());
	var contrasena = verificarContrasena($("#contrasena").val());

	if(email && contrasena){
		login($("#formLogin").serialize());
	}else{
		mensajeDivs("btnLogin","Email/contraseña incorrectos");
	}

});

function login(valores){
	$.ajax({
		type: "POST",
		url: './controlador/usuarioControlador.php',           
		data: valores+"&opt="+1,
		dataType: "json",
		success: function(retorno){
			var json = jQuery.parseJSON(retorno);
			if(!json.resultado){
				mensajeDivs("btnLogin","Correo electrónico/contraseña equivocada");
			}else{
				if (json.resultado == 'ROLE_USER') {
					window.location.href = './vista/usuario/index.php';            
				}else{
					window.location.href = './vista/admin/index.php';
				}
			}
		},
		error : function(xhr, status) {
			console.log(xhr);
		}
	});
}

/*
function enterKey() {
    if (event.keyCode == 13) {
        checkLogin();
    }
}
*/