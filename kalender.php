<?php
$nama_bulan_id = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

$nama_hari_id = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

$bulan = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$tahun = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');


if ($bulan < 1 || $bulan > 12) {
    $bulan = date('n');
}
if ($tahun < 1970 || $tahun > 2038) {
    $tahun = date('Y');
}

$bulan_sebelumnya = $bulan - 1;
$tahun_sebelumnya = $tahun;
if ($bulan_sebelumnya == 0) {
    $bulan_sebelumnya = 12;
    $tahun_sebelumnya = $tahun - 1;
}

$bulan_berikutnya = $bulan + 1;
$tahun_berikutnya = $tahun;
if ($bulan_berikutnya == 13) {
    $bulan_berikutnya = 1;
    $tahun_berikutnya = $tahun + 1;
}

$nama_bulan_sekarang = $nama_bulan_id[$bulan];
$jumlah_hari_bulan_ini = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
$hari_pertama_bulan_ini = date('w', mktime(0, 0, 0, $bulan, 1, $tahun));

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender <?php echo $nama_bulan_sekarang . ' ' . $tahun; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
            background-color: #f4f4f4;
            margin: 20px;
            overflow: hidden;
        }
        .calendar-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .calendar-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .calendar-nav a {
            text-decoration: none;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        .calendar-nav a:hover {
            background-color: #e9ecef;
        }
        .calendar-nav h2 {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }
        table.calendar {
            width: 100%;
            border-collapse: collapse;
        }
        table.calendar th, table.calendar td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            height: 40px;
        }
        table.calendar th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        table.calendar td.highlight {
            background-color: red;
            color: white;
            font-weight: bold;
        }
        table.calendar td.empty {
            background-color: #f9f9f9;
            border: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div class="calendar-nav">
            <a href="?month=<?php echo $bulan_sebelumnya; ?>&year=<?php echo $tahun_sebelumnya; ?>"><< Bulan Sebelumnya</a>
            <h2><?php echo $nama_bulan_sekarang . ' ' . $tahun; ?></h2>
            <a href="?month=<?php echo $bulan_berikutnya; ?>&year=<?php echo $tahun_berikutnya; ?>">Bulan Berikutnya >></a>
        </div>

        <table class="calendar">
            <thead>
                <tr>
                    <?php foreach ($nama_hari_id as $hari): ?>
                        <th><?php echo $hari; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    for ($i = 0; $i < $hari_pertama_bulan_ini; $i++) {
                        echo '<td class="empty"></td>';
                    }

                    $hitung_hari = 1;
                    $kolom = $hari_pertama_bulan_ini;

                    while ($hitung_hari <= $jumlah_hari_bulan_ini) {
                        if ($kolom == 7) {
                            echo '</tr><tr>';
                            $kolom = 0;
                        }
                        $class_highlight = ($hitung_hari == 15) ? 'highlight' : '';
                        echo '<td class="' . $class_highlight . '">' . $hitung_hari . '</td>';

                        $hitung_hari++;
                        $kolom++;
                    }
                    while ($kolom > 0 && $kolom < 7) {
                        echo '<td class="empty"></td>';
                        $kolom++;
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>