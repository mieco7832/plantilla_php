<?php

namespace Controllers;

use Configs\Controller;
use Configs\Validaciones;
use Models\Usuario;

/**
 * Clase para crear una vista principal,
 * de esta se crean los usuarios y tiene como objetivo un login
 * la estructura de una controller es validar el metodo y los input
 * luego se llama las clases correspondientes, según logica de negocio.
 *  
 * Para validar el metodo se utiliza la propiedad isGet o isPost.
 * Para validar los input se utiliza el metodo ValidarInput.
 * 
 * Cuando se valida todo lo necesario se utilizan los metodos correspondientes, 
 * usualmente para los usuarios se valida a nivel de base de datos
 * que no exista un registro con los mismos datos, 
 * luego se puede crear el registro. 
 * 
 * Para el uso de las alertas o mensajes para el usuario, 
 * se implementa la logica de la superglobal $_SESSION
 * de esta manera facilita el empleo de alertas solo por un request y response. 
 * 
 * Para requerir las vistas se creo un metodo donde se establece una plantilla
 * Head, Body y JS, de esta manera solo se trabaja en el body.
 * Para requerir una vista solo vasta con utilizar el metodo MakeView. 
 */
class ControllerPrincipal extends Controller
{

    // Clase para validar los parametros de entrada
    private Validaciones $validar;

    public function __construct()
    {
        // Inicializa las instancias
        parent::__construct();
        $this->validar = new Validaciones();
    }

    // Muestra una vista principal
    public function Index(): void
    {
        if ($this->request->isGet) {
            $alerta = Sesion("alerta");
            $mensaje = Sesion("mensaje");
            MakeView("home", "Inicio - " . APP_NAME, $mensaje, $alerta);
        } else {
            RedirectBad();
        }
    }

    // Muestra el formulario para crear usuarios
    public function CrearUsuario(): void
    {
        if ($this->request->isGet) {
            $alerta = Sesion("alerta");
            $mensaje = Sesion("mensaje");
            MakeView("formUsuario", "Crear Usuario - " . APP_NAME , $mensaje, $alerta);
        } else {
            RedirectBad();
        }
    }

    // Metodo para la creación de usuario
    public function CrearCuenta(): void
    {
        if ($this->request->isPost) {
            $us = new Usuario();
            $us->nombre = $this->validar->ValidarInput('nombre', "text", 2, 50, true);
            $us->mail = $this->validar->ValidarInput('mail', "email", 8, 120, true);
            $us->clave = $this->validar->ValidarInput('clave', "password", 8, 50, true);
            if ($this->validar->getEstado()) {
                Sesion('alerta', "danger");
                Sesion('mensaje', $this->validar->getMensaje());
                RedirectBack();
            }
            $us->ReadById();
            if (!$us->IsNotEmpty()) {
                $us->Create();
                // Almacenar datos en $_SESSION
                Sesion('alerta', "success");
               Sesion('mensaje', "¡Hola, $us->nombre! Gracias por enviar tus datos.");
                RedirectView("principal/validacion");
            } else {
                Sesion('alerta', "warning");
               Sesion('mensaje', "El usuario $us->mail ya existe.");
                RedirectBack();
            }
        } else {
            RedirectBad();
        }
    }

    // Metodo para validar que el usaurio existe
    public function IniciarSession(): void
    {
        if ($this->request->isPost) {
            $us = new Usuario();
            $us->mail = $this->validar->ValidarInput('mail', "email", 8, 120, true);
            $us->clave = $this->validar->ValidarInput('clave', "password", 8, 50, true);
            if ($this->validar->getEstado()) {
                Sesion('alerta', "danger");
               Sesion('mensaje', $this->validar->getMensaje());
                RedirectBack();
            }
            $us->LogIn();
            if ($us->IsNotEmpty()) {
                Sesion('alerta', "primary");
               Sesion('mensaje', "Usuario encontrado: " . $us->usuarios[0]->nombre);
                RedirectView("principal/validacion");
            } else {
                Sesion('alerta', "danger");
               Sesion('mensaje', "No se encontro usuario asociado a  $us->mail, <br> vuelva a intentarlo de nuevo.");
                RedirectBack();
            }
        }
    }

    // Muestra al usuario un mensaje si el proceso ha sido exitoso. 
    public function Validacion(): void
    {
        if ($this->request->isGet) {
            $alerta = Sesion("alerta");
            $mensaje = Sesion("mensaje");
            MakeView("success", "Confirmación - " . APP_NAME, $mensaje, $alerta);
        } else {
            RedirectBad();
        }
    }
}
