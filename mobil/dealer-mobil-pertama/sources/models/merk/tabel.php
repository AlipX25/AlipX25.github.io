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
        if(isset($_POST['tambahButton']))
        {
            $nama = $_POST['nama'];
            $negara = $_POST['negara'];
            $gambar = $_FILES['gambar']['name'];

            $allowed_exttension = array('gif', 'png', 'jpg', 'jpeg');
            $filename = $_FILES['gambar']['name'];
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($file_extension, $allowed_exttension))
            {
                echo "<script>alert('hanya boleh jpg png jpeg dan gif);</script>";
                echo "<script>window.location='tabel.php';</script>";
            }
            else
            {
                if(file_exists("gambar/" . $_FILES['gambar']['name']))
                {
                    $filename = $_FILES['gambar']['name'];
                    echo "<script>alert('gambar sudah ada);</script>";
                    echo "<script>window.location='tabel.php';</script>";
                }
                else 
                {

                    $sql = "INSERT INTO tabel_merk (nama, negara, gambar) VALUES ('$nama', '$negara', '$gambar')";
                    $result = mysqli_query($conn, $sql);

                    if($result)
                    {
                        move_uploaded_file($_FILES["gambar"]["tmp_name"], "gambar/".$_FILES["gambar"]["name"]);
                        echo "<script>alert('Data berhasil dimasukkan');</script>";
                        echo "<script>window.location='tabel.php';</script>";
                    }
                    else
                    {
                        echo "<script>alert('Data gagal dimasukkan');</script>";
                        echo "<script>window.location='tabel.php';</script>";
                    }
                }
            }
        }
    }
}

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <?php
    $title = "Data Merek";
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
                    <h5 class="font-weight-normal">Data Merek</h5>
                </div>
                <br><button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">Tambah Merek</button>

                <div class="card mt-4 rounded-lg">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="card-title">Data Merek</div>
                        <!-- Data table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered " id="basicDataTable" style="width: 100%; text-align: center;">
                                <!-- Table head -->
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Asal Negara</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Table body -->
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tabel_merk ORDER BY nama";
                                    $result = mysqli_query($conn, $sql);
                                    $no = 0;
                                    foreach ($result as $row) {
                                        $no++;

                                    ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['negara']; ?></td>
                                            <td><img style="width: 50px;" src="gambar/<?php echo $row['gambar'];?>" alt=""></td>
                                            <td style="display: flex; flex-direction: row; justify-content: center;">
                                                <form action="hapus.php" method="POST">
                                                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                                    <input type="hidden" name="delete_gambar" value="<?php echo $row['gambar']; ?>">
                                                    <button type="submit" class="btn btn-danger center-block" name="delete_data">Hapus</button>
                                                </form>
                                                <a style="margin-left: 0.5rem !important" type="submit" class="btn btn-info center-block" href="ubah.php?id=<?php echo $row['id']; ?>">Ubah</a>
                                                <a style="margin-left: 0.5rem !important" type="submit" class="btn btn-info center-block" href="../lihat_jenis/tabel.php?id=<?php echo $row['id']; ?>">Lihat Mobil</a>
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
                                <h5 class="modal-title" id="tambahDataLabel">Tambah Merek</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="tambahDataForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">

                                    <label for="nama">Nama:</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Merk" required>

                                    <label for="negara">Negara:</label>
                                    <input type="text" name="negara" id="negara" class="form-control" placeholder="Masukkan Negara" required>

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