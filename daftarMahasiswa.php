<?php

$koneksi = mysqli_connect("localhost", "root", "", "webabsensi");
$mk = null;

$ambil = mysqli_query($koneksi, "SELECT DISTINCT nama, idMhs FROM mahasiswa ORDER BY idMhs DESC");

function hitungTotal($mk = null, $status, $idMhs)
{
    global $koneksi;
    if ($mk == null) {
        $ambil = mysqli_query($koneksi, "SELECT * FROM tb_absensi WHERE idMhs = $idMhs and status = '$status'");
    } else {
        $ambil = mysqli_query($koneksi, "SELECT * FROM tb_absensi WHERE idMhs = $idMhs and mata_kuliah = '$mk' and status = '$status'");
    }

    return mysqli_num_rows($ambil);
}



if (isset($_GET["mataKuliah"])) {
    if ($_GET["mataKuliah"] == "all") {
        $mk = null;
        header('location: daftarMahasiswa.php');
    } else {
        $mk = $_GET["mataKuliah"];
    }
}

function chooseSelect($mkPerbandingan)
{
    if (isset($_GET["mataKuliah"]) && $_GET["mataKuliah"] == $mkPerbandingan) {
        return "selected";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

</head>

<body>
    <div class="container-fluid row p-0">
        <!-- SIDEBAR SECTION -->
        <div class="col-3">
            <nav class="nav flex-column bg-success" style="height: 800px; " id="sidebar-dashboard">
                <h4 class="text-center text-white my-3">Kelola Absensi Mahasiswa</h4>
                <hr>
                <a href="dashboard-dosen.php" class="text-decoration-none btn-outline-dark">
                    <div class="d-flex align-items-center px-4 py-3 text-white">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Dashboard</span>
                    </div>
                </a>
                <a href="#" class="text-decoration-none bg-dark btn-outline-dark">
                    <div class="d-flex align-items-center px-4 py-3 text-white">
                        <i class="bi bi-people"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Daftar Mahasiswa</span>
                    </div>
                </a>
                <a href="logout.php" class="position-absolute ms-3 mb-2 bottom-0 rounded-3 text-decoration-none bg-danger btn-outline-danger">
                    <div class=" d-flex align-items-center px-3 py-2 text-white">
                        <i class="bi bi-box-arrow-in-left"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Log Out</span>
                    </div>
                </a>
            </nav>
        </div>
        <!-- END OF SIDEBAR SECTION -->

        <div class="col-9">
            <h5 class="py-3">
                <i class="bi bi-speedometer2"></i>
                Daftar Mahasiswa
            </h5>

            <form action="" method="GET" id="form-filter">
                <label class="mt-2 fs-5" for="mataKuliah">Filter bersarkan mata kuliah:</label> <br>
                <select class="w-25 py-1" name="mataKuliah" id="" onChange="document.getElementById('form-filter').submit();" required>
                    <option value="" hidden selected>Tampilkan Semua</option>
                    <option <?= chooseSelect("Algoritma dan Pemrograman"); ?>>Algoritma dan Pemrograman</option>
                    <option <?= chooseSelect("Kalkulus"); ?>>Kalkulus</option>
                    <option <?= chooseSelect("Internet of Thing"); ?>>Internet of Thing</option>
                    <option <?= chooseSelect("Data Science"); ?>>Data Science</option>
                    <option <?= chooseSelect("Pemrograman Internet") ?>>Pemrograman Internet</option>
                    <option value="all" <?= chooseSelect("all"); ?>>Tampilkan Semua</option>
                </select>
            </form>

            <table class="table mt-1">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Total Hadir</th>
                        <th scope="col">Total Absen</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    while ($dataMhs = mysqli_fetch_assoc($ambil)) : ?>
                        <?php if (hitungTotal($mk, "hadir", $dataMhs["idMhs"]) !== 0 || hitungTotal($mk, "absen", $dataMhs["idMhs"]) !== 0 || !isset($_GET["mataKuliah"])) : ?>
                            <tr>
                                <th scope="row"><?= $no++; ?></th>
                                <td><?= $dataMhs["nama"] ?></td>
                                <td><?= hitungTotal($mk, "hadir", $dataMhs["idMhs"]) ?></td>
                                <td><?= hitungTotal($mk, "absen", $dataMhs["idMhs"]) ?></td>
                            </tr>
                        <?php endif ?>
                    <?php endwhile ?>
                </tbody>
            </table>



        </div>
    </div>



    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>