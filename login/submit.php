<?php


include '../controller/session.php';

$errors = array();
$data = array();
// Getting posted data and decodeing json
if (empty($_POST['password'])&&(empty($_POST['username']))){
	$_POST = json_decode(file_get_contents('php://input'), true);
}


// checking for blank values.
if (empty($_POST['password']))
  $errors['password'] = 'Password is required.';

if (empty($_POST['username']))
  $errors['username'] = 'Username is required.';

if(empty($errors)){
    echo 'testest'.DB_PW;
   $myCon = createSQLCon();

   $userName = $_POST['username'];
   $password = $_POST['password'];
   $src = "system";
   if(isset($_POST['src'])){
   	$src = $_POST['src'];
   }

   $strQuery = "SELECT idno FROM account where username = '$userName' and password = '$password' ";
   
   if($src==="app"){
   	$strQuery = $strQuery . " and not(roles = 'STUDENT') ";
   }
   
  if ($result = $myCon->query($strQuery)) {

    while($row = $result->fetch_assoc()) {
      $userId = $row["idno"];
    }

    /* free result set */
    $result->close();

    if(!empty($userId)){
    	$_SESSION['page'] = PAGE_DIRECTORY;
    	$_SESSION['userId'] = $userId;
      addUserActivity('Logged in to the '.$src.'.');
    }
    else{
    	$errors['username'] = 'Username or Password not found.';
    }
    
  }
  else{
  	$errors['username'] = 'Error fetching account.';
  }
}


if (!empty($errors)) {
  $data['errors']  = $errors;
}
else{
	$data['msg']  = 'Login successful.';
}

// response back.
echo json_encode($data);
?>