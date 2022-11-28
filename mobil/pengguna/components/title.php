<?php  


$sql = "SELECT * FROM tabel_perusahaan";
$result = mysqli_query($conn, $sql);
$data_perusahaan = mysqli_fetch_assoc($result);




?>

<title><?php echo $data_perusahaan['nama']; ?></title>
<link rel="icon" href="../dealer-mobil/sources/models/perusahaan/gambar/<?php echo $data_perusahaan['gambar'];   ?>" type="image/icon-type">