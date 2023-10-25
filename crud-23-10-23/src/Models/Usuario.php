<?php

namespace Src\Models;

use \PDO;
use \PDOException;
use Src\Utils\Provincias;

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

    public static function read(): array
    {
        parent::setConexion();
        $q = "select * from users order by id desc";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en read(): " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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

        $faker = \Faker\Factory::create("es-ES");
        for ($i = 0; $i < $cantidad; $i++) {
            $nombre = $faker->firstName();
            $apellidos = $faker->lastName() . " " . $faker->lastName();
            $email = $faker->unique()->email();
            $perfil = random_int(1, 2);
            $provincia = $faker->randomElement(Provincias::$misProvincias);

            (new Usuario)->setNombre($nombre)
                ->setApellidos($apellidos)
                ->setEmail($email)
                ->setPerfil($perfil)
                ->setProvincia($provincia)
                ->create();
        }
    }

    private static function hayRegistros(): bool
    {
        parent::setConexion();
        $q = "select * from users";
        $stmt = parent::$conexion->prepare($q);

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
