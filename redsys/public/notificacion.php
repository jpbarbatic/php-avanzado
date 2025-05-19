<?php
require('../lib/pago.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
  $version = isset($_POST["Ds_SignatureVersion"]) ? $_POST["Ds_SignatureVersion"] : null ;
  $params = isset($_POST["Ds_MerchantParameters"]) ? $_POST["Ds_MerchantParameters"] : null;
  $signatureRecibida = isset($_POST["Ds_Signature"]) ? $_POST["Ds_Signature"] : null;

  if($version==null or $params==null or $signatureRecibida==null){
    return false;
  }

  $params=notificacion_pago_web($version, $params, $signatureRecibida);

  if($params){
     // Si la notificación es correcta, guardamos la orden de pago en un fichero CSV    
    $params['Ds_Amount']=number_format(floatval($params['Ds_Amount'])/100, 2, ',');
    $f='../pagos.csv';
    print_r($params);
    // Si el fichero no existe o si existe y está vacío añadimos la cabecera
    if(!file_exists($f) or (file_exists($f) and filesize($f)==0))
    {
      file_put_contents($f, implode(';',array_keys($params))."\n", FILE_APPEND);
    }

    file_put_contents($f, urldecode(implode(';',array_values($params)))."\n", FILE_APPEND);
  }
}
