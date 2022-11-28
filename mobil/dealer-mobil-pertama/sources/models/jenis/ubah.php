<?php
$sourcePath = "./../..";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 2, "$sourcePath/../");

function cek($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_SESSION["id"])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM tabel_jenis WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $id = $_GET['id'];

            $nama = cek($_POST['nama']);

            $sql = "UPDATE tabel_jenis SET nama='$nama' WHERE id='$id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>alert('Data berhasil diubah');</script>";
                echo "<script>window.location='ubah.php?id=$id';</script>";
            } else if (!$result) {
                echo '<script>alert("Data gagal diubah");</script>';
            }
        }
    }
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $title = "Ubah Tahun Masuk";
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
                    <h5 class="font-weight-normal">Ubah Jenis</h5>
                </div>

                <!-- All Basic Form elements -->
                <div class="row mt-4">
                    <div class="col-12 mt-4">
                        <!-- Form inputs card -->
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>" method="post">
                            <div class="card rounded-lg">
                                <div class="card-body">
                                    <div class="card-title">Masukkan Data Baru</div>

                                    <!-- Create 2 row -->
                                    <div class="row">
                                        <!-- 1st row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama">Jenis</label>
                                                <input id="nama" class="form-control bg-light" type="text" name="nama" value="<?php echo $data['nama']; ?>" required>
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