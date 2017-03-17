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
	$dateenrolled = postVarToQueryVar('dateenrolled');
	$status = postVarToQueryVar('status');
	
	$myCon = createSQLCon();

	$q = "";
	
	if(isModeIn([MODE_CREATE])=='true'){
		$q = "INSERT INTO enrolledstudent (accountidno,dateenrolled,status) 
		values ($accountidno,'$dateenrolled','$status')";	
	}
	else if(isModeIn([MODE_UPDATE])=='true'){
		$q = "update enrolledstudent
		 set 
		 accountidno = '$accountidno',
		 dateenrolled = '$dateenrolled',
		 status = '$status'
		 where idno = $id ";	
	}
	else if(isModeIn([MODE_DELETE])=='true'){
		$q = "delete from enrolledstudent where idno = $id";	
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

   $filter = '';
   if(isset($_GET['startdate'])){
   		$filter .= " and logdate >= '".$_GET['startdate']."' and logdate <=  '".$_GET['enddate']."' ";
   }
   if(isset($_GET['student'])){
    	$filter .= " and b.accountid = ".$_GET['student']." ";
   }
   if(isset($_GET['subject'])){
    	$filter .= " and b.subjectid = ".$_GET['subject']." ";
   }
   if(isset($_GET['section'])){
    	$filter .= " and b.sectionid = ".$_GET['section']." ";
   }
   $queryStr = '';
   if(isRoleIn([ROLE_STUDENT,ROLE_TEACHER])==='true'){
   		$userIdNo = getCurrentUser()['idno'];
   		$queryStr = "SELECT b.idno,a.idno as accountidno,concat('".BUCKETPATH."',coalesce((select filename from accountphoto where accountidno = a.idno and isprimary = 'YES'),'noimage_png')) as photo,a.usn,concat(lastname,', ',firstname,' ',middlename) as name, (select code from section s where s.idno = sectionid) as section,sectionid,
   		(select code from subjectunit sb where sb.idno = subjectid) as subject,subjectid,DATE_FORMAT(DATE_ADD(logdate, INTERVAL 8 HOUR),'%a, %d %b %Y %T') as logindate,DATE_FORMAT((SELECT min(x.logdate) FROM accountlog x where x.status = 'logout' and x.subjectid = b.subjectid and x.sectionid = b.sectionid and x.accountid = b.accountid),'%a, %d %b %Y %T') as logoutdate,remarks,status from accountlog b,account a where b.status = 'login' and a.idno = b.accountid 
   				 and a.idno = $userIdNo ".$filter."
   		 order by logdate desc";
   }
   else{
   	$queryStr = "SELECT b.idno,a.idno as accountidno,concat('".BUCKETPATH."',coalesce((select filename from accountphoto where accountidno = a.idno and isprimary = 'YES'),'noimage_png')) as photo,a.usn,concat(lastname,', ',firstname,' ',middlename) as name, (select code from section s where s.idno = sectionid) as section,sectionid,
   		(select code from subjectunit sb where sb.idno = subjectid) as subject,subjectid,DATE_FORMAT(DATE_ADD(logdate, INTERVAL 8 HOUR), '%a, %d %b %Y %T') as logindate,DATE_FORMAT((SELECT min(x.logdate) FROM accountlog x where x.status = 'logout' and x.subjectid = b.subjectid and x.sectionid = b.sectionid and x.accountid = b.accountid),'%a, %d %b %Y %T') as logoutdate,remarks,status from accountlog b,account a where b.status = 'login' and a.idno = b.accountid  ".$filter." order by logdate desc";
   }

  //if ($result = $myCon->query("SELECT b.idno,a.usn,concat(lastname,', ',firstname,middlename) as name,b.status,b.dateenrolled FROM account a, enrolledstudent b where a.idno = b.accountidno order by b.dateenrolled desc")) {
   if ($result = $myCon->query($queryStr)) {
   //if ($result = $myCon->query("SELECT * from accountlog b order by logdate desc")) {
   
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