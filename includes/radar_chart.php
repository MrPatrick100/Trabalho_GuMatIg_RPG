<?php
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
            "Enganacao",
            "Fortitude",
            "Furtividade",
            "Intimidacao",
            "Intuicao",
            "Investigacao",
            "Luta_Briga",
            "Medicina",
            "Ocultismo",
            "Percepcao",
            "Pontaria",
            "Reflexos_Iniciativa",
            "Religiao",
            "Tatica",
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

            borderColor: '#c9a45c',
            backgroundColor: 'rgba(0,120,255,0.45)',
            pointBackgroundColor: '#c9a45c',
            pointBorderColor: '#e3c98c',
            pointRadius: (ctx) => ctx.raw <= 0 ? 0 : 3,
            pointHoverRadius: (ctx) => ctx.raw <= 0 ? 0 : 6,
            borderWidth: 3,
            fill: true

            
        },
        
        {
            label: 'Status',
            data: 
            [
                <?= $personagem->getForca(); ?>,
                null, null,
                <?= $personagem->getAgilidade(); ?>,
                null,null,null,
                <?= $personagem->getConstituicao(); ?>,
                null,null,
                <?= $personagem->getMagia(); ?>,
                null,null,
                <?= $personagem->getIntelecto(); ?>,
                null,null,null,
                <?= $personagem->getCarisma(); ?>,
                null,null,null
            ],

            borderColor: '#0625c1',
            backgroundColor: 'rgba(201,164,92,0.15)',
            pointBackgroundColor: '#131b63',
            borderWidth: 3,
            fill: true
        }
    ],
},

    options: {
        plugins: {
            legend: {
                labels: {
                    color: '#c9a45c'
                }
            }
        },

        scales: {
            r: {
                min: -1.5,
                max: 5,

                ticks: {
                    display: false
                },

                angleLines: {
                    color: '#c9a45c',
                    lineWidth: 2
                },

                grid: {
                    color: '#c9a45c',
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
        ctx.shadowColor = '#c9a45c';
        ctx.shadowBlur = 15;
    },
    afterDatasetDraw(chart) {
        chart.ctx.restore();
    }
};

Chart.register(glowPlugin);
</script>