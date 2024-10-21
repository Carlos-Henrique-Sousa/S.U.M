<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/area_escolha/login_cadast.css" />
  <title>Login - Cadastrar</title>
</head>
<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="area_escola_cadast_login.php" class="sign-in-form" method="POST">
          <h2 class="title">Login</h2>
          <div class="input-field">
            <i class="fa-solid fa-user"></i>
            <input type="text" placeholder="Username" name="email" required />
          </div>
          <div class="input-field">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Password" name="senha" required />
          </div>
          <input type="submit" name="login" value="Login" class="btn solid" />
        </form>
        <form action="area_escola_cadast_login.php" class="sign-up-form" method="POST">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fa-solid fa-user"></i>
            <input type="text" placeholder="Nome da Escola" name="NomeEscola" required />
          </div>
          <div class="input-field">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" placeholder="Email" name="EmailEscola" required />
          </div>
          <div class="input-field">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Password" name="SenhaEscola" required />
          </div>
          <div class="input-field">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Confirmar Senha" name="CSenhaEscola" required />
          </div>
          <input type="submit" name="cadastrar_escola" class="btn" value="Sign up" />
        </form>
      </div>
    </div>
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Deseja Cadastrar a sua escola?</h3>
          <p>
            Faça já o seu cadastro! Esteja apenas um passo de distância dos seus alunos!
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Cadastrar
          </button>
        </div>
        <img src="../dist/imgs/Security On-rafiki.svg" class="image" alt="Log image" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Já se cadastrou? Faça login agora!</h3>
          <p>
            Entre na sua conta para estar por dentro de tudo!
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Login
          </button>
        </div>
        <img src="../dist/imgs/Login-rafiki.svg" class="image" alt="Register image" />
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <script src="../dist/js/cadast_login.js"></script>

  <?php
  include('../data/database.php');

  // Cadastro de Escola
  if (isset($_POST['cadastrar_escola'])) {
    $nome = $_POST['NomeEscola'];
    $email = $_POST['EmailEscola'];
    $senha = $_POST['SenhaEscola'];
    $confirmar_senha = $_POST['CSenhaEscola'];

    // Verificar se as senhas são iguais
    if ($senha !== $confirmar_senha) {
      echo '<script>
              document.addEventListener("DOMContentLoaded", function() {
                alert("As senhas não correspondem!");
              });
            </script>';
    } else {
      // Criptografar a senha antes de salvar no banco de dados
      $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

      // Verificar se o e-mail já está registrado
      $sql_verificar = "SELECT * FROM escola WHERE email = :email";
      $stmt_verificar = $conect->prepare($sql_verificar);
      $stmt_verificar->bindParam(':email', $email);
      $stmt_verificar->execute();
      $resultado = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

      if ($resultado) {
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                  alert("Email já cadastrado!");
                });
              </script>';
      } else {
        // Inserir a nova escola no banco de dados
        $sql = "INSERT INTO escola (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $conect->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_criptografada);

        if ($stmt->execute()) {
          echo '<script>
                  document.addEventListener("DOMContentLoaded", function() {
                    alert("Cadastro feito com sucesso!");
                    window.location.href = "home_escola.php";
                  });
                </script>';
        } else {
          echo '<script>
                  document.addEventListener("DOMContentLoaded", function() {
                    alert("Erro ao cadastrar a escola. Tente novamente mais tarde.");
                  });
                </script>';
        }
      }
    }
  }

  // Login de Escola
  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM escola WHERE email = :email";
    $stmt = $conect->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
      session_start();
      $_SESSION['email'] = $email;
      echo '<script>
              window.location.href = "area/escolar/home_escola.php";
            </script>';
    } else {
      echo '<script>
              document.addEventListener("DOMContentLoaded", function() {
                alert("Login ou senha incorretos!");
              });
            </script>';
    }
  }
  ?>
</body>
</html>
