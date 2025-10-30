<?php
require_once __DIR__ . '/../config/database.php';

class LoginModel {
    public static function autenticar($email, $senha) {
        global $pdo; 

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['senha'] === $senha) {
            return $usuario;
        }

        return false;
    }
}
?>
