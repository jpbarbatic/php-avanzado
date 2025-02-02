<?php
require('../config.php');
require("../librerias/email.php");
session_start();

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $email=$_REQUEST['email'];
    $asunto=$_REQUEST['asunto'];
    $mensaje=$_REQUEST['mensaje'];

    $html=crear_mensaje_plantilla('../plantillas/easter.php', ['usuario'=>'jpbarba']);
    if(enviar_mail($email, $asunto, $mensaje))
    {
      $_SESSION['ok']='Mensaje enviado correctamente';
    }else
    {
      $_SESSION['error']='Se ha producido un error';
    }   
    
    header('Location: index.php');
}
