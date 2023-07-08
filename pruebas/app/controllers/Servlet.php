<?php

namespace Controllers;

/**
 * Controla los procesos de peticiones del usuario
 * desglosa la url en Controller, Function y Params
 * Controller: reservado para seleccionar un controlador especifico,
 * Function: para acceder a la funcion o metodo del controlador
 * Params: arreglo para agregar mas parametros get
 */
class Servlet
{
    // Propiedades para procesamientos
    private string $function = "";
    private string $controller = "";
    private string $url = "";

    function __construct()
    {
    }

    // logica de procesamiento de request y response
    public function Procesar(): void
    {
        $this->Init();
        if ($this->controller === "") {
            header("Location: " . URL . "principal");
            exit();
        }
        $class = "";
        if ($this->controller === 'Principal') {
            $class = new ControllerPrincipal();
        }

        if (method_exists($class, $this->function))
            call_user_func([$class, $this->function]);
        else
            RedirectBad();
        //var_dump([method_exists($class, $this->function), $this->controller, $this->function, $class]);
    }



    // Inicializa las propiedades de procesamiento
    private function Init(): void
    {
        /**
         * Para el caso de procesamientos se asume que todas son GET,
         * Cuando se realiza una peticion POST el controlador debe manejar el tipo de petición,
         * cada controller debe tener un metodo Index para inicializar la vista correspondiente
         * o manejar a conveniencia. 
         */
        $this->url = isset($_GET['url']) ? $_GET['url'] : "";
        if ($this->url !== "") {
            $part = explode("/", $this->url);
            $this->controller = ucfirst($part[0]);
            $this->function = isset($part[1]) ? ucfirst($part[1]) : "Index";
        }
    }
}
