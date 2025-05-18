<?php
require('../config.php');
require('../lib/pago.php');

function getCurrentURL() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host     = $_SERVER['HTTP_HOST'];
    $uri      = $_SERVER['REQUEST_URI'];

    return $protocol . "://" . $host . $uri;
}

if($_POST['realizar_pedido']){
  $id=$_POST['id_pedido'];
  $importe=floatval(str_replace(',', '.', str_replace('.', '', $_POST['importe'])));

  $path=dirname(getCurrentURL());
  $urlok=$path.DS_MERCHANT_URLOK;
  $urlko=$path.DS_MERCHANT_URLKO;
  
  $res=realizar_pago($importe, $_POST['concepto'], $id, $urlok, $urlko);


  $titulo="Realizar pago";
  $vista='formularioPago';
  require('../vistas/plantilla.html.php');
}

