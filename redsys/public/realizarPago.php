<?php
require('../config.php');
require('../lib/pago.php');

if($_POST['realizar_pedido']){
  $id=$_POST['id_pedido'];
  $importe=floatval(str_replace(',', '.', str_replace('.', '', $_POST['importe'])));
  $res=realizar_pago($importe, $_POST['concepto'], $id);

  $titulo="Realizar pago";
  $vista='formularioPago';
  require('../vistas/plantilla.html.php');
}

?>

