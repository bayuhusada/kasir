<?php 
    $struk  = new lsp();
    $id = $_GET['id'];
    $data   = $struk->edit("transaksi","kd_transaksi",$id);
    $total  = $struk->selectSumWhere("transaksi","sub_total","kd_transaksi='$id'");
    $dataDetail = $struk->edit("detailTransaksi","kd_transaksi",$id);
    $jumlah_barang = $struk->selectSumWhere("transaksi","jumlah","kd_transaksi='$id'");
?>
<style>
    .col-sm-8 {
        background: white;
        padding: 20px;
    }

    @media print {
        .ds {
            display: none;
        }
        .card {
            box-shadow: none;
            border: none;
        }
        .hd {
            display: none;
        }
    }
</style>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="text-align: center;">
                            <h4>Struk</h4>
                            <img src="images/icon/logo-mini.png" alt="logo" width="5%" height="5%" />
                            <p><strong>CV Raihan Sentosa</strong></p>
                            <p><strong>Alamat Toko:</strong></p>
                            <p>Jl. Bundaran PU No. 42 TDM 1, Kupang, NTT</p>
                            <p>081 237 948 974</p>
                            <p><strong>~ Terima kasih telah berbelanja di CV Raihan Sentosa ~</strong></p>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">Kode Transaksi: <?php echo $id ?></div>
                                <div class="col-sm-6">
                                    <p class="text-right"><span><?php echo "Tanggal Cetak : ".date("Y-m-d"); ?></span></p>
																		
                                </div>
                            </div>
                            <br>
                            <table class="table table-striped table-bordered" width="100%">
                                <tr>
                                    <td>Kode Antrian</td>
                                    <td>Nama Barang</td>
                                    <td>Harga Satuan</td>
                                    <td>Jumlah</td>
                                    <td>Sub Total</td>
                                </tr>
                                <?php foreach ($dataDetail as $dd): ?>
                                <tr>
                                    <td><?= $dd['kd_pretransaksi'] ?></td>
                                    <td><?= $dd['nama_barang'] ?></td>
                                    <td><?= "Rp.".number_format($dd['harga_barang']) ?></td>
                                    <td><?= $dd['jumlah'] ?></td>
                                    <td><?= "Rp.".number_format($dd['sub_total']).",-" ?></td>
                                </tr>
                                <?php endforeach ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Jumlah Barang</td>
                                    <td><?php echo $jumlah_barang['sum'] ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">Total</td>
                                    <td><?php echo "Rp.".number_format($total['sum']).",-" ?></td>
                                </tr>
                            </table>
                            <br>
                            <p>Tanggal Beli : <?php echo $dd['tanggal_beli']; ?></p>

                            <br>
                            <div style="text-align: center; margin-top: 20px;">
                                <p>Hormat Kami,</p>
                                <p><strong>CV Raihan Sentosa</strong></p>
                            </div>

                            <br>
                            <!-- Pilihan ukuran struk -->
                            <div class="form-group ds">
                                <label for="ukuranCetak">Pilih Ukuran Struk:</label>
                                <select id="ukuranCetak" class="form-control">
                                    <option value="a4">A4 (Default)</option>
                                    <option value="thermal">Thermal 80mm</option>
                                </select>
                            </div>

                            <!-- Tombol -->
                            <a href="#" class="btn btn-info ds" id="btnCetak"><i class="fa fa-print"></i> Cetak Struk</a>
                            <a href="?" class="btn btn-danger ds">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk handle ukuran cetak -->
<script>
document.getElementById('btnCetak').addEventListener('click', function (e) {
    e.preventDefault();
    const ukuran = document.getElementById('ukuranCetak').value;

    if (ukuran === 'thermal') {
        const style = document.createElement('style');
        style.innerHTML = `
            @media print {
                @page {
                    size: 80mm auto;
                    margin: 5mm;
                }
                body {
                    width: 80mm;
                    font-size: 11px;
                }
                .card, .card-header, .card-body {
                    padding: 0;
                    margin: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
    window.print();
});
</script>
