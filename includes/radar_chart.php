<?php
    require_once __DIR__ . "../repository/PericiaRepository.php";
?>
<script>
    function graficoPericias(acrobacia, adestramento, artes, atletismo)

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
                data: [12, 19, 8],
                borderWidth: 1,
                backgroundColor: [
                    'red',
                    'blue',
                    'green'
                ]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>