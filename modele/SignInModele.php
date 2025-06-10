<?php
require_once(__DIR__ . '/../connectToDB.php');

/**
 * Checks if a user exists with the given email and password.
 * @param string $email
 * @param string $password
 * @return array|null Returns user data as associative array if found, null otherwise.
 */
function verifyUser(string $email, string $password): ?array
{
    try {
        $pdo = connectToDB();
        $sql = "SELECT * FROM utilisateur WHERE mail = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
        echo mb_convert_encoding("Database access error: $error \n", 'UTF-8', 'UTF-8');
        return null;
    }
}