<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../repository/UsuarioRepository.php';

$erro = '';
$repo = new UsuarioRepository();
$usuario = $repo->buscarPorEmail($_SESSION['email']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = trim($_POST['senha_atual'] ?? '');
    $senha_nova = trim($_POST['senha_nova'] ?? '');
    
    if($_SESSION['senha'] !== hash('sha256', $senha_atual)) {
        $erro = 'Senha atual incorreta.';
    }
    else {
        $_SESSION['senha'] = hash('sha256', $senha_nova);
        $repo->atualizarSenha($usuario->getId(), $_SESSION['senha']);
    }
}
?>

<div class="page-header">
  <h2>Segurança e Privacidade</h2>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="conteudo">
    <img src=<?= $_SESSION['foto_perfil'] ?? '../assets/avatar.png' ?> class="avatar"><br>
    <div class="form-card">
        <div class="form-group">
            <br>
            <div class="form-group2">
                <button id="btn-alterar-senha" class="btn">Alterar Senha</button>
                <div id="form-alterar-senha" class="form-alterar-senha">
                    <form method="POST" action="seguranca_privacidade.php">
                        <div class="form-group">
                            <label for="senha_atual">Senha Atual</label>
                            <input
                                type="password"
                                id="senha_atual"
                                name="senha_atual"
                                placeholder="••••••••"
                                required
                            />
                        </div>

                        <div class="form-group">
                            <label for="senha_atual">Senha Nova</label>
                            <input
                                type="password"
                                id="senha_nova"
                                name="senha_nova"
                                placeholder="••••••••"
                                required
                            />
                        </div>

                        <button type="submit" class="btn btn-primary" name="alterar_senha">Alterar Senha</button>
                    </form>
                    <script>
                        const btnAltSenha = document.getElementById("btn-alterar-senha");
                        const formAltSenha = document.getElementById("form-alterar-senha");

                        btnAltSenha.addEventListener("click", () => {
                            btnAltSenha.classList.toggle("active");
                            formAltSenha.classList.toggle("active");
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>