<?php
session_start();

if (!isset($_SESSION["rol"])) {
    header("Location:login.php");
    die();
}

if ($_SESSION["rol"] != "admin") {
    header("Location:portal.php");
    die();
}

if (isset($_COOKIE["counter"])) {
    setcookie("counter", $_COOKIE["counter"] + 1, time() + 7 * 24 * 60 * 60);
    $message = "Has ingresado <span class='text-purple-600 font-medium'>" . $_COOKIE["counter"] . "</span> veces al panel de administración.";
} else {
    setcookie("counter", 1, time() + 7 * 24 * 60 * 60);
    $message = "Es tu primera vez ingresando al panel de administración.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CDN Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Portal Admin</title>
</head>

<body>
    <main class="flex flex-col ml-5 mt-5 gap-4">
        <div>Bienvenido <span class="text-purple-600 font-medium"><?php echo $_SESSION["username"] ?></span></div>
        <div>
            <?php echo $message ?>
        </div>
        <div>
            <a href="./logout.php" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Log Out</a>
        </div>
    </main>
</body>

</html>