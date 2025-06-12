<?php
require_once(__DIR__ . '/../Models/LogInModele.php');

function areCrendentialsCorrect(string $email, string $password): array|bool
{
    $user = getUser($email);

    if (!is_null($user)) {
        if (password_verify($password, $user['motDePasse'])) {
            return $user;
        }
    }
    return false;
}