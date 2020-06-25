<?php
setlocale(LC_TIME, 'es_MX.UTF-8');
date_default_timezone_set('America/Mexico_city');

$json = json_decode($_POST['venta'], true);

ob_start();
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<style type="text/css">
		.qr {
			width: 114px;
			height: 114px;
		}

		#title {
			width: 500px;
			height: 104px;
		}

		#squareFolio {
			border-style: solid;
			border-width: 2px;
			border-color: black;
			background-color: black;
			position: absolute;
			width: 100px;
			height: 10px;
			top: 10px;
			left: 643px;
		}

		#squareFolio label {
			font-size: 11;
			color: white;
			font-weight: bold;
		}

		#squareValueFolio {
			border-style: solid;
			border-width: 2px;
			border-color: black;
			position: absolute;
			width: 100px;
			height: 25px;
			top: 26px;
			left: 643px;
			text-align: center;
			vertical-align: middle;
		}

		#squareValueFolio label {
			font-size: 13;
			font-weight: bold;
		}

		#squareDate {
			border-style: solid;
			border-width: 2px;
			border-color: black;
			position: absolute;
			width: 100px;
			height: 10px;
			top: 55px;
			left: 643px;
			background-color: black;
			text-align: center;
		}

		#squareDate label {
			font-size: 11;
			font-weight: bold;
			color: white;
		}

		#squareValueDate {
			border-style: solid;
			border-width: 2px;
			border-color: black;
			position: absolute;
			width: 100px;
			height: 25px;
			top: 71px;
			left: 643px;
			text-align: center;
			vertical-align: middle;
		}

		#squareValueDate label {
			font-size: 11;
			font-weight: bold;
		}

		#squareCustomer {
			word-wrap: break-word;
			border-style: solid;
			border-width: 2px;
			border-color: black;
			position: absolute;
			width: 745px;
			height: 40px;
			top: 110px;
			left: 0px;
			vertical-align: middle;
		}

		#squareCustomer label {
			font-size: 14;
			font-weight: bold;
			margin-left: 10px;
			margin-top: 10px;
			vertical-align: middle;
		}

		#products {
			position: relative;
			font-family: Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			table-layout: fixed;
			margin-top: 47px;
		}

		#products td,
		#products th {
			border: 2px solid #ddd;
			border-color: black;
			height: 25px;
		}

		#products th {
			text-align: left;
			background-color: #C0C0C0;
			color: white;
		}

		.colQuantity {
			width: 75px;
			font-size: 14;
			color: black;
			text-align: center;
			vertical-align: middle;
		}

		#colName {
			/*word-wrap: break-word;*/
			width: 444px;
			font-size: 14;
			text-align: center;
			color: black;
		}

		#colPrice {
			text-align: center;
			width: 100px;
			font-size: 14;
			color: black;
		}

		#colImport {
			width: 100px;
			font-size: 14;
			text-align: center;
			color: black;
		}

		.valueRow {
			word-wrap: break-word;
			font-size: 14;
			color: black;
			font-weight: bold;
		}

		.valueRowName {
			width: 440px;
			word-wrap: break-word;
		}

		.valueRowPrecioImporte {
			text-align: center;
		}

		.squareTotalLetter {
			word-wrap: break-word;
			border-style: solid;
			border-width: 2px;
			border-color: black;
			width: 534px;
			height: 39px;
			font-size: 10;
		}

		.squareTotalLetter label {
			font-size: 14;
			font-weight: normal;
		}

		.squareTotalNumber {
			word-wrap: break-word;
			border-style: solid;
			border-width: 2px;
			border-color: black;
			width: 100px;
			height: 50px;
			text-align: middle;
			vertical-align: middle;
		}

		.squareTotalNumber label {
			font-weight: normal;
			/*font-family: "Arial";*/
		}

		.tabFooter {
			margin-top: -1px;
			border-collapse: collapse;
			table-layout: fixed;
		}

		.adsNote1 {
			font-size: 11;
			/*font-family: "Arial";*/
			width: 104px;
			word-wrap: break-word;
			text-align: center;
		}

		.adsNote2 {
			font-size: 11;
			/*font-family: "Arial";*/
			margin-top: 15px;
			width: 103px;
			word-wrap: break-word;
			text-align: right;
		}

		.adsValueNote1 {
			width: 103px;
			word-wrap: break-word;
			height: 30px;
			border-style: solid;
			border-width: 2px;
			border-color: black;
			background-color: #C0C0C0;
			font-size: 16;
			text-align: center;
			vertical-align: middle;
		}

		.adsValueNote2 {
			font-size: 16;
			width: 103px;
			height: 30px;
			word-wrap: break-word;
			text-align: center;
			vertical-align: middle;
			border-style: solid;
			border-width: 2px;
			border-color: black;
			background-color: #C0C0C0;
		}

		.termsConditions {
			font-weight: normal;
			font-size: 9;
			font-family: Courier, sans-serif;
		}
	</style>

