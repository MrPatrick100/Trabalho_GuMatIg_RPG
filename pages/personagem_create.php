<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';

$repo = new PersonagemRepository();
$erro = '';

$id_usuario = 0;
$id = 0;
$nome = '';
$idade = 0;
$raca = '';
$nivel = 1;
$agilidade = 0;
$forca = 0;
$intelecto = 0;
$constituicao = 0;
$carisma = 0;
$magia = 0;
$aparencia = '';
$hp = 0;
$stamina = 0;
$mana = 0;
$pf = 0;

$racas = ['Humano', 'Elfo', 'Goblin', 'Anao', 'Lefou', 'Demonio', 'Gnomo', 'Orc', 'Troll', 'Tita'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $idade = (int) ($_POST['idade'] ?? 0);
    $raca = trim($_POST['raca'] ?? '');
    $nivel = (int) ($_POST['nivel'] ?? 1);
    $agilidade = (int) ($_POST['agilidade'] ?? 0);
    $forca = (int) ($_POST['forca'] ?? 0);
    $intelecto = (int) ($_POST['intelecto'] ?? 0);
    $constituicao = (int) ($_POST['constituicao'] ?? 0);
    $carisma = (int) ($_POST['carisma'] ?? 0);
    $magia = (int) ($_POST['magia'] ?? 0);
    $aparencia = trim($_POST['aparencia'] ?? '');
    $hp = $nivel * 5 + $constituicao * 5;
    $stamina = $forca * 10;
    $mana = $magia * 10;
    if($carisma > $intelecto) $pf = $carisma;
    else $pf = $intelecto;
    $id_usuario = $_SESSION['id_usuario'];

    try {
        $personagem = Personagem::novo($id_usuario, $nome, $idade, $raca, $nivel, $agilidade, $forca, $intelecto, $constituicao, $carisma, $magia, $aparencia);
        $repo->salvar($personagem);

        header('Location: index.php');
        exit;
    } catch (InvalidArgumentException $e) {
        $erro = $e->getMessage();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Novo Personagem</h2>
  <a href="index.php" class="btn btn-ghost">← Voltar</a>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="form-card">
  <form method="POST" action="personagem_create.php">

    <div class="form-group">
      <label for="nome">Nome do Personagem</label>
      <input
        type="text"
        id="nome"
        name="nome"
        placeholder="Ex: Dragão"
        value="<?= htmlspecialchars($nome) ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="idade">Idade</label>
      <input
        type="number"
        id="idade"
        name="idade"
        placeholder="Ex: 50"
        value="<?= htmlspecialchars($idade) ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="raca">Raça</label>
      <select id="raca" name="raca" required>
        <option value="">Selecione a raça...</option>
        <?php foreach ($racas as $r): ?>
          <?php
            $selecionado = '';
            if ($raca === $r) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $r ?>" <?= $selecionado ?>>
            <?= $r ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="nivel">Nível (1 – 5)</label>
      <input
        type="number"
        id="nivel"
        name="nivel"
        min="1"
        max="5"
        value="<?= $nivel ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="agilidade">Agilidade</label>
      <input
        type="number"
        id="agilidade"
        name="agilidade"
        min="0"
        max="5"
        value="<?= $agilidade ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="forca">Força</label>
      <input
        type="number"
        id="forca"
        name="forca"
        min="0"
        max="5"
        value="<?= $forca ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="intelecto">Intelecto</label>
      <input
        type="number"
        id="intelecto"
        name="intelecto"
        min="0"
        max="5"
        value="<?= $intelecto ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="constituicao">Constituição</label>
      <input
        type="number"
        id="constituicao"
        name="constituicao"
        min="0"
        max="5"
        value="<?= $constituicao ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="carisma">Carisma</label>
      <input
        type="number"
        id="carisma"
        name="carisma"
        min="0"
        max="5"
        value="<?= $carisma ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="magia">Magia</label>
      <input
        type="number"
        id="magia"
        name="magia"
        min="0"
        max="5"
        value="<?= $magia ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="aparencia">Aparência</label>
      <input
        type="file"
        id="aparencia"
        name="aparencia"
        value="<?= $aparencia ?>"
      />
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Cadastrar Personagem</button>
      <a href="index.php" class="btn btn-ghost">Cancelar</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>