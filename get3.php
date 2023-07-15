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

// Cria a consulta SQL para obter o ranking das top 5 pessoas por conquistas
$sql = "SELECT Nome, Conquistas, Emblemas FROM Contas ORDER BY Conquistas DESC LIMIT 5";
$result = $conn->query($sql);

// Verifica se há resultados
if ($result->num_rows > 0) {
    $ranking = array();

    // Percorre os resultados e monta o ranking
    $position = 1;
    while ($row = $result->fetch_assoc()) {
        $nome = $row['Nome'];
        $conquistas = $row['Conquistas'];
        $emblemas = $row['Emblemas'];

        // Cria um item no ranking com a posição, nome, conquistas e emblemas
        $item = array(
            'posicao' => $position,
            'nome' => $nome,
            'conquistas' => $conquistas,
            'emblemas' => $emblemas
        );

        // Adiciona o item ao ranking
        $ranking[] = $item;

        // Incrementa a posição
        $position++;
    }

    // Retorna o ranking em formato JSON
    echo json_encode($ranking);
} else {
    // Retorna um erro se não houver resultados
    $response = array('error' => 'Não há dados suficientes para gerar o ranking.');
    echo json_encode($response);
}

// Fechar a conexão (opcional)
$conn->close();
?>
