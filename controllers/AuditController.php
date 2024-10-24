<?php
require_once '../config/db.php';
require_once '../models/Audit.php';

class AuditController {
    private $auditModel;

    public function __construct($pdo) {
        $this->auditModel = new User($pdo);
    }




}
?>


