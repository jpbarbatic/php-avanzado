<?php
require('librerias/pdf.php');

$codigo_barras=generar_codigo_barras_tcpdf('EAN13', '8480000047175', ['w'=>200]);
$qr=generar_qr('Hola');
generar_pdf('plantillas/ejemplo.pdf.php', 'Ejemplo HTML', ['codigo_barras'=>$codigo_barras, 'qr'=>$qr]);
