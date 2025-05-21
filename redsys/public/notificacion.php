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
    $transaccion['importe']=number_format(floatval($params['Ds_Amount'])/100, 2, ',');
    $transaccion['id_pedido']=$params['Ds_Order'];
    $transaccion['fecha']=urldecode($params['Ds_Date']);
    $transaccion['hora']=urldecode($params['Ds_Hour']);
    $transaccion['num_tarjeta']=$params['Ds_Card_Number'];
    $transaccion['resultado_pago']=urldecode($params['Ds_Response_Description']);
    
    $f='../pagos.csv';

    print_r($params);
    
    // Si el fichero no existe o si existe y está vacío añadimos la cabecera
    if(!file_exists($f) or (file_exists($f) and filesize($f)==0)){
      file_put_contents($f, "Fecha;Hora;Id Pedido;Importe;Núm. tarjeta;Estado\n", FILE_APPEND);
    }
    
    $linea='';
    $linea.=$transaccion['fecha'].";";
    $linea.=$transaccion['hora'].";";
    $linea.=$transaccion['id_pedido'].";";
    $linea.=$transaccion['num_tarjeta'].";";
    $linea.=$transaccion['resultado_pago']."\n";

    file_put_contents($f, $linea, FILE_APPEND);
    
    // Enviamos un correo 
    $html=crear_mensaje_plantilla('../vistas/email.html.php', $transaccion);
    enviar_mail(MAIL_DESTINATARIO, 'Nueva transacción', $html);
  }
}
