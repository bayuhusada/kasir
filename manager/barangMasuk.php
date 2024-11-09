<?php 
    $lsp = new lsp();
    $startDate = isset($_POST['dateAwal']) ? $_POST['dateAwal'] : null;
    $endDate = isset($_POST['dateAkhir']) ? $_POST['dateAkhir'] : null;

    // Ambil data barang masuk dengan nama_barang yang di-join dari table_barang
    $dataBarangMasuk = $lsp->selectBarangMasuk("barang_masuk", "tanggal_masuk", $startDate, $endDate);
?>

<div class="main-content" style="margin-top: 20px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h4>Data Barang Masuk</h4>
                    <hr>
                    
                    <!-- Form Filter Tanggal -->
                    <form method="post" class="form-inline mb-4">
                        <label for="dateAwal" class="mr-2">Dari Tanggal:</label>
                        <input type="date" name="dateAwal" id="dateAwal" value="<?= $startDate ?>" class="form-control mr-3" required>

                        <label for="dateAkhir" class="mr-2">Ke Tanggal:</label>
                        <input type="date" name="dateAkhir" id="dateAkhir" value="<?= $endDate ?>" class="form-control mr-3" required>

                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-success ml-2" onclick="window.print()">Print</button>
                    </form>

                    <!-- Tabel Data Barang Masuk -->
                    <table id="example" class="table table-borderless table-striped table-earning">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Masuk</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dataBarangMasuk)): ?>
                                <?php foreach ($dataBarangMasuk as $item): ?>
                                    <tr>
                                        <td><?= $item['kd_barang'] ?></td>
                                        <td><?= $item['nama_barang'] ?></td> <!-- Menampilkan Nama Barang -->
                                        <td><?= $item['jumlah'] ?></td>
                                        <td><?= $item['tanggal_masuk'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data untuk rentang tanggal ini.</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
