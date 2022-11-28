<?php
$sourcePath = "./../..";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 3, "$sourcePath/../");

if (isset($_SESSION["id"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['tambahButton'])) {
            $username = $_POST['username'];
            $nama_lengkap = $_POST['nama_lengkap'];
            $nomor_hp = $_POST['nomor_hp'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $password = md5($_POST['password']);
            $cpassword = md5($_POST['cpassword']);
            $aktif = "0";

            if (is_numeric($nomor_hp)) {
                if ($password == $cpassword) {
                    $sql = "SELECT * FROM tabel_user WHERE username='$username'";
                    $result = mysqli_query($conn, $sql);

                    if ($result->num_rows == 0) {
                        $sql = "INSERT INTO tabel_user (username, nama_lengkap, password, nomor_hp, email, role, aktif) VALUES ('$username', '$nama_lengkap', '$password', '$nomor_hp', '$email', '$role', '$aktif')";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            echo "<script>alert('Data berhasil dibuat');</script>";
                            echo "<script>window.location='tabel.php';</script>";
                        } else if (!$result) {
                            echo '<script>alert("Data gagal dibuat");</script>';
                        }
                    } else if ($result->num_rows != 0) {
                        echo "<script>alert('Woops! Username sudah terdaftar')</script>";
                    }
                } else if ($password != $cpassword) {
                    echo "<script>alert('Konfirmasi password salah')</script>";
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
    $title = "Data User";
    include "$sourcePath/components/head.php";
    ?>

    <!-- Data Table stylesheet -->
    <link rel="stylesheet" href="<?php echo $sourcePath ?>/public/css/vendor/DataTable-1.10.20/datatables.min.css">
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
                    <h5 class="font-weight-normal">Data User</h5>
                </div>
                <br><button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">Tambah User</button>

                <div class="card mt-4 rounded-lg">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="card-title">Data User</div>
                        <!-- Data table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="basicDataTable" style="width: 100%;">
                                <!-- Table head -->
                                <thead>
                                    <tr style="text-align: center;">
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nomor HP</th>
                                        <th>Email</th>
                                        <th>role</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Table body -->
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tabel_user";
                                    $result = mysqli_query($conn, $sql);
                                    $no = 0;
                                    foreach ($result as $row) {
                                        $no++;
                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['nama_lengkap']; ?></td>
                                            <td><?php echo $row['nomor_hp']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['role']; ?></td>
                                            <td><?php echo $row['aktif'] == 1 ? 'aktif' : 'tidak aktif' ?></td>
                                            <td style="display: flex; flex-direction: row; justify-content: center;">
                                                <a type="submit" class="btn btn-danger center-block" href="hapus.php?id=<?php echo $row['id']; ?>">Hapus</a>

                                                <?php if ($row["aktif"] == 1) { ?>
                                                    <a style="margin-left: 0.5rem !important" type="submit" class="btn btn-danger center-block" href="aktif.php?id=<?php echo $row['id']; ?>">Matikan</a>
                                                <?php } else if ($row["aktif"] == 0) { ?>
                                                    <a style="margin-left: 0.5rem !important" type="submit" class="btn btn-success center-block" href="aktif.php?id=<?php echo $row['id']; ?>">Aktifkan</a>
                                                <?php } ?>

                                                <a style="margin-left: 0.5rem !important; white-space: nowrap !important;" type="submit" class="btn btn-danger center-block" href="ubahPassword.php?id=<?php echo $row['id']; ?>">Ubah Password</a>
                                                <a style="margin-left: 0.5rem !important" type="submit" class="btn btn-info center-block" href="ubah.php?id=<?php echo $row['id']; ?>">Ubah</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahDataLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahDataLabel">Tambah User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="tambahDataForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                                    <label for="username">Username:</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>

                                    <label for="nama_lengkap">Nama Lengkap:</label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>

                                    <label for="nomor_hp">Nomor HP:</label>
                                    <input type="text" name="nomor_hp" id="nomor_hp" class="form-control" placeholder="Nomor HP" required>

                                    <label for="email">Email:</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>

                                    <label for="role">Role:</label>
                                    <select id="role" class="custom-select bg-light" name="role" required>
                                        <option selected disabled>Pilih Role</option>
                                        <option value='admin'>Admin</option>
                                        <option value='operator'>Operator</option>
                                    </select>

                                    <label for="password">Password:</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

                                    <label for="cpassword">Konfirmasi Password:</label>
                                    <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Konfirmasi Password" required>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                <button type="submit" name="tambahButton" id="tambahButton" form="tambahDataForm" class="btn btn-primary">Tambah</button>
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
    <!-- Data Table -->
    <script src="<?php echo $sourcePath ?>/scripts/js/vendor/DataTable-1.10.20/datatables.min.js"></script>
    <!-- Data Table script -->
    <script src="<?php echo $sourcePath ?>/scripts/js/plugins/dataTable_script.js"></script>

    <script src="<?php echo $sourcePath ?>/scripts/js/plugins.js"></script>
    <script src="<?php echo $sourcePath ?>/scripts/js/main.js"></script>
</body>

</html>