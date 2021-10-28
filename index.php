<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

</head>

<body class="bg-light">

    <div class="position-absolute top-50 start-50 translate-middle text-white bg-dark p-5">
        <h1 class="m-0 p-0 fw-bold" style="font-size: 70px;">SAO</h1>
        <p class="fw-light">Sistem Absensi Online</p>

        <p style="font-size: 14px;">Sistem Absensi Online merupakan fitur terbaru dari AIS UIN Jakarta yang digunakan untuk mempermudah mahasiswa UIN Jakarta melakukan absen secara online. Mahasiswa UIN Jakarta dapat melakukan absensi ini dengan cara login Memilih Matakuliah agar tercatat sudah absen pada matakuliah tersebut. Absensi ini memudahkan mahasiswa dan dosen dalam melaksanakan aktivitas perkuliahan.</p>

        <button onclick="document.location = 'mahasiswa/login-mahasiswa.php'" type="button" class="btn bg-primary text-white w-100 mb-2 mt-4">Login as Student</button>
        <button onclick="document.location = 'dosen/login-dosen.php'" type="button" class="btn bg-success text-white w-100">Login as Dosen</button>
    </div>


    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>