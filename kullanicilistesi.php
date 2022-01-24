<?php
session_start();
include'dbbaglanti.php';
// checking session is valid for not 
if (strlen($_SESSION['id']==0)) {
  header('location:cikis.php');
  } else{

// for deleting user
if(isset($_GET['del']))
{
$adminid=intval($_GET['del']);
//$msg = $db->query("delete from users where id='$adminid'")->fetch(PDO::FETCH_ASSOC);
$msg = $db->exec("DELETE FROM users where id=$adminid");

  $pre2 = $db->prepare("insert into log_admin SET
  admin_id = ?,
  log_tur = 'Kisi-sil',
  log_icerik = ?,
  tarih = NOW()
  ");
  $insertid=$db->lastInsertId();
  $query2= $pre2->execute(array(
       $_SESSION['id'],
       'Kişi Silindi id='.$adminid
  )); 

if($msg)
{
  $_SESSION['msg']="Kullanıcı Silindi";
}
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin | Kullanıcı Listesi</title>
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

                 
<?php //-------------------BUTON EKLEME İŞLEMİ-------------
                   ?>
                  
              
                 
              </ul>
          </div>
      </aside>
      <section id="main-content">
          <section class="wrapper">
                    <?php 
                                $grupismi='';
                                if(isset($_GET['grupid'])){
                                   $grupid=intval($_GET['grupid']);
                                   if (isset($grupid)) {
								   $rowgrup = $db->query("select * from grup where id={$grupid}")->fetch(PDO::FETCH_ASSOC);
							  		
							  		$grupismi=$rowgrup['grupisim'];
							  		$grupid=$rowgrup['id'];
								   }
						}  ?>       
          	<h3><i class="fa fa-angle-right"></i> Kullanıcı Listesi <?php echo $grupismi;?></h3>
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                      		<p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?></p>
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Tüm Kullanıcı Detayları </h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th>ID</th>
                                  <th class="hidden-phone">Ad</th>
                                  <th> Soy Ad</th>
                                  <th> E-Mail</th>
                                  <th>Ev Telefon Numarası</th>
                                  <th>Cep Telefon Numarası</th>
                                  <th>Kuruluş Bilgisi</th>
                                  <th>Ünvan Bilgisi</th>
                                  <th>Grup</th>
                                  <th>Açıklama</th>
                                 
                              </tr>
                              </thead>
                              <tbody>
                              <?php 
                                $eksql='';
                                if(isset($_GET['grupid'])){
                                   $grupid=intval($_GET['grupid']);
                                   if (isset($grupid)) $eksql="where grup={$grupid}";
								}
                              	$query = $db->query("select * from users $eksql", PDO::FETCH_ASSOC);
								$cnt=1;
     							foreach( $query as $row ){
 	
							  	$grup='';
							  	$grupid='0';
							  	if ($row['grup']<>0){
							  		$rowgrup = $db->query("select * from grup where id={$row['grup']}")->fetch(PDO::FETCH_ASSOC);
							  		
							  		$grup=$rowgrup['grupisim'];
							  		$grupid=$rowgrup['id'];
								}
							  
							  
							  ?>
                              <tr>
                              <td><?php echo $cnt;?></td>
                                  <td><?php echo $row['ad'];?></td>
                                  <td><?php echo $row['soyad'];?></td>
                                  <td><?php echo $row['email'];?></td>
                                  <td><?php echo $row['evtel'];?></td>
                                  <td><?php echo $row['ceptelno'];?></td>  
                                  <td><?php echo $row['kurulus'];?></td>
                                  <td><?php echo $row['unvan'];?></td>
                                  <td><a href="kullanicilistesi.php?grupid=<?php echo $grupid;?>"><?php echo $grup;?></a></td>
                                  <td><?php echo $row['aciklama'];?></td>
                                  <td><?php echo $row['kayit_tarihi'];?></td>
                                  <td>
                                     
                                     <a href="profilguncelleme.php?uid=<?php echo $row['id'];?>"> 
                                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                     <a href="kullanicilistesi.php?del=<?php echo $row['id'];?>"> 
                                     <button class="btn btn-danger btn-xs" onClick="return confirm('Gerçekten Silmek İstiyor Musun ?');"><i class="fa fa-trash-o "></i></button></a>
                                  </td>
                              </tr>
                              <?php $cnt=$cnt+1; }?>
                             
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
		</section>
      </section
  ></section>
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
<?php unset($_SESSION['msg']); ?>
<?php } ?>