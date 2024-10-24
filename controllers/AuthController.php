<?php
require_once '../config/db.php';
require_once '../models/User.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function register($name, $lastname, $dni, $email, $password) {
        if ($this->userModel->register($name, $lastname, $dni, $email, $password)) {
            $_SESSION['username'] = $dni;
            $_SESSION['name'] = $name; 
            $_SESSION['lastname'] = $lastname; 
            $_SESSION['email'] = $email; 
            header('Location: ../views/dashboard.php');
        } else {
            // Manejo de errores
            header('Location: ../public/index.php?msg=Error al registrar');
        }
    }

    public function login($username, $password) {
        $user = $this->userModel->login($username, $password);
        if ($user) {
            header('Location: ../views/dashboard.php');
        } else {
            header('Location: ../public/index.php?msg=Credenciales inválidas');
        }
    }
}
?>
