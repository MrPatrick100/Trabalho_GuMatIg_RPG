<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';

$repo = new HabilidadeRepository();

$id = 0;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

$habilidade = null;
if ($id > 0) {
    $habilidade = $repo->buscarPorId($id);
}

// Habilidade não encontrada ou não pertence ao usuário logado
if ($habilidade === null || $habilidade->getId_usuario() !== $_SESSION['id_usuario']) {
    header('Location: index2.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habilidade->alterarDados($habilidade->getNome(), $habilidade->getTipo(), $habilidade->getCiclo(),
    $habilidade->getEstilo(), $habilidade->getCusto(), $habilidade->getDescricao(), 1);
    
    $repo->salvar($habilidade);
    header('Location: index2.php');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Excluir Habilidade</h2>
  <a href="index2.php" class="btn btn-ghost">← Voltar</a>
</div>

<div class="confirm-card">
  <h3>Você tem certeza?</h3>
  <p>
    Você está prestes a EXCLUIR uma habilidade
    <strong><?= htmlspecialchars($habilidade->getNome()) ?></strong>
    (<?= htmlspecialchars($habilidade->getEstilo()) ?>, <?= $habilidade->getCiclo() ?>°).
    Esta ação NÃO pode ser desfeita.
  </p>

  <form method="POST" action="habilidade_delete.php?id=<?= $habilidade->getId() ?>">
    <div class="form-actions">
      <button type="submit" class="btn btn-excluir">Sim, excluir</button>
      <a href="index2.php" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
