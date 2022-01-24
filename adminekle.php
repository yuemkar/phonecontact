<?php session_start();
require_once('dbbaglanti.php');


if (!isset($_SESSION['login'])){
	echo "<script>window.location.href='/'</script>";
	exit();
}
//Code for Registration 
if(isset($_POST['adminekle']))
{
  $adminadi=$_POST['admin_adi'];
  $adminsifre=$_POST['admin_sifre'];
  $adminsifre=md5($adminsifre);
  //$id=intval($_GET['id']);
  //$query=mysqli_query($con,"update grup set grupisim='$grupisim' where id='$id'");
  //$query=mysqli_query($con,"insert into grup (grupisim) values ('{$grupisim}')");
  
  $grpsql = $db->prepare("select * from admin where username=?");
  $grpsql->execute([$adminadi]); 
  $qrpok = $grpsql->fetch();
  if (isset($qrpok) && is_array($qrpok)){
  	$_SESSION['msg']="Aynı İsimde Admin Var!";
  }else{
   
  $pre = $db->prepare("insert into admin SET username = ?, password = ?");
	$query = $pre->execute(array($adminadi,$adminsifre));
	
  //log tutmal
  $pre2 = $db->prepare("insert into log_admin SET
	admin_id = ?,
	log_tur = 'Admin-ekle',
	log_icerik = ?,
	tarih = NOW()
	");
	$insertid=$db->lastInsertId();
	$query2= $pre2->execute(array(
	     $_SESSION['id'],
	     'Admin id='.$insertid
	)); 	
	
  
  if($query)
  {
  	$_SESSION['msg']="Admin Eklendi";
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
            <h3><i class="fa fa-angle-right"></i> Admin Ekleme</h3>,
            <p align="center" style="color:#F00;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']=""; ?></p>
	        <div class="row">
        
                  
                    
                  <div class="col-md-12">
                      <div class="content-panel">
                           <form class="form-horizontal style-form" name="form1" method="post" action="" onSubmit="return valid();">
                           
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Kullanıcı Adı</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" value=""  name="admin_adi" required >
                              </div>
                          </div>
                           <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label" style="padding-left:40px;">Sifre</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" value=""  name="admin_sifre" required >
                              </div>
                          </div>                         
                

                          <?php //kopyalama alanı ?>

<?php //butonlar ?>
                          <div style="float: left; margin-left:100px;">
                          <input type="reset" name="reset" value="Sıfırla" class="btn btn-theme"></div>


                          <div style="margin-left:200px;">
                          <input type="submit" name="adminekle" value="Onayla" class="btn btn-theme"></div>
<?php //butonlar ?>
                          </form>
                      </div>
                  </div>
              </div>
    </section>
      </section></section>
     <section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-angle-right"></i> Admin Listesi</h3>
				<div class="row">
				
                  
	                  
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Admin Liste </h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th>Say</th>
                                  <th>id</th>
                                  <th>Admin Adı</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php 
                              
                              $query = $db->query("select * from admin", PDO::FETCH_ASSOC);
							  $cnt=1;
     						  foreach( $query as $row ){
							  ?>
                              <tr>
                              <td><?php echo $cnt;?></td>
                                  <td><?php echo $row['id'];?></td>
                                  <td><?php echo $row['username'];?></td>
                                   <td>
                                     <a href="adminguncelle.php?uid=<?php echo $row['id'];?>"> 
                                     <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                     <a href="adminguncelle.php?sil=<?php echo $row['id'];?>"> 
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
  >     
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
