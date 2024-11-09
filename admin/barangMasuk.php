<!-- barangMasuk.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barang Masuk</title>
</head>
<body>
    <h2>Form Barang Masuk</h2>
    <form action="proses_barang_masuk.php" method="post">
        <label>Kode Barang:</label>
        <input type="text" name="kd_barang" required>
        <label>Jumlah Masuk:</label>
        <input type="number" name="jumlah" required>
        <button type="submit">Tambah Barang Masuk</button>
    </form>
</body>
</html>
