<h1>PDF con TCPDF</h1>
<p>Este es un ejemplo de cómo generar un PDF usando <strong>TCPDF</strong> con PHP.</p>
<p>Código de barras:</p>
<img src="data:image/svg+xml;base64,<?=$codigo_barras?>" style="width: 100px;">
<p>Fecha: <?php echo date("d/m/Y") ?></p>
<div>
<img src="data:image/svg+xml;base64,<?=$qr?>">
</div>
<ul>
    <li>Texto normal y formateado</li>
    <li>Listas y párrafos</li>
    <li>Tablas simples</li>
    <li>Imágenes</li>
</ul>
<img style="width: 100px;" src="logo.png">
<p style="color: red;">También acepta estilos CSS básicos.</p>
<h2>Tabla</h2>
<table border="1">
  <tr style="text-align: center;">
    <td>Lunes</td>
    <td>Martes</td>
    <td>Miércoles</td>
    <td>Jueves</td>
    <td>Viernes</td>
  </tr>
  
  <tr style="text-align: center;">
    <td>IAW</td>
    <td>IAW</td>
    <td>SRI</td>
    <td>SDA</td>
    <td>SDA</td>
  </tr>
  <tr style="text-align: center;">
    <td>IAW</td>
    <td>IAW</td>
    <td>SRI</td>
    <td>SDA</td>
    <td>SDA</td>
  </tr>
  <tr style="text-align: center;">
    <td>IAW</td>
    <td>IAW</td>
    <td>SRI</td>
    <td>SDA</td>
    <td>SDA</td>
  </tr>
</table>
