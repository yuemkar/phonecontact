<?php
session_start();
include'dbbaglanti.php';





if (strlen($_SESSION['id']==0)) {
  header('location:cikis.php');
  } else{

if(isset($_POST['log_admin']))
{
  $id=$_POST['id'];
    $admin_id=$_POST['admin_id'];

  $log_tur=$_POST['log_tur'];

  $log_icerik=$_POST['log_icerik'];

  $tarih=$_POST['tarih'];


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
          	<h3><i class="fa fa-angle-right"></i> Log Listesi</h3>
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                      		<p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?></p>
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Tüm Log Detayları </h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th>Say</th>
                                  <th>ID</th>
                                  <th>Adı</th>
                                  <th>Log Türü</th>
                                  <th>Log İçerik</th>
                                  <th>İp Adresi</th>
                                  <th>Log Tarih</th>
                                 
                              </tr>
                              </thead>
                              <tbody>



                                <?php 
                              
                              $query = $db->query("select * from log_admin order by id desc", PDO::FETCH_ASSOC);
                $cnt=1;
                  foreach( $query as $row ){
                ?>



                                
                              
                              <tr>
                              <td><?php echo $cnt;?></td>
                               <td><?php echo $row['id'];?></td>
								<?php 
								
								$admin = $db->query("select * from admin where id={$row['admin_id']}")->fetch(PDO::FETCH_ASSOC);
								if (isset($admin) && is_array($admin)){
									$adminname=$admin['username'];
								}else{
									$adminname='Kullanıcı Bulunamadı';
								}
								?>
                                  <td><?php echo $adminname;?></td>
                                  <td><?php echo $row['log_tur'];?></td>
                                  <td><?php echo $row['log_icerik'];?></td>
                                  <td><?php echo $row['ipadres'];?></td>
                                  <td><?php echo $row['tarih'];?></td>
                           
                                  
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