<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

// mengecek data hasil submit dari form
if (isset($_POST['simpan'])) {
    // Ambil data hasil submit dari form
    $id_siswa      = $db->real_escape_string($_POST['id_siswa']);
    $tanggal       = $db->real_escape_string(trim($_POST['tanggal_daftar']));
    $kelas         = $db->real_escape_string($_POST['kelas']);
    $nama_lengkap  = $db->real_escape_string(trim($_POST['nama_lengkap']));
    $jenis_kelamin = $db->real_escape_string($_POST['jenis_kelamin']);
    $alamat        = $db->real_escape_string(trim($_POST['alamat']));
    $email         = $db->real_escape_string(trim($_POST['email']));
    $whatsapp      = $db->real_escape_string(trim($_POST['whatsapp']));

    // Ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_daftar = date('Y-m-d', strtotime($tanggal));

    // Ambil data file hasil submit dari form
    if (!empty($_FILES['foto']['name'])) {
        $nama_file          = $_FILES['foto']['name'];
        $tmp_file           = $_FILES['foto']['tmp_name'];
        $extension          = pathinfo($nama_file, PATHINFO_EXTENSION);
        
        // Enkripsi nama file
        $nama_file_enkripsi = sha1(md5(time() . $nama_file)) . '.' . $extension;
        // Tentukan direktori penyimpanan file
        $path               = "images/" . $nama_file_enkripsi;

        // Lakukan proses unggah file
        if (move_uploaded_file($tmp_file, $path)) {
            // SQL statement untuk insert data ke tabel "tbl_siswa"
            $insert = $db->query("INSERT INTO tbl_siswa(id_siswa, tanggal_daftar, kelas, nama_lengkap, jenis_kelamin, alamat, email, whatsapp, foto_profil) 
                                      VALUES('$id_siswa', '$tanggal_daftar', '$kelas', '$nama_lengkap', '$jenis_kelamin', '$alamat', '$email', '$whatsapp', '$nama_file_enkripsi')")
                                      or die('Ada kesalahan pada query insert : ' . $db->error);

            // Cek jika proses insert berhasil
            if ($insert) {
                // Alihkan ke halaman data siswa dan tampilkan pesan berhasil simpan data
                header('location: index.php?halaman=data&pesan=1');
            }
        } else {
            die('Gagal mengunggah file.');
        }
    } else {
        die('File foto belum dipilih.');
    }
}
?>
