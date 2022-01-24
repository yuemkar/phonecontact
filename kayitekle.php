<?php 
session_start();
require_once('dbbaglanti.php');
if (strlen($_SESSION['id']==0)) {
  header('location:cikis.php');
  } else{

  $ad='';
  $soyad='';
  $email='';
  $evtel='';
  $ceptel='';
  $kurulus='';
  $unvan='';
  $grup='';
  $aciklama='';



//Code for Registration 
if(isset($_POST['signup']))
{
  $ad=$_POST['ad'];
  $soyad=$_POST['soyad'];
  $email=$_POST['email'];
  $evtel=$_POST['evtel'];
  $ceptel=$_POST['ceptel'];
  $kurulus=$_POST['kurulus'];
  $unvan=$_POST['unvan']; 
  $grup=$_POST['grup'];  
  $aciklama=$_POST['aciklama'];  
  
  $usersql = $db->prepare("select * from users where ad=? and soyad=?");
  $usersql->execute([$ad,$soyad]); 
  $userok = $usersql->fetch();
  $usererror=false;
  
  if (isset($userok) && is_array($userok)){
  	$_SESSION['msg'].="Aynı Ad Soyadda kullanıcı var!</br>";
  	$usererror=true;
  }
  
  $usersql = $db->prepare("select * from users where ceptelno=:telno01 or evtel=:telno02 or ceptelno=:telno02 or evtel=:telno01");
  $usersql->execute(array('telno01'=>$ceptel,'telno02'=>$evtel));
  $userok2 = $usersql->fetch();
  if (isset($userok2) && is_array($userok2)){
  	$_SESSION['msg'].="Aynı Telefon/Ev Numarasına Kayıtlı Kullanıcı var!</br>";
  	$usererror=true;
  }
  if (!$usererror){
 
  $query = $db->prepare("insert into users SET
	ad = ?,
	soyad = ?,
	email = ?,
	evtel = ?,
	ceptelno = ?,
	kurulus =?,
	unvan =?,
	grup =?,
	aciklama = ?
	");
	$msg = $query->execute(array(
	     $ad, $soyad, $email,$evtel,$ceptel,$kurulus,$unvan,$grup,$aciklama
	));
  header("location:kullanicilistesi.php?durum=ok");
  //log tutmal
  $pre2 = $db->prepare("insert into log_admin SET
  admin_id = ?,
  log_tur = 'Kisi-Ekle',
  log_icerik = ?,
  tarih = NOW()
  ");
  $insertid=$db->lastInsertId();
  $query2= $pre2->execute(array(
       $_SESSION['id'],
       'Kişi Eklendi id='.$insertid
  ));   

  
if($msg)
{
  //echo "<script>alert('Kayıt Başarılı');</script>";
	$_SESSION['msg']="Kayıt Başarılı";

}
}
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


    <title>Admin | Kayıt Ekle</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
</script>
<script src="js/jquery.min.js"></script>
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
        <script type="text/javascript">
          $(document).ready(function () {
            $('#horizontalTab').easyResponsiveTabs({
              type: 'default',       
              width: 'auto', 
              fit: true 
            });
          });
           </script>
           <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,600,700,200italic,300italic,400italic,600italic|Lora:400,700,400italic,700italic|Raleway:400,500,300,600,700,200,100' rel='stylesheet' type='text/css'>
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
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Kullanıcı Ekleme Menüsü </h3>
          	<p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Ad</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" value="<?php echo $ad;?>"  name="ad" required >
                              </div>
                          </div>
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Soyad</label>
                              <div class="col-sm-10">
                                 <input type="text" class="form-control" value="<?php echo $soyad;?>" name="soyad"  required >
                              </div>
                          </div>
                              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Mail</label>
                              <div class="col-sm-10">
                                  <input type="email" class="form-control" value="<?php echo $email;?>" name="email"  >
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Ev Telefon Numarası</label>
                              <div class="col-sm-10">
                                 <input onkeypress="return isNumberKey(event)" value="<?php echo $evtel;?>" maxlength="11" type="text" class="form-control" name="evtel" >
                              </div>
                          </div>

                          <?php //kopyalama alanı ?>
                          
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Cep Telefon Numarası</label>
                              <div class="col-sm-10">
                                  <input onkeypress="return isNumberKey(event)" value="<?php echo $ceptel;?>" maxlength="11" type="text" class="form-control" name="ceptel"  required>
                              </div>
                          </div>
                                                          
                                <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Kuruluş Bilgisi</label>
                              <div class="col-sm-10">
                                 <input type="text" class="form-control"  value="<?php echo $kurulus;?>" name="kurulus"   >
                              </div>
                          </div>

                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Ünvan Bilgisi</label>
                              <div class="col-sm-10">
                                 <input type="text" class="form-control"  value="<?php echo $unvan;?>" name="unvan"   >
                              </div>
                          </div>
                          
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Grup</label>
                              <div class="col-sm-10">
                                 <select class="custom-select" name="grup">
                  <option selected>Grup Seç</option>
                    <?php 
                    $query = $db->query("select * from grup", PDO::FETCH_ASSOC);
                    foreach( $query as $row ){ ?>
                      <option <?php if ($grup==$row['id'])echo 'selected';?> value="<?php echo $row['id'];?>"><?php echo $row['grupisim'];?></option>
                    <?php }?>
                </select>
               </div>
                          </div>                             
                           <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Açıklama Bilgisi</label>
                              <div class="col-sm-10">
                                 <input type="text" class="form-control"  name="aciklama"  value="<?php echo $aciklama;?>" >
                              </div>
                          </div>
                       <?php //kopyalama alanı ?>

<?php //butonlar ?>
                          <div style="float: left; margin-left:100px;">
                          <input type="reset" name="reset" value="Sıfırla" class="btn btn-theme"></div>


                          <div style="margin-left:200px;">
                          <input type="submit" name="signup" value="Onayla" class="btn btn-theme"></div>
<?php //butonlar ?>
                          </form>
                      </div>
                  </div>
              </div>
		</section>
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