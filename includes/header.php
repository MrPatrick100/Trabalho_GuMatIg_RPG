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
  <button id="btnMenu" class="btn">+</button>

  <div id="sidebar" class="sidebar">
    <img src=<?= $_SESSION['foto_perfil'] ?? '../assets/avatar.png' ?> class="avatar" id="avatar-header">
    <br>
    <a href="../pages/perfil.php" class="btn">Perfil</a> <br>
    <a href="../pages/seguranca_privacidade.php" class="btn">Segurança e Privacidade</a> <br>
    <a href="../pages/index.php" class="btn">Configurações</a> <br>
    <script>
      const btnMenu = document.getElementById("btnMenu");
      const sidebar = document.getElementById("sidebar");

      btnMenu.addEventListener("click", () => {
          btnMenu.classList.toggle("active");
          sidebar.classList.toggle("active");
      });
  </script>
  </div>
    <div class="header-user">
      <?php
        $nomeUser = $_SESSION['usuario_nome'] ?? 'Usuário';
      ?>
      <a href="../pages/perfil.php" class="user-name">
        <?= htmlspecialchars($nomeUser) ?>
      </a>
      <a href="../pages/logout.php" class="btn-logout">Sair</a>
    </div>

    <a href="../pages/index.php" class="logo">RPG CRUD</a>

    <nav class="nav">
      <a href="../pages/index.php">Meus Personagens</a>
      <a href="../pages/index2.php">Minhas Habilidades</a>
      <a href="../pages/personagem_create.php">+ Novo Personagem</a>
      <a href="../pages/habilidade_create.php">+ Nova Habilidade</a>
    </nav>
  </div>
</header>

<main class="container">
