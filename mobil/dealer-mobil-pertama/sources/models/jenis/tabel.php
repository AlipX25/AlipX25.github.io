<?php
$sourcePath = "./../..";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 2, "$sourcePath/../");

if (isset($_SESSION["id"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['tambahButton'])) {
            $nama = $_POST['nama'];

            $sql = "INSERT INTO tabel_jenis (nama) VALUES ('$nama')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>alert('Data berhasil dibuat');</script>";
                echo "<script>window.location='tabel.php';</script>";
            } else if (!$result) {
                echo '<script>alert("Data gagal dibuat");</script>';
            }
        }
    }
}

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $title = "Data Jenis Mobil";
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
                    <h5 class="font-weight-normal">Data Jenis Mobil</h5>
                </div>
                <br><button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">Tambah Jenis</button>

                <div class="card mt-4 rounded-lg">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="card-title">Data Jenis Mobil</div>
                        <!-- Data table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered " id="basicDataTable" style="width: 100%; text-align: center;">
                                <!-- Table head -->
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Table body -->
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tabel_jenis ORDER BY nama";
                                    $result = mysqli_query($conn, $sql);
                                    $no = 0;
                                    foreach ($result as $row) {
                                        $no++;

                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td style="display: flex; flex-direction: row; justify-content: center;">
                                                <a type="submit" class="btn btn-danger center-block" href="hapus.php?id=<?php echo $row['id']; ?>">Hapus</a>
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
                                <h5 class="modal-title" id="tambahDataLabel">Tambah Jenis</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="tambahDataForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">

                                    <label for="nama">Jenis:</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Jenis" required>



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