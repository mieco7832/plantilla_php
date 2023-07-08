<?php

namespace Configs;

/**
 * Clase para validar metodos e input de formularios.
 * La estructura de una petición a validar es la url, metodo y variables. 
 * 
 * La url es el medio que facilita la dorección para comunicar al servidor, 
 * El metodo es tipo de petición POST o GET (los demás no son muy usados), 
 * Las variables son los datos que se comunican por el usuario.
 */
class Validaciones
{

    /**
     * Las contantes de tipo de dato o input, pueden haber mas y según la logica de uso
     */
    private const ITEXT = "text";
    private const IEMAIL = "email";
    private const INUMBER = "number";
    private const IPASS = "password"; 

    /**
     * Propiedades para validar en el controller
     */
    private string $mensaje = "";
    private bool $estado = false;

    public function __construct()
    {
    }

    /**
     * Valida que la propiedad exista y si se requiere validar las caracteristicas del input
     */
    public function ValidarInput(string $input, string $tipo = "", int $min = null, int $max = null, bool $required = false): mixed
    {
        // Obitiene el valor del input
        $value = $_POST[$input];
        // Si es required, validara las demas propiedades
        if ($required) {
            // Valida que el valor no este null o vacio, si lo esta asigna un mensaje y estado
            if (empty($value)) {
                $this->estado = empty($value);
                $this->mensaje = "El input $input esta vacío";
            }
            // Si min y max no son null, valida que la longitud del campo se encuentre en el rango
            if ($min != null && $max != null)
                $this->VerificarLongitud($value, $tipo, $min, $max, $input);
            // Sanitiza su valor
            $value = $this->Sanitizar($value, $tipo);
        }
        return $value;
    }

    // Según el tipo de intput valida que no contenga cararteres especiales y o parsea su valor
    private function Sanitizar(mixed $value, string $tipo): mixed
    {
        $sanitizedInput = trim($value);
        if (in_array($tipo, [self::ITEXT, self::IEMAIL]))
            $sanitizedInput = htmlspecialchars($sanitizedInput, ENT_QUOTES, 'UTF-8');
        if ($tipo === self::INUMBER)
            $sanitizedInput = intval($value);
        if ($tipo === SELF::IPASS)
            $sanitizedInput = hash("sha256", htmlspecialchars($sanitizedInput, ENT_QUOTES, 'UTF-8'));
        return $sanitizedInput;
    }

    // Valida la longitud de la variable
    private function VerificarLongitud(mixed $value, string $tipo, int $min = 0, int $max = 0, string $input = ""): void
    {
        if (in_array($tipo, [self::ITEXT, self::IPASS, self::IEMAIL])){
            $this->estado = !(strlen($value) >= $min && strlen($value) <= $max);
            $this->mensaje = "El input $input no cumple la longitud $min - $max";
        }
        if ($tipo === self::INUMBER)
        {
            $this->estado = !(strlen($value) >= $min && strlen($value) <= $max);
            $this->mensaje = "El input $input no cumple la longitud $min - $max";
        }
    }

    /**
     * Metodos accesores
     */
    public function getMensaje(): string
    {
        return $this->mensaje;
    }

    public function setMensaje(string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }
}
