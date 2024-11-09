<?php
include '../config/koneksi.php'; // Pastikan path ini benar
include 'controller.php'; // Pastikan path sudah benar

$br = new lsp(); // Membuat objek dari kelas lsp

// Pastikan ada data yang dikirim dari form
if (isset($_POST['getSimpanMasuk'])) {
    // Tangkap data dari form
    $kode_barang = $br->validateHtml($_POST['kode_barang_masuk']);
    $jumlah = $br->validateHtml($_POST['jumlah_masuk']);

    // Periksa apakah kode barang ada di dalam tabel
    $barang = $br->selectWhere("table_barang", "kd_barang", $kode_barang);

    if ($barang) {
        // Panggil fungsi untuk tambah barang masuk
        $response = $br->tambahBarangMasuk($kode_barang, $jumlah);
        
        // Redirect ke halaman viewBarang.php setelah berhasil
        header("Location: pageAdmin.php?page=viewBarang&status=" . $response['response'] . "&message=" . urlencode($response['alert']));
        exit(); // Pastikan untuk menghentikan script setelah redirect
    } else {
        // Jika barang tidak ditemukan, redirect juga dengan pesan
        header("Location: pageAdmin.php?page=viewBarang&status=negative&message=" . urlencode("Barang tidak ditemukan"));
        exit();
    }
}
?>
