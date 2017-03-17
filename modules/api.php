<?php 

include '../controller/session.php';
if(isset($_GET['photo']) && isset($_GET['idno']) ){

	$myCon = createSQLCon();
	$useridno = $_GET['idno'];
	$photoname =  $_GET['photo'];
	
	$index = 0;
	$errors = "";
	if ($result = $myCon->query("select coalesce(max(idno),0) as lastindex from accountphoto")) {
	
		while($row = $result->fetch_assoc()) {
			$index = $row["lastindex"];
		}
	
	
		$result->close();
	}
	
	$index = $index+1;
	
	$q = "INSERT INTO accountphoto (accountidno,filename,fileindex)
	values ($useridno,'".$photoname."_capture',$index)";
	
	if ($result = $myCon->query($q) or die($myCon->error)) {
	
				if($result === TRUE){
					
				$ch = curl_init(APIPATH.'/upload?userId='.$useridno.'&id='.urlencode($photoname.'_capture').'&imPath='.urlencode(BUCKETPATH.''.$photoname));
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_HEADER, false);
							
						$result = curl_exec($ch);
							
						$myCon->close();
						$extra['proc'] = 'success';
						$extra['api'] = $result;
								$data['extra'] = $extra;
								echo json_encode($data);
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
	echo $errors;
}
if(isset($_GET['usn'])){
	$usn = $_GET['usn'];
	$myCon = createSQLCon();
		
		
	if ($result = $myCon->query("SELECT idno,concat('".BUCKETPATH."',coalesce((select filename from accountphoto where accountidno = a.idno and isprimary = 'YES'),'noimage_png')) as photo,usn,username,concat(lastname,', ',firstname,' ',middlename) as name,
			email,roles,dateadded FROM account a
			where usn = $usn order by dateadded desc")) {
				
			while($row = $result->fetch_assoc()) {
				$account = $row;
			}
			/* free result set */
			$result->close();
			
			echo json_encode($account);
	}
}
if(isset($_GET['sections'])){
	$myCon = createSQLCon();


  if ($result = $myCon->query("SELECT distinct c.idno as sectionidno,b.idno as subjectidno,b.code as sectioncode,c.code as subjectcode,DAYNAME(CONCAT('1970-09-2', d.dayofweek-1)) as day,DATE_FORMAT(d.starttime,'%h:%i %p') as starttime,DATE_FORMAT(d.endtime,'%h:%i %p') as endtime FROM enrolledstudent a,section b,subjectunit c, sectionsubject d where d.subjectidno = c.idno and d.sectionidno = b.idno")) {
//note sectionidno and subjectidno are reversed, lazy fix for mapping values in app.
    while($row = $result->fetch_assoc()) {
      $list[] = $row;
    }

    /* free result set */
    $result->close();
  }


	$data['list'] = $list;
	echo json_encode($data);
	exit;
	
}
if(isset($_GET['cmd'])){
	$cmd = $_GET['cmd'];
	
	if($cmd=='accountlog'){
		
		if(!isset($_GET['subjectidno'])){

			echo 'subject id no is required';
			exit;
		}
		if(!isset($_GET['sectionidno'])){
			echo 'section id no is required';
			exit;
		}		
		if(!isset($_GET['accountidno'])){
			echo 'account id no is required';
			exit;
		}
		
		//$mode = $_GET['mode'];
		$subjectidno = $_GET['subjectidno'];
		$sectionidno = $_GET['sectionidno'];
		$accountidno = $_GET['accountidno'];
		
		//
		
		$account = array();
		$subjectstatus = '';
		$studentstatus = '';
		$dateenrolled = '';
		
		{
			
			/*
			 * name
			 * dp image url
			 * status
			 * 
			 */
			$myCon = createSQLCon();
			
			
			if ($result = $myCon->query("SELECT idno,concat('".BUCKETPATH."',coalesce((select filename from accountphoto where accountidno = a.idno and isprimary = 'YES'),'noimage_png')) as photo,usn,username,concat(lastname,', ',firstname,' ',middlename) as name,
					email,roles,dateadded FROM account a 
					where idno = $accountidno order by dateadded desc")) {
			
				while($row = $result->fetch_assoc()) {
					$account = $row;
				}
				/* free result set */
				$result->close();
			}

			if ($result = $myCon->query("select b.status from sectionsubject a , studentschedule b 
				where  studentidno in (select idno from enrolledstudent where accountidno = $accountidno)
				and b.sectionsubjectidno = a.idno and sectionidno = $sectionidno and subjectidno = $subjectidno
				order by b.idno desc limit 1 
					 ")) {
					
				while($row = $result->fetch_assoc()) {
					$account['subjectstatus'] = $row['status'];
				}
				/* free result set */
				$result->close();
			}
			
			if ($result = $myCon->query("select DATE_ADD(dateenrolled, INTERVAL 8 HOUR),status from enrolledstudent where accountidno = $accountidno
					order by dateenrolled desc limit 1
					")) {
						
					while($row = $result->fetch_assoc()) {
						$account['studentstatus']= $row['status'];
						$account['dateenrolled'] = $row['dateenrolled'];
					}
				/* free result set */
					$result->close();
			}

			if(empty($account['idno'])){
				$account['logstatus'] = 'failed';
				$account['logmessage'] = "accountid#$accountidno not found.";
				echo 
				exit;
			}
			

			$status = 'login';
			$remarks = 'Logged-in successfully ';
			if ($result = $myCon->query("select * from accountlog where idno in 
					(select max(idno) from accountlog where accountid = $accountidno) 
					and status = 'login'
					and DATE(logdate) = curdate() ")) {
		
				while($row = $result->fetch_assoc()) {
					$status= 'logout';
					$remarks = 'Logged-out successfully ';
				}
				/* free result set */
				$result->close();
			}

			$account['logstatus'] = $status;
			$account['logmessage'] = $remarks;
			
			
			$q = "INSERT INTO accountlog (accountid,logdate,remarks,sectionid,subjectid,status)
			values ('$accountidno',now(),'$remarks','$subjectidno','$sectionidno','$status')";
			
			if ($result = $myCon->query($q) or die($myCon->error)) {
			
				if($result === TRUE){
					$myCon->close();
				}
			}
			echo json_encode($account);
			
				
		}
	}
}

?>