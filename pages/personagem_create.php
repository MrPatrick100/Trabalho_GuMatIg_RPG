<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/PericiaRepository.php';

$repoPersonagem = new PersonagemRepository();
$repoPericia = new PericiaRepository();
$erro = '';

$id_usuario = 0;
$id = 0;
$nome = '';
$idade = 0;
$raca = '';
$nivel = 1;
$nivelp = 0;
$agilidade = 0;
$forca = 0;
$intelecto = 0;
$constituicao = 0;
$carisma = 0;
$magia = 0;
$aparencia = '';
$lore = '';
$hp = 0;
$stamina = 0;
$mana = 0;
$pf = 0;

$racas = ['Humano', 'Elfo', 'Goblin', 'Anao', 'Lefou', 'Demonio', 'Gnomo', 'Orc', 'Troll', 'Tita'];
$pericias = [
  "Acrobacia" => 0,
  "Adestramento" => 0,
  "Artes" => 0,
  "Atletismo" => 0,
  "Diplomacia" => 0,
  "Enganacao" => 0,
  "Fortitude"=> 0,
  "Furtividade" => 0,
  "Intimidacao" => 0,
  "Intuicao" => 0,
  "Investigacao" => 0,
  "Luta_Briga" => 0,
  "Medicina" => 0,
  "Ocultismo" => 0,
  "Percepcao" => 0,
  "Pontaria" => 0,
  "Reflexos_Iniciativa" => 0,
  "Religiao" => 0,
  "Tatica" => 0,
  "Vontade" => 0
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  try {
    $img = $_FILES['aparencia']; // Guarda o objeto da imagem em img

    $nome_img = $img['name']; //pega o nome do objeto e guarda em uma variavel
    $caminho_temporario_img = $img['tmp_name']; //pega o caminho temporário do objeto e guarda em uma variavel

    $caminho_final_img = "../assets/img_personagem/" . $nome_img; //Decide o caminho final de onde vai ficar a img
    move_uploaded_file($caminho_temporario_img, $caminho_final_img); //Copia a imagem para a pasta que a gente vai puxar
    $_SESSION['aparencia'] = $caminho_final_img;

  } catch (Exception $e) {
    $erro = 'erro ao carregar a imagem';
  }

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
  $aparencia = trim($caminho_final_img ?? '');
  $lore = trim($_POST['lore'] ?? '');
  $hp = $nivel * 5 + $constituicao * 5;
  $stamina = $forca * 10;
  $mana = $magia * 10;
  if($carisma > $intelecto) $pf = $carisma;
  else $pf = $intelecto;
  $id_usuario = $_SESSION['id_usuario'];

  $pericias["Acrobacia"]              = (int) ($_POST['acrobacia']    ?? 0);
  $pericias["Adestramento"]           = (int) ($_POST['adestramento'] ?? 0);
  $pericias["Artes"]                  = (int) ($_POST['artes']        ?? 0);
  $pericias["Atletismo"]              = (int) ($_POST['atletismo']    ?? 0);
  $pericias["Diplomacia"]             = (int) ($_POST['diplomacia']   ?? 0);
  $pericias["Enganacao"]              = (int) ($_POST['enganacao']    ?? 0);
  $pericias["Fortitude"]              = (int) ($_POST['fortitude']    ?? 0);
  $pericias["Furtividade"]            = (int) ($_POST['furtividade']  ?? 0);
  $pericias["Intimidacao"]            = (int) ($_POST['intimidacao']  ?? 0);
  $pericias["Intuicao"]               = (int) ($_POST['intuicao']     ?? 0);
  $pericias["Investigacao"]           = (int) ($_POST['investigacao'] ?? 0);
  $pericias["Luta_Briga"]             = (int) ($_POST['luta_briga']   ?? 0);
  $pericias["Medicina"]               = (int) ($_POST['medicina']            ?? 0);
  $pericias["Ocultismo"]              = (int) ($_POST['ocultismo']           ?? 0);
  $pericias["Percepcao"]              = (int) ($_POST['percepcao']           ?? 0);
  $pericias["Pontaria"]               = (int) ($_POST['pontaria']            ?? 0);
  $pericias["Reflexos_Iniciativa"]    = (int) ($_POST['reflexos_iniciativa'] ?? 0);
  $pericias["Religiao"]               = (int) ($_POST['religiao'] ?? 0);
  $pericias["Tatica"]                 = (int) ($_POST['tatica'] ?? 0);
  $pericias["Vontade"]                = (int) ($_POST['vontade'] ?? 0);

  try {
    $personagem = Personagem::novo($id_usuario, $nome, $idade, $raca, $nivel, $agilidade, $forca, $intelecto, $constituicao, $carisma, $magia, $aparencia, $lore, 0, 0);
    $repoPersonagem->salvar($personagem);

    $pericia = Pericia::novo(
      $personagem->getId(), $pericias["Acrobacia"], $pericias["Adestramento"], $pericias["Artes"], $pericias["Atletismo"], 
      $pericias["Diplomacia"], $pericias["Enganacao"], $pericias["Fortitude"], $pericias["Furtividade"], $pericias["Intimidacao"],
      $pericias["Intuicao"], $pericias["Investigacao"], $pericias["Luta_Briga"], $pericias["Medicina"], $pericias["Ocultismo"],
      $pericias["Percepcao"], $pericias["Pontaria"], $pericias["Reflexos_Iniciativa"],
      $pericias["Religiao"], $pericias["Tatica"], $pericias["Vontade"]
    );
    $repoPericia->salvar($pericia);

    header('Location: index.php');
    exit;
  } catch (Exception $e) {
    $erro = 'Ocorreu um erro ao cadastrar o personagem: ' . $e->getMessage();
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

<div class="form">
  <div class="form-card">
    <form method="POST" action="personagem_create.php" enctype="multipart/form-data">

      <div class="form-group">
        <label for="nome">Nome do Personagem</label>
        <input
          type="name"
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
          value="<?= $idade ?>"
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
          accept="image/png, image/jpeg"
        />
      </div>

      <div class="form-group">
        <label for="lore">História</label>
        <textarea
          id="lore"
          name="lore"
          placeholder="Ex: Herói de Guerra"
          required
          rows="10"
          cols="60"
        ><?= htmlspecialchars($lore) ?></textarea>
      </div>
  </div>
  <div class="form-card">
      <div class="form-group">

        <h3>Perícias</h3>
        <div class="div-pericia">
          <div><label for="acrobacia">Acrobacia</label></div>
          <div><input
          type="number"
          id="acrobacia"
          name="acrobacia"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Acrobacia"] ?>"
          required></div>
        </div>


        <div class="div-pericia">
          <label for="adestramento">Adestramento</label>
          <input
          type="number"
          id="adestramento"
          name="adestramento"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Adestramento"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="artes">Artes</label>
          <input
          type="number"
          id="artes"
          name="artes"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Artes"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="atletismo">Atletismo</label>
          <input
          type="number"
          id="atletismo"
          name="atletismo"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Atletismo"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="diplomacia">Diplomacia</label>
          <input
          type="number"
          id="diplomacia"
          name="diplomacia"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Diplomacia"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="enganacao">Enganação</label>
          <input
          type="number"
          id="enganacao"
          name="enganacao"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Enganacao"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="fortitude">Fortitude</label>
          <input
          type="number"
          id="fortitude"
          name="fortitude"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Fortitude"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="furtividade">Furtividade</label>
          <input
          type="number"
          id="furtividade"
          name="furtividade"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Furtividade"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="intimidacao">Intimidação</label>
          <input
          type="number"
          id="intimidacao"
          name="intimidacao"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Intimidacao"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="intuicao">Intuição</label>
          <input
          type="number"
          id="intuicao"
          name="intuicao"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Intuicao"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="investigacao">Investigação</label>
          <input
          type="number"
          id="investigacao"
          name="investigacao"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Investigacao"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="luta_briga">Luta/Briga</label>
          <input
          type="number"
          id="luta_briga"
          name="luta_briga"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Luta_Briga"] ?>"
          required>
        </div>


        <div class="div-pericia">
          <label for="medicina">Medicina</label>
          <input
          type="number"
          id="medicina"
          name="medicina"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Medicina"] ?>"
          required>
        </div>

        <div class="div-pericia">
          <label for="ocultismo">Ocultismo</label>
          <input
          type="number"
          id="ocultismo"
          name="ocultismo"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Ocultismo"] ?>"
          required>
        </div>

        <div class="div-pericia">
          <label for="percepcao">Percepção</label>
          <input
          type="number"
          id="percepcao"
          name="percepcao"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Percepcao"] ?>"
          required>
        </div>

        <div class="div-pericia">
          <label for="pontaria">Pontaria</label>
          <input
          type="number"
          id="pontaria"
          name="pontaria"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Pontaria"] ?>"
          required>
        </div>

        <div class="div-pericia">
          <label for="reflexos_iniciativa">Reflexos/Iniciativa</label>
          <input
          type="number"
          id="reflexos_iniciativa"
          name="reflexos_iniciativa"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Reflexos_Iniciativa"] ?>"
          required>
        </div>

        <div class="div-pericia">
          <label for="religiao">Religião</label>
          <input
          type="number"
          id="religiao"
          name="religiao"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Religiao"] ?>"
          required>
        </div>

        <div class="div-pericia">
          <label for="tatica">Tática</label>
          <input
          type="number"
          id="tatica"
          name="tatica"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Tatica"] ?>"
          required>
        </div>

        <div class="div-pericia">
          <label for="vontade">Vontade</label>
          <input
          type="number"
          id="vontade"
          name="vontade"
          class="input-pericias"
          min="0"
          max="5"
          value="<?= $pericias["Vontade"] ?>"
          required>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Cadastrar Personagem</button> <br>
        
        <a href="index.php" class="btn btn-ghost">Cancelar</a>
      </div>

    </form>
    <form action="inventario_edit.php" method="post">
      <button type="submit" class="btn btn-primary">Editar inventário</button>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>