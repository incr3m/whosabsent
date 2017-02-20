<?php 

include '../controller/session.php';

addUserActivity('Logged out to the system.');

$_SESSION['userId'] = null;
$_SESSION['page'] = PAGE_LOGIN;


header('Location: '.'../index.php');
?>