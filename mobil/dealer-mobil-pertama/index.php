<?php
$sourcePath = "./sources";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 1, "$sourcePath/../");

if (isset($_SESSION["id"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['btnUpdateData'])) {
            if ($sessionType == "user") {
                $username = $_POST['username'];
                $nama_lengkap = $_POST['nama_lengkap'];
                $nomor_hp = $_POST['nomor_hp'];
                $email = $_POST['email'];

                if (is_numeric($nomor_hp)) {
                    $sql = "SELECT * FROM tabel_user WHERE username='$username'";
                    $result = mysqli_query($conn, $sql);

                    $numberIncrease = 0;
                    if ($username == $sessionUsername) {
                        $numberIncrease = 1;
                    };

                    if ($result->num_rows <= 0 + $numberIncrease) {
                        $sql = "UPDATE tabel_user SET username='$username', nama_lengkap='$nama_lengkap', nomor_hp='$nomor_hp', email='$email' WHERE id='$sessionId'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            echo "<script>alert('Data berhasil diupdate');</script>";
                            echo "<script>window.location='index.php';</script>";
                        } else if (!$result) {
                            echo '<script>alert("Data gagal diupdate");</script>';
                        }
                    } else if ($result->num_rows > 0 + $numberIncrease) {
                        echo "<script>alert('Woops! Username sudah terdaftar')</script>";
                    }
                } else if (!is_numeric($nomor_hp)) {
                    echo '<script>alert("Pastikan nomor HP hanya menggunakan angka");</script>';
                }
            } else if ($sessionType == "siswa") {
                $nama_lengkap = $_POST['nama_lengkap'];
                $tempat_lahir = $_POST['tempat_lahir'];
                $tanggal_lahir = $_POST['tanggal_lahir'];
                $jenis_kelamin = $_POST['jenis_kelamin'];
                $id_tahun_masuk = $_POST['id_tahun_masuk'];
                $id_tingkat = $_POST['id_tingkat'];
                $id_jurusan = $_POST['id_jurusan'];
                $id_rombel = $_POST['id_rombel'];

                $sql = "UPDATE tabel_siswa SET nama_lengkap='$nama_lengkap', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin', id_tahun_masuk='$id_tahun_masuk', id_tingkat='$id_tingkat', id_jurusan='$id_jurusan', id_rombel='$id_rombel' WHERE id='$sessionId'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<script>alert('Data berhasil diupdate');</script>";
                    echo "<script>window.location='index.php';</script>";
                } else if (!$result) {
                    echo '<script>alert("Data gagal diupdate");</script>';
                }
            }
        } else if (isset($_POST["btnUpdatePassword"])) {
            $password = md5($_POST['password']);
            $cpassword = md5($_POST['cpassword']);

            if ($password == $cpassword) {
                $sql = "UPDATE tabel_user SET password='$password', WHERE id='$sessionId'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<script>alert('Password berhasil diupdate');</script>";
                    echo "<script>window.location='index.php';</script>";
                } else if (!$result) {
                    echo '<script>alert("Password gagal diupdate");</script>';
                }
            } else if ($password != $cpassword) {
                echo "<script>alert('Konfirmasi password salah');</script>";
            }
        }
    }
}

