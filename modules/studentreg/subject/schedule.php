<?php


include '../../../controller/session.php';

$errors = "";
$data = array();
$list = array();
// Getting posted data and decodeing json

if(!isset($_SESSION['objectId'])){
	exit;
}

$_POST = json_decode(file_get_contents('php://input'), true);


if(isset($_POST['idno'])){
	$id = $_POST['idno'];
	$studentidno = $_SESSION['objectId'];
	$sectionsubjectidno = postVarToQueryVar('sectionsubjectidno');
	
	
	
	$myCon = createSQLCon();

	$q = "";
	
	if(isModeIn([MODE_CREATE])=='true'){
		$q = "INSERT INTO studentschedule (studentidno,sectionsubjectidno) 
		values ($studentidno,$sectionsubjectidno)";	
	}
	else if(isModeIn([MODE_UPDATE])=='true'){
		$q = "update studentschedule
		 set 
		 sectionsubjectidno = '$sectionsubjectidno'
		 where idno = $id ";	
	}
	else if(isModeIn([MODE_DELETE])=='true'){
		$q = "delete from studentschedule where idno = $id";	
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

   $objId = $_SESSION['objectId'];

  if ($result = $myCon->query("SELECT e.idno,b.code as sectioncode,c.code as subjectcode,DAYNAME(CONCAT('1970-09-2', d.dayofweek-1)) as day,DATE_FORMAT(d.starttime,'%h:%i %p') as starttime,DATE_FORMAT(d.endtime,'%h:%i %p') as endtime FROM enrolledstudent a,section b,subjectunit c, sectionsubject d, studentschedule e where a.idno = e.studentidno and d.idno = e.sectionsubjectidno and d.subjectidno = c.idno and d.sectionidno = b.idno and a.idno = $objId")) {

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