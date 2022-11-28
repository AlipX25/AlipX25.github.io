<?php
$sourcePath = ".";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/isAuthenticated.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Login";
    ?>

    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $sourcePath; ?>/public/css/login_register.css">
    <link rel="icon" href="<?php echo $sourcePath; ?>/public/images/smk.png" type="image/icon-type">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    if (!isset($_SESSION["id"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["btnLogin"])) {
                $nisn = $_POST['nisn'];
                $tanggal_lahir = $_POST['tanggal_lahir'];

                $sql = "SELECT id FROM tabel_siswa WHERE nisn='$nisn' AND tanggal_lahir='$tanggal_lahir'";
                $result = mysqli_query($conn, $sql);

                if ($result->num_rows != 0) {
                    $row = mysqli_fetch_assoc($result);

                    $_SESSION['id'] = $row['id'];
                    $_SESSION['type'] = "siswa";

                    echo "<script>alert('Login berhasil');</script>";
                    echo "<script>window.location='$sourcePath/../index.php';</script>";
                } else if ($result->num_rows == 0) {
                    echo "<script>alert('Login gagal');</script>";
                }
            }
        }
    }
    ?>

    <div class="container" id="container">
        <!-- Login -->
        <div class="form-container sign-in-container">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <h1>Sign In</h1>
                <div class="social-container">

                </div>
                <input type="number" name="nisn" placeholder="NISN" />
                <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" />
                <button name="btnLogin">Sign In</button>
                <p>Login sebagai user <a href="login.php">di sini</a></p>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Halo, Teman!</h1>
                    <p>Selamat Datang di Website Data Siswa</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</body>

</html>