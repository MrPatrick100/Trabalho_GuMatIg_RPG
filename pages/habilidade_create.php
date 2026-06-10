<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';
require_once __DIR__ . '/../repository/RelacaoPersonagemHabilidadeRepository.php';

$repo_habilidade = new HabilidadeRepository();
$repo_personagem = new PersonagemRepository();
$repo_relacao = new RelacaoPersonagemHabilidadeRepository();
$personagens = $repo_personagem->listarPorUsuario($_SESSION['id_usuario']);
$personagem = null;
$erro = '';

$id_usuario = 0;
$id = 0;
$nome = '';
$tipo = '';
$ciclo = 1;
$estilo = '';
$custo = 2;
$descricao = '';

$tipos = ['Passiva', 'Ativa'];
$estilos = ['Física', 'Mágica', 'Híbrida'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim  ($_POST['nome']      ?? '');
    $tipo       = trim  ($_POST['tipo']      ?? '');
    $ciclo      = (int) ($_POST['ciclo']     ?? 0);
    $estilo     = trim  ($_POST['estilo']    ?? '');
    $custo      = (int) ($_POST['custo']     ?? 0);
    $descricao  = trim  ($_POST['descricao'] ?? '');

    $id_usuario = $_SESSION['id_usuario'];

    try {
        $habilidade = Habilidade::novo($id_usuario, $nome, $tipo, $ciclo, $estilo, $custo, $descricao, 0);
        $repo_habilidade->salvar($habilidade);

        $id_habilidade = $habilidade->getId();
        $id_personagem  = (int)  ($_POST['personagem'] ?? 0);

        $relacao = RelacaoPersonagemHabilidade::novo($id_usuario, $id_personagem, $id_habilidade);
        $repo_relacao->salvar($relacao);

        header('Location: index2.php');
        exit;
    } catch (InvalidArgumentException $e) {
        $erro = $e->getMessage();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Nova Habilidade</h2>
  <a href="index2.php" class="btn btn-ghost">← Voltar</a>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="form-card">
  <form method="POST" action="habilidade_create.php" enctype="multipart/form-data">

    <div class="form-group">
      <label for="nome">Nome da Habilidade</label>
      <input
        type="text"
        id="nome"
        name="nome"
        placeholder="Ex: Bola de Fogo"
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
      <label for="ciclo">Ciclo (1 – 6)</label>
      <input
        type="number"
        id="ciclo"
        name="ciclo"
        min="1"
        max="6"
        value="<?= $ciclo ?>"
        required
      />
    </div>

    <div class="form-group">
      <label for="estilo">Estilo</label>
      <select id="estilo" name="estilo" required>
        <option value="">Selecione o estilo...</option>
        <?php foreach ($estilos as $e): ?>
          <?php
            $selecionado = '';
            if ($estilo === $e) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $e ?>" <?= $selecionado ?>>
            <?= $e ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="custo">Custo</label>
      <input
        type="number"
        id="custo"
        name="custo"
        min="2"
        max="18"
        step="2"
        value="<?= $custo ?>"
        required
      />
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

    <div class="form-group">
      <label for="personagem">Personagens</label>
      <select id="personagem" name="personagem" required>
        <option value="">Selecione o personagem que possuí essa habilidade...</option>
        <?php foreach ($personagens as $p): ?>
          <?php
            $selecionado = '';
            if ($personagem === $p) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $p->getId() ?>" <?= $selecionado ?>>
            <?= $p->getNome(); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Cadastrar Habilidade</button>
      <a href="index2.php" class="btn btn-ghost">Cancelar</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>