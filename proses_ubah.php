<?php
// Panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// Cek jika form disubmit
if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $id_siswa = $_POST['id_siswa'];
    $tanggal = $_POST['tanggal_daftar'];
    $kelas = $_POST['kelas'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];

    // Ubah format tanggal menjadi Y-m-d
    $tanggal_daftar = date('Y-m-d', strtotime($tanggal));

    // Cek jika ada file foto yang diunggah
    if (!empty($_FILES['foto']['name'])) {
        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $extension = pathinfo($nama_file, PATHINFO_EXTENSION);
        $nama_file_enkripsi = uniqid() . '.' . $extension; // Menggunakan uniqid() sebagai pengganti md5 untuk nama file
        $path = "images/" . $nama_file_enkripsi;

        // Memeriksa ukuran file (bisa lebih dari 1MB)
        if ($_FILES['foto']['size'] <= 5242880) {

            // Unggah file ke direktori tujuan
            if (move_uploaded_file($tmp_file, $path)) {
                // Update data siswa dengan foto baru
                $query = "UPDATE tbl_siswa SET tanggal_daftar='$tanggal_daftar', kelas='$kelas', nama_lengkap='$nama_lengkap', jenis_kelamin='$jenis_kelamin', alamat='$alamat', email='$email', whatsapp='$whatsapp', foto_profil='$nama_file_enkripsi' WHERE id_siswa='$id_siswa'";
            } else {
                die('Gagal mengunggah file.');
            }
        } else {
            die('Ukuran file melebihi batas 1MB.');
        }
    } else {
        // Update data siswa tanpa mengubah foto
        $query = "UPDATE tbl_siswa SET tanggal_daftar='$tanggal_daftar', kelas='$kelas', nama_lengkap='$nama_lengkap', jenis_kelamin='$jenis_kelamin', alamat='$alamat', email='$email', whatsapp='$whatsapp' WHERE id_siswa='$id_siswa'";
    }

    // Jalankan query update
    if (mysqli_query($db, $query)) {
        // Alihkan ke halaman data siswa dengan pesan sukses
        header('Location: index.php?halaman=data&pesan=2');
    } else {
        // Tampilkan pesan error jika query gagal
        die('Ada kesalahan pada query: ' . mysqli_error($db));
    }
}
?>
