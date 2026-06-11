<?php
    require_once __DIR__ . "/costumizacao.php";
    require_once __DIR__ . "/../repository/PericiaRepository.php";
    require_once __DIR__ . "/../repository/PersonagemRepository.php";
    require_once __DIR__ . "/../pages/personagem_espiar.php";
?>
<script>
    const grafico = document.getElementById('meuGrafico');

    new Chart(grafico, {
    type: 'radar',
    data: {
        labels: [
            "Acrobacia",
            "Adestramento",
            "Artes",
            "Atletismo",
            "Diplomacia",
            "Enganação",
            "Fortitude",
            "Furtividade",
            "Intimidação",
            "Intuição",
            "Investigação",
            "Luta/Briga",
            "Medicina",
            "Ocultismo",
            "Percepção",
            "Pontaria",
            "Reflexos/Iniciativa",
            "Religião",
            "Tática",
            "Vontade"
        ],
        datasets: [{
            label: 'Perícias',
            data: [
                <?= $pericias->getAcrobacia(); ?>,
                <?= $pericias->getAdestramento(); ?>,
                <?= $pericias->getArtes(); ?>,
                <?= $pericias->getAtletismo(); ?>,
                <?= $pericias->getDiplomacia(); ?>,
                <?= $pericias->getEnganacao(); ?>,
                <?= $pericias->getFortitude(); ?>,
                <?= $pericias->getFurtividade(); ?>,
                <?= $pericias->getIntimidacao(); ?>,
                <?= $pericias->getIntuicao(); ?>,
                <?= $pericias->getInvestigacao(); ?>,
                <?= $pericias->getLuta_Briga(); ?>,
                <?= $pericias->getMedicina(); ?>,
                <?= $pericias->getOcultismo(); ?>,
                <?= $pericias->getPercepcao(); ?>,
                <?= $pericias->getPontaria(); ?>,
                <?= $pericias->getReflexos_Iniciativa(); ?>,
                <?= $pericias->getReligiao(); ?>,
                <?= $pericias->getTatica(); ?>,
                <?= $pericias->getVontade(); ?>
            ],

            borderColor: '<?= $cor_principal; ?>',
            backgroundColor: 'rgba(0,120,255,0.45)',
            pointBackgroundColor: '<?= $cor_principal; ?>',
            pointBorderColor: '<?= $cor_principal_clara; ?>',
            pointRadius: (ctx) => ctx.raw <= 0 ? 0 : 3,
            pointHoverRadius: (ctx) => ctx.raw <= 0 ? 0 : 6,
            borderWidth: 3,
            fill: true

            
        },
    ],
},

    options: {
        plugins: {
            legend: {
                labels: {
                    color: '<?= $cor_principal; ?>'
                }
            }
        },

        scales: {
            r: {
                min: -1,
                max: 5,

                ticks: {
                    display: false
                },

                angleLines: {
                    color: '<?= $cor_principal; ?>',
                    lineWidth: 2
                },

                grid: {
                    color: '<?= $cor_principal; ?>',
                    lineWidth: 1
                },

                pointLabels: {
                    color: '#ffffff',
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
                // pointRadius: (ctx) => ctx.raw <= 0 ? 0 : 3,
                // pointHoverRadius: (ctx) => ctx.raw <= 0 ? 0 : 6,
            }
        }
    }
});
Chart.defaults.elements.line.borderWidth = 3;

const glowPlugin = {
    id: 'glow',
    beforeDatasetDraw(chart) {
        const ctx = chart.ctx;

        ctx.save();
        ctx.shadowColor = '<?= $cor_principal; ?>';
        ctx.shadowBlur = 15;
    },
    afterDatasetDraw(chart) {
        chart.ctx.restore();
    }
};

Chart.register(glowPlugin);

const centerHolePlugin = {
    id: 'centerHole',

    afterDraw(chart) {
        const { ctx } = chart;
        const scale = chart.scales.r;

        ctx.save();

        ctx.beginPath();
        ctx.arc(
            scale.xCenter - 0.25,
            scale.yCenter,
            22.5, // tamanho do buraco
            0,
            Math.PI * 2
        );

        ctx.fillStyle = 'rgba(0,120,255,0.45)'; // mesma cor do fundo
        ctx.fill();

        ctx.restore();
    }
};

Chart.register(centerHolePlugin);
</script>