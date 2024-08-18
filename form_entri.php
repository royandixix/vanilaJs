<?php
// panggil file "database.php" untuk koneksi ke database
require "config/database.php";



// Query untuk ID Siswa
$query = "SELECT RIGHT(id_siswa, 5) as nomor FROM tbl_siswa ORDER BY id_siswa DESC LIMIT 1";
$result = mysqli_query($db, $query) or die('Ada kesalahan pada query tampil data : ' . mysqli_error($db));

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $nomor_urut = $data['nomor'] + 1;
} else {
    $nomor_urut = 1;
}

$id_siswa = "ID-" . str_pad($nomor_urut, 5, "0", STR_PAD_LEFT);
?>

<div class="d-flex flex-column flex-lg-row mt-5 mb-4">
    <!-- Judul halaman -->
    <div class="flex-grow-1 d-flex align-items-center mt-5 ms-4">
        <i class="fa-regular fa-user icon-title"></i>
        <h3>Siswa</h3>
    </div>
    <!-- Breadcrumbs -->
    <div class="ms-5 ms-lg-0 pt-lg-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-dark text-decoration-none"><i class="fa-solid fa-house"></i></a></li>
                <li class="breadcrumb-item"><a href="?halaman=data" class="text-dark text-decoration-none">Siswa</a></li>
                <li class="breadcrumb-item" aria-current="page">Entri</li>
            </ol>
        </nav>
    </div>
</div>

<div class="bg-white rounded-4 shadow-sm p-4 mb-5">
    <!-- Judul form -->
    <div class="alert alert-primary rounded-4 mb-5" role="alert">
        <i class="fa-solid fa-pen-to-square me-2"></i> Entri Data Siswa
    </div>
    <!-- Form entri data -->
    <form action="proses_simpan.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row">
            <div class="col-xl-6">
                <div class="row g-0">
                    <div class="mb-3 col-xl-6 pe-xl-3">
                        <label class="form-label">ID Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="id_siswa" class="form-control" value="<?php echo htmlspecialchars($id_siswa, ENT_QUOTES); ?>" readonly>
                    </div>
                    <div class="mb-3 col-xl-6 pe-xl-3">
                        <label class="form-label">Tanggal Daftar <span class="text-danger">*</span></label>
                        <input type="text" name="tanggal_daftar" class="form-control datepicker" autocomplete="off" required>
                        <div class="invalid-feedback">Tanggal daftar tidak boleh kosong.</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                    <label class="form-label">Kelas <span class="text-danger">*</span></label>
                    <select name="kelas" class="form-select" autocomplete="off" required>
                        <option selected disabled value="">-- Pilih --</option>
                        <option value="Data Analysis">Data Analysis</option>
                        <option value="Digital Marketing">Digital Marketing</option>
                        <option value="Game Development">Game Development</option>
                        <option value="Mobile Development">Mobile Development</option>
                        <option value="Web Design">Web Design</option>
                        <option value="Web Development">Web Development</option>
                    </select>
                    <div class="invalid-feedback">Kelas tidak boleh kosong.</div>
                </div>
            </div>
        </div>

        <hr class="mb-4-2">

        <div class="row">
            <div class="col-xl-6">
                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" autocomplete="off" required>
                    <div class="invalid-feedback">Nama lengkap tidak boleh kosong.</div>
                </div>

                <div class="mb-4 pe-xl-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="laki_laki" name="jenis_kelamin" class="form-check-input" value="Laki-laki" required>
                        <label class="form-check-label" for="laki_laki">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="perempuan" name="jenis_kelamin" class="form-check-input" value="Perempuan" required>
                        <label class="form-check-label" for="perempuan">Perempuan</label>
                        <div class="invalid-feedback invalid-feedback-inline">Pilih salah satu jenis kelamin.</div>
                    </div>
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" rows="2" class="form-control" autocomplete="off" required></textarea>
                    <div class="invalid-feedback">Alamat tidak boleh kosong.</div>
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" autocomplete="off" required>
                    <div class="invalid-feedback">Email tidak boleh kosong.</div>
                </div>

                <div class="mb-3 pe-xl-3">
                    <label class="form-label">WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="whatsapp" class="form-control" maxlength="13" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required>
                    <div class="invalid-feedback">WhatsApp tidak boleh kosong.</div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="mb-3 ps-xl-3">
                    <label class="form-label">Foto Profil <span class="text-danger">*</span></label>
                    <input type="file" accept=".jpg, .jpeg, .png" id="foto" name="foto" class="form-control" autocomplete="off" required>
                    <div class="invalid-feedback">Foto profil tidak boleh kosong.</div>

                    <div class="mt-4">
                        <img id="preview_foto" src="images/img-default.png" class="border border-2 img-fluid rounded-4 shadow-sm" alt="Foto Profil" width="240" height="240">
                    </div>

                    <div class="form-text mt-4">
                        Keterangan : <br>
                        - Tipe file yang bisa diunggah adalah *.jpg atau *.png. <br>
                        - Ukuran file yang bisa diunggah maksimal 1 Mb.
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 pb-2 mt-5 border-top">
            <div class="d-grid gap-3 d-sm-flex justify-content-md-start pt-1">
                <!-- Button simpan data -->
                <input type="submit" name="simpan" value="Simpan" class="btn btn-primary rounded-pill py-2 px-4">
                <!-- Button kembali ke halaman tampil data -->
                <a href="?halaman=data" class="btn btn-secondary rounded-pill py-2 px-4">Batal</a>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    // Validasi file dan preview file sebelum diunggah
    document.getElementById('foto').onchange = function() {
        var fileInput = document.getElementById('foto');
        var filePath = fileInput.value;
        var fileSize = fileInput.files[0].size;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

        if (!allowedExtensions.exec(filePath)) {
            alert("Tipe file tidak sesuai. Harap unggah file yang memiliki tipe *.jpg atau *.png.");
            fileInput.value = "";
            document.getElementById("preview_foto").src = "images/img-default.png";
        } else if (fileSize > 1000000) {
            alert("Ukuran file lebih dari 1 Mb. Harap unggah file yang memiliki ukuran maksimal 1 Mb.");
            fileInput.value = "";
            document.getElementById("preview_foto").src = "images/img-default.png";
        } else {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById("preview_foto").src = e.target.result;
            };

            reader.readAsDataURL(this.files[0]);
        }
    };
</script>
