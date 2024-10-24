<?php
session_start();
require_once '../config/db.php';
require_once '../controllers/AuthController.php';

$authController = new AuthController($pdo);

// Formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $authController->register($_POST['name'],$_POST['lastname'],$_POST['dni'],$_POST['email'], $_POST['password']);
}

// Formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $authController->login($_POST['username'], $_POST['password']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Aplicación</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="login">
    <div class="login-bg">
    <div>
        <h1 class="h1"> Sistema web de 
        </br> Procesamiento
        </br> de datos RollPay</h1>
    </div>
    <div>
        <div class="card card-login">
            <div class="card-body">
                <h5 class="card-title">Iniciar sesión</h5>
                <form id="form-login" class="" method="POST" action="" novalidate>

                    <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['msg'])) { ?>
                        <div class="alert alert-danger">
                            <?=$_GET['msg']?>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" value="" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                        <p  class="text-error"></p> 

                    <button type="submit" class="btn btn-success g-recaptcha"  name="login">Ingresar</button>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Registrarse
                    </button>
                </form>
            </div>
        </div>
    </div>   
       
</div>

<!-- Modal de Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-register" method="POST" action="" >
                    <div class="mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" >
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                    </div>
                    <div class="alert alert-danger" id="error-message" style="display:none;"></div>
                    <button type="submit" class="btn btn-success" name="register" id="register">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap.bundle.js"></script>
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
