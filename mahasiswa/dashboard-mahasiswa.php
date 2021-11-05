<?php
session_start();

if (!isset($_SESSION["loginMhs"])) {
    header("location: ../");
    exit;
}
require "../koneksi.php";

$idMhs = $_SESSION["dataMahasiswa"]["idMhs"];
$ambil_tb_absen = mysqli_query($koneksi, "SELECT * FROM tb_absensi WHERE idMhs = $idMhs");

//Mendeklarasikan variabel yang akan ditampilkan d dashboard
$totalHariBelajar = 0;
$totalKehadiran = 0;
$totalAbsen = 0;

//menghitung banyaknya total hari belajar
while ($data = mysqli_fetch_assoc($ambil_tb_absen)) {
    $totalHariBelajar++;
    if (strcmp($data["status"], "hadir") == 0) {
        $totalKehadiran++;
    } elseif (strcmp($data["status"], "absen") == 0) {
        $totalAbsen++;
    } else {
        $totalAbsen++;
    }
}

//Mendapatkan Waktu Saat Ini baik jam maupun waktu detail
function getWaktu($param)
{
    date_default_timezone_set("Asia/Jakarta");

    if ($param == "date") {
        // $waktu = date("j-m-Y");
        $waktu = date("Y-m-j");
    } elseif ($param == "jam") {
        $waktu = date("G:i");
    }
    return $waktu;
}

//Ketika button hadir diklik
if (isset($_POST["hadir"])) {
    $waktu = getWaktu("date");
    $mk = $_POST["mataKuliah"];
    $jam_hadir = getWaktu("jam");
    $ket = $_POST["keterangan"];

    mysqli_query($koneksi, "INSERT INTO tb_absensi VALUES ('', $idMhs, '$mk', 'hadir', '$waktu', '$jam_hadir', '$ket')");

    header("location: attendance.php");
    exit;
}
//Ketika button Tidak Hadir diklik
if (isset($_POST["absen"])) {
    $waktu = getWaktu("date");
    $mk = $_POST["mataKuliah"];
    $jam_hadir = getWaktu("jam");
    $ket = $_POST["keterangan"];

    mysqli_query($koneksi, "INSERT INTO tb_absensi VALUES ('', $idMhs, '$mk', 'absen', '$waktu', '-', '$ket')");
    header("location: attendance.php");
    exit;
}

//Mengambil absensi terakhir guna membuat logic alert informasi sudah absen atau belum
function checkAbsen()
{
    global $koneksi, $idMhs;
    $ambil_absensi_terakhir = mysqli_query($koneksi, "SELECT * FROM tb_absensi WHERE idMhs = $idMhs ORDER BY id_absensi DESC LIMIT 1");
    $absensi_terakhir = mysqli_fetch_assoc($ambil_absensi_terakhir);

    if (isset($absensi_terakhir) && $absensi_terakhir["waktu"] == getWaktu("date") && $absensi_terakhir["status"] == "hadir") {
        return true;
    } else {
        return false;
    }
}

checkAbsen();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

</head>

<body>
    <div class="container-fluid row p-0">
        <!-- SIDEBAR SECTION -->
        <div class="col-3">
            <nav class="nav flex-column bg-dark" style="height: 800px; " id="sidebar-dashboard">
                <h3 class="text-center text-white my-3">Absensi Mahasiswa</h3>
                <hr class="border">

                <a href="#" class="text-decoration-none bg-primary btn-outline-primary">
                    <div class="d-flex align-items-center px-4 py-3 text-white">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Dashboard</span>
                    </div>
                </a>
                <a href="attendance.php" class="text-decoration-none btn-outline-primary">
                    <div class="d-flex align-items-center px-4 py-3 text-white">
                        <i class="bi bi-calendar-check"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Attandance</span>
                    </div>
                </a>
                <a href="../logout.php" class="position-absolute ms-3 mb-2 bottom-0 rounded-3 text-decoration-none bg-danger btn-outline-danger">
                    <div class=" d-flex align-items-center px-3 py-2 text-white">
                        <i class="bi bi-box-arrow-in-left"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Log Out</span>
                    </div>
                </a>
            </nav>
        </div>
        <!-- END OF SIDEBAR SECTION -->

        <div class="col-9">
            <div class="d-flex justify-content-between py-3">
                <h5 class="">
                    <i class="bi bi-speedometer2"></i>
                    DASHBOARD
                </h5>
                <h6>
                    <?= $_SESSION["dataMahasiswa"]["nama"] ?>
                    <i class="ms-2 bi bi-person-circle fs-3 align-middle"></i>
                </h6>
            </div>

            <?php if (checkAbsen()) : ?>
                <div class="alert alert-success" role="alert">
                    Hari Ini Sudah Absen
                </div>
            <?php endif ?>
            <div class="row justify-content-between mt-3 mx-1">
                <div class="col-3 bg-dark text-white py-3 rounded-3 text-center">
                    <h6>Total Hari Belajar</h6>
                    <span class="fw-bold"><?= $totalHariBelajar ?></span>
                </div>
                <div class="col-3 bg-dark text-white py-3 rounded-3 text-center">
                    <h6>Total Kehadiran</h6>
                    <span class="fw-bold"><?= $totalKehadiran ?></span>
                </div>
                <div class="col-3 bg-dark text-white py-3 rounded-3 text-center">
                    <h6>Total Absent</h6>
                    <span class="fw-bold"><?= $totalAbsen ?></span>
                </div>
            </div>

            <?php if (!checkAbsen()) : ?>
                <h6 class="mt-5 mb-3">Fitur Absensi</h6>


                <form action="" method="POST" class="" id="form-area">
                    <select class="d-block w-50 py-2 mb-2" name="mataKuliah" id="" required>
                        <option value="" hidden selected>Pilih Mata Kuliah</option>
                        <option>Rekayasa Perangkat Lunak</option>
                        <option>Manajemen Proyek Sistem Informasi</option>
                        <option>Customer Relationship Management</option>
                        <option>Arsitektur Enterprise</option>
                        <option>Supply Chain Management</option>
                        <option>Metodologi Penelitian</option>
                    </select>
                    <div class="d-flex mb-3">
                        <input type="text" class="currentTime form-control w-25 me-2 ps-5" name="waktu" readonly>
                        <i class="bi bi-clock-fill position-absolute text-dark p-3"></i>
                        <input type="text" class="form-control me-3" placeholder="Beri keterangan jika tidak hadir" name="keterangan">
                        <button onclick="tidakHadir();" type="submit" class="btn btn-outline-danger me-2 btn-submit" name="absen">Tidak Hadir</button>
                        <button onclick="hadir();" type="submit" class="btn btn-outline-success px-4" name="hadir">Hadir</button>
                    </div>
                </form>
            <?php endif ?>





        </div>
    </div>

    <?php if (checkAbsen()) : ?>
        <script>
            let form = document.getElementById("form-area");
            form.setAttribute("hidden");
        </script>
    <?php endif ?>


    <script src="../script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>