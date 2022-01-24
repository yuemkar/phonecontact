<?php
session_start();
include("dbbaglanti.php");
if(isset($_POST['login']))
{

$adminusername=$_POST['username'];
$pass=md5($_POST['password']);

$query = $db->query("SELECT * FROM admin WHERE username='$adminusername' and password='$pass'")->fetch(PDO::FETCH_ASSOC);
if ( $query ){
$extra="kullanicilistesi.php";
$_SESSION['login']=$_POST['username'];
$_SESSION['id']=$query['id'];
echo "<script>window.location.href='".$extra."'</script>";

  $pre2 = $db->prepare("insert into log_admin SET
  admin_id = ?,
  log_tur = 'Admin Giriş',
  log_icerik = ?,
  tarih = NOW(),
  ipadres = ?
  ");
  $insertid=$db->lastInsertId();
  $query2= $pre2->execute(array(
       $query['id'],
       'Admin Giriş Yaptı',
       $ip
  )); 

exit();
}
else
{
$_SESSION['action1']="*Bilinmeyen Kullanıcı Adı Şifre";
$extra="index.php";
echo "<script>window.location.href='".$extra."'</script>";
exit();
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

    <title>Admin | Giriş</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>
	  <div id="login-page">
	  	<div class="container">
      
	  	
		      <form class="form-login" action="" method="post">
		        <h2 class="form-login-heading">Admin Giriş Paneli</h2>
                  <p style="color:#F00; padding-top:20px;" align="center">
                    <?php echo $_SESSION['action1'];?><?php echo $_SESSION['action1']="";?></p>
		        <div class="login-wrap">
		            <input type="text" name="username" class="form-control" placeholder="Kullanıcı Adı" autofocus>
		            <br>
		            <input type="password" name="password" class="form-control" placeholder="Şifre"><br >
		            <input  name="login" class="btn btn-theme btn-block" type="submit">
		         
		        </div>
		      </form>	  	
	  	
	  	</div>
	  </div>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
