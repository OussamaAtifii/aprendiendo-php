<?php

namespace App\Db;

use PDO;
use PDOException;

class User extends Conexion
{
    private int $id;
    private string $email;
    private string $password;
    private string $foto;
    private int $isAdmin;

    public function __construct()
    {
        parent::__construct();
    }

    // CRUD
    public function create()
    {
        $q = "insert into users(email, password, foto, isAdmin) values(:e, :p, :f, :a)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ":e" => $this->email,
                ":p" => $this->password,
                ":f" => $this->foto,
                ":a" => $this->isAdmin
            ]);
        } catch (PDOException $ex) {
            die("Error al crear un usuario: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    // OTROS
    public static function login(string $email, string $password)
    {
        parent::setConexion();

        $q = "select id, isAdmin, password from users where email=:e";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ":e" => $email
            ]);
        } catch (PDOException $ex) {
            die("Error en login: ") . $ex->getMessage();
        }

        parent::$conexion = null;

        // False si no encuentra nada
        $datos = $stmt->fetch(PDO::FETCH_OBJ);

        //  Correo no existe
        if (!$datos) return false;

        // Validar si el pass es correcto
        if (!password_verify($password, $datos->password)) {
            // Correo correcto pero contraseña no
            return false;
        }

        // Login correcto, enviar los datos
        return $datos;
    }

    // FAKER
    private static function hayUsuarios()
    {
        parent::setConexion();
        $q = "select id from users";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([]);
        } catch (PDOException $ex) {
            die("Error al buscar un usuario: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function generarUsuarios(int $cantidad)
    {
        if (self::hayUsuarios()) return;

        $faker = \Faker\Factory::create('es_ES');
        for ($i = 0; $i < $cantidad; $i++) {
            $email = $faker->unique()->email();
            $password = "secret0";
            $foto = "img/perfil/default.png";
            $isAdmin = random_int(0, 1);

            (new User)->setEmail($email)
                ->setPassword($password)
                ->setFoto($foto)
                ->setIsAdmin($isAdmin)
                ->create();
        }
    }

    public static function getIds()
    {
        parent::setConexion();
        $q = "select id from users";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al obtener ids: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // SETTERS
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    public function setFoto(string $foto): self
    {
        $this->foto = $foto;
        return $this;
    }

    public function setIsAdmin(int $isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }
}
