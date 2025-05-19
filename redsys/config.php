<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de tpv Redsys
define('TPV_URL', 'https://sis-t.redsys.es:25443/sis/realizarPago');  // Sandbox
//define('TPV_URL', 'https://sis.redsys.es/sis/realizarPago');        // Producción

define('DS_SIGNATURE_VERSION', 'HMAC_SHA256_V1');

define('DS_MERCHANT_MERCHANTCODE', '999008881');
define('DS_MERCHANT_TERMINAL', '1');
define('DS_SIGNATURE', 'sq7HjrUOBfKmC576ILgskD5srU870gJ7');

define('DS_MERCHANT_MERCHANTNAME', 'Mi empresa S.A.');
define('DS_MERCHANT_MERCHANTURL', '/notificacion.php');

define('DS_MERCHANT_CURRENCY', '978');
define('DS_MERCHANT_CONSUMERLANGUAGE', '001');

define('DS_MERCHANT_URLOK', '/estadoPago.php');
define('DS_MERCHANT_URLKO', '/estadoPago.php');
