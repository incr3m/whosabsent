<?php 
include './controller/session.php';

//$_SESSION['userId'] = null;
if(!isset($_SESSION['userId'])){
  echo '{"authError":true}';
  exit(1);
}


echo json_encode(getCurrentUser());

?>