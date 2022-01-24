<?php
session_start();
include("dbbaglanti.php");
$pre2 = $db->prepare("insert into log_admin SET
admin_id = ?,
log_tur = 'Admin Çıkış',
log_icerik = ?,
tarih = NOW(),
ipadres = ?
");
$query2= $pre2->execute(array(
   $_SESSION['id'],
   'Admin Çıkış Yaptı',
   $ip
)); 

$_SESSION['login']=="";

session_unset();
$_SESSION['action1']="Güvenli Çıkış Gerçekleştirdiniz";



?>
<script language="javascript">
document.location="index.php";
</script>
