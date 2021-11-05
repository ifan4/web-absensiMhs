<?php
session_start();

if (isset($_SESSION["loginMhs"])) {
    header("location: dashboard-mahasiswa.php");
    exit;
}

require '../koneksi.php';
$error = false;

if (isset($_POST["submit"])) {

    $nim = $_POST["nim"];
    $password = md5($_POST["password"]);

    $ambil = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim = '$nim'");



    if (mysqli_num_rows($ambil) === 1) {

        $user = mysqli_fetch_assoc($ambil);
        $passwordHash = $user["password"];

        $checkPassword =  $password == $passwordHash;


        if ($checkPassword) {
            $_SESSION["loginMhs"] = true;
            $_SESSION["dataMahasiswa"] = $user;


            header('location: dashboard-mahasiswa.php');
            exit;
        }
    }
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>

    <!-- IMPORT STYLE -->
    <link rel="stylesheet" href="../css/login.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!--Icon Kecil-->
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!--Bootstrap Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
</head>

<body class="">
    <div class="container col-md-4 col-11 position-absolute top-50 start-50 translate-middle">
        <div class="buletan bg-dark d-flex justify-content-center mx-auto">
            <i class="bi bi-person-fill align-self-center"></i>
        </div>
        <h1 class="fs-2 text-center">Login Mahasiswa</h1>
        <?php if ($error) : ?>
            <h5 class="text-danger fs-5 text-center">PASSWORD SALAH!</h5>
        <?php endif
        ?>
        <form action="" method="POST" class="text-center mx-5">
            <input type="text" class="form-control mb-2 mx-auto w-100" placeholder="NIM" name="nim">
            <input type="password" class="form-control mb-3 mx-auto w-100" placeholder="PASSWORD" name="password">

            <button type="submit" name="submit" class="btn mb-5 text-white bg-dark btn-outline-dark w-100">LOGIN</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>