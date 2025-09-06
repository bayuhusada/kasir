<?php
$pem       = new lsp();
$transkode = $pem->autokode("table_transaksi", "kd_transaksi", "TR");
$sql       = "SELECT SUM(sub_total) as sub FROM table_pretransaksi WHERE kd_transaksi = '$transkode'";
$exec      = mysqli_query($con, $sql);
$assoc     = mysqli_fetch_assoc($exec);
$sql1      = "SELECT SUM(jumlah) as jum FROM table_pretransaksi WHERE kd_transaksi = '$transkode'";
$exec1     = mysqli_query($con, $sql1);
$assoc1    = mysqli_fetch_assoc($exec1);
$auth      = $pem->selectWhere("table_user", "username", $_SESSION['username']);
$sql2      = "SELECT COUNT(kd_pretransaksi) as count FROM table_pretransaksi WHERE kd_transaksi = '$transkode'";
$exec2     = mysqli_query($con, $sql2);
$assoc2    = mysqli_fetch_assoc($exec2);
if ($assoc2['count'] <= 0) {
	header("location:PageKasir.php?page=kasirTransaksi");
}

if (isset($_POST['selesaiGet'])) {
	$total  = $_POST['tot'];
	$bayar  = $_POST['bayar'];
	$deskripsi = $_POST['deskripsi_transaksi'];
	$kem    = $_POST['kem'];
	if ($bayar == "" || $kem == "") {
		$response = ['response' => 'negative', 'alert' => 'Bayar dahulu'];
	} else {
		if ($bayar < $total) {
			$response = ['response' => 'negative', 'alert' => 'Uang Kurang'];
		} else {
			$date  = date("Y-m-d");
			$value = "'$transkode','$auth[kd_user]','$assoc1[jum]','$assoc[sub]','$date','$deskripsi'";
			$response = $pem->insert("table_transaksi", $value, "?page=struk&id=$transkode");
			if ($response['response'] == "positive") {
				unset($_SESSION['transaksi']);
			}
		}
	}
}
?>
<div class="main-content">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-sm-12 offset-2">
					<div class="card">
						<div class="card-header">
							<h3>Pembayaran</h3>
						</div>
						<div class="card-body">
							<form method="post">
								<div class="col-sm-12">
									<div class="form-group">
										<label for="">Kode Transaksi</label>
										<input type="text" class="form-control" name="autokode" id="autokode" value="<?php echo $transkode ?>" readonly>
									</div>
									<div class="form-group">
										<label for="">Total harga</label>
										<!-- Input untuk ditampilkan -->
										<input type="text" class="form-control" value="Rp. <?= number_format($assoc['sub'], 0, ',', '.') ?>" readonly>

										<!-- Input hidden untuk hitungan -->
										<input type="hidden" name="tot" id="tot" value="<?= $assoc['sub'] ?>">
									</div>
									<div class="form-group">
										<label for="">Bayar</label>
										<!-- Input untuk user (hanya tampilan, diformat rupiah) -->
										<input type="text" class="form-control" id="bayar_display">
										<!-- Input hidden untuk server (angka murni yang dikirim) -->
										<input type="hidden" name="bayar" id="bayar">
									</div>

									<div class="form-group">
										<label for="">Kembalian</label>
										<input type="text" class="form-control" id="kem_display" readonly>
										<input type="hidden" name="kem" id="kem">
									</div>

									<button class="btn btn-primary" name="selesaiGet"><i class="fa fa-cart-plus"></i> Selesaikan Transaksi </button>
									<div class="form-group">
										<label for="deskripsi_transaksi">Jenis Transaksi</label>
										<select class="form-control" name="deskripsi_transaksi" required>
											<option value="NonSipLah">Non SipLah</option>
											<option value="SipLah">SipLah</option>
										</select>
									</div>

									<a href="?page=kasirTransaksi" class="btn btn-danger"><i class="fa fa-repeat"></i> Kembali</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="vendor/jquery-3.2.1.min.js"></script>
<script>
	$(document).ready(function() {
		$('#jumjum').keyup(function() {
			var jumlah = $(this).val();
			var harba = $('#harba').val();
			var kali = harba * jumlah;
			$("#totals").val(kali);
		});

$('#bayar_display').on('keyup', function() {
    // Ambil hanya angka
    var angka = $(this).val().replace(/\D/g, '') || 0;

    // Simpan angka mentah ke input hidden
    $('#bayar').val(angka);

    // Format jadi Rupiah untuk tampilan input
    var formatted = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);

    $(this).val(formatted);

    // ===== Hitung Kembalian di sini =====
    var total = parseInt($('#tot').val().replace(/\D/g, '')) || 0;
    var kembalian = angka - total;

    // Format kembalian untuk tampilan
    var formattedKem = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(kembalian);

    $('#kem_display').val(formattedKem); // untuk user
    $('#kem').val(kembalian); // angka mentah dikirim ke server
});


		// $('#bayar').keyup(function() {
		// 	var bayar = parseInt($(this).val().replace(/\D/g, '')) || 0;
		// 	var total = parseInt($('#tot').val().replace(/\D/g, '')) || 0;
		// 	var kembalian = bayar - total;

		// 	// tampilkan dalam format Rp
		// 	var formatted = new Intl.NumberFormat('id-ID', {
		// 		style: 'currency',
		// 		currency: 'IDR',
		// 		minimumFractionDigits: 0
		// 	}).format(kembalian);

		// 	$('#kem_display').val(formatted); // tampilkan ke user
		// 	$('#kem').val(kembalian); // simpan angka mentah untuk dikirim
		// });

	})
</script>