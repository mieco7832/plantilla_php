<?php
// Icluye el archivo de Servlet
include_once $_SERVER['DOCUMENT_ROOT'] . "/configs/Config.php";

use Controllers\Servlet;

// Crea la instancia de logica para procesar peticiones
$servlet = new Servlet();
$servlet->Procesar();
