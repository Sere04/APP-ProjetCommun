
<?php

function connectToDB(): PDO
{
    $host = '144.76.54.100';
    $user = 'G2C';
    $pass = 'AppG2-C';
    $port = '3306';
    $charset = 'utf8mb4';
    $dbname = 'G2C'; 

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

function connectToDBALL(): PDO
{
    $host = '144.76.54.100';
$db   = 'G2';
$user = 'G2';
$pass = 'APPG2-BDD';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

    try {
        return  new PDO($dsn, $user, $pass, $options);

    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
//HOW TO USE
//function insertUser(string $nom, string $prenom, string $pseudonyme, string $email, string $hashedPassword, string $telephone, string $description, string $role, string $token): ?int
//{
  //  try {
    //    $pdo = connectToDB();
      //  $sql = "INSERT INTO utilisateur (nom, prenom, pseudonyme, mail, mot_de_passe, description, telephone, token, is_verified, role_id)
        //    (select :nom, :prenom, :pseudonyme, :email, :motDePasse, :description, :telephone, :valToken, 0, id_role
          //   from role
            // where nom = :role)";
        //$stmt = $pdo->prepare($sql);
        //$stmt->execute([
          //  ':nom' => $nom,
            //':prenom' => $prenom,
            //':pseudonyme' => $pseudonyme,
            //':email' => $email,
            //':motDePasse' => $hashedPassword,
            //':description' =>$description,
            //':telephone' => $telephone,
            //':role' => $role,
          //  ':valToken' => $token
        //]);

        //$stmt->closeCursor();
      //  return $pdo->lastInsertId(); 
    //} catch (PDOException $e) {
        // Error executing the query
        //$error = $e->getMessage();
      //  echo mb_convert_encoding("Database access error: $error \n", 'UTF-8', 'UTF-8');
    //    return null;
  //  }
//}
