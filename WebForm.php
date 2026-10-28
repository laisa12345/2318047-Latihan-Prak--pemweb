<?php
$pesanError = [];
$hasil = null;

function hitungTotal($jumlah, $harga) {
    $subtotal = $jumlah * $harga;
    $diskon = ($subtotal > 100000) ? $subtotal * 0.10 : 0;
    $total = $subtotal - $diskon;

    return [
        'subtotal' => $subtotal,
        'diskon' => $diskon,
        'total' => $total
    ];
}

function rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_proses'])) {
    $produk = trim($_POST['produk'] ?? '');
    $jumlahInput = trim($_POST['jumlah'] ?? '');
    $hargaInput = trim($_POST['harga'] ?? '');

    // Validasi menggunakan if-else: seluruh field wajib diisi.
    if ($produk === '' || $jumlahInput === '' || $hargaInput === '') {
        $pesanError[] = 'Semua field wajib diisi.';
    } else {
        if (!is_numeric($jumlahInput) || (float)$jumlahInput <= 0) {
            $pesanError[] = 'Jumlah harus berupa angka lebih besar dari nol.';
        } elseif (!is_numeric($hargaInput) || (float)$hargaInput <= 0) {
            $pesanError[] = 'Harga satuan harus berupa angka lebih besar dari nol.';
        } else {
            $jumlah = (int)$jumlahInput;
            $harga = (float)$hargaInput;

            // Jumlah harus bilangan bulat positif.
            if ($jumlah <= 0 || (string)$jumlah !== (string)(int)$jumlahInput) {
                $pesanError[] = 'Jumlah harus berupa bilangan bulat lebih besar dari nol.';
            } else {
                $hasil = hitungTotal($jumlah, $harga);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Produk</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; padding: 24px;
            background: #dde8ec;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #14263a;
        }
        h1 { text-align: center; margin: 12px 0 24px; }
        .container {
            background: #fff; max-width: 620px; margin: 0 auto;
            padding: 24px; border-radius: 16px;
            box-shadow: 0 8px 24px rgba(20,38,58,.15);
        }
        .input { display: flex; flex-direction: column; margin: 12px 0; }
        label { margin-bottom: 6px; font-weight: 600; }
        input[type="text"], input[type="number"] {
            width: 100%; padding: 10px; border: 2px solid #c3d1d9;
            border-radius: 8px; font-size: 15px;
        }
        input:focus { outline: none; border-color: #2457f5; }
        .button {
            width: 100%; margin: 8px 0; padding: 11px;
            background: #14263a; border-radius: 8px; cursor: pointer;
            border: none; color: white; font-weight: bold; font-size: 15px;
        }
        .button:hover { background: #2457f5; }
        .error {
            margin-top: 16px; padding: 12px; border-radius: 8px;
            color: #842029; background: #f8d7da; border: 1px solid #f5c2c7;
        }
        .result { margin-top: 22px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #c3d1d9; padding: 10px; text-align: left; }
        th { background: #14263a; color: white; }
        .total-row { font-weight: bold; background: #fff2b3; }
        .note { font-size: 13px; color: #526579; margin-top: 12px; }
    </style>
</head>
<body>
    <h1>Form Pemesanan Produk</h1>
    <div class="container">
        <form action="" method="POST">
            <div class="input">
                <label for="produk">Nama Produk</label>
                <input type="text" name="produk" id="produk"
                       value="<?= htmlspecialchars($_POST['produk'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       required>
            </div>
            <div class="input">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1" step="1"
                       value="<?= htmlspecialchars($_POST['jumlah'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       required>
            </div>
            <div class="input">
                <label for="harga">Harga Satuan (Rp)</label>
                <input type="number" name="harga" id="harga" min="0.01" step="0.01"
                       value="<?= htmlspecialchars($_POST['harga'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       required>
            </div>
            <input type="submit" class="button" name="btn_proses" value="Hitung Total">
            <input type="reset" class="button" value="Hapus">

            <?php if (!empty($pesanError)): ?>
                <div class="error">
                    <strong>Data belum dapat diproses:</strong>
                    <ul>
                        <?php foreach ($pesanError as $error): ?>
                            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php elseif ($hasil !== null): ?>
                <div class="result">
                    <h2>Rincian Pemesanan</h2>
                    <table>
                        <tr><th>Keterangan</th><th>Detail</th></tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td><?= htmlspecialchars($produk, ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr><td>Jumlah</td><td><?= number_format($jumlah, 0, ',', '.') ?></td></tr>
                        <tr><td>Harga Satuan</td><td><?= rupiah($harga) ?></td></tr>
                        <tr><td>Subtotal</td><td><?= rupiah($hasil['subtotal']) ?></td></tr>
                        <tr><td>Diskon</td><td><?= rupiah($hasil['diskon']) ?>
                            (<?= $hasil['diskon'] > 0 ? '10%' : '0%' ?>)</td></tr>
                        <tr class="total-row"><td>Total Pembayaran</td><td><?= rupiah($hasil['total']) ?></td></tr>
                    </table>
                    <p class="note">Diskon 10% diberikan jika subtotal lebih dari Rp 100.000.</p>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
