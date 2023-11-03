<?php

if (!isset($_POST['id'])) {
    header("Location:index.php");
    die();
}

session_start();

$id = (int) $_POST['id'];
