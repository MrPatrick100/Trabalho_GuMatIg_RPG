<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';

$repo     = new PersonagemRepository();
$personagems = $repo->listarPorUsuario($_SESSION['usuario_id']);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Meus Personagens</h2>
  <a href="personagem_create.php" class="btn btn-primary">+ Novo Personagem</a>
</div>

<?php if (empty($personagems)): ?>
  <div class="empty-state">
    <p>Você ainda não cadastrou nenhum personagem.</p>
    <a href="personagem_create.php" class="btn btn-primary">Cadastrar agora</a>
  </div>
<?php else: ?>
  <div class="table-wrapper">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Tipo</th>
          <th>Nível</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($personagems as $personagem): ?>
          <tr>
            <td><?= $personagem->getId() ?></td>
            <td><strong><?= htmlspecialchars($personagem->getNome()) ?></strong></td>
            <td><span class="badge badge-tipo"><?= htmlspecialchars($personagem->getTipo()) ?></span></td>
            <td>Lv. <?= $personagem->getNivel() ?></td>
            <td class="acoes">
              <a href="personagem_edit.php?id=<?= $personagem->getId() ?>" class="btn btn-sm btn-editar">Editar</a>
              <a href="personagem_delete.php?id=<?= $personagem->getId() ?>" class="btn btn-sm btn-excluir">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
