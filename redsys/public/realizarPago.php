<?php
require('../config.php');
require('../lib/pagos.php');

if ($_POST['realizar_pedido']) {
  $id = $_POST['id_pedido'];
  $importe = floatval(str_replace(',', '.', str_replace('.', '', $_POST['importe'])));

  $pago = firmar_pago($importe, $_POST['concepto'], $id);

  $titulo = "Realizar pago";
  $vista = 'formularioPago';
  require('../vistas/plantilla.html.php');
}
