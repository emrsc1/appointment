<?php
session_start();
if(empty($_SESSION["id"])){
    header("location:login.html");
}
include("connect.php");
if(isset($_GET["guncelle"])){
    $randevuid=$_GET["guncelle"];
    $randevular=$db->query("SELECT * FROM randevu INNER JOIN musteri ON musteri.musteri_id=randevu.musteri_id where randevu_id=$randevuid");
    $randevu=$randevular->fetch();

?>

<div id="guncelle">
    <form action="main.php?updated=<?=$randevu["randevu_id"]?>" method="post">
          <h3><?=$randevu["ad"]?> <?=$randevu["soyad"]?> Randevu Bilgileri</h3>

          <select name ="kullanici"class="form-select form-select-lg mb-3" aria-label="large select example" style="width:13rem">
 
 <?php $clients=$db->query("select * from musteri");
 while($client=$clients->fetch()){?>
 <option value="<?=$client["musteri_id"]?>" <?php if($client["musteri_id"]==$randevu["musteri_id"]) echo "selected"?>><?=$client["ad"]?> <?=$client["soyad"]?></option>
<?php
 } ?>
</select>

<div class="mb-3">
  <label for="btarih" class="form-label">Başlangıç Tarihi</label>
  <input type="date" class="form-control" name="btarih" id="btarih" value="<?=$randevu["baslangic_tarih"]?>">
</div>

<div class="mb-3">
  <label for="bitarih" class="form-label">Bitiş Tarihi</label>
  <input type="date" class="form-control" name="bitarih" id="bitarih" value="<?=$randevu["bitis_tarihi"]?>">
</div>
<div class="d-flex flex-row">
<input type="submit" class="btn btn-info" value="Güncelle" style="margin-right:5px">
<button class="btn btn-warning"><a href="main.php">İptal Et</a></button>
</div>
    </form>
</div>
<?php } 
if(isset($_GET["updated"])){
    $id=$_GET["updated"];
    $kullanici=$_POST["kullanici"];
    $btarih=$_POST["btarih"];
    $bitarih=$_POST["bitarih"];
    if($btarih>$bitarih){
        header("location:main.php?error=true");
    }
    else{
    $db->query("UPDATE randevu SET musteri_id=$kullanici,baslangic_tarih='$btarih',bitis_tarihi='$bitarih' where randevu_id=$id");
    
    header("location:main.php");
    }
}
if(isset($_GET["error"])){?>
<div id="alert-a" class="d-flex justify-content-center">
<div id="alert" class="">
  <h5>Uyarı</h5>
  <hr style="width:15rem">
  <p>Başlangıç tarihi bitiş tarihinden ilerde olamaz!</p>
  <hr style="width:15rem">
  <button type="button" class="btn btn-primary"><a href="main.php">Tamam</a></button>
</div>
</div>

<?php

}
if(isset($_GET["sil"])){
    $id=$_GET["sil"];
    $db->query("DELETE FROM randevu WHERE randevu_id=$id");
    ?>
       <div id="alert-a" class="d-flex justify-content-center">
    <div id="alert" class="">
      <h5>Bildiri</h5>
      <hr style="width:15rem">
      <p class="text-success">Başarıyla Eklendi!</p>
      <hr style="width:15rem">
      <button type="button" class="btn btn-primary"><a href="main.php">Tamam</a></button>
    </div>
    </div>
    <?php
}
if(isset($_GET["ekle"])){
    $randevular=$db->query("SELECT * FROM randevu INNER JOIN musteri ON musteri.musteri_id=randevu.musteri_id");
    $randevu=$randevular->fetch();
    ?>
    <div id="ekle">
        <form action="main.php?added=true" method="post">
        <select name ="kullanici"class="form-select form-select-lg mb-3" aria-label="large select example" style="width:13rem">
 
 <?php $clients=$db->query("select * from musteri");
 while($client=$clients->fetch()){?>
 <option value="<?=$client["musteri_id"]?>"><?=$client["ad"]?> <?=$client["soyad"]?></option>
<?php
 } ?>
</select>

<div class="mb-3">
  <label for="btarih" class="form-label">Başlangıç Tarihi</label>
  <input type="date" class="form-control" name="btarih" id="btarih" value="<?=$randevu["baslangic_tarih"]?>">
</div>

<div class="mb-3">
  <label for="bitarih" class="form-label">Bitiş Tarihi</label>
  <input type="date" class="form-control" name="bitarih" id="bitarih" value="<?=$randevu["bitis_tarihi"]?>">
</div>
  
    
    
    <div class="d-flex flex-row">
    <button type="submit" class="btn btn-success">Ekle</button>
    <button type="button" class="btn btn-warning" style="margin-left:6px"><a href="users.php">Vazgeç</a></button>
    </div>
        </form>
    </div>
    <?php
    }
    if(isset($_GET["added"])){
        $kullanici=$_POST["kullanici"];
    $btarih=$_POST["btarih"];
    $bitarih=$_POST["bitarih"];
        $db->query("INSERT INTO randevu (musteri_id,baslangic_tarih,bitis_tarihi) VALUES ('$kullanici','$btarih','$bitarih')");
        ?>
             <div id="alert-a" class="d-flex justify-content-center">
    <div id="alert" class="">
      <h5>Bildiri</h5>
      <hr style="width:15rem">
      <p class="text-success">Başarıyla Eklendi!</p>
      <hr style="width:15rem">
      <button type="button" class="btn btn-primary"><a href="main.php">Tamam</a></button>
    </div>
    </div>
        <?php
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Takip</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
   
<div class="d-flex flex-row">
        <div class="d-flex justify-content-start" id="left-side">
            <div class="btn-group-vertical" role="group" aria-label="Vertical button group" id="buttons">
            <a href="main.php" id="randevu"type="button" class="btn btn-outline-primary"><i class="fa-solid fa-calendar fa-2xl"></i></a>
                <a href="users.php" id="kullanici"type="button" class="btn btn-outline-primary"><i class="fa-solid fa-users fa-2xl"></i></a>
                <a href="logout.php" id="logout" class="btn btn-outline-danger"><i class="fa-solid fa-right-from-bracket fa-2xl"></i></a>
            </div>
        </div>
        <div class="d-flex justify-content-center" id="middle-meeting">

            <div id="top-meeting" class="d-flex flex-column">
                
                <form class="d-flex " role="search" action="main.php?search=true" method="post">
                    <input class="form-control me-2" id="search" type="search" name="search" placeholder="Randevu Ara" aria-label="Search">
                    <button class="btn btn-info" type="submit">Ara</button>
                  </form>

                  
                
                  <div class="list-group" style="margin-top: 30px;width: 65rem;">
                  <h3 style="color: white;margin-top: 20px;">Randevular</h3>
                  <a class="btn btn-primary" href="main.php?ekle=true" id="add"><i class="fa-solid fa-plus fa-2xl" ></i> Randevu</a>
                     <?php
                     if(empty($_GET["search"])){
                     $randevular=$db->query("SELECT * FROM randevu INNER JOIN musteri ON musteri.musteri_id=randevu.musteri_id");
                     while($randevu=$randevular->fetch()){
                     ?>

                    <div class="list-group-item list-group-item-action d-flex flex-row justify-content-between" aria-current="true" href="#">
                        <span style="font-size:20px;width:10rem"class="d-flex align-items-center">
                        <?=$randevu["ad"]?> <?=$randevu["soyad"]?></span>
                        <span style="font-size:20px"class="d-flex align-items-center">Başlangıç: <?=$randevu["baslangic_tarih"]?> |
                    Bitiş: <?=$randevu["bitis_tarihi"]?>
                    </span>
                        <span>
                            <button type="button" class="btn btn-success" ><a href="main.php?guncelle=<?=$randevu["randevu_id"]?>">Güncelle</a></button>
                             <button type="button" class="btn btn-danger"><a href="main.php?sil=<?=$randevu["randevu_id"]?>">Sil</a></button></span>
                    
                        </div>
                        <?php }
                        }else{
                            $id=$_POST["search"];
                            $randevular=$db->query("SELECT * FROM randevu INNER JOIN musteri ON musteri.musteri_id=randevu.musteri_id
                             where ad LIKE ('%$id%') or soyad LIKE ('%$id%') or telefon LIKE ('%$id%')");
                            while($randevu=$randevular->fetch()){

                        ?><div class="list-group-item list-group-item-action d-flex flex-row justify-content-between" aria-current="true" href="#">
                        <span style="font-size:20px;width:10rem"class="d-flex align-items-center">
                        <?=$randevu["ad"]?> <?=$randevu["soyad"]?></span>
                        <span style="font-size:20px"class="d-flex align-items-center">Başlangıç: <?=$randevu["baslangic_tarih"]?> |
                    Bitiş: <?=$randevu["bitis_tarihi"]?>
                    </span>
                        <span>
                            <button type="button" class="btn btn-success" ><a href="main.php?guncelle=<?=$randevu["randevu_id"]?>">Güncelle</a></button>
                             <button type="button" class="btn btn-danger"><a href="main.php?sil=<?=$randevu["randevu_id"]?>">Sil</a></button></span>
                    
                        </div>
                        <?php } }?>


                        
                   
                  </div>
                </div>
                
                
            </div>



           

           

        </div>
</body>
<script src="script.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>