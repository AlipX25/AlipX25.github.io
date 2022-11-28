<?php
$sourcePath = "./../..";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/sessionData.php";
include "$sourcePath/utilities/isNotActive.php";
include "$sourcePath/utilities/isNotAuthenticated.php";
include "$sourcePath/utilities/role.php";

guardRole($sessionRole, 2, "$sourcePath/../");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
}

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $title = "Data Mobil";
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
                    <h5 class="font-weight-normal">Jenis Mobil</h5>
                </div>
                <br>

                <div class="card mt-4 rounded-lg">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="card-title">Data Mobil</div>
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
                                                <a style="margin-left: 0.5rem !important" type="submit" class="btn btn-info center-block" href="../lihat_mobil/tabel.php?id=<?php echo $id; ?>&id_jenis=<?php echo $row['id']  ?>">Lihat Mobil</a>
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
                <br> <a href="../merk/tabel.php" class="btn btn-danger" type="button" >Kembali</a>

                
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