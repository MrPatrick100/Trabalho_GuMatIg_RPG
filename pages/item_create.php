<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/ItemRepository.php';

$repo_item = new ItemRepository();
$repo_personagem = new PersonagemRepository();
$erro = '';

$id_personagem = 0;
if (isset($_GET['id'])) {
    $id_personagem = (int) $_GET['id'];
}

$personagem = null;
if ($id_personagem > 0) {
  $personagem = $repo_personagem->buscarPorId($id_personagem);
}

$inventario = $repo_item->listarPorPersonagem($id_personagem);

$id = 0;
$nome = '';
$tipo = '';
$descricao = '';
$equipado = FALSE;

$tipos = ['Cabeça', 'Peitoral', 'Calça', 'Calçado', 'Arma', 'Amuleto', 'Extra'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim  ($_POST['nome']      ?? '');
    $tipo       = trim  ($_POST['tipo']      ?? '');
    $descricao  = trim  ($_POST['descricao'] ?? '');

    try {
        $item = Item::novo($id_personagem, $nome, $tipo, $descricao, $equipado, FALSE);
        echo $item->getId_Personagem();
        $repo_item->salvar($item);

        header('Location: item_create.php' . '?id=' . $id_personagem);
        exit;
    } catch (InvalidArgumentException $e) {
        $erro = $e->getMessage();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Novo Item (<?= $id_personagem ?>)</h2>
  <a href="index.php" class="btn btn-ghost">← Voltar</a>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="form">
  <div class="form-card">
    <form method="POST" action="item_create.php?id=<?=$id_personagem?>" enctype="multipart/form-data">

      <div class="form-group">
        <label for="nome">Nome do Item</label>
        <input
          type="text"
          id="nome"
          name="nome"
          placeholder="Ex: Capacete de ferro"
          value="<?= htmlspecialchars($nome) ?>"
          required
        />
      </div>

      <div class="form-group">
        <label for="tipo">Tipo</label>
        <select id="tipo" name="tipo" required>
          <option value="">Selecione o tipo...</option>
          <?php foreach ($tipos as $t): ?>
            <?php
              $selecionado = '';
              if ($tipo === $t) {
                  $selecionado = 'selected';
              }
            ?>
            <option value="<?= $t ?>" <?= $selecionado ?>>
              <?= $t ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="descricao">Descrição</label>
        <input
          type="text"
          id="descricao"
          name="descricao"
          value="<?= htmlspecialchars($descricao) ?>"
          required
        />
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Adicionar Item</button>
        <a href="index.php" class="btn btn-ghost">Cancelar</a>
      </div>
    </form>
  </div>

  <div class="form-card">
    <div class="form-group">
        <h3 for="inventario">Inventário</h3>
        <?php foreach ($inventario as $indice => $it): ?>
        <div class="form-group2">
          <label for="nome">Nome: <?= $it->getNome() ?></label>
        </div>

        <div class="form-group2">
          <label for="tipo">Tipo: <?= $it->getTipo() ?></label>
        </div>

        <div class="form-group2">
          <label for="equipado">Equipado: <?= $it->getEquipado() ?></label>
        </div>

        <div class="form-group2">
          <label for="deletado">Deletado: <?= $it->getDeletado() ?></label>
        </div>

        <div class="form-group2">
          <label for="descricao">Descrição: <?= $it->getDescricao() ?></label>
        </div>
        <br>
        <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>