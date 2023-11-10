<?php

namespace App\Db;

use PDO;
use PDOException;

class Post extends Conexion
{
    private int $id;
    private string $titulo;
    private string $descripcion;
    private string $imagen;
    private int $user;

    public function __construct()
    {
        parent::setConexion();
    }

    // CRUD
    public function create()
    {
        $q = "insert into posts(titulo, descripcion, imagen, user) values (:t, :d, :i, :u)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':t' => $this->titulo,
                ':d' => $this->descripcion,
                ':i' => $this->imagen,
                ':u' => $this->user,
            ]);
        } catch (PDOException $ex) {
            die("Error al crear un post: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public static function readAll(?int $id = null)
    {
        parent::setConexion();
        $q = ($id == null)
            ? "select posts.*, email from users, posts where users.id=posts.user order by posts.id desc"
            : "select posts.*, email from users, posts where users.id=posts.user AND users.id=:i order by posts.id desc";

        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute($id == null
                ? []
                : [':i' => $id]);
        } catch (PDOException $ex) {
            die("Error en readAll: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPostById(int $id)
    {
        parent::setConexion();

        $q = "select posts.*, email from users, posts where users.id=posts.user AND posts.id=:i order by posts.id desc";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error en getPostById: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // FAKER
    public static function generarPosts($cantidad)
    {
        if (self::hayPosts()) return;
        $faker = \Faker\Factory::create('es_ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));

        for ($i = 0; $i < $cantidad; $i++) {
            $titulo = ucfirst($faker->words(random_int(2, 4), true));
            $descripcion = $faker->text(random_int(100, 150));
            $imagen = "img/posts/" . $faker->picsum("./img/posts/", 640, 480, false);
            $user = $faker->randomElement(User::getIds())->id;

            (new Post)->setTitulo($titulo)
                ->setDescripcion($descripcion)
                ->setImagen($imagen)
                ->setUser($user)
                ->create();
        }
    }

    private static function hayPosts()
    {
        parent::setConexion();
        $q = "select id from posts";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([]);
        } catch (PDOException $ex) {
            die("Error al buscar un post: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }
    // OTROS



    // SETTERS
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;
        return $this;
    }
}
