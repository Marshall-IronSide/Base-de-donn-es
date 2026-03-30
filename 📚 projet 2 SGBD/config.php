<?php $host = "localhost";
$user = "root";
$port = 3377;
$password = getenv('DB_PASSWORD') ?: '';
$db = "bibliotheque";
$conn = new mysqli($host, $user, $password, $db, (int)$port);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
