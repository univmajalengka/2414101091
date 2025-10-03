<?php
include "../config/db.php";
$register_message = "";

if (isset($_POST["daftar"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $enc_password = hash("sha256", $password);

  try {
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$enc_password')";

    if ($conn->query($sql)) {
      $register_message = "Daftar akun berhasil, silahkan login";
      header('location: ../auth/login.php');
    } else {
      $register_message = "Daftar akun gagal, silahkan coba lagi!";
      header('location: ../auth/register.php');
    }
  } catch (mysqli_sql_exception) {
    $register_message = "Daftar akun gagal, username sudah ada!";
  }
  $conn->close();
}
