<?php
$kelipatan_basis = 1;
$batas_angka = 40;

if (isset($_GET['kelipatan_input'])) {
    $input_pengguna = filter_input(INPUT_GET, 'kelipatan_input', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);

    if ($input_pengguna !== false && $input_pengguna !== null) {
        $kelipatan_basis = $input_pengguna;
    } else {
        $kelipatan_basis = 1;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencari Kelipatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin: 0;
            padding-top: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 600px;
        }
        form {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        form label {
            font-weight: bold;
        }
        form input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 80px;
        }
        form input[type="submit"] {
            padding: 8px 15px;
            background-color: #e0e0e0;
            border: 1px solid #adadad;
            border-radius: 4px;
            cursor: pointer;
            font-weight: normal;
        }
        form input[type="submit"]:hover {
            background-color: #d0d0d0;
        }
        h2 {
            text-align: left;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.8em;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        tr.highlight td:nth-child(2) {
            background-color: #d9ead3;
        }
        input:invalid {
            border-color: red;
        }
        input:invalid + span::after {
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="kelipatan_input_id">Masukan Kelipatan :</label>
            <input type="number" id="kelipatan_input_id" name="kelipatan_input"
                   value="<?php echo htmlspecialchars($kelipatan_basis); ?>"
                   min="1" required>
            <input type="submit" value="Kirim">
        </form>

        <h2>Kelipatan dari <?php echo htmlspecialchars($kelipatan_basis); ?></h2>

        <table>
            <thead>
                <tr>
                    <th>Angka</th>
                    <th>Kelipatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 1; $i <= $batas_angka; $i++) {
                    $is_kelipatan = false;
                    $teks_kelipatan = $i;
                    if ($kelipatan_basis > 0 && $i % $kelipatan_basis == 0) {
                        $is_kelipatan = true;
                        $teks_kelipatan = $i . " (kelipatan dari " . htmlspecialchars($kelipatan_basis) . ")";
                    }
                    $row_class = $is_kelipatan ? 'highlight' : '';

                    echo "<tr class='" . $row_class . "'>";
                    echo "<td>" . $i . "</td>";
                    echo "<td>" . $teks_kelipatan . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>