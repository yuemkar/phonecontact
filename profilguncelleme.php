<?php
session_start();
include'dbbaglanti.php';
//Checking session is valid or not
if (strlen($_SESSION['id']==0)) {
  header('location:cikis.php');
  } else{

// for updating user info    
if(isset($_POST['Submit']))
{
  $ad=$_POST['ad'];
  $soyad=$_POST['soyad'];
  $evtel=$_POST['evtel'];
  $email=$_POST['email'];
  $ceptel=$_POST['ceptel'];
  $kurulus=$_POST['kurulus'];
  $unvan=$_POST['unvan'];
  $grup=$_POST['grup'];
  $aciklama=$_POST['aciklama'];
  $uid=intval($_GET['uid']);
$query= $db->prepare("UPDATE users SET  
  ad = :ad,
  soyad = :soyad,
  email = :email,
  evtel = :evtel,
  ceptelno = :ceptelno,
  kurulus = :kurulus,
  aciklama = :aciklama,
  unvan = :unvan,
  grup = :grup where id=:uid");
  $degistir= array('ad'=>"{$ad}", 'soyad'=>$soyad,'email'=> $email,'evtel'=>$evtel,'ceptelno'=>$ceptel,'kurulus'=>$kurulus,'unvan'=>$unvan,'grup'=>$grup,'aciklama'=>$aciklama,'uid'=>$uid);
  $msg = $query->execute($degistir);
  $_SESSION['msg']="Profil Güncelleme Başarılı";

  //log tutmal
  $pre2 = $db->prepare("insert into log_admin SET
  admin_id = ?,
  log_tur = 'Kisi-Guncelle',
  log_icerik = ?,
  tarih = NOW()
  ");
  $insertid=$db->lastInsertId();
  $query2= $pre2->execute(array(
       $_SESSION['id'],
       'Kisi Güncellendi id='.$uid
  )); 

}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <script>
    function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

  </script>

    <title>Admin | Profil Düzenle</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>

  <section id="container" >
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <a href="#" class="logo"><b>Admin Paneli</b></a>
            <div class="nav notify-row" id="top_menu">
               
                         
                   
                </ul>
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="cikis.php">Çıkış</a></li>
            	</ul>
            </div>
        </header>
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="#"><img src="assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
              	  <h5 class="centered"><?php echo $_SESSION['login'];?></h5>
              	  	
                     <li class="sub-menu">
                      <a href="kullanicilistesi.php" >
                          <i class="fa fa-users"></i>
                          <span>Kullanıcı Listesi</span>
                      </a>
                   
                  </li>

 <li class="sub-menu">
                      <a href="kayitekle.php" >
                          <i class="fa fa-users"></i>
                          <span>Kayıt Ekle</span>
                      </a>
                   
                  </li>

                   <li class="sub-menu">
                      <a href="grupekle.php" >
                          <i class="fa fa-users"></i>
                          <span>Grup Ekle/Listele</span>
                      </a>
                   
                  </li>

                  <li class="sub-menu">
                      <a href="adminekle.php" >
                          <i class="fa fa-users"></i>
                          <span>Admin Ekle/Listele</span>
                      </a>
                   
                  </li>

                  <li class="sub-menu">
                      <a href="log.php" >
                          <i class="fa fa-users"></i>
                          <span>Log Listesi</span>
                      </a>
                   
                  </li>
                  
                  <li class="sub-menu">
                      <a href="sifredegistir.php">
                          <i class="fa fa-file"></i>
                          <span>Şifre Değiştir</span>
                      </a>
                  </li>
              
                 
              </ul>
          </div>
      </aside>
      <?php $ret=mysqli_query($con,"select * from users where id='".$_GET['uid']."'");
	  while($row=mysqli_fetch_array($ret))
	  
	  {?>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> <?php echo $row['ad'];?> Profil Bilgileri</h3>
             	
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                      <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Ad </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="ad" value="<?php echo $row['ad'];?>" >
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Soyad</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="soyad" value="<?php echo $row['soyad'];?>" >
                              </div>
                          </div>
                          
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Mail Adresi </label>
                              <div class="col-sm-10">
                                  <input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>"  >
                              </div>
                          </div>
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Ev Telefon Numarası </label>
                              <div class="col-sm-10">
                                  <input onkeypress="return isNumberKey(event)" maxlength="11" type="text" class="form-control" name="evtel" value="<?php echo $row['evtel'];?>" >
                              </div>
                            </div>                            
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Telefon Numarası </label>
                              <div class="col-sm-10">
                                  <input onkeypress="return isNumberKey(event)" maxlength="11" type="text" class="form-control" name="ceptel" value="<?php echo $row['ceptelno'];?>" >
                              </div>
                          </div>
                                                        
                                      <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Kurulus</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="kurulus" value="<?php echo $row['kurulus'];?>" >
                              </div>
                          </div>                           
                               <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Ünvan Bilgisi </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="unvan" value="<?php echo $row['unvan'];?>" >
                              </div>
                          </div>
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Grup</label>
                              <div class="col-sm-10">
                                 <select class="custom-select" name="grup">
								  <option <?php if ($row['grup']==0) echo 'selected';?>">Grup Seç</option>
								    <?php $ret=mysqli_query($con,"select * from grup");
	  									while($rowgrup=mysqli_fetch_array($ret)){?>
								  		<option <?php if ($row['grup']==$rowgrup['id']) echo 'selected';?> value="<?php echo $rowgrup['id'];?>"><?php echo $rowgrup['grupisim'];?></option>
										<?php }?>
								</select>
							 </div>
                          </div>                            
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Açıklama Bilgisi </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="aciklama" value="<?php echo $row['aciklama'];?>" >
                              </div>
                          </div>
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Kayıt Tarihi </label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="regdate" value="<?php echo $row['kayit_tarihi'];?>" readonly >
                              </div>
                          </div>
                          <div style="margin-left:100px;">
                          <input type="submit" name="Submit" value="Güncelle" class="btn btn-theme"></div>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
        <?php } ?>
      </section></section>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
  <script>
      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
<?php } ?>