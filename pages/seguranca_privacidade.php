<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../repository/UsuarioRepository.php';

$erro = '';
$sucesso = '';
$repo = new UsuarioRepository();
$usuario = $repo->buscarPorEmail($_SESSION['email']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['acao'] === 'alterar_avatar')
    {
        $img = $_FILES['avatar']; // Guarda o objeto da imagem em img

        $nome_img = $img['name']; //pega o nome do objeto e guarda em uma variavel
        $caminho_temporario_img = $img['tmp_name']; //pega o caminho temporário do objeto e guarda em uma variavel

        $caminho_final_img = "../assets/img_perfil/" . $nome_img; //Decide o caminho final de onde vai ficar a img
        move_uploaded_file($caminho_temporario_img, $caminho_final_img); //Copia a imagem para a pasta que a gente vai puxar

        $_SESSION['foto_perfil'] = $caminho_final_img;

        $repo->atualizarAvatar($usuario->getId(), $caminho_final_img);
        $sucesso = 'Imagem alterada com sucesso';
        $erro = '';
    }
    if ($_POST['acao'] === 'alterar_senha')
    {
        $senha_atual = trim($_POST['senha_atual'] ?? '');
        $senha_nova = trim($_POST['senha_nova'] ?? '');
    
        if($_SESSION['senha'] !== hash('sha256', $senha_atual) && $senha_nova !== '') {
            $erro = 'Senha atual incorreta.';
            $sucesso = '';
        }
        else {
            $_SESSION['senha'] = hash('sha256', $senha_nova);
            $repo->atualizarSenha($usuario->getId(), $_SESSION['senha']);
            $senha_atual = '';
            $senha_nova = '';
            $sucesso = 'Senha alterada com sucesso';
            $erro = '';
        }
    }
}
?>

<div class="page-header">
  <h2>Segurança e Privacidade</h2>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<?php if ($sucesso !== ''): ?>
  <div class="alert alert-sucesso"><?= htmlspecialchars($sucesso) ?></div>
<?php endif; ?>

<div class="conteudo">
    <div>
        <button type="button" class="btn btn-ghost" id="btn-alterar-avatar">
            <img src=<?= $_SESSION['foto_perfil'] ?? '../assets/img_perfil/avatar.png' ?> class="avatar">
        </button>
        <div id="form-alterar-avatar" class="form-alterar-avatar">
            <form method="POST" action="seguranca_privacidade.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="avatar">Avatar</label>
                    <input
                        type="file"
                        id="avatar"
                        name="avatar"
                        accept="image/png, image/jpeg"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary" name="acao" value="alterar_avatar">Alterar Avatar</button>
                <button type="button" class="btn btn-ghost" id="btn-cancelar1">Cancelar</button>
            </form>

            <script>
                const btnAltAvatar = document.getElementById("btn-alterar-avatar");
                const formAltAvatar = document.getElementById("form-alterar-avatar");
                const btnCancelar1 = document.getElementById("btn-cancelar1");

                btnAltAvatar.addEventListener("click", () => {
                    btnAltAvatar.classList.toggle("active");
                    formAltAvatar.classList.toggle("active");
                });

                btnCancelar1.addEventListener("click", () => {
                    btnAltAvatar.classList.remove("active");
                    formAltAvatar.classList.remove("active");
                })
            </script>
        </div>
    </div>
    <div class="form-card">
        <div class="form-group">
            <br>
            <div class="form-group2">
                <button type="button" id="btn-alterar-senha" class="btn">Alterar Senha</button>
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

                        <button type="submit" class="btn btn-primary" name="acao" value="alterar_senha">Alterar Senha</button>
                        <button type="button" class="btn btn-ghost" id="btn-cancelar2">Cancelar</button>
                    </form>
                    <script>
                        const btnAltSenha = document.getElementById("btn-alterar-senha");
                        const formAltSenha = document.getElementById("form-alterar-senha");
                        const btnCancelar2 = document.getElementById("btn-cancelar2");

                        btnAltSenha.addEventListener("click", () => {
                            btnAltSenha.classList.toggle("active");
                            formAltSenha.classList.toggle("active");
                        });

                        btnCancelar2.addEventListener("click", () => {
                            btnAltSenha.classList.remove("active");
                            formAltSenha.classList.remove("active");
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>