<?php
$servername = "localhost"; // Nome do servidor do banco de dados
$username = ""; // Nome de usuário do banco de dados
$password = ""; // Senha do banco de dados
$dbname = ""; // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida corretamente
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o ID do usuário foi fornecido na URL
if (!isset($_GET['id'])) {
    // Retorna um erro se o ID do usuário não for fornecido
    $response = array('error' => 'ID do usuário não fornecido.');
    echo json_encode($response);
    exit;
}

// Obtém o ID do usuário da URL
$idUsuario = $_GET['id'];

// Cria a consulta SQL para obter as informações do usuário
$sql = "SELECT Nome, Conquistas, ID, Emblemas FROM Contas WHERE ID = '$idUsuario'";
$result = $conn->query($sql);

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    // Obtém os dados do usuário
    $row = $result->fetch_assoc();

    // Monta a resposta em formato JSON
    $response = array(
        'nome' => $row['Nome'],
        'conquistas' => $row['Conquistas'],
        'id' => $row['ID'],
        'emblemas' => $row['Emblemas']
    );

    // Retorna a resposta em JSON
    echo json_encode($response);
} else {
    // Retorna um erro se o usuário não for encontrado
    $response = array('error' => 'Usuário não encontrado.');
    echo json_encode($response);
}

// Fechar a conexão (opcional)
$conn->close();
?>
