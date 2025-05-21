<?php
require('../lib/pagos.php');
require('../lib/email.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
  $version = isset($_POST["Ds_SignatureVersion"]) ? $_POST["Ds_SignatureVersion"] : null ;
  $params = isset($_POST["Ds_MerchantParameters"]) ? $_POST["Ds_MerchantParameters"] : null;
  $signatureRecibida = isset($_POST["Ds_Signature"]) ? $_POST["Ds_Signature"] : null;

  if($version==null or $params==null or $signatureRecibida==null){
    exit;
  }

  notificacion_pago_web($version, $params, $signatureRecibida);
}
