<?php
require('../config.php');
require("../librerias/email.php");
session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_REQUEST['email'];
    $asunto=$_REQUEST['asunto'];
    $mensaje=$_REQUEST['mensaje'];

    //$mensaje=crear_mensaje_plantilla('../plantillas_correo/alta_usuario.php', ['usuario'=>'pepeitor']);
    if(enviar_mail($email, $asunto, $mensaje)){
      $_SESSION['ok']='Mensaje enviado correctamente';
    }else{
      $_SESSION['error']='Se ha producido un error';
    }   
    
    header('Location: index.php');
}
