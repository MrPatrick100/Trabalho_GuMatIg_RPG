<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RPG CRUD</title>
  <link rel="stylesheet" href="../assets/style.css" />
</head>
<body>

<header class="site-header">
  <div class="header-inner">
    <a href="../pages/index.php" class="logo">RPG CRUD</a>

    <nav class="nav">
      <a href="../pages/index.php">Meus Personagens</a>
      <a href="../pages/index2.php">Minhas Habilidades</a>
      <a href="../pages/personagem_create.php">+ Novo Personagem</a>
      <a href="../pages/habilidade_create.php">+ Nova Habilidade</a>
    </nav>

    <div class="header-user">
      <?php
        $nomeUser = $_SESSION['usuario_nome'] ?? 'Usuário';
      ?>
      <span class="user-name">
        <?= htmlspecialchars($nomeUser) ?>
      </span>
      <a href="../pages/logout.php" class="btn-logout">Sair</a>
    </div>
  </div>
</header>

<main class="container">
