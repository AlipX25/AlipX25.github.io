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

        $sql = "SELECT * FROM tabel_merk WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $id = $_GET['id'];

            $nama = cek($_POST['nama']);
            $negara = cek($_POST['negara']);

            $new_image = $_FILES['gambar']['name'];
            $old_image = $_POST['gambar_lama'];

            if($new_image != '')
            {
                $update_filename = $_FILES['gambar']['name'];
            }
            else
            {
                $update_filename = $old_image;
            }

            if($_FILES['gambar']['name'] !='')
            {
                if(file_exists("gambar/" . $_FILES['gambar']['name']))
                {
                    $filename = $_FILES['gambar']['name'];
                    echo "<script>alert('data sudah ada');</script>";
                    echo "<script>window.location='ubah.php?id=$id';</script>";
                }
            }
            else
            {
                $sql = "UPDATE tabel_merk SET nama='$nama', negara='$negara', gambar='$update_filename' WHERE id='$id'";
                $result = mysqli_query($conn, $sql);

                if($result)
                {
                    if($_FILES['gambar']['name'] !='')
                    {
                        move_uploaded_file($_FILES['gambar']['tmp_name'], "gambar/".$_FILES["gambar"]["name"]);
                        unlink("gambar/".$old_image);
                    }
                    echo "<script>alert('Data berhasil diubah');</script>";
                    echo "<script>window.location='ubah.php?id=$id';</script>";
                }
                else
                {
                    echo "<script>alert('Data gagal diubah');</script>";
                    echo "<script>window.location='ubah.php?id=$id';</script>";
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
    $title = "Ubah Siswa";
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
                    <h5 class="font-weight-normal">Ubah Siswa</h5>
                </div>

                <!-- All Basic Form elements -->
                <div class="row mt-4">
                    <div class="col-12 mt-4">
                        <!-- Form inputs card -->
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $_GET["id"]; ?>" method="post" enctype="multipart/form-data">
                            <div class="card rounded-lg">
                                <div class="card-body">
                                    <div class="card-title">Masukkan Data Baru</div>

                                    <!-- Create 2 row -->
                                    <div class="row">
                                        <!-- 1st row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama">nama</label>
                                                <input id="nama" class="form-control bg-light" type="text" name="nama" value="<?php echo $data['nama']; ?>">
                                            </div>
                                        </div>

                                        <!-- 2nd row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="negara">negara</label>
                                                <input id="negara" class="form-control bg-light" type="text" name="negara" value="<?php echo $data['negara']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Create 2 row -->
                                    <div class="row">
                                        <!-- 1st row -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gambar">gambar</label>
                                                <input id="gambar" class="form-control bg-light" type="file" name="gambar">
                                                <input id="gambar" class="form-control bg-light" type="hidden" name="gambar_lama" value="<?php echo $data['gambar']; ?>">
                                            </div>
                                            <img style="width: 50px;"src="<?php echo "gambar/".$data['gambar'];   ?>" alt="">
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