<?php
require_once '../config/db.php';
require_once '../models/User.php';
require_once '../models/Audit.php';

class UserController {
    private $userModel;
    private $auditModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
        $this->auditModel = new User($pdo);
    }

    public function login($username, $password) {
        $user = $this->userModel->login($username, $password);
        if ($user) {
            header('Location: ../views/dashboard.php');
        } else {
            header('Location: ../public/index.php?msg=Credenciales inválidas');
        }
    }

    public function getUsers() {
        $user = $this->userModel->getUsers();
        return $user; 
    }

    public function logout() {
        session_start(); 

        $_SESSION = [];

        session_destroy();

        // Redirigir al usuario a la página de inicio o login
        header('Location: ../public/index.php');
        exit;
    }


}
?>
