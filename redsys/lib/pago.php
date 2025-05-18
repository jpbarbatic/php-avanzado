<?php
require('apiRedsys.php');

function realizar_pago($importe, $concepto, $id_pedido, $urlok, $urlko)
{
	$tpv=new RedsysAPI;

	$tpv->setParameter("DS_MERCHANT_AMOUNT", number_format($importe * 100, 0, '', ''));
	$tpv->setParameter("DS_MERCHANT_ORDER", $id_pedido);
	$tpv->setParameter("DS_MERCHANT_MERCHANTCODE", DS_MERCHANT_MERCHANTCODE);
	$tpv->setParameter("DS_MERCHANT_CURRENCY", DS_MERCHANT_CURRENCY);
	$tpv->setParameter("DS_MERCHANT_TRANSACTIONTYPE", 0);
	$tpv->setParameter("DS_MERCHANT_TERMINAL", DS_MERCHANT_TERMINAL);
	$tpv->setParameter("DS_MERCHANT_URLOK", $urlok);
	$tpv->setParameter("DS_MERCHANT_URLKO", $urlko);
	$tpv->setParameter("DS_MERCHANT_MERCHANTNAME", DS_MERCHANT_MERCHANTNAME);
	$tpv->setParameter("DS_MERCHANT_MERCHANTURL", DS_MERCHANT_MERCHANTURL);
	$tpv->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION", $concepto);
    
  $params = $tpv->createMerchantParameters();
  $signature = $tpv->createMerchantSignature(DS_SIGNATURE);
  
  return ['params'=>$params, 'signature'=>$signature];
}

function comprobar_pago()
{
	$tpv=new RedsysAPI;
	
	$version = $_GET["Ds_SignatureVersion"];
	$params = $_GET["Ds_MerchantParameters"];
	$signatureRecibida = $_GET["Ds_Signature"];	

	$decodec = $tpv->decodeMerchantParameters($params);

	$firma = $tpv->createMerchantSignatureNotif(DS_SIGNATURE, $params);
	
	if($firma === $signatureRecibida)
	{
	  return $tpv->getParameter('Ds_Response')==='0000';
	}else{
	  return false;
	}
}

