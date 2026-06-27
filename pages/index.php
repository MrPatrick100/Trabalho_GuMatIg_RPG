<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';

$repo = new PersonagemRepository();
$personagens = $repo->listarPorUsuario($_SESSION['id_usuario']);
$pesquisa = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pesquisar'])) {
  $pesquisa = trim($_GET['pesquisar']);
}

if ($pesquisa !== '') {
  $personagens = $repo->listarFiltrando($_SESSION['id_usuario'], $pesquisa);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['limpar'])) {
  $personagens = $repo->listarPorUsuario($_SESSION['id_usuario']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['favorito'])) {
  $personagens = $repo->filtrarPorFavorito($_SESSION['id_usuario']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['idp'])) {
  try {
    $idp = $_GET['idp'];
    
    if($_GET['acao'] === 'desfavoritar') {
      $repo->setFavorito($idp, 0);
    }

    else if($_GET['acao'] === 'favoritar') {
      $repo->setFavorito($idp, 1);
    }
  } catch (Exception $e) {
    $erro = 'Ocorreu um erro ao favoritar o personagem: ' . $e->getMessage();
  }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Meus Personagens</h2>
  <a href="personagem_create.php" class="btn btn-primary btn-inicial" id="btn-novo-personagem">+ Novo Personagem</a>
  <a href="personagens_deletados.php" class="btn" id="btn-deletados"><img src="../assets/images/reciclagem.png" width="20px" class="img-reciclagem"></a>
</div>

<div>
  <form class="search-bar" method="GET" action="index.php">
    <input type="search" name="btn-pesquisa" placeholder="Buscar personagem...">
    <button type="submit" name="pesquisar">🔍</button>
    <button type="submit" id="btn-limpar" name="limpar">Todos</button>
    <button type="submit" id="btn-favorito" name="favorito">Favoritos</button>
    <!-- <button type="submit" id="btn-filtrar" name="filtrar">Filtrar</button>
    <button type="button" id="btn-mostrar-filtros" name="mostrar-filtros">+</button>
    <input type="checkbox" class="opcao-filtro" id="ciclo" name="filtro" value="ciclo">
    <input type="checkbox" class="opcao-filtro" id="nivel" name="filtro" value="nivel"> -->
  </form>
</div>
<br>

<?php if (empty($personagens)): ?>
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
          <th>Raça</th>
          <th>Nível</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($personagens as $indice => $personagem): ?>
          <?php if ($personagem->getDeletado() !== 1): ?>
            <tr class="tr-personagem">
              <td><?= $indice + 1 ?></td>
              <td><strong><?= htmlspecialchars($personagem->getNome()) ?></strong></td>
              <td><span class="badge badge-raça"><?= htmlspecialchars($personagem->getRaca()) ?></span></td>
              <td>Lv. <?= $personagem->getNivel() ?></td>
              <td class="acoes">
                <a href="item_create.php?id=<?= $personagem->getId() ?>" class="btn btn-sm btn-editar">Editar Inventário</a>
                <a href="personagem_edit.php?id=<?= $personagem->getId() ?>" class="btn btn-sm btn-editar">Editar Personagem</a>
                <a href="personagem_delete.php?id=<?= $personagem->getId() ?>" class="btn btn-sm btn-excluir">Excluir</a>
                <a href="personagem_espiar.php?id=<?= $personagem->getId() ?>" class="btn btn-sm btn-espiar">Espiar</a>
                <?php if ($personagem->getFavorito() == 1): ?>
                  <a href="index.php?idp=<?= $personagem->getId() ?>&acao=desfavoritar" class="btn btn-sm btn-desfavoritar"><img src="../assets/images/estrela_favoritada.png" width="20px" class="img-favorito"></a>
                <?php else: ?>
                  <a href="index.php?idp=<?= $personagem->getId() ?>&acao=favoritar" class="btn btn-sm btn-favoritar"><img src="../assets/images/estrela_desfavoritada.png" width="20px" class="img-favorito"></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
