<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';
require_once __DIR__ . '/../repository/RelacaoPersonagemHabilidadeRepository.php';

$repoHabilidade = new HabilidadeRepository();
$repoRelacao = new RelacaoPersonagemHabilidadeRepository();
$erro = '';

$id = 0;
$idp = 0;
if (isset($_GET['id']) && isset($_GET['idp'])) {
  $id = (int) $_GET['id'];
  $idp = (int) $_GET['idp'];
}

$relacoes = [];
$habilidade = null;
if ($id > 0) {
  $habilidade = $repoHabilidade->buscarPorId($id);
  $relacoes = $repoRelacao->listarPorHabilidade($id);
}

// Habilidade não encontrada ou não pertence ao usuário logado
if ($habilidade === null || $habilidade->getId_usuario() !== $_SESSION['id_usuario']) {
    header('Location: index2.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if($_POST['acao'] === 'excluir') {
    try {
      $habilidade->alterarDados($habilidade->getNome(), $habilidade->getTipo(), $habilidade->getCiclo(),
      $habilidade->getEstilo(), $habilidade->getCusto(), $habilidade->getDano(), $habilidade->getBuff(), $habilidade->getNerf(),
      $habilidade->getAlcance(), $habilidade->getArea(), $habilidade->getDuracao(),
      $habilidade->getPontos(), $habilidade->getDescricao(), 1);
      
      $repoHabilidade->salvar($habilidade);
      header('Location: index2.php');
      exit;
    } 
    catch(Exception $e)
    {
      $erro = 'erro ao excluir habilidade';
    }
  }
  else if($_POST['acao'] === 'desvincular') {
    try {

      $repoRelacao->excluirPorPersonagem_Habilidade($idp, $id);
      
      if($repoRelacao->verificarExistencia($id) === false) {
        $repoHabilidade->excluir($id);
      }
      header('Location: index2.php');
      exit;
    }
    catch(Exception $e)
    {
      $erro = 'erro ao desvincular habilidade';
    }
  }
  
}

require_once __DIR__ . '/../includes/header.php';
?>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="page-header">
  <h2>Excluir Habilidade</h2>
  <a href="index2.php" class="btn btn-ghost">← Voltar</a>
</div>

<div class="confirm-card">
  <h3>Você tem certeza?</h3>
  <p>
    Você está prestes a EXCLUIR ou DESVINCULAR uma habilidade
    <strong><?= htmlspecialchars($habilidade->getNome()) ?></strong>
    (<?= htmlspecialchars($habilidade->getEstilo()) ?>, <?= $habilidade->getCiclo() ?>°).
    Esta ação pode ser desfeita.
  </p>

  <form method="POST" action="habilidade_delete.php?id=<?= $habilidade->getId() ?>&idp=<?= $idp ?>">
    <div class="form-actions">
      <button type="submit" class="btn btn-excluir" name="acao" value="excluir">Excluir</button>
      <button type="submit" class="btn btn-excluir" name="acao" value="desvincular">Desvincular</button>
      <a href="index2.php" class="btn btn-ghost">Cancelar</a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
