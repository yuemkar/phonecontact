<?php
session_start();
 $uid=intval($_GET['uid']);
include'dbbaglanti.php';
//Checking session is valid or not

if (!isset($_SESSION['login'])){
	echo "<script>window.location.href='/'</script>";
	exit();
}

if (strlen($_SESSION['id']==0)) {
  header('location:cikis.php');
  } else{

// for updating admin user
if(isset($_POST['Submit']))
{
  $adminadi=$_POST['admin_adi'];
  $adminsifre=$_POST['admin_sifre'];
  $adminsifre=md5($adminsifre);
  $uid=intval($_POST['uid']);

  $query= $db->prepare("UPDATE admin SET username = :adminadi, password =:sifre where id=:uid");
  $degistir= array('adminadi'=>$adminadi,'sifre'=>$adminsifre,'uid'=>$uid);
  $msg = $query->execute($degistir); 
  $_SESSION['msg']="Güncelleme Başarılı";
  
  //log tutmal
  $pre2 = $db->prepare("insert into log_admin SET
	admin_id = ?,
	log_tur = 'Admin-Guncelle',
	log_icerik = ?,
	tarih = NOW()
	");
	$insertid=$db->lastInsertId();
	$query2= $pre2->execute(array(
	     $_SESSION['id'],
	     'Admin Güncellendi admin id='.$uid
	)); 
  
  
}
if(isset($_GET['sil']))
{
  $adminid=intval($_GET['sil']);
  
  //$query=mysqli_query($con,"DELETE FROM grup where id=$grupid");

  $delete = $db->exec("DELETE FROM admin where id=$adminid");
  
    //log tutmal
  $pre2 = $db->prepare("insert into log_admin SET
	admin_id = ?,
	log_tur = 'Admin-Sil',
	log_icerik = ?,
	tarih = NOW()
	");
	$insertid=$db->lastInsertId();
	$query2= $pre2->execute(array(
	     $_SESSION['id'],
	     'Admin Silindi id='.$adminid
	)); 
  
  
  $_SESSION['msg']="Silme Başarılı";
  
   header('location:adminekle.php');
   header('location:adminekle.php');
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
      <?php 
      $query = $db->query("select * from admin where id='".$uid."'", PDO::FETCH_ASSOC);
	  foreach( $query as $row )
	  {?>
      <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> <?php echo $row['username'];?> Admin Bilgileri</h3>
             	
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                      <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           <p style="color:#F00"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Kullanıcı Adı</label>
                              <div class="col-sm-10">
                              	  <input type="hidden" name="uid" value="<?php echo $row['id'];?>" >
                                  <input type="text" class="form-control" name="admin_adi" value="<?php echo $row['username'];?>" >
                              </div>
                          </div>
                            <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Şifre</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" name="admin_sifre" value="" >
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
<?php 
//$_SESSION['msg']='';
} ?>