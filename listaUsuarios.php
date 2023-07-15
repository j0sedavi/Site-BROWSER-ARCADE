<?php
// ...
$servername = "localhost"; // Nome do servidor do banco de dados
$username = ""; // Nome de usuário do banco de dados
$password = ""; // Senha do banco de dados
$dbname = ""; // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a requisição é para excluir um usuário
if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    excluirUsuario($conn, $id);
}

// Função para excluir um usuário
function excluirUsuario($conn, $id) {
    $sql = "DELETE FROM Contas WHERE Id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário excluído com sucesso!";
        // Redireciona de volta para a página de lista de usuários após a exclusão
        header("Location: admsystem5370.php");
        exit();
    } else {
        echo "Erro ao excluir usuário: " . $conn->error;
    }
}

// ...
?>
