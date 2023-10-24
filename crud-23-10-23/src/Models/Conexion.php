<?php

namespace Src\Models;

use \PDO;
use \PDOException;

class Conexion
{
    protected static $conexion;

    public function __construct()
    {
    }

    public static function getConexion(): PDO
    {
        if (self::$conexion != null) return self::$conexion;

        // Cargar la configuración de .env
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        $usuario = $_ENV["USER"];
        $password = $_ENV["PASS"];
        $host = $_ENV["HOST"];
        $db = $_ENV["DB"];

        // Crear el descriptor de nombre de servicio
        $dns = "mysql:dbname=$db;host=$host;charset=utf8mb4";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        // Crear conexion con db
        try {
            self::$conexion = new PDO($dns, $usuario, $password, $options);
            return self::$conexion;
        } catch (PDOException $ex) {
            die("Error al conectar, mensaje: " . $ex->getMessage());
        }
    }
}
