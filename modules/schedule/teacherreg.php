<?php


include '../../controller/session.php';

$errors = "";
$data = array();
$list = array();
// Getting posted data and decodeing json

$_POST = json_decode(file_get_contents('php://input'), true);


if(isset($_POST['idno'])){
	$id = $_POST['idno'];
	$accountidno = postVarToQueryVar('accountidno');
	$dateemployed = postVarToQueryVar('dateemployed');
	$department = postVarToQueryVar('department');
	
	$myCon = createSQLCon();

	$q = "";
	
	if(isModeIn([MODE_CREATE])=='true'){
		$q = "INSERT INTO teacher (accountidno,dateemployed,department) 
		values ($accountidno,'$dateemployed','$department')";	
	}
	else if(isModeIn([MODE_UPDATE])=='true'){
		$q = "update teacher
		 set 
		 accountidno = '$accountidno',
		 dateemployed = '$dateemployed',
		 department = '$department'
		 where idno = $id ";	
	}
	else if(isModeIn([MODE_DELETE])=='true'){
		$q = "delete from teacher where idno = $id";	
	}


	if ($result = $myCon->query($q) or die($myCon->error)) {

		if($result === TRUE){
			if(isModeIn([MODE_CREATE])=='true'){
				$data['idno']=$myCon->insert_id;
				echo json_encode($data);
			}
			else if(isModeIn([MODE_UPDATE])=='true'){
				$data['idno']=$id;
				echo json_encode($data);
			}
			$myCon->close();	
			exit;	
			
		}
		else{
			$errors = 'Error occurred while saving new record.';
		}

		/* free result set */
		$myCon->close();

	}
	else{
		$errors .= 'Record already exist.';
	}
	//echo json_encode($_POST['account']);

	if (!empty($errors)) {
		$data['errors']  = $errors;
		echo json_encode($data);
	}

	
	exit;
}


   $myCon = createSQLCon();


  if ($result = $myCon->query("SELECT b.idno,concat(lastname,', ',firstname,middlename) as name,b.department,b.dateemployed FROM account a, teacher b where a.idno = b.accountidno ")) {

    while($row = $result->fetch_assoc()) {
      $list[] = $row;
    }

    /* free result set */
    $result->close();
  }


$data['list'] = $list;


// response back.
echo json_encode($data);
//echo 'test2';
?>	