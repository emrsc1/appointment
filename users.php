<?php
session_start();
if(empty($_SESSION["id"])){
    header("location:login.html");
}
include("connect.php");
if(isset($_GET["guncelle"])){
    $userid=$_GET["guncelle"];
    $users=$db->query("SELECT * FROM musteri where musteri_id=$userid");
    $user=$users->fetch();

?>

<div id="guncelle">
    <form action="users.php?updated=<?=$user["musteri_id"]?>" method="post">
          <h3><?=$user["ad"]?> <?=$user["soyad"]?> Randevu Bilgileri</h3>
          <div class="mb-3">
  <label for="ad" class="form-label">Ad</label>
  <input type="text" class="form-control" name="ad" id="ad" value="<?=$user["ad"]?>">
</div>

<div class="mb-3">
  <label for="soyad" class="form-label">Soyad</label>
  <input type="text" class="form-control" name="soyad" id="soyad" value="<?=$user["soyad"]?>">
</div>

<div class="mb-3">
  <label for="tel" class="form-label">Telefon Numarası</label>
  <input type="tel" class="form-control" name="tel" id="tel" value="<?=$user["telefon"]?>">
</div>
          
          


<div class="d-flex flex-row">
<input type="submit" class="btn btn-info" value="Güncelle" style="margin-right:5px">
<button class="btn btn-warning"><a href="users.php">İptal Et</a></button>
</div>
    </form>
</div>
<?php } 
if(isset($_GET["updated"])){
    $id=$_GET["updated"];
    $ad=$_POST["ad"];
    $soyad=$_POST["soyad"];
    $tel=$_POST["tel"];
    $db->query("UPDATE musteri SET ad='$ad',soyad='$soyad',telefon='$tel' where musteri_id=$id");
    ?>
    <div id="alert-a" class="d-flex justify-content-center">
<div id="alert" class="">
  <h5>Bildiri</h5>
  <hr style="width:15rem">
  <p class="text-success">Başarıyla Güncellendi!</p>
  <hr style="width:15rem">
  <button type="button" class="btn btn-primary"><a href="users.php">Tamam</a></button>
</div>
</div>
    <?php
    
    
}
if(isset($_GET["sil"])){
    $id=$_GET["sil"];
    $db->query("DELETE FROM randevu WHERE musteri_id=$id");
    $db->query("DELETE FROM musteri WHERE musteri_id=$id");
    header("location.php:users.php");
    ?>
     <div id="alert-a" class="d-flex justify-content-center">
<div id="alert" class="">
  <h5>Bildiri</h5>
  <hr style="width:15rem">
  <p class="text-success">Başarıyla Silindi!</p>
  <hr style="width:15rem">
  <button type="button" class="btn btn-primary"><a href="users.php">Tamam</a></button>
</div>
</div>
    <?php
}
if(isset($_GET["ekle"])){?>
<div id="ekle">
    <form action="users.php?added=true" method="post">

    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Ad</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" name="ad" placeholder="Adı">
</div>

<div class="mb-3">
  <label for="soyad" class="form-label">Soyad</label>
  <input type="text" class="form-control" id="soyad" name="soyad" placeholder="Soyadı">
</div>

<div class="mb-3">
  <label for="tel" class="form-label">Telefon Numarası</label>
  <input type="tel" class="form-control" id="soyad" name="tel" placeholder="Telefon numarası">
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
    $ad=$_POST["ad"];
    $soyad=$_POST["soyad"];
    $telefon=$_POST["tel"];
    $db->query("INSERT INTO musteri (ad,soyad,telefon) VALUES ('$ad','$soyad','$telefon')");
    ?>
         <div id="alert-a" class="d-flex justify-content-center">
<div id="alert" class="">
  <h5>Bildiri</h5>
  <hr style="width:15rem">
  <p class="text-success">Başarıyla Eklendi!</p>
  <hr style="width:15rem">
  <button type="button" class="btn btn-primary"><a href="users.php">Tamam</a></button>
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

            <div class="d-flex justify-content-center" id="middle-users">

                <div id="top-meeting" class="d-flex flex-column">
                    
                    <form class="d-flex " role="search" action="users.php?search=true" method="post">
                        <input class="form-control me-2" id="search" type="search" name="search" placeholder="Müşteri Ara" aria-label="Search">
                        <button class="btn btn-info" type="submit">Ara</button>
                      </form>
    
                      
                    
                      <div class="list-group" style="margin-top: 30px;width: 65rem;">
                      <h3 style="color: white;margin-top: 20px;">Müşteriler</h3>
                      <a class="btn btn-primary" id="add" href="users.php?ekle=true"><i class="fa-solid fa-plus fa-2xl"></i> Müşteri</a>
                         <?php
                         if(empty($_GET["search"])){
                         $musteriler=$db->query("SELECT * FROM musteri");
                         while($musteri=$musteriler->fetch()){
                         ?>
    
                        <div class="list-group-item list-group-item-action d-flex flex-row justify-content-between" aria-current="true" href="#">
                            <span style="font-size:20px;width:10rem"class="d-flex align-items-center">
                            <?=$musteri["ad"]?> <?=$musteri["soyad"]?></span>
                            <span style="font-size:20px;"class="d-flex align-items-center flex-row"> Tel No: <?=$musteri["telefon"]?></span>
                            
                            <span>
                                <button type="button" class="btn btn-success" ><a href="users.php?guncelle=<?=$musteri["musteri_id"]?>">Güncelle</a></button>
                                 <button type="button" class="btn btn-danger"><a href="users.php?sil=<?=$musteri["musteri_id"]?>">Sil</a></button></span>
                        
                            </div>
                            <?php }
                            }else{
                                $id=$_POST["search"];
                                $users=$db->query("SELECT * FROM randevu INNER JOIN musteri ON musteri.musteri_id=randevu.musteri_id
                                 where ad LIKE ('%$id%') or soyad LIKE ('%$id%') or telefon LIKE ('%$id%')");
                                while($user=$users->fetch()){
    
                            ?><div class="list-group-item list-group-item-action d-flex flex-row justify-content-between" aria-current="true" href="#">
                            <span style="font-size:20px;width:10rem"class="d-flex align-items-center">
                            <?=$user["ad"]?> <?=$user["soyad"]?></span>
                            <span style="font-size:20px"class="d-flex align-items-center">Başlangıç: <?=$user["baslangic_tarih"]?> |
                        Bitiş: <?=$user["bitis_tarihi"]?>
                        </span>
                            <span>
                                <button type="button" class="btn btn-success" ><a href="users.php?guncelle=<?=$user["randevu_id"]?>">Güncelle</a></button>
                                 <button type="button" class="btn btn-danger"><a href="users.php?sil=<?=$user["randevu_id"]?>">Sil</a></button></span>
                        
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