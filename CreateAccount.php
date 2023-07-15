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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $gmail = $_POST["gmail"];
    $senha = $_POST["senha"];

    // Verifica se o nome de usuário já existe
    $sqlNome = "SELECT * FROM Contas WHERE Nome = '$nome'";
    $resultNome = $conn->query($sqlNome);
    if ($resultNome->num_rows > 0) {
        echo "Nome de usuário já existe!";
    } else {
        // Verifica se o e-mail já existe
        $sqlGmail = "SELECT * FROM Contas WHERE Gmail = '$gmail'";
        $resultGmail = $conn->query($sqlGmail);
        if ($resultGmail->num_rows > 0) {
            echo "E-mail já existe!";
        } else {
            // Obtém o próximo valor de ID
            $sqlCount = "SELECT COUNT(*) as total FROM Contas";
            $resultCount = $conn->query($sqlCount);
            $row = $resultCount->fetch_assoc();
            $nextId = $row["total"] + 1;

            // Cria a consulta SQL para inserir os dados na tabela "conta"
            $sql = "INSERT INTO Contas (Id, Nome, Gmail, Senha, Conquistas, Emblemas, Info) VALUES ('$nextId', '$nome', '$gmail', '$senha', 0, 0, 0)";

            if ($conn->query($sql) === TRUE) {
                echo "Conta criada com sucesso!";
            } else {
                echo "Erro ao criar conta: " . $conn->error;
            }
        }
    }
}

// Fechar a conexão (opcional)
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Browser Arcade</title>
  <style>
   
    
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
    <link rel="stylesheet" href="style.css" type="text/css" media="all" />
</head>
<body>
  <div class="container">
    <img class="logo" src="https://media.discordapp.net/attachments/1079511643530207306/1128190366403788851/Sem_titulo37.png" alt="Browser Arcade Logo">
    <h1>Browser Arcade</h1>
    <p>Bem-vindo(a) ao Browser Arcade, Um projeto onde tenta trazer os clássicos jogos de navegador para o PlayStation 2.</p>
    
    <a class="button" href="CreateAccount.php">Criar Conta</a>
    <a class="button" href="loginAccount.php">Fazer Login</a>
    <a style="margin-top: 10px;" class="button" href="download.html">Baixar Browser Arcade</a>
    <a class="button" href="index.php">Rank</a>
    
    <h1 style="font-size: 25px; margin-bottom: 0px;">CRIAR CONTA</h1>
    <div class="form-container">
      <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="text" class="form-input" name="nome" placeholder="Nome de usuário">
        <input type="text" class="form-input" name="gmail" placeholder="Gmail">
        <input type="password" class="form-input" name="senha" placeholder="Senha">
        <br />
        <input type="submit" class="form-button" value="CRIAR">
      </form>
    </div>
  </div>
</body>
</html>
