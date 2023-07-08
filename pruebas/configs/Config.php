<?php

// Constantes
define("APP_NAME", "Pruebas de MVC");
define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT'] . "/", true);
define("SERVER_NAME", $_SERVER['SERVER_NAME'], TRUE);
define("PROTOCOL", isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http');
define("URL", PROTOCOL . "://" . SERVER_NAME . "/");
define("DEVELOP_MODE", TRUE, TRUE);


// Valida reportes de error para desarrollo
if (DEVELOP_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Iniciar la sesión
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Funciones globales
/**
 * SPL_AUTOLOAD_REGISTER inicializa de forma automatica las clases 
 */
spl_autoload_register(function (string $className) {
    $classPath = DOCUMENT_ROOT . "app/" .  lcfirst(str_replace('\\', '/', $className));
    if (file_exists($classPath . '.php')) {
        require_once $classPath . '.php';
        return;
    }
    require_once DOCUMENT_ROOT . "configs/Database.php";
    require_once DOCUMENT_ROOT . "configs/Controller.php";
    require_once DOCUMENT_ROOT . "configs/Validaciones.php";
});

/**
 * Make View crea una plantilla de vistas,
 * View: es el nombre la la vista, debe estar en la carpeta por defecto asignada,
 * Titulo: para cambiar el label de las pestañas en el navegador,
 * Mensaje: para mostrar un mensaje desde la vista al usuario, 
 * Alerta: segun el tema o framework en uso, se puede utilizar para clasificar el mensaje,
 * Params: agrega otros parametros para mostrar en la vista,
 * Links: para utilizar una nueva hoja de estilo en la vista
 * JsSources: para agragar un nuevo javascript en la vista
 */
function MakeView(string $view, string $titulo = null, string $mensaje = "", string $alerta = "", array $params = [], array $links = [], array $jsSources = []): void
{
    unset($_SESSION['alerta']);
    unset($_SESSION['mensaje']);
    include DOCUMENT_ROOT . "app/views/component/head.php";
    include DOCUMENT_ROOT . "app/views/$view.php";
    include DOCUMENT_ROOT . "app/views/component/js.php";
    exit();
}

// Redirecciona a una vista 
function RedirectView(string $view = "")
{
    header("Location: " . URL . $view);
    exit;
}

// Redirecciona a la vista anterior 
function RedirectBack()
{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Redirección en caso no exista el controlados, codigo 404
function RedirectBad(): void
{
    header("HTTP/1.0 404 Not Found");
    exit();
}

/**
 * Funcion de session
 */

function Sesion(string $nombre, string $value = "") : string
{
    if($value === ""){
        if (isset($_SESSION[$nombre]))
            return $_SESSION[$nombre];
        else
            return "";
    }else{
        $_SESSION[$nombre] = $value;
        return $value;
    }
}


