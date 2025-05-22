<?php
require('apiRedsys.php');
require('email.php');
require('utils.php');

function firmar_pago($importe, $concepto, $id_pedido)
{
  $tpv = new RedsysAPI;

  $path = dirname(getCurrentURL());
  $urlok = $path . DS_MERCHANT_URLOK;
  $urlko = $path . DS_MERCHANT_URLKO;
  $url_notificacion = $path . DS_MERCHANT_MERCHANTURL;

  $tpv->setParameter("DS_MERCHANT_AMOUNT", number_format($importe * 100, 0, '', ''));
  $tpv->setParameter("DS_MERCHANT_ORDER", $id_pedido);
  $tpv->setParameter("DS_MERCHANT_MERCHANTCODE", DS_MERCHANT_MERCHANTCODE);
  $tpv->setParameter("DS_MERCHANT_CURRENCY", DS_MERCHANT_CURRENCY);
  $tpv->setParameter("DS_MERCHANT_TRANSACTIONTYPE", 0);
  $tpv->setParameter("DS_MERCHANT_TERMINAL", DS_MERCHANT_TERMINAL);
  $tpv->setParameter("DS_MERCHANT_URLOK", $path . DS_MERCHANT_URLOK);
  $tpv->setParameter("DS_MERCHANT_URLKO", $path . DS_MERCHANT_URLKO);
  $tpv->setParameter("DS_MERCHANT_MERCHANTNAME", DS_MERCHANT_MERCHANTNAME);
  $tpv->setParameter("DS_MERCHANT_MERCHANTURL", $path . DS_MERCHANT_MERCHANTURL);
  $tpv->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION", $concepto);

  $params = $tpv->createMerchantParameters();
  $signature = $tpv->createMerchantSignature(DS_SIGNATURE);

  return ['params' => $params, 'signature' => $signature];
}

function comprobar_firma($version, $params, $signatureRecibida)
{
  $tpv = new RedsysAPI;
  $decodec = $tpv->decodeMerchantParameters($params);
  $firma = $tpv->createMerchantSignatureNotif(DS_SIGNATURE, $params);

  if ($firma === $signatureRecibida) {
    $transaccion['importe'] = number_format(floatval($tpv->getParameter('Ds_Amount')) / 100, 2, ',');
    $transaccion['id_pedido'] = $tpv->getParameter('Ds_Order');
    $transaccion['fecha'] = urldecode($tpv->getParameter('Ds_Date'));
    $transaccion['hora'] = urldecode($tpv->getParameter('Ds_Hour'));
    $transaccion['num_tarjeta'] = $tpv->getParameter('Ds_Card_Number');
    $transaccion['resultado_pago'] = urldecode($tpv->getParameter('Ds_Response_Description'));
    $transaccion['estado']=$tpv->getParameter('Ds_Response')==='0000';
    return $transaccion;
  }else{
    false;
  }
}

function actualizar_log_pagos($transaccion)
{
  $f = '../pagos.csv';

  // Si el fichero no existe o si existe y está vacío añadimos la cabecera
  if (!file_exists($f) or (file_exists($f) and filesize($f) == 0)) {
    file_put_contents($f, "Fecha;Hora;Id Pedido;Importe;Núm. tarjeta;Estado\n", FILE_APPEND);
  }

  $linea = '';
  $linea .= $transaccion['fecha'] . ";";
  $linea .= $transaccion['hora'] . ";";
  $linea .= $transaccion['id_pedido'] . ";";
  $linea .= $transaccion['importe'] . ";";
  $linea .= $transaccion['num_tarjeta'] . ";";
  $linea .= $transaccion['resultado_pago'] . "\n";

  file_put_contents($f, $linea, FILE_APPEND);
}

function notificacion_pago_web($version, $params, $signatureRecibida)
{
  $transaccion=comprobar_firma($version, $params, $signatureRecibida);
  if ($transaccion) {
    // Actualizamos fichero de logs de pagos  
    actualizar_log_pagos($transaccion);

    // Enviamos un correo 
    $html = crear_mensaje_plantilla('../vistas/email.html.php', $transaccion);
    enviar_mail(MAIL_DESTINATARIO, 'Nueva transacción', $html);
  } else {
    return false;
  }
}
