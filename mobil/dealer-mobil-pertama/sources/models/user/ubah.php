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
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM tabel_user WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $id = $_GET['id'];

            $username = cek($_POST['username']);
            $nama_lengkap = cek($_POST['nama_lengkap']);
            $nomor_hp = cek($_POST['nomor_hp']);
            $email = cek($_POST['email']);
            $role = cek($_POST['role']);

            if (is_numeric($nomor_hp)) {
                $sql = "SELECT * FROM tabel_user WHERE username='$username'";
                $result = mysqli_query($conn, $sql);

                $sqlSelf = "SELECT username FROM tabel_user WHERE id='$id'";
                $resultSelf = mysqli_query($conn, $sqlSelf);
                $rowSelf = mysqli_fetch_assoc($resultSelf);

                $numberIncrease = 0;
                if ($username == $rowSelf["username"]) {
                    $numberIncrease = 1;
                };

                if ($result->num_rows <= 0 + $numberIncrease) {
                    $sql = "UPDATE tabel_user SET username='$username', nama_lengkap='$nama_lengkap', nomor_hp='$nomor_hp', email='$email', role='$role' WHERE id='$id'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        echo "<script>alert('Data berhasil diubah');</script>";
                        echo "<script>window.location='ubah.php?id=$id';</script>";
                    } else if (!$result) {
                        echo '<script>alert("Data gagal diubah");</script>';
                    }
                } else if ($result->num_rows > 0 + $numberIncrease) {
                    echo "<script>alert('Woops! Username sudah terdaftar')</script>";
                }
            } else if (!is_numeric($nomor_hp)) {
                echo '<script>alert("Pastikan nomor HP hanya menggunakan angka");</script>';
            }
        }
    }
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $title = "Ubah User";
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
                    <h5 class="font-weight-normal">Ubah User</h5>
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
                                                <label for="username">Username</label>
                                                <input id="username" class="form-control bg-light" type="text" name="username" value="<?php echo $data['username']; ?>">
                                            </div>
                                        </div>

                                        <!-- 2nd row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_lengkap">Nama Lengkap</label>
                                                <input id="nama_lengkap" class="form-control bg-light" type="text" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Create 2 row -->
                                    <div class="row">
                                        <!-- 1st row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nomor_hp">Nomor HP</label>
                                                <input id="nomor_hp" class="form-control bg-light" type="tel" name="nomor_hp" value="<?php echo $data['nomor_hp']; ?>" required>
                                            </div>
                                        </div>

                                        <!-- 2nd row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input id="email" class="form-control bg-light" type="email" name="email" value="<?php echo $data['email']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Create 2 row -->
                                    <div class="row">
                                        <!-- 1st row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role">Role:</label>
                                                <select id="role" class="custom-select bg-light" name="role" required>
                                                    <option selected disabled style="color: #472086;">Pilih Role</option>

                                                    <?php
                                                    $roleArray = array(
                                                        array("operator", "Operator"),
                                                        array("admin", "Admin")
                                                    );

                                                    foreach ($roleArray as $role) {
                                                        if ($data["role"] == $role[0]) {
                                                    ?>
                                                            <option value='<?php echo $role[0] ?>' selected><?php echo $role["1"] ?></option>
                                                        <?php
                                                        } else if ($data["id_rombel"] != $row["id"]) {
                                                        ?>
                                                            <option value='<?php echo $role[0] ?>'><?php echo $role["1"] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
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
        </main>
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