</head>

<body>
	<img class="qr" src="logoAlsana.png">
	<img id="title" src="tituloAlsana.png">
	<div id="squareFolio">
		<label>&nbsp;&nbsp;NOTA DE VENTA</label>
	</div>
	<div id="squareValueFolio">
		<label><?php echo $json[0]['folio']; ?></label>
	</div>
	<div id="squareDate">
		<label>&nbsp;&nbsp;F E C H A</label>
	</div>
	<div id="squareValueDate">
		<label>&nbsp;<?php echo date("d/m/Y", strtotime($json[0]['fecha'])); ?></label>
	</div>
	<div id="squareCustomer">
		<label>CLIENTE: <?php
						echo $json[0]['nombreCliente'];

						?></label>
	</div>
	<table id="products">
		<tr>
			<th class="colQuantity">CANT.</th>
			<th id="colName">DESCRIPCIÓN</th>
			<th id="colPrice">PRECIO</th>
			<th id="colImport">PAGADO</th>
		</tr>
		<?php
		for ($i = 0; $i < sizeof($json); $i++) {
			echo '<tr class="divValueRow">';
			echo '<td class="valueRow colQuantity">' . $json[$i]['cantidad'] . '</td>';
			echo '<td class="valueRow valueRowName">' . $json[$i]['descripcion'] . '  -  ' . date("d/m/Y", strtotime($json[$i]['fecha'])) . '</td>';
			echo '<td class="valueRow valueRowPrecioImporte">' . $json[$i]['total'] . '</td>';
			echo '<td class="valueRow valueRowPrecioImporte">' . $json[$i]['totalPagado'] . '</td>';
			echo '</tr>';
		}


		?>
		<!--

		<tr class="divValueRow">
		<td class="valueRow colQuantity">123456789</td>
		<td class="valueRow valueRowName">CONST.  DE CONDUCTA A COLOR PERS. aaaaaaaa aaaaaaaa aaaaaaaa aaaaaaaa</td>
		<td class="valueRow valueRowPrecioImporte">$4.00</td>
		<td class="valueRow valueRowPrecioImporte">$122,512.00</td>
		</tr>
		<tr class="divValueRow">
		<td class="valueRow colQuantity">123456789</td>
		<td class="valueRow valueRowName">CONST.  DE CONDUCTA A COLOR PERS. aaaaaaaa aaaaaaaa aaaaaaaa aaaaaaaa</td>
		<td class="valueRow valueRowPrecioImporte">$4.00</td>
		<td class="valueRow valueRowPrecioImporte">$122,512.00</td>
		</tr>		
		<tr class="divValueRow">
		<td class="valueRow colQuantity">123456789</td>
		<td class="valueRow valueRowName">CONST.  DE CONDUCTA A COLOR PERS. aaaaaaaa aaaaaaaa aaaaaaaa aaaaaaaa</td>
		<td class="valueRow valueRowPrecioImporte">$4.00</td>
		<td class="valueRow valueRowPrecioImporte">$122,512.00</td>
		</tr>
		<tr class="divValueRow">
		<td class="valueRow colQuantity">123456789</td>
		<td class="valueRow valueRowName">CONST.  DE CONDUCTA A COLOR PERS. aaaaaaaa aaaaaaaa aaaaaaaa aaaaaaaa</td>
		<td class="valueRow valueRowPrecioImporte">$4.00</td>
		<td class="valueRow valueRowPrecioImporte">$122,512.00</td>
		</tr>				
		<tr class="divValueRow">
		<td class="valueRow colQuantity">123456789</td>
		<td class="valueRow valueRowName">CONST.  DE CONDUCTA A COLOR PERS. aaaaaaaa aaaaaaaa aaaaaaaa aaaaaaaa</td>
		<td class="valueRow valueRowPrecioImporte">$4.00</td>
		<td class="valueRow valueRowPrecioImporte">$122,512.00</td>
		</tr>
		<tr class="divValueRow">
		<td class="valueRow colQuantity">123456789</td>
		<td class="valueRow valueRowName">CONST.  DE CONDUCTA A COLOR PERS. aaaaaaaa aaaaaaaa aaaaaaaa aaaaaaaa</td>
		<td class="valueRow valueRowPrecioImporte">$4.00</td>
		<td class="valueRow valueRowPrecioImporte">$122,512.00</td>
		</tr>
	-->
	</table>
	<div>

		<table class="tabFooter">
			<tr>
				<th>
					<div class="squareTotalLetter">
						CANTIDAD CON LETRA:
						<label><?php echo $json[0]['totalLetra'] ?></label>
					</div>
					<label class="termsConditions">LA PRESENTE NOTA FORMA PARTE DE LA FACTURA DEL PERIODO FISCAL POR VENTAS AL PUBLICO EN GENERAL.<br />Al realizar tu pago estas aceptando nuestros terminos y condiciones,<br />
						LEER EN: https://www.alsanaviajes.mx/terminos-y-condiciones<br />
						Consulta nuestro aviso de privacidad: https://goo.gl/kd9M7q <label class="termsConditions" style="text-decoration: underline;">UNA VEZ CONFIRMADOS TUS LUGARES,<br /> NO HAY CAMBIOS NI CANCELACIONES DE NINGÚN TIPO.</label></label>


				</th>
				<th>
					<div class="adsNote1">
						<p>TOTAL PAGADO</p>
					</div>
					<div class="adsNote2">
						<p>PAGO PENDIENTE</p>
					</div>
				</th>
				<th>
					<div class="adsValueNote1">
						<label><?php echo $json[0]['pagado']  ?></label>
					</div>
					<div class="adsValueNote2">
						<label>
							<?php
							if ($json[0]['restoPago'] == '$0.00') {
								echo 'PAGADO';
							} else {
								echo $json[0]['restoPago'];
							}

							?>

						</label>
					</div>
				</th>
			</tr>
		</table>

	</div>


