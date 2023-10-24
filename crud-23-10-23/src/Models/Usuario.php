<?php

namespace Src\Models;

use \PDOException;

class Usuario extends Conexion
{
    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $provincia;
    private string $perfil;

    public function __construct()
    {
        parent::__construct();
    }

    // CRUD
    public function create()
    {
        $q = "insert into users(nombre, apellidos, email, provincia, perfil) values(:n, :a, :e, :p, :perfil)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ":n" => $this->nombre,
                ":a" => $this->apellidos,
                ":e" => $this->email,
                ":p" => $this->provincia,
                ":perfil" => $this->perfil
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar, mensaje: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public function read()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    // OTROS
    public static function crearRegistrosAleatorios($cantidad)
    {
        if (self::hayRegistros()) return;
    }

    private static function hayRegistros(): bool
    {
        $q = "select * from usuario";
        $stmt = parent::getConexion()->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay usuarios: " . $ex->getMessage());
        }

        parent::$conexion == null;
        return $stmt->rowCount();
    }

    // SETTERS

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function setPerfil(string $perfil): self
    {
        $this->perfil = $perfil;

        return $this;
    }
}
