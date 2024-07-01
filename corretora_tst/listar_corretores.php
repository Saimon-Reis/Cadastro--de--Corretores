<?php
$host = 'localhost';
$db = 'corretores_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM corretores");

$corretores = [];

while ($row = $result->fetch_assoc()) {
    $corretores[] = $row;
}

$conn->close();

echo json_encode($corretores);
?>