<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../repository/PersonagemRepository.php';
require_once __DIR__ . '/../repository/HabilidadeRepository.php';
require_once __DIR__ . '/../repository/RelacaoPersonagemHabilidadeRepository.php';

$repoPersonagem = new PersonagemRepository();
$personagens = $repoPersonagem->listarPorUsuario($_SESSION['id_usuario']);
$repoHabilidade = new HabilidadeRepository();
$habilidades = $repoHabilidade->listarPorUsuario($_SESSION['id_usuario']);
$repoRelacao = new RelacaoPersonagemHabilidadeRepository();
$relacao = $repoRelacao->listarPorUsuario($_SESSION['id_usuario']);
$pesquisa = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pesquisa'])) {
  $pesquisa = trim($_GET['pesquisa']);
}

// if ($pesquisa !== '') {
//   $habilidades = $repoHabilidade->listarFiltrando($_SESSION['id_usuario'], $pesquisa);
// }

// if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['limpar'])) {
//   $habilidades = $repoHabilidade->listarPorUsuario($_SESSION['id_usuario']);
// }

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header">
  <h2>Minhas Habilidades</h2>
  <a href="habilidade_create.php" class="btn btn-primary btn-inicial">+ Nova Habilidade</a>
  <a href="habilidades_deletadas.php" class="btn" id="btn-deletados">🗑️</a>
</div>

<!-- <div>
  <form class="search-bar" method="GET" action="index2.php">
    <input type="search" name="pesquisa" placeholder="Buscar habilidade...">
    <button type="submit">🔍</button>
    <button type="submit" id="limpar" name="limpar">Todos</button>
  </form>
</div> -->

<?php if (empty($habilidades)): ?>
  <div class="empty-state">
    <p>Você ainda não cadastrou nenhuma habilidade.</p>
    <a href="habilidade_create.php" class="btn btn-primary">Cadastrar agora</a>
  </div>
<?php else: ?>
  <div class="personagens-container">
    <?php foreach ($personagens as $p): ?>
      <br>
      <button class="btn btn-personagem">
        ▶ <?= $p->getNome() ?>
      </button>
      <div class="habilidades">
        <table class="data-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Estilo</th>
              <th>Ciclo</th>
              <th>Ações</th>
            </tr>
          </thead>
          <?php foreach ($habilidades as $indice => $h): ?>
            <?php foreach ($relacao as $r): ?>
              <?php if (
                $h->getDeletado() !== 1 &&
                $r->getId_personagem() === $p->getId() &&
                $r->getId_habilidade() === $h->getId()
              ): ?>
                <tbody>
                  <tr>
                    <td>#</td>
                    <td><?= $h->getNome() ?></td>
                    <td><?= $h->getEstilo() ?></td>
                    <td><?= $h->getCiclo() ?>°</td>
                    <td class="acoes">
                      <a href="habilidade_edit.php?id=<?= $h->getId() ?>&idp=<?= $p->getId() ?>" class="btn btn-sm btn-editar">Editar</a>
                      <a href="habilidade_delete.php?id=<?= $h->getId() ?>&idp=<?= $p->getId() ?>" class="btn btn-sm btn-excluir">Excluir/Desvincular</a>
                      <a href="habilidade_espiar.php?id=<?= $h->getId() ?>&idp=<?= $p->getId() ?>" class="btn btn-sm btn-espiar">Espiar</a>
                    </td>
                  </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endforeach; ?>
          </tbody>  
        </table>
      </div>
    <?php endforeach; ?>
  </div>
    <script>
      document.querySelectorAll(".btn-personagem").forEach(botao => {
        botao.addEventListener("click", () => {
          const alvo = botao.nextElementSibling;
          document.querySelectorAll(".habilidades").forEach(div => {
              if (div !== alvo) {
                div.style.display = "none";
              }
          });
          alvo.style.display = alvo.style.display === "block" ? "none" : "block";
        });
      });
    </script>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
