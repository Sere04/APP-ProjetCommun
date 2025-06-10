<?php
require_once(__DIR__ . '/../connectToDB.php');

/**
 * @param string $nom
 * @param string $prenom
 * @param string $pseudonyme
 * @param string $email
 * @param string $hashedPassword
 * @param string $telephone
 * @param string $description
 * @param string $role
 * @param string $token
 * @return int|null
 */
function insertUser(string $prenom, string $nom, string $email, string $pseudonyme, string $hashedPassword, string $telephone): ?int
{
    try {
        $pdo = connectToDB();
        $sql = "INSERT INTO User (firstName, lastName, mailUser, userName, motDePasse, phoneNumber)
            (select :prenom, :nom, :email, :pseudonyme, :motDePasse, :telephone)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':pseudonyme' => $pseudonyme,
            ':email' => $email,
            ':motDePasse' => $hashedPassword,
            ':telephone' => $telephone,
        ]);

        $stmt->closeCursor();
        return $pdo->lastInsertId(); 
    } catch (PDOException $e) {
        // Error executing the query
        $error = $e->getMessage();
        echo mb_convert_encoding("Database access error: $error \n", 'UTF-8', 'UTF-8');
        return null;
    }
}

function verifyUsername(string $pseudonyme): ?bool
{
    try {
        $pdo = connectToDB();
        $sql = "SELECT * FROM `User` WHERE userName=:valUsername";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":valUsername", $pseudonyme);
        $bool = $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return count($results) === 0;

    } catch (PDOException $e) {
        // Error executing the query
        $error = $e->getMessage();
        echo mb_convert_encoding("Database access error: $error \n", 'UTF-8', 'UTF-8');
        return null;
    }
}

function verifyMail(string $email): ?bool
{
    try {
        $pdo = connectToDB();
        $sql = "SELECT * FROM `User` WHERE mailUser=:valMail";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":valMail", $email);
        $bool = $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return count($results) === 0;
    } catch (PDOException $e) {
        // Error executing the query
        $error = $e->getMessage();
        echo mb_convert_encoding("Database access error: $error \n", 'UTF-8', 'UTF-8');
        return null;
    }
}
