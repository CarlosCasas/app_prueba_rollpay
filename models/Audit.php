<?php
class Audit {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function register($user_id, $event,$auditable_type,$old_values,$new_values,$auditable_id) {
        global $pdo; 
        $stmt = $pdo->prepare("INSERT INTO audit (user_id, event,auditable_type,old_values,new_values,auditable_id) 
                VALUES (:user_id, :event, :auditable_type, :old_values, :new_values, :auditable_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':event', $event);
        $stmt->bindParam(':auditable_type', $auditable_type);
        $stmt->bindParam(':old_values', $old_values);
        $stmt->bindParam(':new_values', $new_values);
        $stmt->bindParam(':auditable_id', $auditable_id);

        $stmt->execute();
    }

}
?>
