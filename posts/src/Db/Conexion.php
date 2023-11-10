<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Conexion
{
    protected static $conexion;
    public function __construct()
    {
        self::setConexion();
    }

    protected static function setConexion()
    {
        if (self::$conexion) return;

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();

        // $user = "$_ENV['USER']";
        $user = "paco";
        $pass = $_ENV['PASS'];
        $host = $_ENV['HOST'];
        $db = $_ENV['DB'];

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            self::$conexion = new PDO($dsn, $user, $pass, $options);;
        } catch (PDOException $ex) {
            die("Error en la conexion: " . $ex->getMessage());
        }
    }
}
