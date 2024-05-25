<?php
session_start();

if (!isset($_SESSION['kasir'])) {
    $_SESSION['kasir'] = array();
}

if (isset($_GET['hapus'])) {
    unset($_SESSION['kasir'][$_GET['hapus']]);
}

if (isset($_POST['kirim'])) {
    // Pastikan semua kolom terisi
    if (!empty($_POST['nama_item']) && !empty($_POST['harga_item']) && !empty($_POST['jumlah_item'])) {
        $sameitem = -1;
        foreach ($_SESSION['kasir'] as $key => $item) {
            if ($item['nama_item'] === $_POST['nama_item']) {
                $sameitem = $key;
                break;
            }
        }
        if ($sameitem !== -1) {
            $_SESSION['kasir'][$sameitem]['jumlah_item'] += $_POST['jumlah_item'];
        } else {
            $data = array(
                'nama_item' => $_POST['nama_item'],
                'harga_item' => $_POST['harga_item'],
                'jumlah_item' => $_POST['jumlah_item'],
            );
            array_push($_SESSION['kasir'], $data);
        }
    }
}

$total = 0;
foreach ($_SESSION['kasir'] as $item) {
    $total += $item['harga_item'] * $item['jumlah_item'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Doa Ibu</title>
    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-color: #f8f9fa;
        }

        .main {
            width: 100%;
            max-width: 768px;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .row {
            margin-bottom: 15px;
        }

        .col {
            padding: 5px;
        }

        .table {
            font-size: 14px;
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
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

        .btn-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .text-white {
            color: #fff !important;
        }

        .text-decoration-none {
            text-decoration: none !important;
        }

        @media (max-width: 768px) {
            .form-floating {
                display: block;
            }

            .form-floating .form-control,
            .form-floating label {
                margin-bottom: 10px;
            }

            .col {
                flex: 1 1 auto;
            }

            .btn-danger.ms-2 {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="main d-flex flex-column align-items-center justify-content-center">
        <div class="container p-5 shadow">
            <h1 class="text-center mb-5">Toko Doa Ibu</h1>

            <form method="POST" action="" class="mb-5">
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" name="nama_item" class="form-control" id="floatingInput" placeholder="Nama Barang">
                            <label for="floatingInput">Nama Produk</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" name="harga_item" max="1000000000" class="form-control" id="HargaItem" placeholder="Harga Barang">
                            <label for="HargaItem" class="form-label">Harga Produk</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" name="jumlah_item" max="1000" class="form-control" id="JumlahItem" placeholder="Jumlah Barang">
                            <label for="JumlahItem" class="form-label">Jumlah Produk</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" name="kirim" class="btn btn-primary">Tambahkan</button>
                        <button type="button" class="btn btn-danger ms-2"><a href="destroy.php" class="text-white text-decoration-none">Reset</a></button>
                    </div>
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['kasir'] as $index => $item) : ?>
                        <tr>
                            <td><?php echo $item['nama_item']; ?></td>
                            <td>Rp. <?php echo number_format($item['harga_item'], 0, ',', '.'); ?></td>
                            <td><?php echo $item['jumlah_item']; ?></td>
                            <td>Rp. <?php echo number_format($item['harga_item'] * $item['jumlah_item'], 0, ',', '.'); ?></td>
                            <td>
                                <a href="?hapus=<?php echo $index; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>Rp. <?php echo number_format($total, 0, ',', '.'); ?></th>
                        <th>
                            <?php if (!empty($_SESSION['kasir'])) : ?>
                                <button type="button" class="btn btn-primary"><a href="2.php" class="text-white text-decoration-none">Bayar</a></button>
                            <?php endif; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>
