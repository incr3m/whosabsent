<?php 

include '../controller/session.php';

$params = '';
if(isset($_GET['mobile'])){
  $params = '?mobile=1';
}

if(!isset($_SESSION['userId'])){
  header('Location: '.'../index.php'.$params);
  exit;
}


addUserActivity('Logged out to the system.');

$_SESSION['userId'] = null;
$_SESSION['page'] = PAGE_LOGIN;


header('Location: '.'../index.php'.$params);
?>