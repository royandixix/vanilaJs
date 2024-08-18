<?php
// Include koneksi ke database
include('koneksi.php');

// Mengecek data hasil submit dari form pencarian
$kata_kunci = '';
$hasil_pencarian = [];

if (isset($_POST['kata_kunci'])) {
    // Ambil data hasil submit dari form
    $kata_kunci = $_POST['kata_kunci'];

    // Query untuk menampilkan data dari tabel "tbl_siswa" berdasarkan "kata_kunci"
    $query = "SELECT id_siswa, kelas, nama_lengkap, foto_profil 
              FROM tbl_siswa 
              WHERE id_siswa LIKE '%$kata_kunci%' OR nama_lengkap LIKE '%$kata_kunci%'
              ORDER BY id_siswa ASC";
    $result = mysqli_query($db, $query);

    // Ambil hasil pencarian
    if ($result && mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            $hasil_pencarian[] = $data;
        }
    }
}
?>



<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>Siswa</h3>
    </div>
    <!-- breadcrumbs -->
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none"><i
                            class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">Siswa</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Pencarian</li>
            </ol>
        </nav>
    </div>
</div>

<div class="mb-5">
    <div class="row flex-lg-row-reverse align-items-center">
        <!-- button kembali ke halaman tampil data -->
        <div class="col-lg-4 col-xl-3">
            <a href="?halaman=data" class="btn btn-primary rounded-pill float-lg-end py-2 px-4 mb-4 mb-lg-0">
                <i class="fa-solid fa-angle-left me-2"></i> Kembali
            </a>
        </div>
        <!-- form pencarian -->
        <div class="col-lg-8 col-xl-9">
            <form action="?halaman=pencarian" method="post" class="form-search needs-validation" novalidate>
                <input type="text" name="kata_kunci" class="form-control rounded-pill" placeholder="Cari Siswa ..."
                    autocomplete="off" required>
                <div class="invalid-feedback">Masukan ID atau Nama Siswa yang ingin Anda cari.</div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <?php if (!empty($kata_kunci)) { ?>
        <div class="col-12">
            <div class="alert alert-primary rounded-4 mb-5" role="alert">
                <i class="fa-solid fa-hand-point-right me-2"></i> Hasil Pencarian <span
                    class="fw-bold fst-italic">"<?php echo htmlspecialchars($kata_kunci, ENT_QUOTES); ?>"</span>
            </div>
        </div>
    <?php } ?>

    <?php if (!empty($hasil_pencarian)) {
        foreach ($hasil_pencarian as $data) { ?>
            <div class="p-2">
                <div class="d-flex bg-white rounded-4 shadow-sm">
                    <div class="flex-shrink-0 p-3">
                        <img src="images/<?php echo htmlspecialchars($data['foto_profil'], ENT_QUOTES); ?>"
                            class="border border-2 img-fluid rounded-4" alt="Foto Profil" width="100" height="100">
                    </div>
                    <div class="p-4 flex-grow-1">
                        <h5><?php echo htmlspecialchars($data['id_siswa'], ENT_QUOTES); ?> -
                            <?php echo htmlspecialchars($data['nama_lengkap'], ENT_QUOTES); ?></h5>
                        <p class="text-muted"><?php echo htmlspecialchars($data['kelas'], ENT_QUOTES); ?></p>
                    </div>
                    <div class="p-4">
                        <div class="d-flex flex-column flex-lg-row">
                            <a href="?halaman=detail&id=<?php echo htmlspecialchars($data['id_siswa'], ENT_QUOTES); ?>"
                                class="btn btn-primary btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Detail </a>
                            <a href="?halaman=ubah&id=<?php echo htmlspecialchars($data['id_siswa'], ENT_QUOTES); ?>"
                                class="btn btn-success btn-sm rounded-pill px-3 me-2 mb-2 mb-lg-0"> Ubah </a>
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal"
                                data-bs-target="#modalHapus<?php echo htmlspecialchars($data['id_siswa'], ENT_QUOTES); ?>">
                                Hapus </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal hapus data -->
            <div class="modal fade" id="modalHapus<?php echo htmlspecialchars($data['id_siswa'], ENT_QUOTES); ?>"
                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                <i class="fa-regular fa-trash-can me-2"></i> Hapus Data Siswa
                            </h1>
                        </div>
                        <div class="modal-body">
                            <p class="mb-2">Anda yakin ingin menghapus data siswa?</p>
                            <p class="fw-bold mb-2"><?php echo htmlspecialchars($data['id_siswa'], ENT_QUOTES); ?> <span
                                    class="fw-normal">-</span>
                                <?php echo htmlspecialchars($data['nama_lengkap'], ENT_QUOTES); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-pill px-3"
                                data-bs-dismiss="modal">Batal</button>
                            <a href="proses_hapus.php?id=<?php echo htmlspecialchars($data['id_siswa'], ENT_QUOTES); ?>"
                                class="btn btn-danger rounded-pill px-3">Ya, Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    } else if (!empty($kata_kunci)) { ?>
            <div class="col-12">
                <i class="fa-regular fa-circle-question me-1"></i>
                Data siswa dengan kata kunci <span
                    class="text-primary fst-italic px-2">"<?php echo htmlspecialchars($kata_kunci, ENT_QUOTES); ?>"</span> tidak
                ditemukan.
            </div>
    <?php } ?>
</div>