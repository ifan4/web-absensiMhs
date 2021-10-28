<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../");
    exit;
}

require "../koneksi.php";

$ambil_tb_mhs = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
$ambil_tb_absen_hadir = mysqli_query($koneksi, "SELECT * FROM tb_absensi WHERE status = 'hadir' ");
$ambil_tb_absen_absen = mysqli_query($koneksi, "SELECT * FROM tb_absensi WHERE status = 'absen' ");

//deklarasi variabel yang ditampilkan pada dashboard dosen
$total_mahasiswa = mysqli_num_rows($ambil_tb_mhs);
$total_hadir = mysqli_num_rows($ambil_tb_absen_hadir);
$total_absen = mysqli_num_rows($ambil_tb_absen_absen);


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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="container-fluid row p-0">
        <!-- SIDEBAR SECTION -->
        <div class="col-3">
            <nav class="nav flex-column bg-success" style="height: 800px; " id="sidebar-dashboard">
                <h4 class="text-center text-white my-3">Kelola Absensi Mahasiswa</h4>
                <hr>
                <a href="#" class="text-decoration-none bg-dark btn-outline-dark">
                    <div class="d-flex align-items-center px-4 py-3 text-white">
                        <i class="bi bi-speedometer2"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Dashboard</span>
                    </div>
                </a>
                <a href="daftarMahasiswa.php" class="text-decoration-none btn-outline-dark">
                    <div class="d-flex align-items-center px-4 py-3 text-white">
                        <i class="bi bi-people"></i>
                        <span class="ms-3 text-sidebar" aria-current="page">Daftar Mahasiswa</span>
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
            <h4 class="py-3">
                <i class="bi bi-speedometer2"></i>
                DASHBOARD
            </h4>


            <div class="row justify-content-between mt-3 mx-1">
                <div class="col-3 bg-dark text-white py-3 rounded-3 text-center">
                    <h6>Total Mahasiswa</h6>
                    <span class="fw-bold" id="totMhs"><?= $total_mahasiswa ?></span>
                </div>
                <div class="col-3 bg-success text-white py-3 rounded-3 text-center">
                    <h6>Total Kehadiran</h6>
                    <span class="fw-bold" id="totHadir"><?= $total_hadir ?></span>
                </div>
                <div class="col-3 bg-danger text-white py-3 rounded-3 text-center">
                    <h6>Total Absent</h6>
                    <span class="fw-bold" id="totAbsen"><?= $total_absen ?></span>
                </div>
            </div>

            <div class="w-50 mx-auto mt-3">
                <canvas id="myChart"></canvas>
            </div>

            <script>
                totMhs = parseInt(document.getElementById("totMhs").innerHTML);
                totHadir = parseInt(document.getElementById("totHadir").innerHTML);
                totAbsen = parseInt(document.getElementById("totAbsen").innerHTML);

                const labels = [
                    'Total Kehadiran',
                    'Total Absent',
                ];
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: [
                            '#188754',
                            '#DC3546'
                        ],
                        borderColor: '#00C292',
                        data: [totHadir, totAbsen],
                    }]
                };
                const config = {
                    type: 'pie',
                    data: data,
                    options: {}
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>




        </div>
    </div>



    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>