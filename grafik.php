<?php
session_start();

if (!isset($_SESSION['chartData'])) {
    $_SESSION['chartData'] = [
        'labels' => ['January', 'February', 'March', 'April', 'May'],
        'values' => [10, 20, 15, 25, 30]
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['label']) && isset($_POST['value'])) {
    $newLabel = trim($_POST['label']);
    $newValue = filter_input(INPUT_POST, 'value', FILTER_VALIDATE_FLOAT);

    if (!empty($newLabel) && $newValue !== false && $newValue !== null) {
        $_SESSION['chartData']['labels'][] = $newLabel;
        $_SESSION['chartData']['values'][] = $newValue;

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$chartLabels = $_SESSION['chartData']['labels'];
$chartValues = $_SESSION['chartData']['values'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Dinamis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
            width: 90%;
            max-width: 700px;
        }
        .form-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }
        .form-container input[type="text"],
        .form-container input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex-grow: 1;
        }
        .form-container input[type="text"] {
            min-width: 100px;
        }
        .form-container input[type="number"] {
            width: 80px;
            flex-grow: 0;
        }
        .form-container button {
            padding: 9px 15px;
            background-color: #e9e9e9;
            border: 1px solid #bbb;
            border-radius: 4px;
            cursor: pointer;
            font-weight: normal;
        }
        .form-container button:hover {
            background-color: #dcdcdc;
        }
        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }
        input:invalid {
            border-color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="form-container" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="label" placeholder="Label" required>
            <input type="number" name="value" placeholder="Value" step="any" required>
            <button type="submit">Add Data</button>
        </form>
        <div class="chart-container">
            <canvas id="myLineChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myLineChart').getContext('2d');
        let myLineChart;

        const initialLabels = <?php echo json_encode($chartLabels); ?>;
        const initialData = <?php echo json_encode($chartValues); ?>;

        function createOrUpdateChart(labels, dataValues) {
            if (myLineChart) {
                myLineChart.destroy();
            }
            myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Dataset Value',
                        data: dataValues,
                        fill: false,
                        borderColor: 'rgb(54, 162, 235)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                   return value;
                                }
                            }
                        },
                        x: {
                           ticks: {
                                font: {
                                    size: 10
                                }
                           }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        createOrUpdateChart(initialLabels, initialData);
    </script>
</body>
</html>