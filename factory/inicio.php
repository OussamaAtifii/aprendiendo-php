<?php
// require "./src/Plan.php";
// require "./src/BroncePlan.php";
// require "./src/PlataPlan.php";
// require "./src/OroPlan.php";
// require "./src/PlatinoPlan.php";
// require "./src/Cliente.php";
// require "./src/PlanFactory.php";

spl_autoload_register(fn ($nombreClase) => require "./src/" . $nombreClase . ".php");

$cliente = new Cliente(2);
$planCliente = (new PlanFactory)->getPlan($cliente);

echo $planCliente::class;
