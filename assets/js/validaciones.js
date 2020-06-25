function verificarEmail(email){
	if (email.length <3) {
		return false;
	}else{
		if (/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) {
			return true;
		}else{
			return false;
		}
	}
}

function verificarContrasena(contrasena){
	if (contrasena.length >=6) {
		return true;
	}else{
		return false;
	}
}

function verificarEmailEnviar(idInput, msg) {
	var textError = "<span class='fab fa-deviantart' style='color:red'>" +msg +" </span>";
	var textSuccess ="<i class='fas fa-check-circle'></i> <span style='color:green'>" +msg +"  </span>";
	var valueInput = $("#" + idInput).val();
	if (/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(valueInput) || valueInput.length===0) {
		$("#" + idInput).parent().attr("id", "has-success has-feedback");
		$("#" + idInput).parent().children("span").html(textSuccess).show();
		return true;
	}else{
		$("#" + idInput).parent().attr("id", "has-error has-feedback");
		$("#" + idInput).parent().children("span").html(textError).show();
		return false;		
	}
}


function verificarNombre(idInput, msg) {
	var textError ="<span class='fab fa-deviantart' style='color:red'>" +msg +" Invalido </span>";
	var textSuccess ="<i class='fas fa-check-circle'></i> <span style='color:green'>" +msg +"</span>";
	var valueInput = $("#" + idInput).val();
	if (valueInput.length < 3) {
		$("#" + idInput).parent().attr("id", "has-error has-feedback");
		$("#" + idInput).parent().children("span").html(textError).show();
		return false;
	} else {
		if (/^[0-9.a-z.A-Z.-áéíóúÁÉÍÓÚñ*.\s]+$/.test(valueInput)) {
			$("#" + idInput).parent().attr("id", "has-success has-feedback");
			$("#" + idInput).parent().children("span").html(textSuccess).show();
			return true;
		} else {
			$("#" + idInput).parent().attr("id", "has-error has-feedback");
			$("#" + idInput).parent().children("span").html(textError).show();
			return false;
		}
	}
}

function verificarFormatoDecimal(idInput, msg) {
	var textError = "<span class='fab fa-deviantart' style='color:red'>" +msg +" Invalido</span>";
	var textSuccess ="<i class='fas fa-check-circle'></i> <span style='color:green'>" +msg +" Correcto</span>";
	var valueInput = $("#" + idInput).val();
	if (/^\+?(\d*[1-9]\d*\.?|\d*\.\d*[1-9]\d*)$/.test(valueInput)) {
		$("#" + idInput).parent().attr("id", "has-success has-feedback");
		$("#" + idInput).parent().children("span").html(textSuccess).show();
		return true;
	} else {
		$("#" + idInput).parent().attr("id", "has-error has-feedback");
		$("#" + idInput).parent().children("span").html(textError).show();
		return false;
	}
}

function cambiarDecimalADinero(decimal) {
	var parseNum = parseFloat(decimal);
	return '$'+parseNum.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

function cambiarDineroADecimal(dinero){
	var parseMoney = Number(dinero.replace(/[^0-9\.]+/g,""));
	return parseMoney;
}

function verificarNumeroEntero(idInput, msg) {
	var textError = "<span class='fab fa-deviantart' style='color:red'>" +msg +" Invalido</span>";
	var textSuccess = "<i class='fas fa-check-circle'></i> <span style='color:green'>" +msg +" Correcto</span>";
	var valueInput = $("#" + idInput).val();
	if (/^\d*$/.test(valueInput)) {
		$("#" + idInput).parent().attr("id", "has-success has-feedback");
		$("#" + idInput).parent().children("span").html(textSuccess).show();
		return true;
	} else {
		$("#" + idInput).parent().attr("id", "has-error has-feedback");
		$("#" + idInput).parent().children("span").html(textError).show();
		return false;
	}
}

function mensajeDivs(component,msg) {
	var divHtml= "<div id='alertEmail' class='alert alert-warning' role='alert'>"+msg+"</div>";
	$('#'+ component).parent().children('span').html(divHtml).show();
	$("#alertEmail").fadeTo(2000, 500).slideUp(500, function(){
		$("#success-alert").slideUp(500);
	});
}
