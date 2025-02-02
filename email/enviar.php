<?php
require('config.php');
require("utilidades/email.php");

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $email=$_REQUEST['email'];
    $asunto=$_REQUEST['asunto'];
    $mensaje=$_REQUEST['mensaje'];

    $html=crear_mensaje_plantilla('plantillas/easter.php', ['usuario'=>'jpbarba']);
    enviar_mail($email, $asunto, $mensaje);
}
