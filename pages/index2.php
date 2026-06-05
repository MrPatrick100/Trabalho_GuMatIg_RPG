<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';

$repo = new HabilidadeRepository();
$habilidades = $repo->listarPorUsuario($_SESSION['id_usuario']);
$pesquisa = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pesquisa'])) {
  $pesquisa = trim($_GET['pesquisa']);
}

if ($pesquisa !== '') {
  $habilidades = $repo->listarFiltrando($_SESSION['id_usuario'], $pesquisa);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['limpar'])) {
  $habilidades = $repo->listarPorUsuario($_SESSION['id_usuario']);
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Minhas Habilidades</h2>
  <a href="habilidade_create.php" class="btn btn-primary">+ Nova Habilidade</a>
</div>

<div>
  <form class="search-bar" method="GET" action="index2.php">
    <input type="search" name="pesquisa" placeholder="Buscar habilidade...">
    <button type="submit">🔍</button>
    <button type="submit" id="limpar" name="limpar">Todos</button>
  </form>
</div>

<?php if (empty($habilidades)): ?>
  <div class="empty-state">
    <p>Você ainda não cadastrou nenhuma habilidade.</p>
    <a href="habilidade_create.php" class="btn btn-primary">Cadastrar agora</a>
  </div>
<?php else: ?>
  <div class="table-wrapper">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Estilo</th>
          <th>Ciclo</th>
          <th>Ações</th>
        </tr>
      </thead>
      <!-- <div class="personagem">
        <button class="btn-personagem">
          ▶ <?= $personagem->getNome() ?>
        </button>
        <div class="habilidades">
          <ul>
              <li>Habilidade 1</li>
              <li>Habilidade 2</li>
              <li>Habilidade 3</li>
          </ul> -->
          <tbody>
            <?php foreach ($habilidades as $indice => $h): ?>
              <tr>
                <td><?= $indice + 1 ?></td>
                <td><strong><?= htmlspecialchars($h->getNome()) ?></strong></td>
                <td><span class="badge badge-raça"><?= htmlspecialchars($h->getEstilo()) ?></span></td>
                <td><?= $h->getCiclo() ?>°</td>
                <td class="acoes">
                  <a href="habilidade_edit.php?id=<?= $h->getId() ?>" class="btn btn-sm btn-editar">Editar</a>
                  <a href="habilidade_delete.php?id=<?= $h->getId() ?>" class="btn btn-sm btn-excluir">Excluir</a>
                  <a href="habilidade_espiar.php?id=<?= $h->getId() ?>" class="btn btn-sm btn-espiar">Espiar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        <!-- </div> -->
      <!-- </div> -->
    </table>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
