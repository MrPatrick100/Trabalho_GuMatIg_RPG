<?php

function ajustarCor($hex, $percentual) {
    $hex = str_replace('#', '', $hex);

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $r = max(0, min(255, $r + ($r * $percentual / 100)));
    $g = max(0, min(255, $g + ($g * $percentual / 100)));
    $b = max(0, min(255, $b + ($b * $percentual / 100)));

    return sprintf("#%02x%02x%02x", $r, $g, $b);
}

$cor_principal = '#c9a45c';
if (isset($_SESSION['cor_principal'])) {
  $cor_principal = trim  ($_SESSION['cor_principal']      ?? '#c9a45c');
}
$cor_principal_clara = ajustarCor($cor_principal, 20); // 20% mais clara
$cor_principal_escura  = ajustarCor($cor_principal, -30); // 30% mais escura

?>

<style>
    :root {

    /* Fundos */
    --paper: #0f0f0f;
    --paper-soft: #1b1b1b;
    --cream: #242424;

    /* Texto */
    --ink: #ece7db;
    --ink-soft: #b5aea0;
    --muted: #8f887c;

    /* Bordas */
    --line: #4f3d1b;

    /* Dourado */
    --cor-principal: <?= $cor_principal ?>;
    --cor-principal-light: <?= $cor_principal_clara ?>;
    --cor-principal-dark: <?= $cor_principal_escura ?>;

    /* Vermelho */
    --red: #7a1010;
    --red-dark: #4e0808;
    --red-soft: #4a1f1f;

    /* Verde */
    --green: #3f5a3f;
    --green-dark: #2b402b;

    /* Laranja */
    --orange: #c78b35;
    --orange-dark: #9f6923;

    /* Extras */
    --radius: 10px;

    --shadow:
    0 12px 24px rgba(0,0,0,.45);

    --shadow-sm:
    0 6px 12px rgba(0,0,0,.35);
    }
</style>