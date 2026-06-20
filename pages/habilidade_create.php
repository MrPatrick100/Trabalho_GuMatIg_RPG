<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';
require_once __DIR__ . '/../repository/RelacaoPersonagemHabilidadeRepository.php';
?>



<?php
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
$duracoes = ['Passiva', 'Ativa'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome       = trim  ($_POST['nome']      ?? '');
  $tipo       = trim  ($_POST['tipo']      ?? '');
  $ciclo      = (int) ($_POST['ciclo']     ?? 0);
  $estilo     = trim  ($_POST['estilo']    ?? '');
  $dano       = trim  ($_POST['dano_completo']      ?? '');
  $buff_nerf  = trim  ($_POST['buff_nerf_completo'] ?? '');
  $custo      = (int) ($_POST['custo']     ?? 0);
  $alcance    = trim  ($_POST['alcance']   ?? '');
  $area       = trim  ($_POST['area']      ?? '');
  $duracao    = trim  ($_POST['duracao']   ?? '');
  $pontos     = (int) ($_POST['pontos']    ?? 0);
  $descricao  = trim  ($_POST['descricao'] ?? '');

  $id_usuario = $_SESSION['id_usuario'];

  if($_POST['acao'] === 'cadastrar') {
    try {
      $habilidade = Habilidade::novo($id_usuario, $nome, $tipo, $ciclo, $estilo, $dano, $buff_nerf, $custo, $alcance, $area, $duracao, $pontos, $descricao, 0);
      $repo_habilidade->salvar($habilidade);
      $id_habilidade = $habilidade->getId();

      $personagensSelecionados = $_POST['personagens'] ?? [];

      foreach($personagensSelecionados as $id_personagem) {
        $relacao = RelacaoPersonagemHabilidade::novo($id_usuario, (int)$id_personagem, $id_habilidade);
        $repo_relacao->salvar($relacao);
      }

      header('Location: index2.php');
      exit;
    } 
    catch (InvalidArgumentException $e) {
      $erro = $e->getMessage();
    }
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
      <select id="duracao" name="duracao" required>
        <option value="">Selecione o duração...</option>
        <?php foreach ($duracoes as $d): ?>
          <?php
            $selecionado = '';
            if ($duracao === $d) {
                $selecionado = 'selected';
            }
          ?>
          <option value="<?= $d ?>" <?= $selecionado ?>>
            <?= $d ?>
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

    <div class="form-group">
      <label for="add-relacao">Relacionar com Personagem</label>
      <button type="button" id="btn-add-relacao" class="btn btn-primary" name="acao" value="add-relacao">+</button>
    </div>

    <div id="lista-personagens">
      <div class="form-group">
        <label for="select-personagem-base">Personagem</label>
        <select id="select-personagem-base" name="personagens[]" required>
          <option value="">Selecione um personagem...</option>
          <?php foreach ($personagens as $p): ?>
            <option value="<?= $p->getId() ?>"><?= $p->getNome() ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <script>
        const personagens = [
          <?php foreach ($personagens as $p): ?>
            {
              id: <?= $p->getId() ?>,
              nome: "<?= addslashes($p->getNome()) ?>"
            },
          <?php endforeach; ?>
        ];
        const select_base = document.getElementById('select-personagem-base');
        const lista = document.getElementById('lista-personagens');
        const btnAdicionar = document.getElementById('btn-add-relacao');

        select_base.addEventListener('change', atualizarTodosOsSelects);

        function personagensSelecionados() {
          return Array.from(
            document.querySelectorAll('select[name="personagens[]"]')
          )
          .map(select => select.value)
          .filter(valor => valor !== '');
        }

        function atualizarTodosOsSelects() {
          const selecionados = personagensSelecionados();
          document.querySelectorAll('select[name="personagens[]"]').forEach(select => {

            const valorAtual = select.value;
            select.innerHTML = '<option value="">Selecione um personagem...</option>';
            personagens.forEach(personagem => {
              if (
                !selecionados.includes(String(personagem.id)) ||
                String(personagem.id) === valorAtual
              ) 
              {
                const option = document.createElement('option');
                option.value = personagem.id;
                option.textContent = personagem.nome;
                if (String(personagem.id) === valorAtual) {
                  option.selected = true;
                }
                select.appendChild(option);
              }
            });
          });
          if (personagensSelecionados().length >= personagens.length) {
            btnAdicionar.disabled = true;
          }
          else {
            btnAdicionar.disabled = false;
          }
        }

        function criarSelect() {
          if (
            document.querySelectorAll('select[name="personagens[]"]').length
            >= personagens.length
          ) {
            return;
          }

          const div = document.createElement('div');
          div.classList.add('form-group');

          const select = document.createElement('select');
          select.name = 'personagens[]';
          select.required = true;

          select.addEventListener('change', atualizarTodosOsSelects);

          const btnRemover = document.createElement('button');
          btnRemover.type = 'button';
          btnRemover.classList.add('btn', 'btn-ghost');
          btnRemover.textContent = 'Remover';

          btnRemover.addEventListener('click', () => {
            div.remove();
            atualizarTodosOsSelects();
          });

          div.appendChild(select);
          div.appendChild(btnRemover);

          lista.appendChild(div);
          atualizarTodosOsSelects();
        }

        btnAdicionar.addEventListener('click', criarSelect);

        //Dano e Buff/Nerf
        const selectDano = document.getElementById('dano');
        const campo = document.getElementById('dano_completo');

        selectDano.addEventListener('change', function() {
            const valor = this.value;

            if (valor === '') return;
            else if (valor === "limpar") campo.value = '';

            else if (campo.value.trim() === '') {
                campo.value = valor;
            } else {
                campo.value += '+' + valor;
            }
        });
      </script>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary" name="acao" value="cadastrar">Cadastrar Habilidade</button>
      <a href="index2.php" class="btn btn-ghost">Cancelar</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>