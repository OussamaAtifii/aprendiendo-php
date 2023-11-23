<?php

namespace App\Db;

use PDO;
use PDOException;

class Libros extends Conexion
{
    private int $id;
    private string $titulo;
    private string $sinopsis;
    private string $portada;
    private int $autor_id;

    public function __construct()
    {
        parent::__construct();
    }

    // CRUD
    public function create()
    {
        $q = "insert into libros(titulo, sinopsis, portada, autor_id) values(:t, :s, :p, :a)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':t' => $this->titulo,
                ':s' => $this->sinopsis,
                ':p' => $this->portada,
                ':a' => $this->autor_id
            ]);
        } catch (PDOException $ex) {
            die("Error creando libro:" . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public static function read(?int $id = null): array
    {
        parent::setConexion();
        $q = ($id == null)
            ? "select libros.*, nombre, apellidos, pais from libros, autores where autores.id=autor_id order by apellidos"
            : "select libros.*, nombre, apellidos, pais from libros, autores where autores.id=autor_id AND libros.id=:i";
        $stmt = parent::$conexion->prepare($q);

        try {
            ($id == null) ? $stmt->execute() : $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            die("Error en read: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function delete(int $id)
    {
        parent::setConexion();

        $q = "delete from libros where id = :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i' => $id,
            ]);
        } catch (PDOException $ex) {
            die("ERROR, No se puede eliminar el libro: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public function update(int $id)
    {
        $q = "update libros set titulo=:t, sinopsis=:s, portada=:p, autor_id=:a where id =:i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':t' => $this->titulo,
                ':s' => $this->sinopsis,
                ':p' => $this->portada,
                ':a' => $this->autor_id,
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error modificando libro:" . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    // FAKER
    public static function getLibroById(string $titulo, int $id)
    {
        parent::setConexion();

        $q = "select id from libros where titulo=:t AND id != :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':t' => $titulo,
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error en get libro by id:" . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }


    public static function hayLibros(?string $titulo = null): bool
    {
        parent::setConexion();

        $q = $titulo == null
            ? "select id from libros"
            : "select id from libros where titulo=:t";
        $stmt = parent::$conexion->prepare($q);

        try {
            $titulo == null ? $stmt->execute() : $stmt->execute([':t' => $titulo]);
        } catch (PDOException $ex) {
            die("Error en hay libros:" . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function generarLibros(int $cantidad)
    {
        if (self::hayLibros()) return;

        $faker = \Faker\Factory::create('es_ES');
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $id_autores = Autores::getAutoresId();

        for ($i = 0; $i < $cantidad; $i++) {
            $titulo = ucfirst($faker->unique()->words(random_int(2, 4), true));
            $sinopsis = ucfirst($faker->text());
            $portada = "img/portadas/" . $faker->picsum("./img/portadas/", 640, 480, false);
            $autor_id = $faker->randomElement($id_autores)->id;

            (new Libros)->setTitulo($titulo)
                ->setSinopsis($sinopsis)
                ->setPortada($portada)
                ->setAutorId($autor_id)
                ->create();
        }
    }
    // OTHERS
    //SETTERS
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

    public function setSinopsis(string $sinopsis): self
    {
        $this->sinopsis = $sinopsis;
        return $this;
    }

    public function setPortada(string $portada): self
    {
        $this->portada = $portada;
        return $this;
    }

    public function setAutorId(int $autor_id): self
    {
        $this->autor_id = $autor_id;
        return $this;
    }
}
