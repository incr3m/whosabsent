<?php 
include '../../controller/session.php';

$STATUS_LOG_IN = 'login';
$STATUS_LOG_OUT = 'logout';

?>


<?php 

if(empty($_GET['accountID'])){
	echo 'account not found.';
	exit;
}

$accountID = $_GET['accountID'];

$myCon = createSQLCon();


$queryStr = "SELECT b.idno,concat('".BUCKETPATH."',coalesce((select filename from accountphoto where accountidno = a.idno and isprimary = 'YES'),'noimage_png')) as photo,a.usn,concat(lastname,', ',firstname,middlename) as name, (select code from section s where s.idno = sectionid) as section,sectionid,
(select code from subjectunit sb where sb.idno = subjectid) as subject,subjectid,logdate,remarks,status from accountlog b,account a where a.idno = b.accountid
and a.idno = $accountID
order by logdate ";

?>

<html>
<head>
<title>Calendar</title>
<link href='../../js/fullcalendar.min.css' rel='stylesheet' />
<link href='../../js/scheduler.min.css' rel='stylesheet' />
<script src='../../js/moment.min.js'></script>
<script src='../../js/jquery.min.js'></script>
<script src='../../js/fullcalendar.min.js'></script>
<script src='../../js/scheduler.min.js'></script>
</head>

<body style="font-family:monospace">
<div><h1>Attendance Schedule</h1></div>
<div><h2><?php echo getUser($accountID)['name'];?> </h2></div>
<div id='calendar'></div>


<script>


$(document).ready(function() {

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	$('#calendar').fullCalendar({
		header:
		{
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
		defaultView: 'agendaWeek',
		selectable: true,
		selectHelper: true,
	    events: [
	        // events go here
			<?php 

			if ($result = $myCon->query($queryStr)) {
				//if ($result = $myCon->query("SELECT * from accountlog b order by logdate desc")) {
			
				while($row = $result->fetch_assoc()) {

					$list[] = $row;
					if($row['status']==$STATUS_LOG_IN){
						$loginFlag = $row['logdate'];
					}
					else if($row['status']==$STATUS_LOG_OUT){
						if(!empty($loginFlag)){
							$title = "".$row['section']."-".$row['subject'];
							$phpdate = strtotime( $loginFlag );
							$start = date( 'Y/m/d H:i:s', $phpdate );
							$phpdate = strtotime( $row['logdate']);
							$end = date( 'Y/m/d H:i:s', $phpdate );
							echo "{title:'$title',start:new Date('$start'),end:new Date('$end')},";
						} 
					}
					
				}
			
				/* free result set */
				$result->close();
			}
			?>
	    ],
	   
	});

});
</script>
</body>
</html>