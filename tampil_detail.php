<?php
// Include koneksi database
include 'config/database.php'; // Pastikan file ini ada dan koneksi sudah didefinisikan di sini

// Mengecek data GET "id_siswa"
if (isset($_GET['id'])) {
    // Ambil data GET dari tombol detail
    $id_siswa = $_GET['id'];

    // Menggunakan prepared statement untuk menghindari SQL injection
    if ($stmt = $db->prepare("SELECT * FROM tbl_siswa WHERE id_siswa = ?")) {
        $stmt->bind_param("s", $id_siswa);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ambil data hasil query
        if ($data = $result->fetch_assoc()) {
            // Data ditemukan
        } else {
            die('Data siswa tidak ditemukan.');
        }

        $stmt->close();
    } else {
        die('Gagal mempersiapkan query: ' . $db->error);
    }
} else {
    die('ID siswa tidak ditemukan.');
}
?>

<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- Judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center mt-5 ms-5">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>Siswa</h3>
    </div>
    <!-- Breadcrumbs -->
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">Siswa</a></li>
                <li class="breadcrumb-item" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-white rounded-4 shadow-sm p-4 mb-5">
    <!-- Judul form -->
    <div class="alert alert-primary rounded-4 mb-5" role="alert">
        <i class="fa-solid fa-list-ul me-2"></i> Detail Data Siswa
    </div>
    <!-- Tampilkan data -->
    <div class="d-flex flex-column flex-xl-row">
        <div class="flex-shrink-0 text-center mb-5 mb-xl-0">
            <div class="foto-profil-detail">
                <img src="images/<?php echo htmlspecialchars($data['foto_profil']); ?>" class="border border-2 img-fluid rounded-4 shadow" alt="Foto Profil" width="240" height="240">
            </div>
        </div>
        <div class="flex-grow-1 text-muted fw-light ms-xl-5">
            <div class="table-responsive">
                <table class="table table-striped lh-lg">
                    <tr>
                        <td width="200">ID Siswa</td>
                        <td width="10">:</td>
                        <td><?php echo htmlspecialchars($data['id_siswa']); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Daftar</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars(tanggal_indo($data['tanggal_daftar'])); ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($data['kelas']); ?></td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($data['nama_lengkap']); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($data['jenis_kelamin']); ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($data['email']); ?></td>
                    </tr>
                    <tr>
                        <td>WhatsApp</td>
                        <td>:</td>
                        <td><?php echo htmlspecialchars($data['whatsapp']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="pt-4 pb-2 mt-5 border-top">
        <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
            <!-- Button kembali ke halaman tampil data -->
            <a href="?halaman=data" class="btn btn-primary rounded-pill py-2 px-4">Kembali</a>
        </div>
    </div>
</div>