function getData(String $data)
{
    global $conn;

    switch ($data) {
        case 'merek':
            $query = mysqli_query($conn, "SELECT * FROM tabel_merk");
            $jumlah = mysqli_num_rows($query);
            break;
        case 'mobil':
            $query = mysqli_query($conn, "SELECT * FROM tabel_mobil");
            $jumlah = mysqli_num_rows($query);
            break;
        case 'operator':
            $query = mysqli_query($conn, "SELECT * FROM tabel_user WHERE role='operator'");
            $jumlah = mysqli_num_rows($query);
            break;
        case 'admin':
            $query = mysqli_query($conn, "SELECT * FROM tabel_user WHERE role='admin'");
            $jumlah = mysqli_num_rows($query);
            break;
    }
    return $jumlah;
};
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $title = "Dashboard";
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
            <?php
            include "$sourcePath/components/navBurger.php";
            ?>

            <!--Page Body part -->
            <div class="page-body p-4 text-dark">
                <div class="page-heading border-bottom d-flex flex-row">
                    <h5 class="font-weight-normal">Dashboard</h5>
                </div>

                <!-- Small card component -->
                <?php if ($sessionType == "user") { ?>
                    <div class="small-cards mt-5 mb-4">
                        <div class="row">
                            <!-- Col sm 6, col md 6, col lg 3 -->
                            <div class="col-sm-6 col-md-6 col-lg-3 mt-3 mt-lg-0">
                                <!-- Card -->
                                <div class="card border-0 rounded-lg">
                                    <!-- Card body -->
                                    <div class="card-body">

                                        <div class="d-flex flex-row justify-content-center align-items-center">
                                            <!-- Icon -->
                                            <div class="small-card-icon">
                                                <i class="far fa-user-circle card-icon-bg-primary fa-4x"></i>
                                            </div>
                                            <!-- Text -->
                                            <div class="small-card-text w-100 text-center">
                                                <p class="font-weight-normal m-0 text-muted">Jumlah Merek</p>
                                                <h4 class="font-weight-normal m-0 text-primary"><?php echo number_format((float) getData("merek")); ?></h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Col sm 6, col md 6, col lg 3 -->
                            <div class="col-sm-6 col-md-6 col-lg-3 mt-3 mt-lg-0">
                                <!-- Card -->
                                <div class="card border-0 rounded-lg">
                                    <!-- Card body -->
                                    <div class="card-body">

                                        <div class="d-flex flex-row justify-content-center align-items-center">
                                            <!-- Icon -->
                                            <div class="small-card-icon">
                                                <i class="fas fa-graduation-cap card-icon-bg-primary fa-4x"></i>
                                            </div>
                                            <!-- Text -->
                                            <div class="small-card-text w-100 text-center">
                                                <p class="font-weight-normal m-0 text-muted">Jumlah Mobil</p>
                                                <h4 class="font-weight-normal m-0 text-primary"><?php echo number_format((float) getData("mobil")); ?></h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Col sm 6, col md 6, col lg 3 -->
                            <div class="col-sm-6 col-md-6 col-lg-3 mt-3 mt-lg-0">
                                <!-- Card -->
                                <div class="card border-0 rounded-lg">
                                    <!-- Card body -->
                                    <div class="card-body">

                                        <div class="d-flex flex-row justify-content-center align-items-center">
                                            <!-- Icon -->
                                            <div class="small-card-icon">
                                                <i class="far fa-user-circle card-icon-bg-primary fa-4x"></i>
                                            </div>
                                            <!-- Text -->
                                            <div class="small-card-text w-100 text-center">
                                                <p class="font-weight-normal m-0 text-muted">Jumlah Operator</p>
                                                <h4 class="font-weight-normal m-0 text-primary"><?php echo number_format((float) getData("operator")); ?></h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Col sm 6, col md 6, col lg 3 -->
                            <div class="col-sm-6 col-md-6 col-lg-3 mt-3 mt-lg-0">
                                <!-- Card -->
                                <div class="card border-0 rounded-lg">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="d-flex flex-row justify-content-center align-items-center">
                                            <!-- Icon -->
                                            <div class="small-card-icon">
                                                <i class="far fa-user-circle card-icon-bg-primary fa-4x"></i>
                                            </div>
                                            <!-- Text -->
                                            <div class="small-card-text w-100 text-center">
                                                <p class="font-weight-normal m-0 text-muted">Jumlah Admin</p>
                                                <h4 class="font-weight-normal m-0 text-primary"><?php echo number_format((float) getData("admin")); ?></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="row mt-4">
                    <div class="col-12 mt-4">
                        <!-- Form inputs card -->
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                            <div class="card rounded-lg">
                                <div class="card-body">
                                    <div class="card-title">Profil Anda</div>

                                    <?php if ($sessionType == "user") { ?>
                                        <!-- First Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input id="username" class="form-control bg-light" type="text" name="username" value="<?php echo $sessionUsername; ?>" readonly>
                                                </div>
                                            </div>

                                            <!-- 2nd row -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_lengkap">Nama Lengkap</label>
                                                    <input id="nama_lengkap" class="form-control bg-light" type="text" name="nama_lengkap" value="<?php echo $sessionNamaLengkap; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Second Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nomor_hp">Nomor HP</label>
                                                    <input id="nomor_hp" class="form-control bg-light" type="tel" name="nomor_hp" value="<?php echo $sessionNomorHP; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input id="email" class="form-control bg-light" type="email" name="email" value="<?php echo $sessionEmail; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Third Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="role">Role</label>
                                                    <input id="role" class="form-control bg-light" type="text" name="role" value="<?php echo ucfirst($sessionRole); ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <input id="status" class="form-control bg-light" type="text" name="status" value="<?php echo $sessionAktif == 1 ? 'Aktif' : 'Tidak Aktif'; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else if ($sessionType == "siswa") { ?>
                                        <!-- First Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nisn">NISN</label>
                                                    <input id="nisn" class="form-control bg-light" type="number" name="nisn" value="<?php echo $sessionNISN; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nama_lengkap">Nama Lengkap</label>
                                                    <input id="nama_lengkap" class="form-control bg-light" type="text" name="nama_lengkap" value="<?php echo $sessionNamaLengkap; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Second Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input id="tempat_lahir" class="form-control bg-light" type="text" name="tempat_lahir" value="<?php echo $sessionTempatLahir; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                                    <input id="tanggal_lahir" class="form-control bg-light" type="date" name="tanggal_lahir" value="<?php echo $sessionTanggalLahir; ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Third Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    <input id="jenis_kelamin" class="form-control bg-light" type="text" name="jenis_kelamin" value="<?php echo $sessionJenisKelamin; ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    $sql = "SELECT id, tahun_masuk FROM tabel_tahun_masuk WHERE id='$sessionIdTahunMasuk'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $row = mysqli_fetch_assoc($result);
                                                    ?>

                                                    <label for="id_tahun_masuk">Tahun Masuk</label>
                                                    <input id="id_tahun_masuk" class="form-control bg-light" type="number" name="id_tahun_masuk" value="<?php echo $row["tahun_masuk"] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fourth Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    $sql = "SELECT id, tingkat FROM tabel_tingkat WHERE id='$sessionIdTingkat'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $row = mysqli_fetch_assoc($result);
                                                    ?>

                                                    <label for="id_tingkat">Tingkat</label>
                                                    <input id="id_tingkat" class="form-control bg-light" type="text" name="id_tingkat" value="<?php echo $row["tingkat"] ?>" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    $sql = "SELECT id, jurusan FROM tabel_jurusan WHERE id='$sessionIdJurusan'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $row = mysqli_fetch_assoc($result);
                                                    ?>

                                                    <label for="id_jurusan">Jurusan</label>
                                                    <input id="id_jurusan" class="form-control bg-light" type="text" name="id_jurusan" value="<?php echo $row["jurusan"] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Fifth Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php
                                                    $sql = "SELECT id, rombel FROM tabel_rombel WHERE id='$sessionIdRombel'";
                                                    $result = mysqli_query($conn, $sql);
                                                    $row = mysqli_fetch_assoc($result);
                                                    ?>

                                                    <label for="id_rombel">Rombel</label>
                                                    <input id="id_rombel" class="form-control bg-light" type="text" name="id_rombel" value="<?php echo $row["rombel"] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <!-- Submit button -->
                                    <button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#updateData">Update</button>
                                    <a type="button" class="btn btn-danger center-block" href="index.php">Batalkan</a>

                                    <?php if ($sessionType == "user") { ?>
                                        <button type="button" class="btn btn-danger center-block" data-toggle="modal" data-target="#updatePassword">Ubah Password</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="updatePassword" tabindex="-1" role="dialog" aria-labelledby="updatePasswordLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updatePasswordLabel">Ubah Password</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="updatePasswordForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <label for="password">Password Baru:</label>
                                    <input type="password" name="password" id="password" class="form-control" required>

                                    <label for="cpassword">Konfirmasi Password:</label>
                                    <input type="password" name="cpassword" id="cpassword" class="form-control" required>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                <button type="submit" name="btnUpdatePassword" id="btnUpdatePassword" form="updatePasswordForm" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="updateData" tabindex="-1" role="dialog" aria-labelledby="updateDataLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateDataLabel">Ubah Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="updateDataForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <?php if ($sessionType == "user") { ?>
                                        <label for="username">Username</label>
                                        <input id="username" class="form-control bg-light" type="text" name="username" value="<?php echo $sessionUsername; ?>">

                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input id="nama_lengkap" class="form-control bg-light" type="text" name="nama_lengkap" value="<?php echo $sessionNamaLengkap; ?>">

                                        <label for="nomor_hp">Nomor HP</label>
                                        <input id="nomor_hp" class="form-control bg-light" type="tel" name="nomor_hp" value="<?php echo $sessionNomorHP; ?>">

                                        <label for="email">Email</label>
                                        <input id="email" class="form-control bg-light" type="email" name="email" value="<?php echo $sessionEmail; ?>">
                                    <?php } else if ($sessionType == "siswa") { ?>
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input id="nama_lengkap" class="form-control bg-light" type="text" name="nama_lengkap" value="<?php echo $sessionNamaLengkap; ?>">

                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input id="tempat_lahir" class="form-control bg-light" type="text" name="tempat_lahir" value="<?php echo $sessionTempatLahir; ?>">

                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input id="tanggal_lahir" class="form-control bg-light" type="date" name="tanggal_lahir" value="<?php echo $sessionTanggalLahir; ?>">

                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <select id="jenis_kelamin" class="custom-select bg-light" name="jenis_kelamin" required>
                                            <option <?php echo $sessionJenisKelamin == "Laki-Laki" ? "selected" : ""; ?> value="Laki-Laki">Laki-Laki</option>
                                            <option <?php echo $sessionJenisKelamin == "Perempuan" ? "selected" : ""; ?> value="Perempuan">Perempuan</option>
                                        </select>

                                        <label for="id_tahun_masuk">Tahun Masuk</label>
                                        <select id="id_tahun_masuk" class="custom-select bg-light" name="id_tahun_masuk" required>
                                            <option selected disabled>Tahun Masuk</option>

                                            <?php
                                            $sql = "SELECT id, tahun_masuk FROM tabel_tahun_masuk ORDER BY tahun_masuk";
                                            $result = mysqli_query($conn, $sql);

                                            foreach ($result as $row) {
                                                if ($sessionIdTahunMasuk == $row["id"]) {
                                            ?>
                                                    <option value='<?php echo $row["id"] ?>' selected><?php echo $row["tahun_masuk"] ?></option>
                                                <?php
                                                } else if ($sessionIdTahunMasuk != $row["id"]) {
                                                ?>
                                                    <option value='<?php echo $row["id"] ?>'><?php echo $row["tahun_masuk"] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                        <label for="id_tingkat">Tingkat:</label>
                                        <select id="id_tingkat" class="custom-select bg-light" name="id_tingkat" required>
                                            <option selected disabled>Tingkat</option>

                                            <?php
                                            $sql = "SELECT id, tingkat FROM tabel_tingkat ORDER BY tingkat";
                                            $result = mysqli_query($conn, $sql);

                                            foreach ($result as $row) {
                                                if ($sessionIdTingkat == $row["id"]) {
                                            ?>
                                                    <option value='<?php echo $row["id"] ?>' selected><?php echo $row["tingkat"] ?></option>
                                                <?php
                                                } else if ($sessionIdTingkat != $row["id"]) {
                                                ?>
                                                    <option value='<?php echo $row["id"] ?>'><?php echo $row["tingkat"] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                        <label for="id_jurusan">Jurusan:</label>
                                        <select id="id_jurusan" class="custom-select bg-light" name="id_jurusan" required>
                                            <option selected disabled>Jurusan</option>

                                            <?php
                                            $sql = "SELECT id, jurusan FROM tabel_jurusan ORDER BY jurusan";
                                            $result = mysqli_query($conn, $sql);

                                            foreach ($result as $row) {
                                                if ($sessionIdJurusan == $row["id"]) {
                                            ?>
                                                    <option value='<?php echo $row["id"] ?>' selected><?php echo $row["jurusan"] ?></option>
                                                <?php
                                                } else if ($sessionIdJurusan != $row["id"]) {
                                                ?>
                                                    <option value='<?php echo $row["id"] ?>'><?php echo $row["jurusan"] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                        <label for="id_rombel">Rombel:</label>
                                        <select id="id_rombel" class="custom-select bg-light" name="id_rombel" required>
                                            <option selected disabled>Rombel</option>

                                            <?php
                                            $sql = "SELECT id, rombel FROM tabel_rombel ORDER BY rombel";
                                            $result = mysqli_query($conn, $sql);

                                            foreach ($result as $row) {
                                                if ($sessionIdRombel == $row["id"]) {
                                            ?>
                                                    <option value='<?php echo $row["id"] ?>' selected><?php echo $row["rombel"] ?></option>
                                                <?php
                                                } else if ($sessionIdRombel != $row["id"]) {
                                                ?>
                                                    <option value='<?php echo $row["id"] ?>'><?php echo $row["rombel"] ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } ?>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                <button type="submit" name="btnUpdateData" id="btnUpdateData" form="updateDataForm" class="btn btn-primary">Update</button>
                            </div>
                        </div>
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
    <!-- eChart -->
    <script src="<?php echo $sourcePath ?>/scripts/js/vendor/eChart/echarts.min.js"></script>
    <script src="<?php echo $sourcePath ?>/scripts/js/vendor/eChart/echarts.option.min.js"></script>
    <!-- eChart script -->
    <script src="<?php echo $sourcePath ?>/scripts/js/plugins/echart_drw.js"></script>
    <script src="<?php echo $sourcePath ?>/scripts/js/plugins.js"></script>
    <script src="<?php echo $sourcePath ?>/scripts/js/main.js"></script>
</body>

</html>