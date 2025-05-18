# Ejemplo de uso de la librería PHPMail

## Configuración
- Cambiar el nombre de *config-ejemplo.php* a *config.php*. Poner los parámetros para el envío de los correos.
- Si vas a usar una cuenta de Google, mirár en esta dirección como generar la contraseña: https://www.kodetop.com/como-enviar-correos-con-php-y-gmail/
- Entrar a través del navegador en la carpeta *public*

## Uso
El ejemplo usa una libreria *email.php*. Esta libreria simplifica aún más el uso de la librería PhpMailer.
La librería permite usar plantillas (altas de usuarios, pedidos, etc), de forma que pasándole los datos, estos son colocados automáticamente.
```php
    ...
    $email=$_REQUEST['email'];
    $asunto=$_REQUEST['asunto'];
    $mensaje=$_REQUEST['mensaje'];

    //$mensaje=crear_mensaje_plantilla('../plantillas/alta_usuario.php', ['usuario'=>'pepeitor']);
    if(enviar_mail($email, $asunto, $mensaje))
    {
      $_SESSION['ok']='Mensaje enviado correctamente';
    }else
    {
      $_SESSION['error']='Se ha producido un error';
    }
    ...
```



