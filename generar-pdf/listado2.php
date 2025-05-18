<?php

require('librerias/pdf.php');
include('datos.php');

$cabecera[]=['k'=>'nombre', 't'=>'Nombre', 'w'=>'25',];
$cabecera[]=['k'=>'apellidos', 't'=>'Apellidos', 'w'=>'25'];
$cabecera[]=['k'=>'dni', 't'=>'DNI', 'w'=>'25', 'a'=>'C'];
$cabecera[]=['k'=>'telefono', 't'=>'Teléfono', 'w'=>'25', 'a'=>'C'];

generar_informe($personas, $cabecera, "Listado de personas");


