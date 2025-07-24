<?php
require_once realpath(__DIR__ . '/../../vendor/autoload.php');

$rootPath = realpath(__DIR__ . '/../../');
if ($rootPath === false) {
    die('Erreur : impossible de résoudre le chemin racine du projet.');
}

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();

$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];
$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $bd = new PDO($dsn, $user, $pass);
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die;
}
