<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';

$repo = new PersonagemRepository();

$id = 0;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

$personagem = null;
if ($id > 0) {
    $personagem = $repo->buscarPorId($id);
}

// Personagem não encontrado ou não pertence ao usuário logado
if ($personagem === null || $personagem->getId_usuario() !== $_SESSION['id_usuario']) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repo->excluir($personagem->getId());
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Excluir Personagem</h2>
  <a href="index.php" class="btn btn-ghost">← Voltar</a>
</div>

<div class="confirm-card">
  <h3>Você tem certeza?</h3>
  <p>
    Você está prestes a EXCLUIR um personagem
    <strong><?= htmlspecialchars($personagem->getNome()) ?></strong>
    (<?= htmlspecialchars($personagem->getRaca()) ?>, Lv. <?= $personagem->getNivel() ?>).
    Esta ação NÃO pode ser desfeita.
  </p>

  <form method="POST" action="personagem_delete.php?id=<?= $personagem->getId() ?>">
    <div class="form-actions">
      <button type="submit" class="btn btn-excluir">Sim, excluir</button>
      <a href="index.php" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
