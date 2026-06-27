<?php
require_once __DIR__ . '/../repository/UsuarioRepository.php';

$erro = '';
$emailFormulario = $_POST['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '' || $confirmarSenha === '') {
        $erro = 'Preencha todos os campos.';
    }

    else if ($senha !== $confirmarSenha) {
        $erro = 'As senhas devem ser iguais.';
    }
    
    else {
      try {
        // throw new Exception('erro ao cadastrar');
        $repo = new UsuarioRepository();
        $senha = hash('sha256', $senha);
        $repo->criarUsuario($nome, $email, $senha);

        header('Location: login.php');
        exit;

      } catch (Exception $e) {
        $erro = 'Erro ao cadastrar usuário: ' . $e->getMessage();
      }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — RPG CRUD</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body class="login-body">

<div class="login-card">
  <div class="login-logo">RPG CRUD</div>
  <h1 class="login-title">Entrar no sistema</h1>

  <?php if ($erro !== ''): ?>
    <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <form method="POST" action="cadastro.php">
    <div class="form-group">
      <label for="nome">Nome</label>
      <input
        type="name"
        id="nome"
        name="nome"
        placeholder="GuMatIg"
        required
      />
    </div>

    <div class="form-group">
      <label for="email">E-mail</label>
      <input
        type="email"
        id="email"
        name="email"
        placeholder="seu@email.com"
        value="<?= htmlspecialchars($emailFormulario) ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="senha">Senha</label>
      <input
        type="password"
        id="senha"
        name="senha"
        placeholder="••••••••"
        required
      />
    </div>

    <div class="form-group">
      <label for="senha">Confirmar Senha</label>
      <input
        type="password"
        id="senha"
        name="confirmar_senha"
        placeholder="••••••••"
        required
      />
    </div>

    <button type="submit" class="btn btn-primary btn-full">Criar Conta</button>
    <br>
    <br>
    <a href="login.php" class="btn btn-secondary btn-full">Fazer Login</a>
  </form>

</div>

</body>
</html>
