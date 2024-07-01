<?php
// Configurações do banco de dados
$host = 'localhost';
$db = 'corretores_db';
$user = 'root';
$pass = '';

// Conectando ao banco de dados
$conn = new mysqli($host, $user, $pass, $db);

// Verificação de conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "passou";

// Obtendo os dados da requisição
$data = json_decode(file_get_contents("php://input"), true);

$response = [];

// Validação dos dados recebidos
if (isset($data['nome'], $data['cpf'], $data['creci'])) {
    $nome = trim($data['nome']);
    $cpf = trim($data['cpf']);
    $creci = trim($data['creci']);

    // Sanitização dos dados
    $nome = filter_var($nome, FILTER_SANITIZE_STRING);
    $cpf = filter_var($cpf, FILTER_SANITIZE_STRING);
    $creci = filter_var($creci, FILTER_SANITIZE_STRING);

    // Validação do formato do CPF (apenas um exemplo básico, ajuste conforme necessário)
    if (!preg_match("/^[0-9]{11}$/", $cpf)) {
        $response['success'] = false;
        $response['message'] = 'CPF inválido';
    } else {
        try {
            // Preparando a declaração SQL
            $stmt = $conn->prepare("INSERT INTO corretores (nome, cpf, creci) VALUES (?, ?, ?)");
            if ($stmt === false) {
                throw new Exception('Erro na preparação da declaração: ' . $conn->error);
            }

            // Vinculando os parâmetros
            $stmt->bind_param("sss", $nome, $cpf, $creci);

            // Executando a declaração
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Dados inseridos com sucesso';
            } else {
                throw new Exception('Erro na execução da declaração: ' . $stmt->error);
            }
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        // Fechando a declaração
        $stmt->close();
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Dados incompletos';
}

// Fechando a conexão
$conn->close();

// Retornando a resposta em formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
