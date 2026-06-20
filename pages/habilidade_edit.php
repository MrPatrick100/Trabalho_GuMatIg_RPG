<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';


$repo = new HabilidadeRepository();

$id = 0;
if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
}

$habilidade = null;
if ($id > 0) {
  $habilidade = $repo->buscarPorId($id);
}

if ($habilidade === null || $habilidade->getId_usuario() !== $_SESSION['id_usuario']) {
    header('Location: index2.php');
    exit;
}

$erro = '';
$id_usuario = 0;

$nome = '';
$tipo = '';
$ciclo = 1;
$estilo = '';
$dano = '';
$buff_nerf = '';
$custo = 2;
$alcance = '';
$area = '';
$duracao = '';
$pontos = 0;
$descricao = '';

$tipos    = ['Passiva', 'Ativa'];
$estilos  = ['Física', 'Mágica', 'Híbrida'];

$danos = ['1', '1d4', '1d6', '1d8', '1d10', '1d12', '1d20'];
$buffs_nerfs = ['1[perícia]', '1d4[perícia]', '1[status]', '1d4[status]', '1[geral]', '1d4[geral]'];

$alcances = ['Curto', 'Médio', 'Longo'];
$areas    = ['Reta', 'Cone', 'Raio'];
$duracoes = ['1', '1d4'];

if ($habilidade !== null) {
  $nome = $habilidade->getNome();
  $tipo = $habilidade->getTipo();
  $ciclo = $habilidade->getCiclo();
  $estilo = $habilidade->getEstilo();
  $dano = $habilidade->getDano();
  $buff_nerf = $habilidade->getBuffNerf();
  $custo = $habilidade->getCusto();
  $alcance = $habilidade->getAlcance();
  $area = $habilidade->getArea();
  $duracao = $habilidade->getDuracao();
  $pontos = $habilidade->getPontos();
  $descricao = $habilidade->getDescricao();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim  ($_POST['nome']      ?? '');
    $tipo       = trim  ($_POST['tipo']      ?? '');
    $ciclo      = (int) ($_POST['ciclo']     ?? 0);
    $estilo     = trim  ($_POST['estilo']    ?? '');
    $dano       = trim  ($_POST['dano_completo']      ?? '');
    $buff_nerf  = trim  ($_POST['buff_nerf'] ?? '');
    $custo      = (int) ($_POST['custo']     ?? 0);
    $alcance    = trim  ($_POST['alcance']   ?? '');
    $area       = trim  ($_POST['area']      ?? '');
    $duracao    = trim  ($_POST['duracao_completa']   ?? '');
    $pontos     = (int) ($_POST['pontos']    ?? 0);
    $descricao  = trim  ($_POST['descricao'] ?? '');

    $id_usuario = $_SESSION['id_usuario'];

    try {
        $habilidade->alterarDados($nome, $tipo, $ciclo, $estilo, $dano, $buff_nerf, $custo, $alcance, $area, $duracao, $pontos, $descricao, 0);
        $repo->salvar($habilidade);

        header('Location: index2.php');
        exit;
    } catch (InvalidArgumentException $e) {
        $erro = $e->getMessage();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Editar Habilidade</h2>
  <a href="index2.php" class="btn btn-ghost">← Voltar</a>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="form-card">
  <form method="POST" action="habilidade_edit.php?id=<?= $habilidade->getId() ?>" enctype="multipart/form-data">

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
      <label for="dano">Dano</label>
      <select id="dano" name="dano">
        <option value="">Selecione o dano...</option>
        <?php foreach ($danos as $d): ?>
          <?php
            $selecionado = '';
            if ($dano === $d) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $d ?>" <?= $selecionado ?>>
            <?= $d ?>
          </option>
        <?php endforeach; ?>
        <option value="limpar">Limpar</option>
      </select>
      <input type="text" id="dano_completo" name="dano_completo" readonly>
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
      <label for="alcance">Alcance</label>
      <select id="alcance" name="alcance" required>
        <option value="">Selecione o alcance...</option>
        <?php foreach ($alcances as $alc): ?>
          <?php
            $selecionado = '';
            if ($alcance === $alc) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $alc ?>" <?= $selecionado ?>>
            <?= $alc ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="area">Área</label>
      <select id="area" name="area" required>
        <option value="">Selecione o área...</option>
        <?php foreach ($areas as $a): ?>
          <?php
            $selecionado = '';
            if ($area === $a) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $a ?>" <?= $selecionado ?>>
            <?= $a ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group">
      <label for="duracao">Duração</label>
      <select id="duracao" name="duracao">
        <option value="">Selecione o duração...</option>
        <?php foreach ($duracoes as $dur): ?>
          <?php
            $selecionado = '';
            if ($duracao === $dur) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $dur ?>" <?= $selecionado ?>>
            <?= $dur ?>
          </option>
        <?php endforeach; ?>
        <option value="limpar">Limpar</option>
      </select>
      <input type="text" id="duracao_completa" name="duracao_completa" readonly>
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
      <button type="submit" class="btn btn-primary">Salvar Habilidade</button>
      <a href="index2.php" class="btn btn-ghost">Cancelar</a>
    </div>

  </form>
  <script>
    //Intercalar Dados
        function IntercalarDados(select, selected_campo){
          select.addEventListener('change', function() {
            const valor = this.value;
            let total = selected_campo.value;
            let encontrado = false;

            
            if (valor === "limpar") selected_campo.value = '';
            if (valor === '' || valor === 'limpar') return;

            if (selected_campo.value.trim() === '') {
              total = valor;
            }
            else {
              const total_repartido = total.split('+');

              for(let i = 0; i < total_repartido.length; i++) {

              let total_repartido_puro = total_repartido[i].slice(1); //Retira o primeiro valor da string -> qtd de dados
              let valor_puro = valor.slice(1); //Retira o primeiro valor da string -> qtd de dados

                if (total_repartido_puro === valor_puro) {
                  
                  if(total_repartido[i].includes('d')) {  // Detecta se o valor é um fixo ou um dado
                    valor_repartido = total_repartido[i].split('d');
                    total_repartido[i] = String(parseInt(valor_repartido[0]) + 1) + 'd' + valor_repartido[1];
                  }
                  else {
                    total_repartido[i] = String(parseInt(total_repartido[i]) + 1)
                  }
                  encontrado = true;
                  break;
                }
              }
              if (encontrado) total = total_repartido.join('+')
              else total += '+' + valor;
            }

            selected_campo.value = total;
            this.selectedIndex = 0;
          });
        }

        //Dano, Buff/Nerf e Duração
        const selectDano = document.getElementById('dano');
        const campoDanoCompleto = document.getElementById('dano_completo');
        IntercalarDados(selectDano, campoDanoCompleto)

        const selectDuracao = document.getElementById('duracao');
        const campoDuracaoCompleta = document.getElementById('duracao_completa');
        IntercalarDados(selectDuracao, campoDuracaoCompleta)
  </script>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
