<?php
$host = 'localhost';
$db = 'corretores_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $_GET['id'];
$nome = $data['nome'];
$cpf = $data['cpf'];
$creci = $data['creci'];

$stmt = $conn->prepare("UPDATE corretores SET nome = ?, cpf = ?, creci = ? WHERE id = ?");
$stmt->bind_param("sssi", $nome, $cpf, $creci, $id);

$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>