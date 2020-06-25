<?php 

//require __DIR__.'/vendor/autoload.php';
//echo getcwd();
require_once '../assets/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;

ob_start();
require_once 'reporteAlsana.php';
$html = ob_get_clean();
$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
$html2pdf->writeHTML($html);
$nombreReporte = $imprimirVenta['folio'];
$html2pdf->output($nombreReporte.'.pdf');


?>