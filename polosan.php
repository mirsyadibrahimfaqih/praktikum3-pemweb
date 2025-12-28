<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <!-- Mengimpor Bootstrap CSS dan JS dari CDN resmi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Styling kustom untuk mempercantik tampilan -->
    <style>
        body {
            background-color: #f2f4f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-header-form {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
            text-align: center;
        }

        .btn-proses {
            background-color: #0d6efd;
            color: white;
        }

        .hasil-container {
            font-size: 0.95rem;
        }

        .hasil-label {
            font-weight: bold;
            width: 130px;
            display: inline-block;
        }

        .nama-nim-row {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .alert-custom {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>

<body>
<div class="container mt-4 mb-5" style="max-width: 900px;">
    <div class="card shadow-sm">
        <!-- Judul utama form -->
        <div class="card-header card-header-form">
            Form Penilaian Mahasiswa
        </div>

        <div class="card-body">
            <!-- Form input data mahasiswa -->
            <form method="post">
                <!-- Input Nama -->
                <div class="mb-3">
                    <label class="form-label">Masukkan Nama</label>
                    <input type="text" name="nama" class="form-control"
                        value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>">
                </div>

                <!-- Input NIM -->
                <div class="mb-3">
                    <label class="form-label">Masukkan NIM</label>
                    <input type="text" name="nim" class="form-control"
                        value="<?= isset($_POST['nim']) ? htmlspecialchars($_POST['nim']) : '' ?>">
                </div>

                <!-- Input Kehadiran -->
                <div class="mb-3">
                    <label class="form-label">Nilai Kehadiran (10%)</label>
                    <input type="number" name="kehadiran" class="form-control"
                        placeholder="Minimal 70% untuk lulus"
                        value="<?= isset($_POST['kehadiran']) ? $_POST['kehadiran'] : '' ?>">
                </div>

                <!-- Input Nilai Tugas -->
                <div class="mb-3">
                    <label class="form-label">Nilai Tugas (20%)</label>
                    <input type="number" name="tugas" class="form-control"
                        value="<?= isset($_POST['tugas']) ? $_POST['tugas'] : '' ?>">
                </div>

                <!-- Input Nilai UTS -->
                <div class="mb-3">
                    <label class="form-label">Nilai UTS (30%)</label>
                    <input type="number" name="uts" class="form-control"
                        value="<?= isset($_POST['uts']) ? $_POST['uts'] : '' ?>">
                </div>

                <!-- Input Nilai UAS -->
                <div class="mb-3">
                    <label class="form-label">Nilai UAS (40%)</label>
                    <input type="number" name="uas" class="form-control"
                        value="<?= isset($_POST['uas']) ? $_POST['uas'] : '' ?>">
                </div>

                <!-- Tombol untuk memproses form -->
                <div class="d-grid">
                    <button type="submit" name="proses" class="btn btn-proses">
                        Proses
                    </button>
                </div>
            </form>

            <?php
            if (isset($_POST['proses'])) {
                // Ambil semua nilai dari form
                $nama = trim($_POST['nama']);
                $nim = trim($_POST['nim']);
                $kehadiran = trim($_POST['kehadiran']);
                $tugas = trim($_POST['tugas']);
                $uts = trim($_POST['uts']);
                $uas = trim($_POST['uas']);

                // Validasi: pastikan semua field terisi
                if ($nama === '' || $nim === '' || $kehadiran === '' || $tugas === '' || $uts === '' || $uas === '') {
                    echo '<div class="alert alert-custom mt-3">Semua kolom harus diisi!</div>';
                } else {
                    // Hitung Nilai Akhir berdasarkan bobot
                    $nilai_akhir = 
                        ($kehadiran * 0.10) + 
                        ($tugas * 0.20) + 
                        ($uts * 0.30) + 
                        ($uas * 0.40);

                    // Tentukan grade berdasarkan nilai akhir
                    if ($nilai_akhir >= 85) {
                        $grade = "A";
                    } elseif ($nilai_akhir >= 70) {
                        $grade = "B";
                    } elseif ($nilai_akhir >= 55) {
                        $grade = "C";
                    } elseif ($nilai_akhir >= 40) {
                        $grade = "D";
                    } else {
                        $grade = "E";
                    }

                    // Cek kelulusan:
                    if ($kehadiran < 70 || $nilai_akhir < 60 || $tugas < 40 || $uts < 40 || $uas < 40) {
                        $status = "TIDAK LULUS";
                        $warna_tema = "#dc3545"; 
                    } else {
                        $status = "LULUS";
                        $warna_tema = "#198754"; 
                    }
            ?>

            <!-- Menampilkan hasil penilaian -->
            <div id="hasilPenilaian" class="card mt-3" style="border: 1px solid <?= $warna_tema ?>;">
                <div class="card-header text-white fw-bold" style="background-color: <?= $warna_tema ?>;">
                    Hasil Penilaian
                </div>

                <div class="card-body hasil-container">
                    <div class="row nama-nim-row">
                        <div class="col-6 text-center">Nama: <?= htmlspecialchars($nama) ?></div>
                        <div class="col-6 text-center">NIM: <?= htmlspecialchars($nim) ?></div>
                    </div>

                    <p><span class="hasil-label">Nilai Kehadiran:</span> <?= $kehadiran ?>%</p>
                    <p><span class="hasil-label">Nilai Tugas:</span> <?= $tugas ?></p>
                    <p><span class="hasil-label">Nilai UTS:</span> <?= $uts ?></p>
                    <p><span class="hasil-label">Nilai UAS:</span> <?= $uas ?></p>
                    <p><span class="hasil-label">Nilai Akhir:</span> <?= number_format($nilai_akhir, 2) ?></p>
                    <p><span class="hasil-label">Grade:</span> <?= $grade ?></p>
                    <p><span class="hasil-label">Status:</span>
                        <strong style="color: <?= $warna_tema ?>"><?= $status ?></strong>
                    </p>

                    <!-- Tombol "Selesai" untuk menyembunyikan hasil -->
                    <button class="btn w-100 text-white" style="background-color: <?= $warna_tema ?>;"
                        onclick="hilangkanHasil()">
                        Selesai
                    </button>
                </div>
            </div>

            <?php
                } 
            } 
            ?>
        </div>
    </div>
</div>

<!-- Logika penyemubyian hasil -->
<script>
    function hilangkanHasil() {
        document.getElementById("hasilPenilaian").style.display = "none";
    }
</script>

</body>
</html>