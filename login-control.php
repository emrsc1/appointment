<?php
session_start();
include("connect.php");
$user=$_POST["username"];
$pass=$_POST["password"];
$query=$db->query("select * from admin where kullanici='$user' and sifre='$pass'");
$check=$query->fetch();
if($user==$check["kullanici"] && $pass=$check["sifre"]){
    $_SESSION["id"]=$check["admin_id"];
    $_SESSION["kullanici"]=$check["kullanici"];
    $_SESSION["sifre"]=$check["sifre"];
    header("location:main.php");
}
else{
    header("location:login.html");
}
?>