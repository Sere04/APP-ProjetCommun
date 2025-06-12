
<?php

require_once(__DIR__ . '/connectToDB.php');

function getUser(string $email): ?array
{
    try {
        $pdo = connectToDB();
        $sql = "SELECT * FROM `User` WHERE mailUser=:valEmail OR userName=:valUserName and is_verified = 1;";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":valEmail", $email);
        $stmt->bindParam(":valUserName", $email);
        $bool = $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $account = null;
        if (count($results) > 0)
            $account = $results[0];
        
        $stmt->closeCursor();
        return $account;
    }
    catch (PDOException $e) {
        // Error executing the query
        $error = $e->getMessage();
        echo mb_convert_encoding("Database access error: $error \n", 'UTF-8', 'UTF-8');
        return null;
    }
}

function getUserById( string $id): ?array
{
    try {
        $pdo = connectToDB();
        $sql = "SELECT * FROM `User` WHERE IDUser=:valId;";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":valId", $id);
        $bool = $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $account = null;
        if (count($results) > 0)
            $account = $results[0];
        
        $stmt->closeCursor();
        return $account;
    }
    catch (PDOException $e) {
        // Error executing the query
        $error = $e->getMessage();
        echo mb_convert_encoding("Database access error: $error \n", 'UTF-8', 'UTF-8');
        return null;
    }
}



?>
