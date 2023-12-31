<?php

namespace App\Db;

use PDO;
use PDOException;

class Articulo extends Conexion
{
    private int $id;
    private string $nombre;
    private string $disponible;
    private float $precio;
    private string $imagen;
    private int $category_id;

    public function __construct()
    {
        parent::__construct();
    }

    // CRUD
    public function create()
    {
        $q = "insert into articulos(nombre, disponible, precio, imagen, category_id) values(:n, :d, :p, :i, :cat_id)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->disponible,
                ':p' => $this->precio,
                ':i' => $this->imagen,
                ':cat_id' => $this->category_id
            ]);
        } catch (PDOException $ex) {
            die("Error al crear el articulo: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public static function read()
    {
        parent::setConexion();

        $q = "select * from articulos";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en read(): " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // FAKER
    public static function generarArticulos(int $cantidad)
    {
        if (self::hayArticulos()) return;

        $faker = \Faker\Factory::create('es_ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));

        for ($i = 0; $i < $cantidad; $i++) {
            $nombre = ucfirst($faker->word());
            $disponible = random_int(1, 2);
            $precio = $faker->randomFloat(2, 20, 100);
            $imagen = "img/articulos/" . $faker->picsum("./img/articulos/", 400, 400, false);
            $category_id = $faker->randomElement(Categoria::getIds())->id;

            (new Articulo)->setNombre($nombre)
                ->setDisponible($disponible)
                ->setPrecio($precio)
                ->setImagen($imagen)
                ->setCategoryId($category_id)
                ->create();
        }
    }

    // OTHERS
    private static function hayArticulos()
    {
        parent::setConexion();

        $q = "select id from articulos";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en hayArticulos(): " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }

    // SETTER
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

    public function setDisponible(string $disponible): self
    {
        $this->disponible = $disponible;
        return $this;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;
        return $this;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }
}
