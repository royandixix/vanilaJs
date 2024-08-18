<?php

require 'config/database.php';

// Menampilkan pesan sesuai dengan proses yang dijalankan
// Jika pesan tersedia
if (isset($_GET['pesan'])) {
    // Jika pesan = 1
    if ($_GET['pesan'] == 1) {
        // Tampilkan pesan sukses simpan data
        echo '<div class="alert alert-success alert-dismissible rounded-4 fade show mb-4" role="alert">
                <strong><i class="fa-solid fa-circle-check me-2"></i>Sukses!</strong> Data siswa berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    // Jika pesan = 2
    elseif ($_GET['pesan'] == 2) {
        // Tampilkan pesan sukses ubah data
        echo '<div class="alert alert-success alert-dismissible rounded-4 fade show mb-4" role="alert">
                <strong><i class="fa-solid fa-circle-check me-2"></i>Sukses!</strong> Data siswa berhasil diubah.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    // Jika pesan = 3
    elseif ($_GET['pesan'] == 3) {
        // Tampilkan pesan sukses hapus data
        echo '<div class="alert alert-success alert-dismissible rounded-4 fade show mb-4" role="alert">
                <strong><i class="fa-solid fa-circle-check me-2"></i>Sukses!</strong> Data siswa berhasil dihapus.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}
?>

<div class="container">
    <div class="d-flex flex-column flex-lg-row mt-5 mb-5">
        <!-- Judul halaman -->
        <div class="flex-grow-1 d-flex align-items-center mt-5">
            <i class="fa-regular fa-user icon-title"></i>
            <h3>Siswa</h3>
        </div>
        <!-- Breadcrumbs -->
        <div class="ms-3 ms-lg-4 pt-lg-2">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none"><i
                                class="fa-solid fa-house"></i></a></li>
                    <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">Siswa</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">Data</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4 mb-lg-5">
        <!-- Button entri data -->
        <div class="col-lg-4 col-xl-3">
            <a href="?halaman=entri" class="btn btn-primary rounded-pill float-lg-end py-2 px-4 mb-3 mb-lg-0">
                <i class="fa-solid fa-plus me-2"></i> Entri Siswa
            </a>
        </div>
        <!-- Form pencarian -->
        <div class="col-lg-8 col-xl-9">
            <form action="?halaman=pencarian" method="post" class="form-search needs-validation" novalidate>
                <input type="text" name="kata_kunci" class="form-control rounded-pill" placeholder="Cari Siswa ..."
                    autocomplete="off" required>
                <div class="invalid-feedback">Masukan ID atau Nama Siswa yang ingin Anda cari.</div>
            </form>
        </div>
    </div>

    <div class="row">
    <?php
    /* 
        Membatasi jumlah data yang ditampilkan dari database untuk membuat pagination/paginasi
    */
    // Cek data "paginasi" pada URL untuk mengetahui paginasi halaman aktif
    // Jika data "paginasi" ada, maka paginasi halaman = data "paginasi". Jika data "paginasi" tidak ada, maka paginasi halaman = 1
    $paginasi_halaman = (isset($_GET['paginasi'])) ? (int) $_GET['paginasi'] : 1;
    // Tentukan jumlah data yang ditampilkan per paginasi halaman
    $batas = 10;
    // Tentukan dari data ke berapa yang akan ditampilkan pada paginasi halaman
    $batas_awal = ($paginasi_halaman - 1) * $batas;

    // SQL statement untuk menampilkan data dari tabel "tbl_siswa"
    $query = $db->query("SELECT id_siswa, kelas, nama_lengkap, foto_profil FROM tbl_siswa
                             ORDER BY id_siswa DESC LIMIT $batas_awal, $batas")
        or die('Ada kesalahan pada query tampil data : ' . $db->error);
    // Ambil jumlah data hasil query
    $rows = $query->num_rows;

    // Cek hasil query
    // Jika data siswa ada
    if ($rows <> 0) {
        // Ambil data hasil query
        while ($data = $query->fetch_assoc()) { ?>
            <!-- Tampilkan data -->
            <div class="p-2">
                <div class="d-flex bg-white rounded-4 shadow-sm">
                    <div class="flex-shrink-0 p-3">
                        <img src="images/<?php echo $data['foto_profil']; ?>" class="border border-2 img-fluid rounded-4"
                            alt="Foto Profil" width="100" height="100">
                    </div>
                    <div class="p-4 flex-grow-1">
                        <h5><?php echo $data['id_siswa']; ?> - <?php echo $data['nama_lengkap']; ?></h5>
                        <p class="text-muted"><?php echo $data['kelas']; ?></p>
                    </div>
                    <div class="p-4">
                        <div class="d-flex flex-column flex-lg-row">
                            <!-- Button form detail data -->
                            <a href="?halaman=detail&id=<?php echo $data['id_siswa']; ?>"
                                class="btn btn-primary btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Detail </a>
                            <!-- Button form ubah data -->
                            <a href="?halaman=ubah&id=<?php echo $data['id_siswa']; ?>"
                                class="btn btn-success btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Ubah </a>
                            <!-- Button modal hapus data -->
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                data-bs-target="#modalHapus<?php echo $data['id_siswa']; ?>"> Hapus </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal hapus data -->
            <div class="modal fade" id="modalHapus<?php echo $data['id_siswa']; ?>" data-bs-backdrop="static"
                data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                <i class="fa-regular fa-trash-can me-2"></i> Hapus Data Siswa
                            </h1>
                        </div>
                        <div class="modal-body">
                            <p class="mb-2">Anda yakin ingin menghapus data siswa?</p>
                            <!-- Informasi data yang akan dihapus -->
                            <p class="fw-bold mb-2"><?php echo $data['id_siswa']; ?> <span class="fw-normal">-</span>
                                <?php echo $data['nama_lengkap']; ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill px-3"
                                data-bs-dismiss="modal">Batal</button>
                            <!-- Button proses hapus data -->
                            <a href="proses_hapus.php?id=<?php echo $data['id_siswa']; ?>"
                                class="btn btn-danger rounded-pill px-3">Ya, Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="d-flex flex-column flex-xl-row align-items-center mt-4">
            <!-- Menampilkan informasi jumlah paginasi halaman dan jumlah data -->
            <div class="flex-grow-1 text-center text-xl-start text-muted mb-3">
                <?php
                // SQL statement untuk menampilkan jumlah data pada tabel "tbl_siswa"
                $query = $db->query("SELECT id_siswa FROM tbl_siswa")
                    or die('Ada kesalahan pada query tampil data : ' . $db->error);
                $total_data = $query->num_rows;
                echo "Menampilkan " . $batas_awal + 1 . " - " . min($batas_awal + $batas, $total_data) . " dari " . $total_data . " data siswa";
                ?>
            </div>
            <!-- Tombol pagination -->
            <ul class="pagination justify-content-center mb-0">
                <?php
                // Hitung total halaman
                $total_halaman = ceil($total_data / $batas);
                // Buat pagination jika jumlah halaman lebih dari 1
                if ($total_halaman > 1) {
                    for ($i = 1; $i <= $total_halaman; $i++) {
                        $active_class = ($i == $paginasi_halaman) ? ' active' : '';
                        echo '<li class="page-item' . $active_class . '"><a class="page-link" href="?halaman=data&paginasi=' . $i . '">' . $i . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>

        <?php
    } else {
        echo '<div class="alert alert-warning rounded-4" role="alert">
                <strong><i class="fa-solid fa-triangle-exclamation me-2"></i>Perhatian!</strong> Data siswa tidak ditemukan.
            </div>';
    }

    // Tutup koneksi
    $db->close();
    ?>
</div>