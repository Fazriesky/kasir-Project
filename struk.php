<?php
session_start();

// Pastikan session kasir dan ibu ada dan berisi data
if (!isset($_SESSION['kasir']) || !isset($_SESSION['ibu']) || empty($_SESSION['kasir']) || empty($_SESSION['ibu'])) {
    echo "Terjadi kesalahan. Silahkan kembali ke halaman awal.";
    exit;
}

$kembalian = $_SESSION['ibu']['kembalian'];
$uang = $_SESSION['ibu']['uang'];
$total = $_SESSION['ibu']['total'];

// Menampilkan struk
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .struk {
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .struk h1 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .struk p {
            margin-bottom: 5px;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.375rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .text-white {
            color: #fff !important;
        }
        .text-decoration-none {
            text-decoration: none !important;
        }
    </style>
</head>
<body>
    <div class="struk">
        <h1>Struk Belanja</h1>
        <hr>
    <?php
        foreach ($_SESSION['kasir'] as $item) {
            echo "<p>" . $item['nama_item'] . " - " . $item['jumlah_item'] . " x Rp " . number_format($item['harga_item'], 0, ',', '.') . "</p>";
        }
    ?>
        <hr>
        <p>Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></p>
        <p>Uang Bayar: Rp <?php echo number_format($uang, 0, ',', '.'); ?></p>
        <p>Kembalian: Rp <?php echo number_format($kembalian, 0, ',', '.'); ?></p>
    </div>
    <button type="button" class="btn btn-primary"><a href="destroy.php" class="text-white text-decoration-none">Kembali</a></button>
</body>
</html>
