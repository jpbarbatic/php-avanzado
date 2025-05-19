<?php
require('../lib/pago.php');
require('../lib/email.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
  $version = isset($_POST["Ds_SignatureVersion"]) ? $_POST["Ds_SignatureVersion"] : null ;
  $params = isset($_POST["Ds_MerchantParameters"]) ? $_POST["Ds_MerchantParameters"] : null;
  $signatureRecibida = isset($_POST["Ds_Signature"]) ? $_POST["Ds_Signature"] : null;

  if($version==null or $params==null or $signatureRecibida==null){
    return false;
  }

  $params=notificacion_pago_web($version, $params, $signatureRecibida);
  
  // Si la notificación es correcta
  if($params){     
     // Obtenemos los campos que van a hacer falta para generar el CVS y el envío del correo
    $importe=number_format(floatval($params['Ds_Amount'])/100, 2, ',');
    $id_pedido=$params['Ds_Order'];
    $fecha=$params['Ds_Date'];
    $hora=$params['Ds_Hour'];
    $num_tarjeta=$params['Ds_Card_Number'];
    $resultado_pago=$params['Ds_Response_Description'];
    
    $f='../pagos.csv';

    print_r($params);
    // Si el fichero no existe o si existe y está vacío añadimos la cabecera
    if(!file_exists($f) or (file_exists($f) and filesize($f)==0))    {
      file_put_contents($f, "Fecha;Hora;Id Pedido;Importe;Núm. tarjeta;Estado\n", FILE_APPEND);
    }

    file_put_contents($f, urldecode(implode(';',array_values([$fecha,$hora, $id_pedido, $importe, $num_tarjeta,$resultado_pago])))."\n", FILE_APPEND);
    
    enviar_mail('jpbarba@gmail.com', 'Pago realizado', 'Se ha realizado un pago de '.$importe);
  }
}
