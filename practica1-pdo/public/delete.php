<?php

use App\Models\Producto;

require_once __DIR__ . "/../vendor/autoload.php";

if (!isset($_POST['id'])) {
    header("Location:index.php");
    die();
}

session_start();
Producto::delete(htmlspecialchars(trim($_POST['id'])));

$_SESSION['mensaje'] = "Producto eliminado correctamente";
header("Location:index.php");
