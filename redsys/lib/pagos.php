<?php
require('../config.php');
require('apiRedsys.php');
require('utils.php');

function realizar_pago($importe, $concepto, $id_pedido)
{
	$tpv=new RedsysAPI;

  $path=dirname(getCurrentURL());
  $urlok=$path.DS_MERCHANT_URLOK;
  $urlko=$path.DS_MERCHANT_URLKO;
  $url_notificacion=$path.DS_MERCHANT_MERCHANTURL;

	$tpv->setParameter("DS_MERCHANT_AMOUNT", number_format($importe * 100, 0, '', ''));
	$tpv->setParameter("DS_MERCHANT_ORDER", $id_pedido);
	$tpv->setParameter("DS_MERCHANT_MERCHANTCODE", DS_MERCHANT_MERCHANTCODE);
	$tpv->setParameter("DS_MERCHANT_CURRENCY", DS_MERCHANT_CURRENCY);
	$tpv->setParameter("DS_MERCHANT_TRANSACTIONTYPE", 0);
	$tpv->setParameter("DS_MERCHANT_TERMINAL", DS_MERCHANT_TERMINAL);
	$tpv->setParameter("DS_MERCHANT_URLOK", $path.DS_MERCHANT_URLOK);
	$tpv->setParameter("DS_MERCHANT_URLKO", $path.DS_MERCHANT_URLKO);
	$tpv->setParameter("DS_MERCHANT_MERCHANTNAME", DS_MERCHANT_MERCHANTNAME);
	$tpv->setParameter("DS_MERCHANT_MERCHANTURL", $path.DS_MERCHANT_MERCHANTURL);
	$tpv->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION", $concepto);
    
  $params = $tpv->createMerchantParameters();
  $signature = $tpv->createMerchantSignature(DS_SIGNATURE);
  
  return ['params'=>$params, 'signature'=>$signature];
}

function notificacion_pago_cliente($version, $params, $signatureRecibida)
{
	$tpv=new RedsysAPI;
	$decodec = $tpv->decodeMerchantParameters($params);
	$firma = $tpv->createMerchantSignatureNotif(DS_SIGNATURE, $params);
	
	if($firma === $signatureRecibida)
	{
	  return $tpv->vars_pay;
	}else{
	  return false;
	}
}

function actualizar_log_pagos($transaccion)
{
    $f='../pagos.csv';
 
    // Si el fichero no existe o si existe y está vacío añadimos la cabecera
    if(!file_exists($f) or (file_exists($f) and filesize($f)==0)){
      file_put_contents($f, "Fecha;Hora;Id Pedido;Importe;Núm. tarjeta;Estado\n", FILE_APPEND);
    }
    
    $linea='';
    $linea.=$transaccion['fecha'].";";
    $linea.=$transaccion['hora'].";";
    $linea.=$transaccion['id_pedido'].";";
    $linea.=$transaccion['importe'].";";
    $linea.=$transaccion['num_tarjeta'].";";
    $linea.=$transaccion['resultado_pago']."\n";

    file_put_contents($f, $linea, FILE_APPEND);
}

function notificacion_pago_web($version, $params, $signatureRecibida){
	$tpv=new RedsysAPI;
	$decodec = $tpv->decodeMerchantParameters($params);
	$firma = $tpv->createMerchantSignatureNotif(DS_SIGNATURE, $params);

  if($firma === $signatureRecibida){
  
    $params=$tpv->vars_pay;
    // Obtenemos los campos que van a hacer falta para generar el CVS y el envío del correo
    $transaccion['importe']=number_format(floatval($params['Ds_Amount'])/100, 2, ',');
    $transaccion['id_pedido']=$params['Ds_Order'];
    $transaccion['fecha']=urldecode($params['Ds_Date']);
    $transaccion['hora']=urldecode($params['Ds_Hour']);
    $transaccion['num_tarjeta']=$params['Ds_Card_Number'];
    $transaccion['resultado_pago']=urldecode($params['Ds_Response_Description']);  
    
    // Actualizamos fichero de logs de pagos  
    actualizar_log_pagos($transaccion);
    
    // Enviamos un correo 
    $html=crear_mensaje_plantilla('../vistas/email.html.php', $transaccion);
    enviar_mail(MAIL_DESTINATARIO, 'Nueva transacción', $html);
    
	}else{
	  return false;
	}
}
