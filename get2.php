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

// Verifica se o nome do usuário foi fornecido na URL
if (!isset($_GET['nome'])) {
    // Retorna um erro se o nome do usuário não for fornecido
    $response = array('error' => 'Nome do usuário não fornecido.');
    echo json_encode($response);
    exit;
}

// Obtém o nome do usuário da URL e decodifica os caracteres especiais
$nomeUsuario = urldecode($_GET['nome']);

// Cria a consulta SQL para obter os dados do usuário
$sql = "SELECT Nome, ID, Conquistas, Emblemas FROM Contas WHERE Nome = '$nomeUsuario'";
$result = $conn->query($sql);

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    // Obtém os dados do usuário
    $row = $result->fetch_assoc();
    $nome = $row['Nome'];
    $id = $row['ID'];
    $conquistas = $row['Conquistas'];
    $emblemas = $row['Emblemas'];

    // Monta a resposta em formato JSON
    $response = array(
        'nome' => $nome,
        'id' => $id,
        'conquistas' => $conquistas,
        'emblemas' => $emblemas
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
