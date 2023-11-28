<?php

use App\Db\Articulo;
use App\Db\Categoria;

require_once __DIR__ . "/../vendor/autoload.php";

Categoria::generarCategorias(10);
Articulo::generarArticulos(20);
