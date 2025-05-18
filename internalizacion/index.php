<?php
$lang=isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'es_ES';
// 1️⃣ Forzar el idioma a inglés (en_US)
putenv("LC_ALL=".$lang.".UTF-8");
setlocale(LC_ALL, $lang.".UTF-8");

// 2️⃣ Especificar la ruta de los archivos de traducción
bindtextdomain("mensajes", __DIR__ . "/locales");
textdomain("mensajes");

// 3️⃣ Asegurar que se use UTF-8
bind_textdomain_codeset("mensajes", "UTF-8");

// 4️⃣ Prueba la traducción
echo gettext("Hola, Mundo!") . "<br>";
echo _("Bienvenido a mi sitio web") . "<br>"; // Equivalente a gettext()

?>

<a href="?lang=es_ES">Español</a>
<a href="?lang=en_US">Inglés</a
