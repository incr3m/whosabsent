<?php

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

function postVarToQueryVar($postKey){
	if(isset($_POST[$postKey])){
		return $_POST[$postKey];
	}
	return '';
}

function dayName($num){
	$dowMap = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
	return $dowMap[$num];
}

function getCurrentModule(){
	$sub = '';
							 	
	if(isset($_GET['sub'])){
		$sub = '&sub='.$_GET['sub'];		
	}

	return $_GET['module'].$sub;
}

function getCurrentModuleName(){
	$name = '';
							 	
	if(isset($_SESSION['moduleName'])){
		$name = $_SESSION['moduleName'];
	}

	return $name;
}

function getCurrentUserType(){
	if(isset($_SESSION['userId'])){
		$id = $_SESSION['userId'];
		$myCon = createSQLCon();
	


		if ($result = $myCon->query("select case when (roles = 'ADMIN') then 'Admin' 
			when (roles = 'STUDENT') then 'Student' 
			when (roles = 'TEACHER') then 'Teacher' 
            else 'Not Registered' end as ret from account a where idno = $id")) {

		    while($row = $result->fetch_assoc()) {
		      $result->close();
		      return $row['ret'];
		    }
		    
	  	}
		
	}
	
}
function getCurrentUser(){
	if(isset($_SESSION['userId'])){
		$id = $_SESSION['userId'];
		return getUser($id);
	}
}

function addUserActivity($message){

		$myCon = createSQLCon();
		$userId = $_SESSION['userId'];
		$module = '';
		$sub = '';
 	
 	
	 	if(isset($_GET['module'])){
			$module =$_GET['module'];		
		}

	 	if(isset($_GET['sub'])){
			$sub = $module.'-'.$_GET['sub'];		
		}
		

$q = "INSERT INTO user_activity (module,user,message,logdate) 
		values ('$module',$userId,'$message',current_timestamp)";

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


function getUser($id){
	
		$myCon = createSQLCon();
	


		if ($result = $myCon->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM account where idNo = $id ")) {

		    while($row = $result->fetch_assoc()) {
		      $result->close();
		      return $row;
		    }
		    
	  	}
	
}

 ?>

 <?php function loadPropertiesPageControls(){ 
 	$sub = '';
 	
 	if(isset($_GET['sub'])){
		$sub = '&sub='.$_GET['sub'];		
	}
	
 	?>
 	<div class="control-toolbar" >
 	<div class="list-primary-controls">

 		<?php if(empty($GLOBALS['hideMainSearch'])&&empty($GLOBALS['hideControls'])){?>
			<?php if(isset($_GET['id'])){ ?>
				<?php if(isRoleIn([ROLE_STUDENT,ROLE_TEACHER])==='false'){ ?>	
				<a class="btn btn-default btn-sm btn-back" title="Back to list" href="?module=<?php echo $_GET['module'].$sub; ?>"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
				<?php }?>
			<?php }?>
			<?php if(isset($_GET['sasub'])&&!isset($_GET['subid'])){ ?>
				<a class="btn btn-default btn-sm btn-add" title="Create New <?php echo getCurrentModuleName(); ?>" href="?module=<?php echo $_GET['module'].$sub; ?>&subid=0&mode=<?php echo MODE_CREATE; ?>"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
			<?php }else if (!isset($_GET['id'])){?>
				<a class="btn btn-default btn-sm btn-add" title="Create New <?php echo getCurrentModuleName(); ?>" href="?module=<?php echo $_GET['module'].$sub; ?>&id=0&mode=<?php echo MODE_CREATE; ?>"><span class="glyphicon glyphicon-plus-sign"></span> Add</a>
			<?php }?>
			<?php if(isModeIn([MODE_CREATE,MODE_UPDATE,MODE_DELETE])==='false' 
					&& ( isset($_GET['id']) )){?>
				<a class="btn btn-default btn-sm btn-edit" title="Modify this <?php echo getCurrentModuleName(); ?>" href="?module=<?php echo $_GET['module']; ?>&id=<?php echo $_GET['id'].$sub; ?>&mode=<?php echo MODE_UPDATE; ?>">
					<span class="glyphicon glyphicon-edit"></span> Edit</a>
				<?php if(isRoleIn([ROLE_STUDENT,ROLE_TEACHER])==='false'){ ?>	
				<a class="btn btn-default btn-sm btn-delete" title="Delete this <?php echo getCurrentModuleName(); ?>" href="?module=<?php echo $_GET['module']; ?>&id=<?php echo $_GET['id'].$sub; ?>&mode=<?php echo MODE_DELETE; ?>">
					<span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				<?php }?>
			<?php
			}
	 	}
		 ?>
		 <?php if(!empty($GLOBALS['returnPageUrl'])){?>
				<a class="btn btn-default btn-sm btn-back" title="Back to list" href="<?php echo $GLOBALS['returnPageUrl'];?>"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
			<?php }?>
	</div>
	<div style="width:100%">
 	<?php if (empty($GLOBALS['hideMainSearch'])&&!isset($_GET['id'])){?>
 	
 	<form>
    <div class="form-group">
      <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-search"></i></div>

        <input type="text" class="form-control" placeholder="Filter list" ng-model="searchList">

      </div>      
    </div>
  </form>
  <?php }?>
  </div>
	</div>
	<script>
	$(function() {
		$(document).on("click", "#mainDeleteBtn", function(e) {
            bootbox.confirm("Are you sure you want to delete this <?php echo getCurrentModuleName(); ?>?", function(result) {
			  angular.element(document.getElementById('mainController')).scope().delete();
			}); 
        });
	});

	</script>
<?php } ?>

<?php function loadPageSubmoduleTab(){ ?>
<ul class="nav nav-tabs" style="margin-bottom:20px">
<?php 
foreach ($GLOBALS['subModules'] as $val) {

	$active = '';


	$requestUrl = "?module=".$_GET['module']."&id=".$_GET['id'];

	if($val['key'] == 'default'){
	}
	else{
		$requestUrl .= "&sub=".$val['key'];
	}

	if(isset($_GET['sub'])){
		if($_GET['sub'] === $val['key']){
			$active = 'class="active"';

			
		}
	}
	else if($val['key'] === 'default'){
		$active = 'class="active"';
	}


	echo '<li role="presentation" '.$active.'>
			  <a href="'.$requestUrl.'">
			  	'.$val['name'].'
			  </a></li>';
}
?>			  
			</ul> 
<?php } ?>