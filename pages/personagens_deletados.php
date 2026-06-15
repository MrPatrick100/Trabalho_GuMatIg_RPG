<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/PericiaRepository.php';
require_once __DIR__ . '/../repository/ItemRepository.php';

$repoPersonagem = new PersonagemRepository();
$repoPericia = new PericiaRepository();
$repoItem = new ItemRepository();

$personagens = $repoPersonagem->listarPorUsuario($_SESSION['id_usuario']);
$pesquisa = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pesquisa'])) {
  $pesquisa = trim($_GET['pesquisa']);
}

if ($pesquisa !== '') {
  $personagens = $repoPersonagem->listarFiltrando($_SESSION['id_usuario'], $pesquisa);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['limpar'])) {
  $personagens = $repoPersonagem->listarPorUsuario($_SESSION['id_usuario']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['personagens'])) {
    foreach ($_POST['personagens'] as $id_personagem) {
        $pericia = $repoPericia->listarPorPersonagem($id_personagem);
        if($_POST['acao'] === 'excluir') {
            $repoPericia->excluir($id_personagem);
            $repoItem->excluirPorPersonagem($id_personagem);
            $repoPersonagem->excluir($id_personagem);
        }
        else if ($_POST['acao'] === 'recuperar')
        {
            $repoItem->recuperarTodos($id_personagem);
            $repoPersonagem->recuperar($id_personagem);
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<form action="personagens_deletados.php" method="POST">

    <div class="page-header">
        <h2>Personagens Deletados</h2>

        <button type="submit" class="btn btn-primary btn-inicial" name="acao" value="recuperar">
            Recuperar
        </button>

        <button type="submit" class="btn btn-primary" name="acao" value="excluir">
            Excluir permanentemente
        </button>

        <a href="../pages/index.php" class="btn">←</a>

    </div>

    <?php if (!empty($personagens)): ?>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Raça</th>
                        <th>Nível</th>
                        <th>.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personagens as $indice => $personagem): ?>
                        <?php if ($personagem->getDeletado() !== 0): ?>
                            <tr>
                                <td><?= $indice + 1 ?></td>
                                <td><?= htmlspecialchars($personagem->getNome()) ?></td>
                                <td><?= $personagem->getRaca() ?></td>
                                <td><?= $personagem->getNivel() ?></td>
                                <td>
                                    <input
                                        type="checkbox"
                                        name="personagens[]"
                                        value="<?= $personagem->getId() ?>">
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</form>
<!-- <form action="personagens_deletados.php" method="POST"></form>
    <div class="page-header">
        <h2>Personagens Deletados</h2>
            <button type="submit" class="btn btn-primary" name="acao" value="recuperar">Recuperar</button>
            <button type="submit" class="btn btn-primary" name="acao" value="excluir">Excluir permanentemente</button>
    </div>

    <div>
    <form class="search-bar" method="GET" action="index.php">
        <input type="search" name="pesquisa" placeholder="Buscar personagem...">
        <button type="submit">🔍</button>
        <button type="submit" id="limpar" name="limpar">Todos</button>
    </form>
    </div>

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
                <th>.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personagens as $indice => $personagem): ?>
                    <?php if ($personagem->getDeletado() !== 0): ?>
                        <tr>
                        <td><?= $indice + 1 ?></td>
                        <td><strong><?= htmlspecialchars($personagem->getNome()) ?></strong></td>
                        <td><span class="badge badge-raça"><?= htmlspecialchars($personagem->getRaca()) ?></span></td>
                        <td>Lv. <?= $personagem->getNivel() ?></td>
                        <td><input type="checkbox" name="personagens[]" value="<?= $personagem->getId() ?>"></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</form>
<?php endif; ?> -->

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
