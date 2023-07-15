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

// Função para atualizar o nome, emblemas e conquistas de um usuário
function atualizarUsuario($conn, $id, $nome, $emblemas, $conquistas) {
    $sql = "UPDATE Contas SET Nome = '$nome', Emblemas = '$emblemas', Conquistas = '$conquistas' WHERE Id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Usuário atualizado com sucesso!";
        header("Location: Adm.php");
        exit();
    } else {
        echo "Erro ao atualizar usuário: " . $conn->error;
    }
}

// Verifica se a requisição é para atualizar um usuário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $emblemas = $_POST["emblemas"];
    $conquistas = $_POST["conquistas"];
    atualizarUsuario($conn, $id, $nome, $emblemas, $conquistas);
}

// Verifica se um ID de usuário foi fornecido
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Consulta SQL para buscar os dados do usuário específico
    $sql = "SELECT * FROM Contas WHERE Id = '$id'";
    $result = $conn->query($sql);

    // Verifica se o usuário existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row["Nome"];
        $emblemas = $row["Emblemas"];
        $conquistas = $row["Conquistas"];
    } else {
        echo "Usuário não encontrado.";
        exit;
    }
} else {
    echo "ID de usuário não fornecido.";
    exit;
}

// Fechar a conexão (opcional)
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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

        .form-container {
            margin-top: 40px;
        }

        .form-title {
            font-size: 24px;
            color: #ff0000;
            margin-bottom: 10px;
        }

        .form-input {
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
            max-width: 300px;
            border: 1px solid #fff;
            background-color: #2f2f2f;
            color: #fff;
        }

        .form-button {
            padding: 10px 20px;
            background-color: #9400d3;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            margin-top: 10px;
        }

        .form-button:hover {
            background-color: #8a2be2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Usuário</h1>
        <div class="form-container">
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="text" class="form-input" name="nome" placeholder="Nome de usuário" value="<?php echo $nome; ?>">
                <input type="text" class="form-input" name="emblemas" placeholder="Emblemas" value="<?php echo $emblemas; ?>">
                <input type="text" class="form-input" name="conquistas" placeholder="Conquistas" value="<?php echo $conquistas; ?>">
                <br />
                <input type="submit" class="form-button" value="Atualizar">
            </form>
        </div>
    </div>
</body>
</html>
