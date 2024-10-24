<?php
require_once '../config/db.php'; // Asegúrate de incluir tu archivo de configuración
require_once '../controllers/UserController.php';

$userController = new UserController($pdo);
$userController->logout(); // Llamar al método de cierre de sesión
?>
