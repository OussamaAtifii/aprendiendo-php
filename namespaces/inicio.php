<?php
spl_autoload_register(function ($nombre) {
    $nombre = str_replace("\\", "/", $nombre) . ".php";
    require $nombre;
});

// require "./src/backend/Users.php";
// require "./src/frontend/Users.php";
// require "./src/Admin.php";

use src\Admin;
use src\backend\Users;
use src\frontend\Users as FrontendUsers;

$manolo = new Users("Oussama");
$paco = new FrontendUsers("Paco");
$admin = new Admin();
echo "<br>";
echo $manolo::class;
