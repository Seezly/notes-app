        <div>
            <canvas id='myChart'></canvas>
        </div>

        <script src='https://cdn.jsdelivr.net/npm/chart.js'></script>

        <script>
            const ctx = document.getElementById('myChart');

            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [<?= implode(", ", array_map(function ($item) {
                                        return "{x: {$item['x']}, y: {$item['y']}}";
                                    }, $data['chart_data']['labels'])) ?>],
                        datasets: [{
                                label: "<?= $data['chart_data']['title_one'] ?>",
                                data: [<?= implode(", ", array_map(function ($item) {
                                            return "{x: {$item['x']}, y: {$item['y']}}";
                                        }, $data['chart_data']['dataTableOne'])) ?>],
                                borderWidth: 1
                            },
                            {
                                label: "<?= $data['chart_data']['title_two'] ?>",
                                data: [<?= implode(", ", array_map(function ($item) {
                                            return "{x: {$item['x']}, y: {$item['y']}}";
                                        }, $data['chart_data']['dataTableTwo'])) ?>],
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        </script>