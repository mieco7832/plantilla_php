<?php

namespace Models;

use Configs\Database;
use PDO;

/**
 * Clase tipo entity, donde se realiza la logica de negocio,
 * es decir todos los procesos que se pueden realizar para la tabla
 * en la base de datos. En el caso se creado un CRUD, adicional un READ BY ID
 * y un LogIn. 
 */
class Usuario extends Database
{

    // La sección de constantes se utiliza para el manejo de consultas
    private const Q_CREATE = "INSERT INTO usuario(mail,nombre,clave) VALUES(?,?,?)";
    private const Q_READ = "SELECT * FROM usuario";
    private const Q_READ_BY_ID = "SELECT * FROM usuario WHERE mail = ?";
    private const Q_UPDATE = "UPDATE usuario SET mail = ?, nombre = ? WHERE mail = ?";
    private const Q_DELETE = "DELETE FROM usuario WHERE mail = ?";
    private const Q_LOG_IN = "SELECT nombre FROM usuario WHERE mail = ? AND clave = ?";

    // Las propiedades de clase, adicional se ha creado un array de la misma
    private string $mail = "";
    private string $nombre = "";
    private string $clave = "";
    private array $usuarios = [];

    public function __construct()
    {
        // Inicializa el contructor de la clase que hereda
        parent::__construct();
    }

    /**
     * Metodos CRUD, para implementar la logica de negocio.
     */

    public function Create(): void
    {
        parent::__set("consulta", self::Q_CREATE);
        parent::__set("parametros", [$this->mail, $this->nombre, $this->clave]);
        $this->EjecutarStatement();
    }

    public function Read(): void
    {
        parent::__set("consulta", self::Q_READ);
        while ($fila = parent::__get("resultado")->fetch(PDO::FETCH_OBJ)) {
            $us = new Usuario();
            $us->mail = $fila->mail;
            $us->nombre = $fila->nombre;
            array_push($this->usuarios, $us);
        }
    }

    public function LogIn(): void
    {
        parent::__set("consulta", self::Q_LOG_IN);
        parent::__set("parametros", [$this->mail, $this->clave]);
        $this->EjecutarStatement();
        if (parent::__get("resultado") !== null)
            while ($fila = parent::__get("resultado")->fetch(PDO::FETCH_OBJ)) {
                $us = new Usuario();
                $us->nombre = $fila->nombre;
                array_push($this->usuarios, $us);
            }
    }

    public function ReadById(): void
    {
        parent::__set("consulta", self::Q_READ_BY_ID);
        parent::__set("parametros", [$this->mail]);
        $this->EjecutarStatement();
        if (parent::__get("resultado") !== null)
            while ($fila = parent::__get("resultado")->fetch(PDO::FETCH_OBJ)) {
                $us = new Usuario();
                $us->mail = $fila->mail;
                $us->nombre = $fila->nombre;
                array_push($this->usuarios, $us);
            }
    }

    public function Update(): void
    {
        parent::__set("consulta", self::Q_UPDATE);
        parent::__set("parametros", [$this->mail, $this->nombre, $this->mail]);
        $this->EjecutarStatement();
    }

    public function Delete(): void
    {
        parent::__set("consulta", self::Q_DELETE);
        parent::__set("parametros", [$this->mail]);
        $this->EjecutarStatement();
    }

    // Adicional se ha creado un metodo para validar que se ha encontrado resultados de las consultas
    public function IsNotEmpty(): bool
    {
        return !empty($this->usuarios) || count($this->usuarios) > 0;
    }

    /**
     * Metodos accesores
     */

    public function __get(string $name)
    {
        if ($name === 'mail')
            return $this->mail;
        if ($name === 'nombre')
            return $this->nombre;
        if ($name === 'clave')
            return $this->clave;
        if ($name === 'usuarios')
            return $this->usuarios;
    }

    public function __set(string $name, $value)
    {
        if ($name === 'mail')
            $this->mail = $value;
        if ($name === 'nombre')
            $this->nombre = $value;
        if ($name === 'clave')
            $this->clave = $value;
        if ($name === 'usuarios')
            $this->usuarios = $value;
    }
}
