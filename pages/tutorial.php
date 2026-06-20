<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/costumizacao.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../repository/UsuarioRepository.php';

$texto_status = "
A cada 1 ponto ganha 1 dado <br>
Força (FOR) <br>
Magia (MAG) <br>
Agilidade (DEX) <br>
Constituição (CONS) <br>
Carisma (CHR) <br>
Intelecto (INT) <br>
<br>

Upando de nível: +2 Pontos de Status. +1 Habilidade Física ou Mágica. +5 Pontos em Perícia <br>

<br>
Status Base: <br>
HP: Nível * 5 + CONS * 10 <br>
Stamina: FOR * 10 <br>
Mana: MAG * 10 <br>

<br>
<strong>Regen de Stamina/Mana</strong> <br>
A cada nível aumenta o dado <br>
Nível 1 -> 4 p/ turno <br>
Nível 2 -> 6 p/ turno <br>
Nível 3 -> 8 p/ turno <br>
Nível 4 -> 10 p/ turno <br>
Nível 5 -> 12 p/ turno";

$texto_cenas = "
Cenas se referem ao estado da campanha no momento atual, se dividem em: <br>
 - Cena de Combate: Quando se joga as iniciativas e se inicia um combate. <br>
 - Cena de Investigação: Quando se está adquirindo informações. <br>
 - Cena de Interlúdio: Cenas entre as sessões/missões, geralmente são feitas para descansar ou melhorar seu personagem. <br>
 - Cena de Perseguição: Quando há um perseguidor e seu objetivo principal se torna sobreviver.";

$texto_combate = "
- Ação de Movimento: Movimenta -> 15ft + DEX * 5 <br>
- Ação de Principal: Usa uma habilidade/improviso/descanso <br>
- Ação de Extra: Levantar, arremessar algo, usar habilidades que contam como ação extra";

$texto_acao_principal = "
- Descansar: Gasta um turno completo para regenerar Mana ou Stamina. <br>
- Improviso: Um ataque improvisado, que não esteja no seu kit de habilidades vai causar 1d4 ou 1 efeito. <br>
- Skill/Habilidade: Uma skill exclusiva sua do seu kit de habilidades";

?>
<div class="page-header">
    <h2>Como funciona o sistema desse RPG</h2>
    </div>
    <div class="form-card">
        <div class="form-group">
            <div class="form-group2">
                <h3 for="nome">Status</h3>
                <p><?= $texto_status ?></p>
            </div>
            <br>
        </div>
        <div class="form-group">
            <div class="form-group2">
                <h3 for="nome">Cenas</h3>
                <p><?= $texto_cenas ?></p> <br>
                <div>
                    <p for="nome"><strong>Combate</strong></p>
                    <p><?= $texto_combate ?></p> <br>
                    <p for="nome"><strong>Ação Principal</strong></p>
                    <p><?= $texto_acao_principal ?></p> <br>
                </div>
            </div>
            <br>
        </div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>