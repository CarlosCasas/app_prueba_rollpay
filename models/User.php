<?php
require_once 'Audit.php';

class User {
    private $pdo;
    private $audit;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->audit = new Audit($pdo);
    }

    public function register($name, $lastname, $dni, $email, $password) {
        $this->pdo->beginTransaction();
        try {
            // Insertar en la tabla PERSON
            $stmtPerson = $this->pdo->prepare("INSERT INTO person (name, lastname, dni) VALUES (:name, :lastname, :dni)");
            $stmtPerson->bindParam(':name', $name);
            $stmtPerson->bindParam(':lastname', $lastname);
            $stmtPerson->bindParam(':dni', $dni);
    
            // Si ejecuta correcta en Person
            if ($stmtPerson->execute()) {
                // Insertar en la tabla USERS
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $profile_id = 1;
                $person_id = $this->pdo->lastInsertId();
                //print_r($person_id);exit;
                $stmtUser = $this->pdo->prepare("INSERT INTO users (username, email, password,profile_id,person_id) VALUES (:username, :email, :password, :profile_id, :person_id)");
                $stmtUser->bindParam(':username', $dni);
                $stmtUser->bindParam(':email', $email);
                $stmtUser->bindParam(':password', $passwordHash);
                $stmtUser->bindParam(':profile_id', $profile_id);
                $stmtUser->bindParam(':person_id', $person_id);

 
                if ($stmtUser->execute()) {
                    $user_id = 1; 
                    $event = 'create';
                    $auditable_type = 'user';
                    $old_values = null; 
                    $new_values = json_encode(['name' => $name, 'lastname' => $lastname, 'email' => $email, 'dni' => $dni]);
                    $auditable_id = $this->pdo->lastInsertId(); 

                    // Auditoría
                    /*print_r($user_id);
                    print_r( $event, );
                    print_r( $auditable_type, );
                    print_r(  $old_values);
                    print_r(   $new_values);
                    print_r(   $auditable_id);

                     exit;*/

                    $this->audit->register($user_id, $event, $auditable_type, $old_values, $new_values, $auditable_id);
                } else {
                    throw new Exception("Error al registrar en la tabla USERS");
                }
            }else{
                throw new Exception("Error al registrar en la tabla PERSON");
            }
    
            // Confirmar la transacción
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Revertir transacción
            $this->pdo->rollBack();
            echo "Error: " . $e->getMessage();
            return false; 
        }
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Usuario autenticado
        }
        return false; 
    }

    public function getUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE status=1");
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $user; 
    }

    public function getUserxID($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id status=1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $user; 
    }
}
?>
