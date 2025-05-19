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

function notificacion_pago_web($version, $params, $signatureRecibida){
	$tpv=new RedsysAPI;
	$decodec = $tpv->decodeMerchantParameters($params);
	$firma = $tpv->createMerchantSignatureNotif(DS_SIGNATURE, $params);

  if($firma === $signatureRecibida){
    //Realizamos una acción
    return $tpv->vars_pay;
	}else{
	  return false;
	}
}
