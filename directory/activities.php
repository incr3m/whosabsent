<?php

include '../controller/session.php';

$_POST = json_decode(file_get_contents('php://input'), true);
if(isset($_POST['mode'])){
	$myCon = createSQLCon();

  $activities =array();

  $queryStr = '';
  
  
  if(isRoleIn([ROLE_STUDENT,ROLE_TEACHER])==='true'){
  	$userIdNo = getCurrentUser()['idno'];
  	$queryStr = "SELECT b.idno,user,message,module,logdate,concat(a.lastname,', ',a.firstname,' ',a.middlename) as name FROM account a,user_activity b where b.user=a.idno  
  			 and a.idno = $userIdNo
  			 order by logdate desc limit 10";
  }
  else{
  	$queryStr = "SELECT b.idno,user,message,module,logdate,concat(a.lastname,', ',a.firstname,' ',a.middlename) as name FROM account a,user_activity b where b.user=a.idno order by logdate desc limit 10";  	
  }
  
  if ($result = $myCon->query($queryStr)) {

	    while($row = $result->fetch_assoc()) {
	      $activities[] = $row;
	    }

	    /* free result set */
	    $result->close();
	  }


	$data['activities'] = $activities;


	// response back.
	echo json_encode($data);
	exit;	
 
}
?>