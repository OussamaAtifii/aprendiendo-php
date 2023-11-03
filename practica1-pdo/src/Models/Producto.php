<?php

namespace App\Models;

use PDO;
use PDOException;

class Producto extends Conexion
{
    private int $codigo;
    private string $nombre;
    private float $precio;

    public function __construct()
    {
        parent::setConexion();
    }

    // CRUD (Create, Read, Update, Delete)
    public function create(): void
    {
        $q = "INSERT INTO producto (nombre, precio) VALUES(:n, :p)";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':p' => $this->precio
            ]);
        } catch (PDOException $ex) {
            die("Error al crear un articulo: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public static function read()
    {
        parent::setConexion();
        $q = "SELECT * FROM producto ORDER BY codigo DESC";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al leer los registros: " . $ex->getMessage());
        }

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function delete(int $id)
    {
        parent::setConexion();
        $q = "DELETE FROM producto WHERE codigo= :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error borrando el producto: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    public function update(int $id)
    {
        $q = "UPDATE producto SET nombre=:n, precio=:p WHERE codigo= :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':p' => $this->precio,
                ':i' =>  $id
            ]);
        } catch (PDOException $ex) {
            die("Error al modificar el producto: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    // Metodos auxiliares
    public static function getProductById(int $id)
    {
        parent::setConexion();
        $q = "SELECT * FROM producto WHERE codigo= :i";
        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error, no se encuentra el producto con el codigo dado: " . $ex->getMessage());
        }

        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // SETTERS de los atributos:
    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
}
