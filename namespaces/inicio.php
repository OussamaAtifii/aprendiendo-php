<?php

require "./src/backend/Users.php";
require "./src/frontend/Users.php";
require "./src/Admin.php";

use src\Admin;
use src\backend\Users;
use src\frontend\Users as FrontendUsers;

$manolo = new Users("Oussama");
$paco = new FrontendUsers("Paco");
$admin = new Admin();
