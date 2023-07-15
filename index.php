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

// Consulta SQL para buscar os dados da tabela "conta" ordenados por conquistas em ordem decrescente
$sql = "SELECT Nome, Conquistas, Emblemas FROM Contas ORDER BY Conquistas DESC";

// Executa a consulta e obtém os resultados
$result = $conn->query($sql);

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
    
    .ranking-container {
      margin-top: 40px;
      overflow-x: auto;
    }
    
    .ranking-table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .ranking-table th,
    .ranking-table td {
      padding: 10px;
      border: 1px solid #fff;
    }
    
    .ranking-table th {
      background-color: #800080;
      color: #fff;
      font-weight: bold;
    }
    
    .ranking-table td {
      background-color: #2f2f2f;
    }
    
    @media (max-width: 480px) {
      .button {
        display: block;
        margin-bottom: 10px;
      }
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
    
    <h1 style="font-size: 25px; margin-bottom: 0px;">RANKING</h1>
    <div class="ranking-container">
      <table class="ranking-table">
        <thead>
          <tr>
            <th>Posição</th>
            <th>Jogador</th>
            <th>Conquistas</th>
            <th>Emblemas</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
              $position = 1;
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $position . "</td>";
                  echo "<td>" . $row["Nome"] . "</td>";
                  echo "<td>" . $row["Conquistas"] . "</td>";
                  echo "<td>" . $row["Emblemas"] . "</td>";
                  echo "</tr>";
                  $position++;
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
