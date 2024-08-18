<?php
// Panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// Mengecek data GET "id_siswa"
if (isset($_GET['id'])) {
    // Ambil data GET dari tombol hapus
    $id_siswa = $db->real_escape_string(trim($_GET['id']));

    // Mengecek data foto profil
    // SQL statement untuk menampilkan data "foto_profil" dari tabel "tbl_siswa" berdasarkan "id_siswa"
    $query = $db->query("SELECT foto_profil FROM tbl_siswa WHERE id_siswa='$id_siswa'")
                             or die('Ada kesalahan pada query tampil data: ' . $db->error);
    
    if ($query) {
        $data = $query->fetch_assoc();
        $foto_profil = $data['foto_profil'];

        // Hapus file foto dari folder images
        if (file_exists("images/$foto_profil")) {
            unlink("images/$foto_profil");
        }

        // SQL statement untuk delete data dari tabel "tbl_siswa" berdasarkan "id_siswa"
        $delete = $db->query("DELETE FROM tbl_siswa WHERE id_siswa='$id_siswa'")
                                  or die('Ada kesalahan pada query delete: ' . $db->error);
        
        // Cek query
        if ($delete) {
            // Alihkan ke halaman data siswa dan tampilkan pesan berhasil hapus data
            header('Location: index.php?halaman=data&pesan=3');
            exit();
        }
    }
}
?>
