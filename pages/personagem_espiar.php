<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';
require_once __DIR__ . '/../repository/PericiaRepository.php';
require_once __DIR__ . '/../repository/ItemRepository.php';

$repo_personagem = new PersonagemRepository();
$repo_habilidade = new HabilidadeRepository();
$repo_pericia = new PericiaRepository();
$repo_item = new ItemRepository();
$erro = '';

$personagem = null;
$pericias = null;
$habilidades = null;
$inventario = null;

$id_personagem = 0;
if (isset($_GET['id'])) {
    $id_personagem = (int) $_GET['id'];
}

$id_usuario = 0;
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = (int) $_SESSION['id_usuario'];
}

if ($id_personagem > 0) {
  $personagem = $repo_personagem->buscarPorId($id_personagem);
  $pericias = $repo_pericia->buscarPorId($id_personagem);
  $habilidades = $repo_habilidade->listarPorUsuario($id_usuario);
  $inventario = $repo_item->listarPorPersonagem($id_personagem);
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
  <h2><?= $personagem->getNome(); ?></h2>
  <a href="index.php" class="btn btn-ghost">← Voltar</a>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="form">
  <div class="form-card">

    <div class="form-group">
        <h3 for="caracteristicas">CARACTERÍSTICAS</h3>
        <div class="form-group2">
          <label for="nome">Nome: <?= $personagem->getNome() ?></label>
        </div>

        <div class="form-group2">
          <label for="idade">Idade: <?= $personagem->getIdade() ?></label>
        </div>

        <div class="form-group2">
          <label for="raca">Raça: <?= $personagem->getRaca() ?></label>
        </div>

        <div class="form-group2">
          <label for="nivel">Nível: <?= $personagem->getNivel() ?></label>
        </div>
    </div>

      <div class="form-group">
        <h3 for="status">STATUS</h3>
        <div class="form-group2">
          <label for="agilidade">Agilidade: <?= $personagem->getAgilidade() ?></label>
        </div>
        <div class="form-group2">
          <label for="forca">Força: <?= $personagem->getForca() ?></label>
        </div>
        <div class="form-group2">
          <label for="intelecto">Intelecto: <?= $personagem->getIntelecto() ?></label>
        </div>
        <div class="form-group2">
          <label for="constituicao">Constituição: <?= $personagem->getConstituicao() ?></label>
        </div>
        <div class="form-group2">
          <label for="carisma">Carisma: <?= $personagem->getCarisma() ?></label>
        </div>
        <div class="form-group2">
          <label for="magia">Magia: <?= $personagem->getMagia() ?></label>
        </div>
      </div>

      <div class="form-group">
        <h3 for="status">ATRIBUTOS</h3>
        <div class="form-group2">
          <label for="hp">HP: <?= $personagem->getHp() ?>/<?= $personagem->getHp() ?></label>
        </div>
        <div class="form-group2">
          <label for="mana">Mana: <?= $personagem->getMana() ?>/<?= $personagem->getMana() ?></label>
        </div>
        <div class="form-group2">
          <label for="stamina">Stamina: <?= $personagem->getStamina() ?>/<?= $personagem->getStamina() ?></label>
        </div>
        <div class="form-group2">
          <label for="pf">PF: <?= $personagem->getPf() ?>/<?= $personagem->getPf() ?></label>
        </div>
      </div>

      <div class="form-group">
        <label for="aparencia">Aparência</label>
        <img src="<?= $personagem->getAparencia() ?>" alt="img">
        <!-- <label for="...">string_img: <?= $personagem->getAparencia() ?></label> -->
      </div>
  </div>

  <div class="form-card">

      <div class="form-group">
          <h3>PERÍCIAS</h3>

          <div class="form-group2">
              <label for="acrobacia">Acrobacia: <?= $pericias->getAcrobacia() ?></label>
              <label for="adestramento">Adestramento: <?= $pericias->getAdestramento() ?></label>
              <label for="artes">Artes: <?= $pericias->getArtes() ?></label>
              <label for="atletismo">Atletismo: <?= $pericias->getAtletismo() ?></label>
              <label for="diplomacia">Diplomacia: <?= $pericias->getDiplomacia() ?></label>
              <label for="enganacao">Enganação: <?= $pericias->getEnganacao() ?></label>
              <label for="fortitude">Fortitude: <?= $pericias->getFortitude() ?></label>
              <label for="furtividade">Furtividade: <?= $pericias->getFurtividade() ?></label>
              <label for="intimidacao">Intimidação: <?= $pericias->getIntimidacao() ?></label>
              <label for="intuicao">Intuição: <?= $pericias->getIntuicao() ?></label>
              <label for="investigacao">Investigação: <?= $pericias->getInvestigacao() ?></label>
              <label for="luta_briga">Luta/Briga: <?= $pericias->getLuta_Briga() ?></label>
              <label for="medicina">Medicina: <?= $pericias->getMedicina() ?></label>
              <label for="ocultismo">Ocultismo: <?= $pericias->getOcultismo() ?></label>
              <label for="percepcao">Percepção: <?= $pericias->getPercepcao() ?></label>
              <label for="pontaria">Pontaria: <?= $pericias->getPontaria() ?></label>
              <label for="reflexos_iniciativa">Reflexos/Iniciativa: <?= $pericias->getReflexos_Iniciativa() ?></label>
              <label for="religiao">Religião: <?= $pericias->getReligiao() ?></label>
              <label for="tatica">Tática: <?= $pericias->getTatica() ?></label>
              <label for="vontade">Vontade: <?= $pericias->getVontade() ?></label>
          </div>
      </div>
  </div>

  <div class="form-card">
    <div class="form-group">
        <h3 for="inventario">Inventário</h3>
        <?php foreach ($inventario as $indice => $item): ?>
          
        <div class="form-group2">
          <label for="nome">Nome: <?= $item->getNome() ?></label>
        </div>

        <div class="form-group2">
          <label for="tipo">Tipo: <?= $item->getTipo() ?></label>
        </div>

        <div class="form-group2">
          <label for="equipado">Equipado: <?= $item->getEquipado() ?></label>
        </div>

        <div class="form-group2">
          <label for="deletado">Deletado: <?= $item->getDeletado() ?></label>
        </div>

        <div class="form-group2">
          <label for="descricao">Descrição: <?= $item->getDescricao() ?></label>
        </div>
        <br>
        <?php endforeach; ?>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>