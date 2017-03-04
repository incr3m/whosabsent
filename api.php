<?php 
include './controller/session.php';

//$_SESSION['userId'] = null;
if(isset($_GET['getUserId'])){
  echo json_encode(getUser($_GET['getUserId']));
  exit(1);
}




?>