</body>

</html>
<?php
$content = ob_get_clean();

$bodyHTML = file_get_contents('correoAlsana.html');
//var_dump($json);


$nombreCliente = $json[0]['nombreCliente'];
$emailCliente = $json[0]['emailCliente'];
$nombrePDFVenta = $json[0]['folio'] . '.pdf';

require_once(dirname(__FILE__) . '/../../html2pdf.class.php');

use PHPMailer\PHPMailer\PHPMailer;

require '../../../vendor/autoload.php';

try {
	//REFERENCES https://github.com/spipu/html2pdf/blob/master/doc/output.md
	/**
	 
	Destination where to send the document. It can take one of the following values:
	I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
	D: send to the browser and force a file download with the name given by name.
	F: save to a local server file with the name given by name.
	S: return the document as a string (name is ignored).
	FI: equivalent to F + I option
	FD: equivalent to F + D option
	E: return the document as base64 mime multi-part email attachment (RFC 2045)
	 */
	$html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8');
	$html2pdf->pdf->SetDisplayMode('fullpage');
	$html2pdf->writeHTML($content);


	if ($json[0]['opcionDeEnvioImprimir'] == 1) {
		$html2pdf->Output($nombrePDFVenta);
	} else {
		//$html2pdf->Output($nombrePDFVenta);		
		$pdfReporte = $html2pdf->Output($nombrePDFVenta, 'S');
		$mail = new PHPMailer;
		$mail->isSMTP();
		//muestra el log del proceso al enviar el email
		//$mail->SMTPDebug = 2;
		//host del servidor de email
		$mail->Host = 'smtp.gmail.com';
		//puerto del servidor que se envia, preferentemente NO ssl
		$mail->Port = 587;
		//estandar de caracteres a usar en el email
		$mail->CharSet = 'UTF-8';
		$mail->SMTPAuth = true;
		//si el contenido será html o texto plano
		$mail->isHTML(true);
		//email que envia
		$mail->Username = 'gerencia_ventas@alsanaviajes.com.mx';
		//contraseña que envia
		$mail->Password = 'sorciere12_1';
		//email que recibe,nombre que recibe el contacto
		//$mail->setFrom('marcoa.9722@gmail.com', 'ALSANA VIAJES');
		$mail->setFrom('gerencia_ventas@alsanaviajes.com.mx');
		//$mail->setFrom('marcoa.9722@gmail.com');
		//$mail->addReplyTo('reply-box@hostinger-tutorials.com', 'Your Name');
		$mail->addAddress($emailCliente, $nombreCliente);
		$mail->Subject = 'ALSANA VIAJES';
		$mail->Body = $bodyHTML;
		$mail->AddStringAttachment($pdfReporte, 'comprobante_de_pago.pdf', 'base64', 'application/pdf');
		//$mail->addAttachment('./'.$nombrePDFVenta);
		$mail->send();
		//echo '<script>window.open('.'./'.$nombrePDFVenta', "",'.$sizeWindows.' );</script>';
		//unlink($nombrePDFVenta);	
?>

		<script>
			window.close();
		</script>
<?php
	}
} catch (HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>