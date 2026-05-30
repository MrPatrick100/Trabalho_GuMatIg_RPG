<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$erro = '';
?>

<div class="page-header">
  <h2>Meu Perfil</h2>
</div>

<?php if ($erro !== ''): ?>
  <div class="alert alert-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="conteudo">
    <img src=<?= $_SESSION['foto_perfil'] ?? '../assets/avatar.png' ?> class="avatar"><br>
    <div class="form-card">
        <div class="form-group">
            <div class="form-group2">
                <h3 for="nome">Nome:</h3>
                <label for="nome"><?= $_SESSION['usuario_nome'] ?? 'Usuário' ?></label>
            </div>
            <br>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>