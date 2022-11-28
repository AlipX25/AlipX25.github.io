<?php
$sourcePath = ".";
include "$sourcePath/utilities/koneksi.php";
include "$sourcePath/utilities/session.php";
include "$sourcePath/utilities/isAuthenticated.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Login";
    ?>

    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link rel="stylesheet" type="text/css" href="<?php echo $sourcePath; ?>/public/css/login_register.css">
    <link rel="icon" href="<?php echo $sourcePath; ?>/public/images/smk.png" type="image/icon-type">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    if (!isset($_SESSION["id"])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["btnLogin"])) {
                $username = $_POST['username'];
                $password = md5($_POST['password']);

                $sql = "SELECT id, aktif FROM tabel_user WHERE username='$username' AND password='$password'";
                $result = mysqli_query($conn, $sql);

                if ($result->num_rows != 0) {
                    $row = mysqli_fetch_assoc($result);

                    if ($row["aktif"] == 1) {
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['type'] = "user";

                        echo "<script>alert('Login berhasil');</script>";
                        echo "<script>window.location='$sourcePath/../index.php';</script>";
                    } else if ($row["aktif"] == 0) {
                        echo "<script>alert('Akun tidak aktif');</script>";
                    }
                } else if ($result->num_rows == 0) {
                    echo "<script>alert('Login gagal');</script>";
                }
            } else if (isset($_POST['btnRegister'])) {
                $username = $_POST['username'];
                $nama_lengkap = $_POST['nama_lengkap'];
                $password = md5($_POST['password']);
                $cpassword = md5($_POST['cpassword']);
                $nomor_hp = $_POST['nomor_hp'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $aktif = "0";

                if ($password == $cpassword) {
                    if (is_numeric($nomor_hp)) {
                        $sql = "SELECT * FROM tabel_user WHERE username='$username'";
                        $result = mysqli_query($conn, $sql);

                        if ($result->num_rows == 0) {
                            $sql = "INSERT INTO tabel_user (username, nama_lengkap, password, nomor_hp, email, role, aktif) VALUES ('$username', '$nama_lengkap', '$password', '$nomor_hp', '$email','$role', '$aktif')";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                            } else if (!$result) {
                                echo "<script>alert('Woops! Terjadi kesalahan')</script>";
                            }
                        } else if ($result->num_rows != 0) {
                            echo "<script>alert('Woops! Username sudah terdaftar')</script>";
                        }
                    } else if (!is_numeric($nomor_hp)) {
                        echo '<script>alert("Pastikan nomor HP hanya menggunakan angka");</script>';
                    }
                } else if ($password != $cpassword) {
                    echo "<script>alert('Konfirmasi password salah')</script>";
                }
            }
        }
    }
    ?>


<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required="">
                    <input type="text" name="username" placeholder="Username" required="">
                    <input type="email" name="email" placeholder="Masukkan Email" required="">
                    <input type="text" name="nomor_hp" placeholder="Nomor HP" required="">
                    <select name="role">
                        <option value="admin">Admin</option>
                        <option value="operator">Operator</option>
                    </select>
                    <input type="password" name="password" placeholder="Password" required="">
                    <input type="password" name="cpassword" placeholder="Confirm Password" required="">
					<button name="btnRegister">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="username" placeholder="Username" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button name="btnLogin">Login</button>
				</form>
			</div>
	</div>



</body>

</html>