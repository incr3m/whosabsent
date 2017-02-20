<?php


include '../../controller/session.php';

$errors = "";
$data = array();
$accounts = array();
// Getting posted data and decodeing json

$_POST = json_decode(file_get_contents('php://input'), true);


if(isset($_POST['idno'])){
	$id = $_POST['idno'];
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
	

	$myCon = createSQLCon();
	


	$q = "";
	
	if(isModeIn([MODE_CREATE])=='true'){
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

		
		//check duplicate username
		$stmt = $myCon->prepare('SELECT * FROM account WHERE username = ?');
		$stmt->bind_param('s', $username);

		$stmt->execute();

		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
		    $data['errors']  = 'Username already exist.';
			echo json_encode($data);
			exit;
		}


		$q = "INSERT INTO account (username,password,firstname,middlename,lastname,contact,address,email,birthday,usn,roles) 
		values ('$username','$password','$firstname','$middlename','$lastname','$contact','$address','$email','$birthday','$username','$roles')";	
	}
	else if(isModeIn([MODE_UPDATE])=='true'){

		if (!($password === $confirmpassword)&&isRoleIn([ROLE_ADMIN])=='true') {
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

		//check duplicate username
		$stmt = $myCon->prepare('SELECT * FROM account 
			WHERE username = ? and idno <> ?');
		$stmt->bind_param('si', $username,$id);


		$stmt->execute();

		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
		    $data['errors']  = 'Username already exist.';
			echo json_encode($data);
			exit;
		}

		$q = "update account
		 set 
		 username = '$username',
		 password = '$password',
		 firstname = '$firstname',
		 middlename = '$middlename',
		 lastname = '$lastname',
		 contact = '$contact',
		 address = '$address',
		 email = '$email',
		 birthday = '$birthday',
		 usn = '$username',
		 roles = '$roles'
		 where idno = $id ";	
	}
	else if(isModeIn([MODE_DELETE])=='true'){
		$q = "delete from account where idno = $id";	
	}


	if ($result = $myCon->query($q) or die($myCon->error)) {

		if($result === TRUE){
			
			if(isModeIn([MODE_CREATE])=='true'){
				$data['idno']=$myCon->insert_id;
				$myCon->close();
				addUserActivity("Registered new account ''$username''.");
				echo json_encode($data);
			
				
			}
			else if(isModeIn([MODE_UPDATE])=='true'){
				$data['idno']=$id;
				$myCon->close();
				addUserActivity("Modified account ''$username''.");
				echo json_encode($data);
			
			}
			else{
				$myCon->close();
				addUserActivity("Deleted account ''$username''.");
			}	
			exit;	
			
		}
		else{
			$errors = 'Error occurred while saving new account.';
		}

		/* free result set */
		$myCon->close();

	}
	else{
		$errors .= 'Username already exist.';
	}
	//echo json_encode($_POST['account']);

	if (!empty($errors)) {
		$data['errors']  = $errors;
		echo json_encode($data);
	}

	
	exit;
}


   $myCon = createSQLCon();


  if ($result = $myCon->query("SELECT idno,coalesce((select filename from accountphoto where accountidno = a.idno and isprimary = 'YES'),'noimage_png') as photo,usn,username,concat(lastname,', ',firstname,' ',middlename) as name,email,roles,dateadded FROM account a order by dateadded desc")) {

    while($row = $result->fetch_assoc()) {
      $accounts[] = $row;
    }
	addUserActivity("Viewed account list.");
    /* free result set */
    $result->close();
  }


$data['accounts'] = $accounts;


// response back.
echo json_encode($data);
//echo 'test2';
?>	