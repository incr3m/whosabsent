	
<?php

$pageName = 'Teacher';
$accounts = array();
$status = array();
$object = array();

$myCon = createSQLCon();
if ($result = $myCon->query("SELECT idno,concat(lastname,', ',firstname,middlename) as name FROM account")) {

    while($row = $result->fetch_assoc()) {
      $accounts[] = $row;
    }
    $result->close();
}

$myCon = createSQLCon();
if ($result = $myCon->query("SELECT value FROM text_params where code = 'departments' ")) {

    while($row = $result->fetch_assoc()) {
      $status = explode("//",$row['value']);
    }
    $result->close();
}


if(isset($_GET['id']) && $_GET['id']>0){
	$id = $_GET['id'];
	$myCon = createSQLCon();
	

	if ($result = $myCon->query("SELECT * FROM teacher where idNo = $id ")) {

	    while($row = $result->fetch_assoc()) {
	      $object = $row;
	    }
	    $result->close();
  	}
}

loadPropertiesPageControls();
 ?>




	<div ng-app="postApp" ng-controller="postController">
		<form name="userForm" ng-submit="submitForm()">

			<h1><?php echo $pageName; ?>
			<span ng-show="teacher.idno" ng-init="teacher.idno = <?php echo $_GET['id']; ?>;" >
				<?php if ($_GET['id']>0) echo '#'.$_GET['id'];?>
			</span>
			</h1>

			<fieldset ng-hide="<?php echo isModeIn([MODE_DELETE]); ?>"
					 ng-disabled="<?php echo isModeIn([MODE_VIEW]); ?>">
			
				<div class="row">
					<div class="col-md-6 columns form-group">
						<label>Account</label>
						<select name="account" class="u-full-width form-control" ng-model="teacher.accountidno" required>
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
						<label>Date Employed</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type='text' name="dateemployed" class="u-full-width form-control"
							 ng-model="teacher.dateemployed">
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
						<label>Department</label>
						<select name="department" class="u-full-width form-control" ng-model="teacher.department" required>
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
					<h2>Are you sure you want to delete this record?</h2>
					<button type="button" class="btn btn-primary" ng-click="delete()">Yes</button>
					<a href="?module=<?php echo $_GET['module']; ?>&id=<?php echo $_GET['id']; ?>">
						<button type="button" class="btn btn-default" >No</button>
					</a>
				</div>
			<?php }?>
			<script>

				var postApp = angular.module('postApp', []);


				postApp.controller('postController', function($scope, $http) {


					<?php  if(!empty($object)){?>
						$scope.teacher = JSON.parse('<?php echo json_encode($object);?>');
						<?php }?>

						$scope.delete = function(){

							$http({
								method  : 'POST',
								url     : 'modules/teacherreg/teacherreg.php',
	                  data    : $scope.teacher, //forms user object
	                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
	              })
							.success(function(data) {
								window.location = '?module=<?php echo $_GET['module']; ?>';
							});
						}

						$scope.submitForm = function() {
							$http({
								method  : 'POST',
								url     : 'modules/teacherreg/teacherreg.php',
	                  data    : $scope.teacher, //forms user object
	                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
	              })
							.success(function(data) {

								if (data.errors) {

									$scope.errorMessage = data.errors;
								} else if(data.idno){
									window.location = '?module=<?php echo $_GET['module']; ?>&id='+data.idno;

								} 
							});

						};
					});


    </script>


</form>
</div>
</div>


