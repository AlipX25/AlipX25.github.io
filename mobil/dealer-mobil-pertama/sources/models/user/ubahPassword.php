<?php
$sourcePath = "./../..";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 3, "$sourcePath/../");

function cek($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_SESSION["id"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $id = $_GET['id'];

            $password = md5($_POST["password"]);
            $cpassword = md5($_POST["cpassword"]);

            if ($password == $cpassword) {
                $sql = "UPDATE tabel_user SET password='$password' WHERE id='$id'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<script>alert('Password berhasil diubah');</script>";
                    echo "<script>window.location='tabel.php';</script>";
                } else if (!$result) {
                    echo '<script>alert("Password gagal diubah");</script>';
                }
            } else if ($password != $cpassword) {
                echo '<script>alert("Konfirmasi password salah");</script>';
            }
        }
    }
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $title = "Ubah Password User";
    include "$sourcePath/components/head.php";
    ?>
</head>

<body class="position-relative">
    <div class="container-fluid px-0">
        <?php
        include "$sourcePath/components/sidebar.php";
        ?>

        <!-- Main section -->
        <main class="bg-light main-full-body">
            <!-- The navbar -->
            <nav class="navbar navbar-expand navbar-light bg-light py-3">
                <p class="navbar-brand mb-0 pb-0">
                    <span></span>
                    <span></span>
                    <span></span>
                </p>
            </nav>

            <!--Page Body part -->
            <div class="page-body p-4 text-dark">
                <div class="page-heading border-bottom d-flex flex-row">
                    <h5 class="font-weight-normal">Ubah Password User</h5>
                </div>

                <!-- All Basic Form elements -->
                <div class="row mt-4">
                    <div class="col-12 mt-4">
                        <!-- Form inputs card -->
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>" method="post">
                            <div class="card rounded-lg">
                                <div class="card-body">
                                    <div class="card-title">Masukkan Password Baru</div>

                                    <!-- Create 2 row -->
                                    <div class="row">
                                        <!-- 1st row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password Baru</label>
                                                <input id="password" class="form-control bg-light" type="password" name="password">
                                            </div>
                                        </div>

                                        <!-- 2nd row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cpassword">Konfirmasi Password</label>
                                                <input id="cpassword" class="form-control bg-light" type="password" name="cpassword">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit button -->
                                    <button type="submit" id='update' name='update' class="btn btn-primary">Ubah</button>
                                    <a type="button" class="btn btn-danger center-block" href="tabel.php">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            include "$sourcePath/components/footer.php";
            ?>
        </main>
    </div>

    <script src="<?php echo $sourcePath ?>/scripts/js/vendor/bootstrap-4.3.1/modernizr-3.7.1.min.js"></script>
    <script src="<?php echo $sourcePath ?>/scripts/js/vendor/jquery-3.3.1/jquery-3.3.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="<?php echo $sourcePath ?>/scripts/js/vendor/popper-js/popper1.14.7.js"></script>
    <script src="<?php echo $sourcePath ?>/scripts/js/vendor/bootstrap-4.3.1/bootstrap.min.js"></script>

    <script src="<?php echo $sourcePath ?>/scripts/js/plugins.js"></script>
    <script src="<?php echo $sourcePath ?>/scripts/js/main.js"></script>
</body>

</html>