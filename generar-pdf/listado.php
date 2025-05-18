<?php

require('librerias/pdf.php');
$paises = [
    [
        "pais" => "Austria",
        "capital" => "Vienna",
        "area" => 83859,
        "poblacion" => 8075
    ],
    [
        "pais" => "Belgium",
        "capital" => "Brussels",
        "area" => 30518,
        "poblacion" => 10192
    ],
    [
        "pais" => "Denmark",
        "capital" => "Copenhagen",
        "area" => 43094,
        "poblacion" => 5295
    ],
    [
        "pais" => "Finland",
        "capital" => "Helsinki",
        "area" => 304529,
        "poblacion" => 5147
    ],
    [
        "pais" => "France",
        "capital" => "Paris",
        "area" => 543965,
        "poblacion" => 58728
    ],
    [
        "pais" => "Germany",
        "capital" => "Berlin",
        "area" => 357022,
        "poblacion" => 82057
    ],
    [
        "pais" => "Greece",
        "capital" => "Athens",
        "area" => 131625,
        "poblacion" => 10511
    ],
    [
        "pais" => "Ireland",
        "capital" => "Dublin",
        "area" => 70723,
        "poblacion" => 3694
    ],
    [
        "pais" => "Italy",
        "capital" => "Roma",
        "area" => 301316,
        "poblacion" => 57563
    ],
    [
        "pais" => "Luxembourg",
        "capital" => "Luxembourg",
        "area" => 2586,
        "poblacion" => 424
    ],
    [
        "pais" => "Netherlands",
        "capital" => "Amsterdam",
        "area" => 41526,
        "poblacion" => 15654
    ],
    [
        "pais" => "Portugal",
        "capital" => "Lisbon",
        "area" => 91906,
        "poblacion" => 9957
    ],
    [
        "pais" => "Spain",
        "capital" => "Madrid",
        "area" => 504790,
        "poblacion" => 39348
    ],
    [
        "pais" => "Sweden",
        "capital" => "Stockholm",
        "area" => 410934,
        "poblacion" => 8839
    ],
    [
        "pais" => "United Kingdom",
        "capital" => "London",
        "area" => 243820,
        "poblacion" => 58862
    ]
];

$cabecera[]=['k'=>'pais', 't'=>'País', 'w'=>'25'];
$cabecera[]=['k'=>'capital', 't'=>'Capital', 'w'=>'25'];
$cabecera[]=['k'=>'area', 't'=>'Área', 'w'=>'25'];
$cabecera[]=['k'=>'poblacion', 't'=>'Población', 'w'=>'25'];

generar_informe($paises, $cabecera, "Listado de paises");


