<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';
require_once __DIR__ . '/../repository/RelacaoPersonagemHabilidadeRepository.php';

$repoHabilidade = new HabilidadeRepository();
$repoRelacao = new RelacaoPersonagemHabilidadeRepository();

$habilidades = $repoHabilidade->listarPorUsuario($_SESSION['id_usuario']);
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['habilidades'])) {
    foreach ($_POST['habilidades'] as $id_habilidade) {
        if($_POST['acao'] === 'excluir') {
            $repoRelacao->excluirPorHabilidade($id_habilidade);
            $repoHabilidade->excluir($id_habilidade);
        }
        else if ($_POST['acao'] === 'recuperar')
        {
            $repoHabilidade->recuperar($id_habilidade);
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<form action="habilidades_deletadas.php" method="POST">

    <div class="page-header">
        <h2>Habilidades Deletados</h2>

        <button type="submit" class="btn btn-primary" name="acao" value="recuperar">
            Recuperar
        </button>

        <button type="submit" class="btn btn-primary" name="acao" value="excluir">
            Excluir permanentemente
        </button>
    </div>

    <?php if (!empty($habilidades)): ?>
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Estilo</th>
                        <th>Ciclo</th>
                        <th>.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($habilidades as $indice => $h): ?>
                        <?php if ($h->getDeletado() !== 0): ?>
                            <tr>
                                <td><?= $indice + 1 ?></td>
                                <td><?= htmlspecialchars($h->getNome()) ?></td>
                                <td><?= $h->getEstilo() ?></td>
                                <td><?= $h->getCiclo() ?></td>
                                <td>
                                    <input
                                        type="checkbox"
                                        name="habilidades[]"
                                        value="<?= $h->getId() ?>">
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
