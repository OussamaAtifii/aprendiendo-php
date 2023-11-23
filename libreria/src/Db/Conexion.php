<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Conexion
{
    public static ?PDO $conexion = null;

    public function __construct()
    {
        self::setConexion();
    }

    public static function setConexion()
    {

        if (self::$conexion != null) return;

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        $user = $_ENV['USER'];
        $password = $_ENV['PASS'];
        $db = $_ENV['DB'];
        $host = $_ENV['HOST'];

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            self::$conexion = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $ex) {
            die("Error en nueva conexión: " . $ex->getMessage());
        }
    }
}
