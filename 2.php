<?php
session_start();

// Array multidimensi belum ada, buat dulu
if (!isset($_SESSION['kasir'])) {
    $_SESSION['kasir'] = array();
}

// Mendapatkan total harga barang
$totalHarga = 0;
foreach ($_SESSION['kasir'] as $item) {
  $totalHarga += $item['harga_item'] * $item['jumlah_item'];
}

// Mendapatkan uang bayar
$uangBayar = isset($_POST['uangBayar']) ? $_POST['uangBayar'] : 0;

// Menghitung kembalian
$kembalian = $uangBayar - $totalHarga;

// Menampilkan hasil
if (isset($_POST['kirim'])) {
  // Validasi input
    if (empty($uangBayar)) {
        echo "<div class='alert alert-danger'>Uang nya Ka!</div>";
    } elseif ($uangBayar < $totalHarga) {
        echo "<div class='alert alert-danger'>Uang tidak cukup!</div>";
    } else {
    // Simpan data ke session
        $_SESSION['ibu'] = [
            'kembalian' => $kembalian,
            'uang' => $uangBayar,
            'total' => $totalHarga
        ];

    // Redirect ke halaman struk
    header("Location: struk.php");
    exit;
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Disini</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-floating input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-floating label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            background-color: #fff;
            padding: 0 5px;
            color: #999;
            font-size: 16px;
            transition: 0.2s ease-in-out;
        }

        .form-floating input:focus + label,
        .form-floating input:not(:placeholder-shown) + label {
            top: -10px;
            font-size: 12px;
            color: #007bff;
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

        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.375rem;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Pembayaran Disini</h1>
        <form method="POST" action="">
            <div class="form-floating mb-3">
                <input type="number" name="uangBayar" class="form-control" id="masukkanUang" placeholder="Masukkan Uang">
                <label for="masukkanUang" class="form-label">Masukkan Uang</label>
            </div>
            <button type="submit" name="kirim" class="btn btn-primary">Bayar</button>
        </form>
    </div>
</body>
</html>
