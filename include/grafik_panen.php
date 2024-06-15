<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            height: 45vh;
            /* Ubah tinggi grafik di sini */
            width: 100vw;
            /* Lebar grafik */
        }
    </style>
</head>

<body>
    <div class="container chart-container">
        <canvas id="myChart"></canvas>
    </div>

    <?php
    include "./include/koneksi.php";

    $query = "
        SELECT YEAR(tgl_panen) AS tahun, MONTH(tgl_panen) AS bulan, tb_team.nama_team, SUM(total_berat) AS total_berat
        FROM tb_panen
        JOIN tb_team ON tb_panen.id_team = tb_team.id_team
        GROUP BY tahun, bulan, tb_team.nama_team
        ORDER BY tahun, bulan, tb_team.nama_team
    ";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    $teams = [];
    foreach ($data as $row) {
        if (!in_array($row['nama_team'], $teams)) {
            $teams[] = $row['nama_team'];
        }
    }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const data = <?php echo json_encode($data); ?>;
            const teams = <?php echo json_encode($teams); ?>;

            const labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            const colors = [
                '#FF5733', '#33FF57', '#3357FF', '#F1C40F', '#8E44AD',
                '#2ECC71', '#E74C3C', '#3498DB', '#1ABC9C', '#9B59B6',
                '#34495E', '#16A085'
            ];

            const datasets = teams.map((team, index) => {
                return {
                    label: team,
                    data: labels.map((label, monthIndex) => {
                        const found = data.find(item => item.bulan - 1 === monthIndex && item.nama_team === team);
                        return found ? parseFloat(found.total_berat) : 0;
                    }),
                    backgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length],
                    borderWidth: 1
                };
            });

            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets,
                },
                options: {
                    indexAxis: 'x',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            },
                            beginAtZero: true,
                            stacked: false
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Berat (kg)'
                            },
                            stacked: false
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: true,
                            text: '',
                        },
                    },
                    elements: {
                        bar: {
                            borderWidth: 20,
                            barThickness: 'flex',
                            maxBarThickness: 30
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>