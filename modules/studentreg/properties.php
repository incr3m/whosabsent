	
<?php


function initPage(){

	$objectId = $_SESSION['objectId'];
	//$pageName = "User #".getUser($objectId)['usn'];

	setPageHeader('USER');
	addPageSubHeader('Detail');

	setPageControllerName('postController');
}

function getPageContents(){
$pageName = ATTR_USER_NAME;
$accounts = array();
$status = array();
$object = array();

$myCon = createSQLCon();
if ($result = $myCon->query("SELECT idno,concat(lastname,', ',firstname,' ',middlename) as name FROM account")) {

    while($row = $result->fetch_assoc()) {
      $accounts[] = $row;
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
	

	if ($result = $myCon->query("SELECT a.*,b.usn FROM enrolledstudent a,account b where a.accountidno = b.idno 
									and a.idno = $id ")) {

	    while($row = $result->fetch_assoc()) {
	      $object = $row;
	    }
	    $result->close();
  	}
}

 ?>


		<form name="userForm" ng-submit="submitForm()">


			<h6><?php echo $pageName; ?>
					<span ng-show="student.idno" ng-init="student.idno = <?php echo $_GET['id']; ?>;" style="font-size:small"  >
						<?php if(isRoleIn([ROLE_ADMIN])==='true'){?>		
							USN# {{student.usn}}
						<?php }?>
					</span>
				</h6>
			
<?php //echo loadPageSubmoduleTab(); ?>	

			<fieldset ng-hide="<?php echo isModeIn([MODE_DELETE]); ?>"
					 ng-disabled="<?php echo isModeIn([MODE_VIEW]); ?>">
			
				<div class="row">
					<div class="col-md-6 columns form-group">
						<label>Account</label>
						<select name="account" class="u-full-width form-control" ng-model="student.accountidno" required>
						<?php 
							foreach ($accounts as $acct) {
								$key = $acct['idno'];
								$name = $acct['name'];
								echo "<option value='$key'>$name</option>";
							}
						?>
						</select>
					</div>
					<div class="col-md-6 columns form-group">
						<label>Date Registered</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type='text' name="dateenrolled" class="u-full-width form-control"
							 ng-model="student.dateenrolled">
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
						<script type="text/javascript">
				            $(function () {
				            	var dateNow = new Date();
				                $('#datetimepicker1').datetimepicker({
				                	format: 'YYYY-MM-DD',
				                	
				                }).on('dp.change',function(){
				                	$('#datetimepicker1 input').trigger('input');
				                });
				            });
				        </script>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 columns form-group">
						<label>Status</label>
						<select name="status" class="u-full-width form-control" ng-model="student.status" required>
							<?php 
							foreach ($status as $sts) {
								echo "<option value='$sts'>$sts</option>";
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
					<a href="?module=<?php echo $_GET['module']; ?>"
					 	ng-show="<?php echo isModeIn([MODE_CREATE]); ?>">
						<button type="button" class="btn btn-default" >Cancel</button>
					</a>
					<a href="?module=<?php echo $_GET['module']; ?>&id=<?php echo $_GET['id']; ?>"
						 ng-show="<?php echo isModeIn([MODE_UPDATE]); ?>">
						<button type="button" class="btn btn-default" >Cancel</button>
					</a>
				</div>
			<?php }?>
			<?php if(isModeIn([MODE_DELETE])==='true'){?>
				<div>
					<h4>Are you sure you want to delete this record?</h4>
					<button type="button" class="btn btn-primary" ng-click="delete()">Yes</button>
					<a href="?module=<?php echo $_GET['module']; ?>&id=<?php echo $_GET['id']; ?>">
						<button type="button" class="btn btn-default" >No</button>
					</a>
				</div>
			<?php }?>
			<script>

				var postApp = angular.module('myApp', []);


				postApp.controller('postController', function($scope, $http) {


					<?php  if(!empty($object)){?>
						$scope.student = JSON.parse('<?php echo json_encode($object);?>');
						<?php }?>

						$scope.delete = function(){

							$http({
								method  : 'POST',
								url     : 'modules/studentreg/studentreg.php',
	                  data    : $scope.student, //forms user object
	                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
	              })
							.success(function(data) {
								
								bootbox.alert("<?php echo getCurrentModuleName(); ?> has been removed successfully.", function() {
									  window.location = '?module=<?php echo $_GET['module']; ?>';
									});
								
							});
						}

						$scope.submitForm = function() {
							$http({
								method  : 'POST',
								url     : 'modules/studentreg/studentreg.php',
	                  data    : $scope.student, //forms user object
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
									  window.location = '?module=<?php echo $_GET['module']; ?>&id='+data.idno;
									});

								} 
							});

						};
					});


    </script>

<a style="float:right" href="?module=stdreg&sub=sched" class="btn btn-default btn-sm">
  Proceed to Schedule <span class="glyphicon glyphicon-forward"></span>
</a>	
<div style="clear:both"/>
</form>
</div>
<?php }?>

