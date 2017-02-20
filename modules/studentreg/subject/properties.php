	
<?php

function initPage(){

	$objectId = $_SESSION['objectId'];
	//$pageName = "User #".getUser($objectId)['usn'];

	setPageHeader('USER');
	addPageSubHeader('Detail');

	setPageControllerName('postController');
}

function getPageContents(){
$objectId = $_SESSION['objectId'];
$pageName = "User #".getCurrentUser()['username'];
$subPageName = "Schedule";

$sectionlist = array();
$sectionsubjectunits = array();
$status = array();
$object = array();





	
if(isset($_GET['sectionid'])){
	$sectionid = $_GET['sectionid'];
}

$sectionFilter = '';
if(isset($sectionid )){
	$sectionFilter = ' and b.idno = '.$sectionid.' ';
}

$myCon = createSQLCon();

$theQuery = "SELECT d.idno,b.code,b.description,c.code,c.description,CONCAT(c.code,' / ' ) as str1,d.dayofweek,CONCAT(' / ',DATE_FORMAT(d.starttime,'%h:%i %p'),' - ',DATE_FORMAT(d.endtime,'%h:%i %p')) as str2 
				FROM section b,subjectunit c, sectionsubject d 
					where d.subjectidno = c.idno 
							and d.sectionidno = b.idno "
							.$sectionFilter . ' order by c.code';

  if ($result = $myCon->query($theQuery)) {

    while($row = $result->fetch_assoc()) {
    	$str['idno'] = $row['idno'];
    	$str['name'] = $row['str1'].''.dayName($row['dayofweek']-1).''.$row['str2'];
      $sectionsubjectunits[] = $str;
    }
       $result->close();
}

 if(!isset($_GET['sectionid'])&&isset($_GET['id'])&&isModeIn([MODE_UPDATE])){
 $id = $_GET['id'];
$myCon = createSQLCon();

$theQuery = "SELECT d.idno,d.subjectidno,d.sectionidno
FROM sectionsubject d, studentschedule e
where d.idno = e.sectionsubjectidno
and e.idno = ".$id;

if ($result = $myCon->query($theQuery)) {

while($row = $result->fetch_assoc()) {
$sectionid = $row['sectionidno'];
}
$result->close();
}
} 


$myCon = createSQLCon();
if ($result = $myCon->query("SELECT * FROM section ")) {

	while($row = $result->fetch_assoc()) {
		$sectionlist[] = $row;
	}
	$result->close();
}


$myCon = createSQLCon();
if ($result = $myCon->query("SELECT value FROM text_params where code = 'stdstatus' ")) {

    while($row = $result->fetch_assoc()) {
      $status = explode("//",$row['value']);
    }
    $result->close();
}


if(isset($_GET['id']) && $_GET['id']>0){
	$id = $_GET['id'];
	$myCon = createSQLCon();
	

	if ($result = $myCon->query("SELECT * FROM studentschedule where idNo = $id ")) {

	    while($row = $result->fetch_assoc()) {
	      $object = $row;
	    }
	    $result->close();
  	}
}

 ?>


		<form name="userForm" ng-submit="submitForm()">



			<h6><?php echo $pageName; ?>
					<span ng-show="schedule.idno" ng-init="schedule.idno = <?php echo $_GET['id']; ?>;"  
							style="font-size:small" >
						
					</span>
				</h6>
<h4><?php echo $subPageName; ?></h4>			
<?php //echo loadPageSubmoduleTab(); ?>	

			<fieldset ng-hide="<?php echo isModeIn([MODE_DELETE]); ?>"
					 ng-disabled="<?php echo isModeIn([MODE_VIEW]); ?>">
			
				<div class="row">
					<div class="col-md-4 columns form-group">
						<label>Section</label>
						<select id="sectionFilter" class="u-full-width form-control" required>
						<option>--</option>
						<?php 
							foreach ($sectionlist as $item) {
								$key = $item['idno'];
								$code = $item['code'];
								$selected = '';
								if(isset($sectionid)){
									if($sectionid==$key)
										$selected = 'selected';
								}
								echo "<option value='$key' $selected>$code</option>";
							}
						?>
						</select>
					</div>
					<div class="col-md-4 columns form-group">
						<label>Subject</label>
						<select name="sectionsubjectidno" class="u-full-width form-control" ng-model="schedule.sectionsubjectidno" required>
						
						<?php 
							foreach ($sectionsubjectunits as $item) {
								$key = $item['idno'];
								$name = $item['name'];
								echo "<option value='$key'>$name</option>";
							}
						?>
						</select>
					</div>
					
				</div>
				
								
				<div class="alert alert-warning" role="alert" ng-show="errorMessage">{{errorMessage}}</div>
			</fieldset>
			<?php if(isModeIn([MODE_UPDATE,MODE_CREATE])==='true'){?>
				<div >
					<button type="submit" class="btn btn-primary">Submit</button>
					<a href="?module=<?php 
							$sub = '';
 	
						 	if(isset($_GET['sub'])){
								$sub = '&sub='.$_GET['sub'];		
							}

							echo $_GET['module'].$sub; ?>"
					 	ng-show="<?php echo isModeIn([MODE_CREATE]); ?>">
						<button type="button" class="btn btn-default" >Cancel</button>
					</a>
					<a href="?module=<?php 
							$sub = '';
 	
						 	if(isset($_GET['sub'])){
								$sub = '&sub='.$_GET['sub'];		
							}

							echo $_GET['module'].$sub; ?>&id=<?php echo $_GET['id']; ?>"
						 ng-show="<?php echo isModeIn([MODE_UPDATE]); ?>">
						<button type="button" class="btn btn-default" >Cancel</button>
					</a>
				</div>
			<?php }?>
			<?php if(isModeIn([MODE_DELETE])==='true'){?>
				<div>
					<h4>Are you sure you want to delete this record?</h4>
					<button type="button" class="btn btn-primary" ng-click="delete()">Yes</button>
					<a href="?module=<?php 
							$sub = '';
 	
						 	if(isset($_GET['sub'])){
								$sub = '&sub='.$_GET['sub'];		
							}

							echo $_GET['module'].$sub; 
							?>&id=<?php echo $_GET['id']; ?>">
						<button type="button" class="btn btn-default" >No</button>
					</a>
				</div>
			<?php }?>
			<script>

				$(function(){
					$("#sectionFilter").change(function(){
						var number = $(this).find('option:selected').attr('value');
						window.location.search += '&sectionid='+number;
					});
				});
			
				var postApp = angular.module('myApp', []);


				postApp.controller('postController', function($scope, $http) {


					<?php  if(!empty($object)){?>
						$scope.schedule = JSON.parse('<?php echo json_encode($object);?>');
						<?php }?>

						$scope.delete = function(){

							$http({
								method  : 'POST',
								url     : 'modules/studentreg/subject/schedule.php',
	                  data    : $scope.schedule, //forms user object
	                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
	              })
							.success(function(data) {

								bootbox.alert("<?php echo getCurrentModuleName(); ?> has been removed successfully.", function() {

									window.location = '?module=<?php $sub = '';
	 	
									 	if(isset($_GET['sub'])){
											$sub = '&sub='.$_GET['sub'];		
										}

										echo $_GET['module'].$sub; ?>';
								});
							});
						}

						$scope.submitForm = function() {
							$http({
								method  : 'POST',
								url     : 'modules/studentreg/subject/schedule.php',
	                  data    : $scope.schedule, //forms user object
	                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
	              })
							.success(function(data) {

								if (data.errors) {

									$scope.errorMessage = data.errors;
								} else if(data.idno){
									
									bootbox.alert("<?php
											if(isModeIn([MODE_CREATE])==='true'){
											 	echo getCurrentModuleName().' has been added successfully';
											}
											else{
												echo getCurrentModuleName().' has been updated successfully';
											}
											?>", function() {
											window.location = '?module=<?php $sub = '';
							 	
													 	if(isset($_GET['sub'])){
															$sub = '&sub='.$_GET['sub'];		
														}

														echo $_GET['module'].$sub; ?>&id='+data.idno;
									});
									

								} 
							});

						};
					});


    </script>


</form>
</div>

<?php }?>
