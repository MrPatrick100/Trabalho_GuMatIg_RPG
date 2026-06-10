<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../repository/UsuarioRepository.php';

$erro = '';
$sucesso = '';
$repo = new UsuarioRepository();
$usuario = new Usuario($_SESSION);

$cor1 = '#c9a45c';
if (isset($_SESSION['cor_principal'])) {
  $cor1 = trim  ($_SESSION['cor_principal']      ?? '#c9a45c');
}

$cor2 = null;

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
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['acao'] === 'alterar_cor1')
    {
        $_SESSION['cor_principal']       = trim  ($_POST['cor1']      ?? '#c9a45c');

        header('Location: menu_configuracoes.php');
        exit;
    }
}
?>

<div class="page-header">
    <h2>Meu Perfil</h2>
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
            <form method="POST" action="perfil.php" enctype="multipart/form-data">
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
                <button type="button" class="btn btn-ghost" id="btn-cancelar">Cancelar</button>
            </form>

            <script>
                const btnAltAvatar = document.getElementById("btn-alterar-avatar");
                const formAltAvatar = document.getElementById("form-alterar-avatar");
                const btnCancelar = document.getElementById("btn-cancelar");

                btnAltAvatar.addEventListener("click", () => {
                    btnAltAvatar.classList.toggle("active");
                    formAltAvatar.classList.toggle("active");
                });

                btnCancelar.addEventListener("click", () => {
                    btnAltAvatar.classList.remove("active");
                    formAltAvatar.classList.remove("active");
                })
            </script>
        </div>
    </div>
    <div class="form-card">
        <div class="form-group">
            <form method="POST" action="menu_configuracoes.php" enctype="multipart/form-data">
                <label for="cor1">Cor 1</label>
                <input
                type="color"
                id="cor1"
                name="cor1"
                value="<?= $cor1 ?>"
                required
                />
                <button type="submit" class="btn btn-primary" name="acao" value="alterar_cor1">Alterar Cor</button>
            </form>
        </div>

        <div class="form-group">
            <form method="POST" action="menu_configuracoes.php" enctype="multipart/form-data">
                <label for="cor2">Cor 2</label>
                <input
                type="color"
                id="cor2"
                name="cor2"
                value="<?= $cor2 ?>"
                required
                />
                <button type="submit" class="btn btn-primary" name="acao" value="alterar_cor2">Alterar Cor</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>