<?php

namespace App\Db;

use PDO;
use \PDOException;

class Autores extends Conexion
{
    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $pais;

    public function __construct()
    {
        parent::__construct();
    }

    // CRUD
    public function create()
    {
        $q = "insert into autores(nombre, apellidos, pais) values(:n, :a, :p)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':p' => $this->pais
            ]);
        } catch (PDOException $ex) {
            die("Error creando un nuevo autor: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    // FAKER
    private static function hayAutores(): bool
    {
        parent::setConexion();

        $q = "select id from autores";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en hay autores:" . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function existeIdAutor(int $id): bool
    {
        parent::setConexion();

        $q = "select id from autores where id=:i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            die("Error en hay id autor:" . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function getAutoresId(): array
    {
        parent::setConexion();

        $q = "select id, nombre, apellidos from autores order by apellidos";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en get autores id:" . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function generarAutores($cantidad): void
    {
        if (self::hayAutores()) return;
        $faker = \Faker\Factory::create('es_ES');

        for ($i = 0; $i < $cantidad; $i++) {
            $nombre = $faker->firstName();
            $apellidos = $faker->lastName() . " " . $faker->lastName();
            $pais = $faker->country();

            (new Autores)->setNombre($nombre)
                ->setApellidos($apellidos)
                ->setPais($pais)
                ->create();
        }
    }

    // OTROS

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

    public function setPais(string $pais): self
    {
        $this->pais = $pais;
        return $this;
    }
}
