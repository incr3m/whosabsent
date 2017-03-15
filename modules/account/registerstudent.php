<?php 

include '../../controller/constants.php';

header("access-control-allow-origin: *");

function addUserActivity($message){

		$myCon = createSQLCon();
		$userId = $_POST['userIdToken'];
		$module = '';
		$sub = '';
 	
 	
		

    $q = "INSERT INTO user_activity (module,user,message,logdate) 
    		values ('account',$userId,'$message',current_timestamp)";

    if ($result = $myCon->query($q) or die($myCon->error)) {

    					if($result === TRUE){
    							$myCon->close();
    							return;
    					}
    					else{
    						$errors = 'Error occurred while saving user activity.';
    					}

    					$myCon->close();

    				}
		    
  	}

function postVarToQueryVar($postKey){
	if(isset($_POST[$postKey])){
		return $_POST[$postKey];
	}
	return '';
}

function createSQLCon(){
	if(!isset($conn)){
		$servername = DB_HOST;
		$username = DB_UN;
		$password = DB_PW;
		$dbName = DB_NAME;

		// Create connection
		$conn = new mysqli($servername, $username, $password,$dbName);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		
	}
	return $conn;
}

$forcemode = postVarToQueryVar('forcemode');
$firstname = postVarToQueryVar('firstname');
$middlename = postVarToQueryVar('middlename');
$lastname = postVarToQueryVar('lastname');
$contact = postVarToQueryVar('contact');
$address = postVarToQueryVar('address');
$birthday = postVarToQueryVar('birthday');
$email = postVarToQueryVar('email');
$username = postVarToQueryVar('username');
$password = postVarToQueryVar('password');
$confirmpassword = postVarToQueryVar('confirmpassword');
$roles = postVarToQueryVar('roles');

if($forcemode=='create'){
	if (!($password === $confirmpassword)) {
	$data['errors']  = 'Password does not match.';
	echo json_encode($data);
	exit;
	}
	if(preg_match("/^[0-9]+$/", $username) == 0) {
	    $data['errors']  = 'Username should only consist of numbers.';
		echo json_encode($data);
		exit;
	}
	if(preg_match("/^[a-zA-Z \.]+$/", $firstname) == 0) {
	    $data['errors']  = 'First Name is invalid.';
		echo json_encode($data);
		exit;
	}
	if(preg_match("/^[a-zA-Z \.]+$/", $middlename) == 0 && strlen($middlename) > 0) {
	    $data['errors']  = 'Middle Name is invalid.';
		echo json_encode($data);
		exit;
	}
	if(preg_match("/^[a-zA-Z \.]+$/", $lastname) == 0) {
	    $data['errors']  = 'Last Name is invalid.';
		echo json_encode($data);
		exit;
	}

  $myCon = createSQLCon();
	
  if ($result = $myCon->query(('SELECT * FROM account WHERE username = '.$username))) {

    while($row = $result->fetch_assoc()) {
      $data['errors']  = 'Username already exist.';
		echo json_encode($data);
		exit;
    }
  }

	$q = "INSERT INTO account (username,password,firstname,middlename,lastname,contact,address,email,birthday,usn,roles) 
	values ('$username','$password','$firstname','$middlename','$lastname','$contact','$address','$email','$birthday','$username','$roles')";	

  if ($result = $myCon->query($q) or die($myCon->error)) {
  
  		if($result === TRUE){
			
				$data['idno']=$myCon->insert_id;
				$myCon->close();
				addUserActivity("Registered new account ''$username''.");
				echo json_encode($data);
  			
  			exit;	
  			
  		}
  		else{
  			$errors = 'Error occurred while saving new account.';
        echo $errors;
  		}
  
  		/* free result set */
  		$myCon->close();
  }
}



?>