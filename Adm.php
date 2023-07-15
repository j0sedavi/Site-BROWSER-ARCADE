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

// Função para excluir um usuário
function excluirUsuario($conn, $id) {
    $sql = "DELETE FROM Contas WHERE Id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro ao excluir usuário: " . $conn->error;
    }
}

// Função para atualizar o nome, emblemas e conquistas de um usuário
function atualizarUsuario($conn, $id, $nome, $emblemas, $conquistas) {
    $sql = "UPDATE Contas SET Nome = '$nome', Emblemas = '$emblemas', Conquistas = '$conquistas' WHERE Id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar usuário: " . $conn->error;
    }
}

// Verifica se a requisição é para excluir um usuário
if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    excluirUsuario($conn, $id);
}

// Verifica se a requisição é para atualizar um usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $emblemas = $_POST["emblemas"];
    $conquistas = $_POST["conquistas"];
    atualizarUsuario($conn, $id, $nome, $emblemas, $conquistas);
}

// Consulta SQL para buscar todos os usuários
$sql = "SELECT * FROM Contas";
$result = $conn->query($sql);

// Fechar a conexão (opcional)
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            padding: 40px;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        h1 {
            color: #ff0000;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #9400d3;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-right: 10px;
        }

        .button:hover {
            background-color: #8a2be2;
        }

        .user-table {
            margin-top: 40px;
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th,
        .user-table td {
            padding: 10px;
            border: 1px solid #fff;
        }

        .user-table th {
            background-color: #800080;
            color: #fff;
            font-weight: bold;
        }

        .user-table td {
            background-color: #2f2f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Usuários</h1>
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Emblemas</th>
                    <th>Conquistas</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["Id"];
                        $nome = $row["Nome"];
                        $emblemas = $row["Emblemas"];
                        $conquistas = $row["Conquistas"];
                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$nome</td>";
                        echo "<td>$emblemas</td>";
                        echo "<td>$conquistas</td>";
                        echo "<td>";
                        echo "<a class='button' href='editarUsuario.php?id=$id'>Editar</a>";
                        echo "<a style='margin-top:20px;' class='button' href='listaUsuarios.php?excluir=$id'>Excluir</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum usuário encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
