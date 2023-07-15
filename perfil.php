<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION["nome"])) {
    // O usuário não está logado, redireciona para a página de login
    header("Location: loginAccount.php");
    exit;
}

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

// Obtém o nome do usuário da sessão
$nomeUsuario = $_SESSION["nome"];

// Função para obter as informações do perfil do usuário
function obterInformacoesPerfil($conn, $nomeUsuario) {
    $sql = "SELECT * FROM Contas WHERE Nome = '$nomeUsuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Retorna os dados do perfil do usuário
    } else {
        return null; // Usuário não encontrado
    }
}

// Verifica se a requisição é para atualizar o nome do perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novoNome = $_POST["novoNome"];

    // Verifica se o novo nome já existe no banco de dados
    $sqlVerificarNome = "SELECT * FROM Contas WHERE Nome = '$novoNome'";
    $resultVerificarNome = $conn->query($sqlVerificarNome);

    if ($resultVerificarNome->num_rows > 0) {
        $mensagemErro = "O nome escolhido já está em uso. Escolha outro nome.";
    } else {
        // Atualiza o nome do perfil no banco de dados
        $sqlAtualizarNome = "UPDATE Contas SET Nome = '$novoNome' WHERE Nome = '$nomeUsuario'";
        $resultAtualizarNome = $conn->query($sqlAtualizarNome);

        if ($resultAtualizarNome === TRUE) {
            // Atualização bem-sucedida, atualiza o nome na sessão
            $_SESSION["nome"] = $novoNome;
            header("Location: perfil.php");
            exit();
        } else {
            // Erro ao atualizar o nome
            $mensagemErro = "Erro ao atualizar o nome do perfil.";
        }
    }
}

// Obtém as informações do perfil do usuário
$informacoesPerfil = obterInformacoesPerfil($conn, $nomeUsuario);

// Fechar a conexão (opcional)
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
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
    
    .profile-info {
      margin-top: 40px;
    }
    
    .profile-info p {
      margin-bottom: 10px;
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

    .error-message {
      color: #ff0000;
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
    
    <h1>Perfil</h1>
    <div class="profile-info">
      <?php if ($informacoesPerfil) : ?>
        <p>Nome: <?php echo $informacoesPerfil["Nome"]; ?></p>
        <p>Conquistas: <?php echo $informacoesPerfil["Conquistas"]; ?></p>
        <p>Emblemas: <?php echo $informacoesPerfil["Emblemas"]; ?></p>
      <?php endif; ?>
    </div>
    
    <h1 style="font-size: 25px; margin-bottom: 0px;">EDITAR PERFIL</h1>
    <div class="form-container">
      <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="text" class="form-input" name="novoNome" placeholder="Novo nome" required>
        <br />
        <input type="submit" class="form-button" value="Salvar">
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
