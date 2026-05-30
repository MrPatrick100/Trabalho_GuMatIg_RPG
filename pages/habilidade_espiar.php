<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';

$repo = new HabilidadeRepository();
$erro = '';

$id = 0;
if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
}

$habilidade = null;
if ($id > 0) {
  $habilidade = $repo->buscarPorId($id);
}

// if ($personagem !== null) {
//   $nome = $personagem->getNome();
//   $idade = $personagem->getIdade();
//   $raca = $personagem->getRaca();
//   $nivel = $personagem->getNivel();
//   $agilidade = $personagem->getAgilidade();
//   $forca = $personagem->getForca();
//   $intelecto = $personagem->getIntelecto();
//   $constituicao = $personagem->getConstituicao();
//   $carisma = $personagem->getCarisma();
//   $magia = $personagem->getMagia();
//   $aparencia = $personagem->getAparencia();
//   $hp = $personagem->getHp();
//   $stamina = $personagem->getStamina();
//   $mana = $personagem->getMana();
//   $pf = $personagem->getPf();
// }

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2><?= $habilidade->getNome(); ?></h2>
  <a href="index.php" class="btn btn-ghost">← Voltar</a>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="form-card">
  <div class="form-group">
      <h3 for="caracteristicas">CARACTERÍSTICAS</h3>

      <div class="form-group2">
        <label for="nome">Nome: <?= $habilidade->getNome() ?></label>
      </div>

      <div class="form-group2">
        <label for="tipo">Tipo: <?= $habilidade->getTipo() ?></label>
      </div>

      <div class="form-group2">
        <label for="ciclo">Ciclo: <?= $habilidade->getCiclo() ?>°</label>
      </div>

      <div class="form-group2">
        <label for="estilo">Estilo: <?= $habilidade->getEstilo() ?></label>
      </div>

      <div class="form-group2">
        <label for="custo">Custo: <?= $habilidade->getCusto() ?></label>
      </div>

  </div>
  <div class="form-group">
    <div class="form-group2">
      <label for="descricao"> <?= $habilidade->getDescricao() ?></label>
    </div>  
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>