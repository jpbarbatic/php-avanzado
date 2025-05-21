<?php

function getCurrentURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host     = $_SERVER['HTTP_HOST'];
    $uri      = $_SERVER['REQUEST_URI'];

    return $protocol . "://" . $host . $uri;
}