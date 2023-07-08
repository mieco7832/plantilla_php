<?php

namespace Configs;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

/**
 * La clase de Database, se utiliza para la conexió de la base de datos,
 * La estructura esta diseñada para heredar a las clases entity.
 */
class Database
{

    /**
     * Las constantes de las propiedades de la base de datos
     */
    private const DB_DNS = 'mysql:host=server;dbname=database;charset=utf8';
    private const DB_USUARIO = 'usuario';
    private const DB_CLAVE = 'clave';

    /**
     * Propiedades de la base de datos
     */
    private PDO $conexion;
    private PDOStatement $resultado;
    private string $consulta;
    private array $parametros;

    public function __construct()
    {
        /**
         * Se inicializan las variables que se les asignara un valor en 
         * el recorrido de la conexión, consulta y resultado.
         */
        $this->consulta = "";
        $this->parametros = [];
        $this->resultado = new PDOStatement();
    }

    /**
     * El metodo conectar realiza la primera etapa, 
     * que es validar las credenciales de la conexión
     */
    private function Conectar(): bool
    {
        $this->conexion = new PDO(self::DB_DNS, self::DB_USUARIO, self::DB_CLAVE);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($this->conexion == null) {
            throw new Exception('Conexión null');
            return false;
        }
        return true;
    }

    /**
     * Los siguientes metodos realizan una consulta, 
     * Ya sea que devulva o no un resultado
     */

    // Solo para crear consultas con resultado, "consultas quemadas"
    public function Consultar(): void
    {
        try {
            if ($this->Conectar())
                $this->resultado = $this->conexion->prepare($this->consulta);
        } catch (PDOException $e) {
            //echo "Error al generar la consulta: " . $e->getMessage();
        }
    }

    // Crea la consulta de forma deinamica, es necesario parametos de entrada
    public function EjecutarStatement(): void
    {
        try {
            if ($this->Conectar()) {
                $this->resultado = $this->conexion->prepare($this->consulta);
                $this->resultado->execute($this->parametros);
            }
        } catch (PDOException $e) {
            //echo "Error al ejecutar la consulta: " . $e->getMessage();
        }
    }

    /**
     * Metodos accesores
     */
    public function __get(string $name)
    {
        if ($name === 'consulta')
            return $this->consulta;
        if ($name === 'resultado')
            return $this->resultado;
        if ($name === 'parametros')
            return $this->parametros;
    }

    public function __set(string $name, $value)
    {
        if ($name === 'consulta')
            $this->consulta = $value;
        if ($name === 'resultado')
            $this->resultado = $value;
        if ($name === 'parametros')
            $this->parametros = $value;
    }
}
