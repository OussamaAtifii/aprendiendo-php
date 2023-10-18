<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location:login.php");
    die();
}

if (isset($_COOKIE[$_SESSION["username"]])) {
    $message = "Te conectaste por ultima vez: " . $_COOKIE[$_SESSION["username"]];
    setcookie($_SESSION["username"], date("d/m/Y - H:i:s"), time() + 7 * 24 * 60 * 60);
} else {
    $message = "Es tu primera vez ingresando al portal de usuarios.";
    setcookie($_SESSION["username"], date("d/m/Y - H:i:s"), time() + 7 * 24 * 60 * 60);
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
    <title>Portal</title>
</head>

<body>
    <div class="flex flex-col ml-5 mt-5 gap-4">
        <div class="">Bienvenido <span class="text-purple-600 font-medium"><?php echo $_SESSION["username"] ?></span></div>
        <?php echo "<div>" . $message . "</div>" ?>
        <div class="flex gap-4">
            <?php
            if ($_SESSION["rol"] == "admin") {
                echo '<div> <a href="./admin.php" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Portal Admin</a></div>';
            }
            ?>
            <div>
                <a href="./logout.php" class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Log Out</a>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

</html>