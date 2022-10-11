<?php
session_start(); 
include "koneksi.php";
$email = mysqli_real_escape_string($koneksi,$_POST['txt_email']);
$password = mysqli_real_escape_string($koneksi,$_POST['txt_pass']);
$sql = mysqli_query($koneksi, "SELECT * FROM user_detail WHERE user_email='".$email."' AND password='".$password."'");
$data = mysqli_fetch_array($sql);
if (!empty($data)){
  $_SESSION['txt_email'] = $data['user_email'];
  $_SESSION['txt_pass'] = $data['user_password'];
  setcookie("message","delete",time()-1);
  header("location:sb-admin/home.php");
}else{
  setcookie("message","Maaf, Username atau password salah",time()+1);
  header("location:index.php");
}
?>