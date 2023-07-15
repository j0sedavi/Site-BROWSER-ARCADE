<?php
session_start(); // Inicia a sessão

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

// Função para verificar as credenciais do usuário
function verificarCredenciais($conn, $nome, $senha) {
    $sql = "SELECT * FROM Contas WHERE Nome = '$nome' AND Senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true; // Credenciais válidas
    } else {
        return false; // Credenciais inválidas
    }
}

// Verifica se o usuário está logado
if (isset($_SESSION["nome"])) {
    // O usuário já está logado, redireciona para a página do perfil
    header("Location: perfil.php");
    exit;
}

// Verifica se a requisição é para efetuar o login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $senha = $_POST["senha"];

    // Verifica as credenciais do usuário
    if (verificarCredenciais($conn, $nome, $senha)) {
        // Credenciais válidas, armazena o nome do usuário na sessão e redireciona para a página do perfil
        $_SESSION["nome"] = $nome;
        header("Location: perfil.php");
        exit;
    } else {
        // Credenciais inválidas, exibe uma mensagem de erro
        $mensagemErro = "Credenciais inválidas. Por favor, tente novamente.";
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
    
    <h1 style="font-size: 25px; margin-bottom: 0px;">LOGIN</h1>
    <div class="form-container">
      <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="text" class="form-input" name="nome" placeholder="Nome de usuário">
        <input type="password" class="form-input" name="senha" placeholder="Senha">
        <br />
        <input type="submit" class="form-button" value="ENTRAR">
      </form>
      <?php
        // Exibe a mensagem de erro, se existir
        if (isset($mensagemErro)) {
            echo '<p class="error-message">' . $mensagemErro . '</p>';
        }
      ?>
    </div>
  </div>
</body>
</html>
