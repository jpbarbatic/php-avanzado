# Ejemplo de integración de plataforma de pago Redsys en PHP usando redirección

## Funcionamiento

Cambiar el config-ejemplo.php a config.php y entrar en carpeta *public*

## Integración por redirección

Utiliza el API por redirección (en vez de API Rest). Cuando finaliza el pago se realiza una redirección
a las **url_ok** o **url_ko** dependiendo de si se ha realizado correctamente o no (petición GET). En la página se pueden mostrar 
los parámetros de la petición del pago.

Además se desde la pasarela de pago se realiza una petición POST con una notificación que puede ser utilizada 
para poder realizar una gestión interna dentro de la aplicación

Para probar la notificación a la web, esta no tiene que estar en un servidor accesible (no funciona con localhost)

- https://pagosonline.redsys.es/desarrolladores-inicio/documentacion-tipos-de-integracion/desarrolladores-redireccion/

```mermaid
  graph TD;
      A-->B;
      A-->C;
      B-->D;
      C-->D;
```

## Datos comercio de prueba

| Código de Comercio |  (FUC)	Terminal	|  Clave de firma SHA-256           |
|--------------------|------------------|-----------------------------------|
| 999008881          |     	 001        | sq7HjrUOBfKmC576ILgskD5srU870gJ7  |


## Tarjetas de prueba

- https://pagosonline.redsys.es/desarrolladores-inicio/integrate-con-nosotros/tarjetas-y-entornos-de-prueba/

## Descargas y documentación de Redsys

- https://pagosonline.redsys.es/desarrolladores-inicio/integrate-con-nosotros/area-de-descargas-y-documentacion/


## Entorno de administración

- https://sis-t.redsys.es:25443/admincanales-web/index.jsp#/login?highlightTrialUser=true

