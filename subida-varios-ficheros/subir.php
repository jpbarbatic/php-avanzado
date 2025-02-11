<?php
// Comprobamos que existe $_FILES y no está vacía

if(isset($_FILES['fotos']) and !empty($_FILES['fotos'])){
  foreach($_FILES['fotos']['tmp_name'] as $i=>$name)
  {
    $destino=__DIR__."/imagenes/".$_FILES['fotos']['name'][$i];
    echo "<p>Copiando $name a $destino</p>";
    copy($name, $destino);
  }
}else
{
  echo "<p>No hay ficheros</p>";
}

