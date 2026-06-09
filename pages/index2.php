<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';
require_once __DIR__ . '/../repository/RelacaoPersonagemHabilidadeRepository.php';

$repoPersonagem = new PersonagemRepository();
$personagens = $repoPersonagem->listarPorUsuario($_SESSION['id_usuario']);
$repoHabilidade = new HabilidadeRepository();
$habilidades = $repoHabilidade->listarPorUsuario($_SESSION['id_usuario']);
$repoRelacao = new RelacaoPersonagemHabilidadeRepository();
$relacao = $repoRelacao->listarPorUsuario($_SESSION['id_usuario']);
$pesquisa = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pesquisa'])) {
  $pesquisa = trim($_GET['pesquisa']);
}

if ($pesquisa !== '') {
  $habilidades = $repoHabilidade->listarFiltrando($_SESSION['id_usuario'], $pesquisa);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['limpar'])) {
  $habilidades = $repoHabilidade->listarPorUsuario($_SESSION['id_usuario']);
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Minhas Habilidades</h2>
  <a href="habilidade_create.php" class="btn btn-primary">+ Nova Habilidade</a>
  <a href="habilidades_deletadas.php" class="btn btn-primary" id="btn-deletados">Deletados</a>
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
      <div class="personagem">
        <?php foreach ($personagens as $p): ?>
          <?php if ($p->getDeletado() !== 1): ?>
            <button class="btn btn-personagem">
              ▶ <?= $p->getNome() ?>
            </button>
          <?php endif; ?>
          <?php foreach ($habilidades as $indice => $h): ?>
            <?php if ($h->getDeletado() !== 1): ?>
              <ul>
                <li>
                  <div class="habilidades">
                    <tbody>
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
                    </tbody>
                  </div>
                </li>
              </ul>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    </table>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
