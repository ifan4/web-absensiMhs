<?php
session_start();

if (!isset($_SESSION["loginMhs"])) {
    header("location: ../");
    exit;
}

$koneksi = mysqli_connect("localhost", "root", "", "webabsensi");

$ambil = mysqli_query($koneksi, "SELECT * FROM mahasiswa, tb_absensi WHERE mahasiswa.idMhs = tb_absensi.idMhs ORDER BY id_absensi DESC");
if (isset($_GET["mataKuliah"])) {
    $mkDipilih = $_GET["mataKuliah"];

    if ($mkDipilih == "all") {
        $ambil = mysqli_query($koneksi, "SELECT * FROM mahasiswa, tb_absensi WHERE mahasiswa.idMhs = tb_absensi.idMhs ORDER BY id_absensi DESC");
    } else {
        $ambil = mysqli_query($koneksi, "SELECT * FROM mahasiswa, tb_absensi WHERE mahasiswa.idMhs = tb_absensi.idMhs and mata_kuliah = '$mkDipilih'  ORDER BY id_absensi DESC");
    }
}


function chooseSelect($mkPerbandingan)
{
    if (isset($_GET["mataKuliah"]) && $_GET["mataKuliah"] == $mkPerbandingan) {
        return "selected";
    }
}



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

                <a href="dashboard-mahasiswa.php" class="text-decoration-none btn-outline-primary">
                    <div class="d-flex align-items-center px-4 py-3 text-white">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Dashboard</span>
                    </div>
                </a>
                <a href="#" class="text-decoration-none bg-primary btn-outline-primary">
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
                <h5>
                    <i class="bi bi-clock"></i>
                    Attandance
                </h5>
                <h6>
                    <?= $_SESSION["dataMahasiswa"]["nama"] ?>
                    <i class="ms-2 bi bi-person-circle fs-3 align-middle"></i>
                </h6>
            </div>


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
                    <h6>Total Absen</h6>
                    <span class="fw-bold"><?= $totalAbsen ?></span>
                </div>
            </div>
            <form action="" method="GET" id="form-filter">
                <label class="mt-4" for="mataKuliah">Filter bersarkan mata kuliah:</label> <br>
                <select class="w-25 py-1" name="mataKuliah" id="" onChange="document.getElementById('form-filter').submit();" required>
                    <option value="" hidden selected>Pilih mata kuliah</option>
                    <option <?= chooseSelect("Rekayasa Perangkat Lunak"); ?>>Rekayasa Perangkat Lunak</option>
                    <option <?= chooseSelect("Manajemen Proyek Sistem Informasi"); ?>>Manajemen Proyek Sistem Informasi</option>
                    <option <?= chooseSelect("Customer Relationship Management"); ?>>Customer Relationship Management</option>
                    <option <?= chooseSelect("Arsitektur Enterprise"); ?>>Arsitektur Enterprise</option>
                    <option <?= chooseSelect("Supply Chain Management") ?>>Supply Chain Management</option>
                    <option <?= chooseSelect("Metodologi Penelitian") ?>>Metodologi Penelitian</option>
                    <option value="all" <?= chooseSelect("all"); ?>>Tampilkan Semua</option>
                </select>
            </form>

            <table class="table mt-1">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Mata Kuliah</th>
                        <th scope="col">Status</th>
                        <th scope="col">Jam Hadir</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($dataAbsensi = mysqli_fetch_assoc($ambil)) : ?>

                        <?php if ($dataAbsensi['idMhs'] == $_SESSION["dataMahasiswa"]["idMhs"]) : ?>
                            <tr>
                                <th scope="row"><?= $dataAbsensi["waktu"] ?></th>
                                <th scope="row"><?= $dataAbsensi["mata_kuliah"] ?></th>
                                <td class="text-white <?php if ($dataAbsensi['status'] == 'hadir') {
                                                            echo 'bg-success';
                                                        } else {
                                                            echo 'bg-danger';
                                                        } ?>"><?= $dataAbsensi["status"] ?></td>
                                <td><?= $dataAbsensi["jam_hadir"] ?></td>
                                <td><?= $dataAbsensi["keterangan"] ?></td>
                            </tr>
                        <?php endif ?>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>



    <script src="../script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>