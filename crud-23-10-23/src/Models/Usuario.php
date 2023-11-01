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
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':e' => $this->email,
                ':p' => $this->provincia,
                ':perfil' => $this->perfil
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar datos: " . $ex->getMessage());
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

    public function update(int $id)
    {
        parent::setConexion();
        $q = "update users set nombre=:n, apellidos=:a, email=:e, provincia=:p, perfil=:pe where id=:i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':e' => $this->email,
                ':p' => $this->provincia,
                ':pe' => $this->perfil,
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al modificar usuario: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public static function delete(int $id)
    {
        parent::setConexion();
        $q = "delete from users where id =:i";

        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ":i" => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar usuario: " . $ex);
        }

        parent::$conexion = null;
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

    public static function existeEmail(string $email, int|null $id = null): bool
    {
        parent::setConexion();
        $q = $id == null ? "select id from users where email=:e" : "select id from users where email=:e and id != :i";

        $options = $id == null ? [":e" => $email] : [":e" => $email, ":i" => $id];

        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute($options);
        } catch (PDOException $ex) {
            die("Error al comprobar email: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function findUser(int $id)
    {
        parent::setConexion();
        $q = "select * from users where id=:i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([":i" => $id]);
        } catch (PDOException $ex) {
            die("Error al encontrar el usuario: " . $ex->getMessage());
        }

        parent::$conexion == null;
        return $stmt->fetch(PDO::FETCH_OBJ);
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
