<?php

// conn start
$hostname = "localhost";
$username = "root";
$password = "";
$db_name = "upload_image";

$db =  mysqli_connect($hostname, $username, $password, $db_name);

// conn end

if (isset($_POST["submit"])) {
  function upload()
  {
    $nama_file = $_FILES["gambar"]["name"];
    $size_file = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tmp_name = $_FILES["gambar"]["tmp_name"];
    var_dump($tmp_name);
    die;

    // cek error
    if ($error === 4) {
      echo "<script>alert('Pilih gambar terlebih dahulu')</script>";
      return false;
    }

    // cek gambar
    $ekstensi_gambar_valid = ["jpg", "jpeg", "png"];
    $ekstensi_gambar = explode(".", $nama_file);
    $ekstensi_gambar = strtolower(end($ekstensi_gambar));
    if (!in_array($ekstensi_gambar, $ekstensi_gambar_valid)) {
      echo "<script>alert('Ukuran gambar anda terlalu besar')</script>";
      return false;
    }

    // nama file baru
    $nama_file_baru = uniqid();
    $nama_file_baru .= ".";
    $nama_file_baru .= $nama_file;

    // lulus pengecekan, gambar siap diupload
    move_uploaded_file($tmp_name, "img/" . $nama_file_baru);

    return $nama_file_baru;
  }
  $username = $_POST["username"];
  $password = $_POST["password"];
  // isi gambar
  $gambar = upload();

  // insert
  $sql = "INSERT INTO users (username,password,gambar) VALUES ('$username','$password','$gambar')";

  $result = $db->query($sql);

  $db->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Belajar upload gambar</title>
</head>

<body>
  <div class="container">
    <form action="index.php" method="post" enctype="multipart/form-data">
      <input type="text" name="username" placeholder="masukkan username">
      <br>
      <input type="password" name="password" placeholder="masukkan password">
      <br>
      <input type="file" name="gambar">
      <input type="submit" name="submit" value="Kirim Gambar">
    </form>
    <img src="./" alt="">
  </div>
</body>

</html>