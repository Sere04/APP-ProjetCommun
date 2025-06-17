<?php
require_once(__DIR__ . '/connectToDB.php');

/**
 * Met à jour le mot de passe via le token de réinitialisation
 *
 * @param string $token
 * @param string $newHashedPassword
 * @return bool
 */
function updatePassword(string $email, string $newHashedPassword): bool
{
    try {
        $pdo = connectToDB();
            // Mise à jour du mot de passe et suppression du token
            $sqlUpdate = "UPDATE User SET motDePasse = :newHashedPassword WHERE mailUser = :email";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':newHashedPassword', $newHashedPassword);
            $stmtUpdate->bindParam(':email', $email);
            return $stmtUpdate->execute();
        
        }
        catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du mot de passe : " . $e->getMessage();
        return false;
    }
}
