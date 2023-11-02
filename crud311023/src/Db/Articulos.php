<?php

namespace App\Db;

use PDO;
use \PDOException;

class Articulos extends Conexion
{
    private int $id;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private string $imagen;

    public function __construct()
    {
        parent::__construct();
    }

    // CRUD
    public function create()
    {
        $q = "INSERT INTO articulos(nombre, descripcion, precio, stock, imagen) VALUES(:n, :d, :p, :s, :i)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ":n" => $this->nombre,
                ":d" => $this->descripcion,
                ":p" => $this->precio,
                ":s" => $this->stock,
                ":i" => $this->imagen,
            ]);
        } catch (PDOException $ex) {
            die("Error al crear un articulo: " . $ex->getMessage());
        }

        parent::$conexion == null;
    }

    public static function read(): array
    {
        parent::setConexion();
        $q = "select * from articulos order by id desc";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al leer los registros: " .  $ex->getMessage());
        }

        parent::$conexion == null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete()
    {
    }

    public function update()
    {
    }

    // FAKER

    private static function hayRegistros(): bool
    {
        parent::setConexion();
        $q = "select id from articulos";

        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al buscar registros: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function registrosRandom(int $cantidad): void
    {
        if (self::hayRegistros()) return;

        $faker = \Faker\Factory::create('es-ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));

        for ($i = 0; $i < $cantidad; $i++) {
            $nombre = ucfirst($faker->unique()->word(random_int(1, 3), true));
            $descripcion = $faker->text();
            $precio = $faker->randomFloat(2, 5, 9999);
            $stock = random_int(1, 20);
            $imagen = "img/" . $faker->picsum(dir: "./img", width: 640, height: 480, fullPath: false);

            (new Articulos)->setNombre($nombre)
                ->setDescripcion($descripcion)
                ->setPrecio($precio)
                ->setStock($stock)
                ->setImagen($imagen)
                ->create();
        }
    }

    // OTROS

    public static function findArticle(int $id)
    {
        parent::setConexion();
        $q = "select * from articulos where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ":i" => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al encontrar el articulo: " . $ex->getMessage());
        }

        parent::$conexion = null;
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

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;
        return $this;
    }

    public function setStock(bool $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;
        return $this;
    }
}
