<?php 
    $lsp = new lsp();
    $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
    $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;
    $dataBarangKeluar = $lsp->getBarangKeluarFromDetailTransaksi($startDate, $endDate);
?>

<div class="main-content" style="margin-top: 20px;">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h2>Data Barang Keluar</h2>
                    <hr>
                    
                    <!-- Form Filter Tanggal -->
                    <form method="post" class="form-inline mb-4">
                        <label for="startDate" class="mr-2">Dari Tanggal:</label>
                        <input type="date" name="startDate" id="startDate" value="<?= $startDate ?>" class="form-control mr-3" required>

                        <label for="endDate" class="mr-2">Ke Tanggal:</label>
                        <input type="date" name="endDate" id="endDate" value="<?= $endDate ?>" class="form-control mr-3" required>

                        <button type="submit" class="btn btn-primary">Cari</button>
                        <button type="button" class="btn btn-success ml-2" onclick="window.print()">Print</button>
                    </form>

                    <!-- Tabel Data Barang Keluar -->
                    <table id="example" class="table table-borderless table-striped table-earning">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah Keluar</th>
                                <th>Tanggal Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($dataBarangKeluar)): ?>
                                <?php foreach ($dataBarangKeluar as $item): ?>
                                    <tr>
                                        <td><?= $item['nama_barang'] ?></td>
                                        <td><?= $item['jumlah'] ?></td>
                                        <td><?= $item['tanggal_beli'] ?></td>
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
