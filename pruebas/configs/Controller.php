<?php

namespace Configs;
/**
 * Verifica la seguridad de las peticiones, 
 * las integra como propiedades de un objeto para su facil acceso
 */
class Controller
{

    // Propiedad donde se almacena la información de la petición
    protected object $request;

    public function __construct()
    {
        $this->Unauthorized();
        $this->request = $this->GenerarRequest();
    }

    /**
     * Genera la autorización de peticiones post,
     * Si una petición post no contiene el token no sera valida,
     * si el token es diferente de la sesión actual la petición se anulara
     */
    private function Unauthorized(): void
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token'])) {
                header("HTTP/1.0 401 Unauthorized");
                exit();
            }
            if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                header("HTTP/1.0 401 Unauthorized");
                exit();
            }
        }
    }

    /**
     * Crea un objeto de la petición,
     * El metodo, dos boolean si es post o get, las variables POST, las variables GET y adicional el token
     */
    private function GenerarRequest(): object
    {
        $properties = (object) [
            "metodo" => $_SERVER["REQUEST_METHOD"] === "POST" ? "POST" : "GET",
            "isPost" =>  $_SERVER["REQUEST_METHOD"] === "POST",
            "isGet" => $_SERVER["REQUEST_METHOD"] === "GET",
            "post" => $_POST,
            "get" => $this->ParamsGet(),
            "csrf_token" => $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['csrf_token']) ? $_POST['csrf_token'] : ""
        ];
        return $properties;
    }

    /**
     * Genera los parametros get como objeto para asignarlos a la propiedad request
     */
    private function ParamsGet(): object
    {
        $params = [];
        $url = isset($_GET['url']) ? $_GET['url'] : "";
        $part = explode("/", $url);
        for ($i = 0; $i < count($part); $i++)
            array_push($params, $part[$i]);
        return (object) $params;
    }

}
