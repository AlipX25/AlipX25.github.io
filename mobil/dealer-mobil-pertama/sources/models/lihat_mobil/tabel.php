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
    $id_jenis = $_GET['id_jenis'];
    $sql = "SELECT * FROM tabel_merk WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $data_merk = mysqli_fetch_assoc($result);




   
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
                <div class="page-heading border-bottom d-flex flex-row" style="padding-bottom: 20px;">
                    <div class="banner-logo" style="background-color: rgba(255,255,255,.75); padding:16px; border-radius: 15px; box-shadow:  5px 5px 10px #888888; ">
                        <img style="width: 80px;" src="../merk/gambar/<?php echo $data_merk['gambar'];?>" alt="">
                    </div>
                        <h1 style="font-weight: 900; text-align: center; margin-left: 50px; margin-top: 20px;"><?php echo $data_merk['nama']; ?></h1>
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
                                        <th>Nama</th>
                                        <th>tahun</th>
                                        <th>Gambar</th>
                                    </tr>
                                </thead>

                                <!-- Table body -->
                                <tbody>
                                    <?php
                                    
                                    $sql = "SELECT * FROM tabel_mobil WHERE id_merk = $id AND id_jenis = $id_jenis  ORDER BY nama";
                                    $result = mysqli_query($conn, $sql);
                                    $no = 0;
                                    foreach ($result as $row) {
                                        $no++;

                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['tahun']; ?></td>
                                            <td><img style="width: 50px;" src="../gambar_mobil/<?php echo $row['gambar'];?>" alt=""></td>
                                           
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <br> <a href="../lihat_jenis/tabel.php" class="btn btn-danger" type="button" >Kembali</a>

                <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahDataLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahDataLabel">Tambah Mobil</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="tambahDataForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

                                    <label for="id_merk">Merek:</label>
                                    <select id="id_merk" class="custom-select bg-light" name="id_merk" required>
                                        <option selected disabled>Pilih Merek</option>

                                        <?php
                                        $sql = "SELECT * FROM tabel_merk ORDER BY nama";
                                        $result = mysqli_query($conn, $sql);
                                        
                                        
                                        foreach ($result as $row) {
                                            
                                        ?>
                                            <option value='<?php echo $row["id"] ?>'><?php echo $row['nama']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <label for="id_jenis">jenis:</label>
                                    <select id="id_jenis" class="custom-select bg-light" name="id_jenis" required>
                                        <option selected disabled>Pilih Jenis</option>

                                        <?php
                                        $sql = "SELECT * FROM tabel_jenis ORDER BY id_merk";
                                        $result = mysqli_query($conn, $sql);
                                        
                                        foreach ($result as $row) {

                                            $id_merk = $row['id_merk'];
                                            $merk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM tabel_merk WHERE id='$id_merk'"))["nama"];
                                            $jenis = $row['nama'];
                                            $jenis_merk = "$jenis - $merk";
                                            
                                        ?>
                                            <option value='<?php echo $row["id"] ?>'><?php echo $jenis_merk; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <label for="nama">Nama:</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama" required>

                                    <label for="tahun">Tahun Produksi:</label>
                                    <input type="text" name="tahun" id="tahun" class="form-control" placeholder="Masukkan Tahun" required>

                                    <label for="gambar">Gambar:</label>
                                    <input type="file" name="gambar" id="gambar" class="form-control" required>



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