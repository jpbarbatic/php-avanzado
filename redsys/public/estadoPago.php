<?php
require('../lib/pago.php');

if($_SERVER['REQUEST_METHOD']=='GET')
{
	$version = isset($_GET["Ds_SignatureVersion"]) ? $_GET["Ds_SignatureVersion"] : null ;
	$params = isset($_GET["Ds_MerchantParameters"]) ? $_GET["Ds_MerchantParameters"] : null;
	$signatureRecibida = isset($_GET["Ds_Signature"]) ? $_GET["Ds_Signature"] : null;
	
	if($version==null or $params==null or $signatureRecibida==null)
	{
	  exit;
	}
	
  $params=notificacion_pago_cliente($version, $params, $signatureRecibida);
  $res=$params['Ds_Response']==='0000';
  
  $titulo="Resultado del pago";
  $vista='notificacionPago';
  require('../vistas/plantilla.html.php');
}
