	
<?php

function initPage(){
	
$objectId = $_SESSION['objectId'];
$pageName = "User #".getUser($objectId)['usn'];

	setPageHeader('Accounts');
	addPageSubHeader($pageName);

	setPageControllerName('postController');
}

function getPageContents(){
$account = array();

if(isset($_GET['id']) && $_GET['id']>0){
	$id = $_GET['id'];
	$myCon = createSQLCon();
	

	if ($result = $myCon->query("SELECT *,concat('".BUCKETPATH."',coalesce((select filename from accountphoto where accountidno = a.idno and isprimary = 'YES'),'noimage_png')) as photo FROM account a where idno = $id ")) {

	    while($row = $result->fetch_assoc()) {
	      $account = $row;
	    }
	    $result->close();
  	}
}



 ?>


	
	
		<form name="userForm" ng-submit="submitForm()">

			<h6>Account 
				<span ng-show="account.idno" ng-init="account.idno = <?php echo $_GET['id']; ?>;" style="font-size:small" >
				
					USN# {{account.usn}}
				</span>
			</h6>
<div class="row">
				<div class="col-md-9 col-sm-12">
			<fieldset ng-hide="<?php echo isModeIn([MODE_DELETE]); ?>"
					 ng-disabled="<?php echo isModeIn([MODE_VIEW]); ?>">
				
				<div class="row">
					<div class="col-md-4 columns form-group">
						<label>First Name</label>
						<input type="text" name="firstname" class="u-full-width form-control" ng-model="account.firstname" required>
					</div>
					<div class="col-md-4 columns form-group">
						<label>Middle Name</label>
						<input type="text" name="middlename" class="u-full-width form-control" ng-model="account.middlename">
					</div>
					<div class="col-md-4 columns form-group">
						<label>Last Name</label>
						<input type="text" name="lastname" class="u-full-width form-control" ng-model="account.lastname" required>
					</div>
				</div>
				<div class="row">
				<!-- <?php if(isRoleIn([ROLE_ADMIN])==='true'){?>		
					<div class="col-md-6 columns form-group">
						<label>USN</label>
						<input type="text" name="usn" class="u-full-width form-control" ng-model="account.usn" required>
					</div>
					<?php }?> -->
					<!-- <div class="col-md-6 columns form-group">
						<label>Email</label>
						<input type="text" name="email" class="u-full-width form-control" ng-model="account.email">
					</div> -->
				</div>
				<div class="row">
					<!-- <div class="col-md-6 columns form-group">
						<label>Birthday</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type="text" name="birthday" class="u-full-width form-control" ng-model="account.birthday">
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
					</div> -->
				</div>
				<!-- <div class="form-group">
					<label>Address</label>
					<textarea name="address" class="u-full-width form-control" ng-model="account.address"></textarea>
				</div> -->
				
					<div class="row">
						<?php if(isRoleIn([ROLE_ADMIN])==='true'){?>		
							<div class="col-md-4 form-group">
								<label>Username</label>
								<input type="text" name="username" class="form-control" ng-model="account.username" required>
							</div>
						

						<div class="col-md-3 form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" ng-model="account.password" required>
						</div>
						<div class="col-md-3 form-group">
							<label>Confirm Password</label>
							<input type="password" name="password" class="form-control" ng-model="account.confirmpassword" ng-init="account.confirmpassword=account.password">
						</div>
						<?php }?>
						<?php if(isRoleIn([ROLE_ADMIN])==='true'){?>		
							<div class="col-md-2 columns form-group">
								<label>Role</label>
								<select name="account" class="u-full-width form-control" ng-model="account.roles" required>
									<option value='ADMIN'>Admin</option>		
									<option value='STUDENT' selected>Student</option>		
									<option value='TEACHER'>Teacher</option>		
								</select>
							</div>
						<?php }?>
					</div>

				<div class="alert alert-warning" role="alert" ng-show="errorMessage">{{errorMessage}}</div>
				
				
				
			</fieldset>
			
			<?php if(isModeIn([MODE_UPDATE,MODE_CREATE])==='true'){?>
			
				<div >
					<button type="submit" class="btn btn-primary">Submit</button>
					<a href="?module=acct"
					 	ng-show="<?php echo isModeIn([MODE_CREATE]); ?>">
						<button type="button" class="btn btn-default" >Cancel</button>
					</a>
					<a href="?module=acct&id=<?php echo $_GET['id']; ?>"
						 ng-show="<?php echo isModeIn([MODE_UPDATE]); ?>">
						<button type="button" class="btn btn-default" >Cancel</button>
					</a>
				</div>
			<?php }?>
			
			<?php if(isModeIn([MODE_DELETE])==='true'){?>
				<div>
					<h4>Are you sure you want to delete this record?</h4>
					<button type="button" class="btn btn-primary" ng-click="delete()">Yes</button>
					<a href="?module=acct&id=<?php echo $_GET['id']; ?>">
						<button type="button" class="btn btn-default" >No</button>
					</a>
				</div>
			<?php }?>
			<script>

				var postApp = angular.module('myApp', []);


				postApp.controller('postController', function($scope, $http) {


					<?php  if(!empty($account)){?>
						$scope.account = JSON.parse('<?php echo json_encode($account);?>');
						<?php }?>

						$scope.delete = function(){
							$http({
								method  : 'POST',
								url     : 'modules/account/account.php',
	                  data    : $scope.account, //forms user object
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
								url     : 'modules/account/account.php',
	                  data    : $scope.account, //forms user object
	                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
	              })
							.success(function(data) {//alert(data);
								if (data.errors) {

									$scope.errorMessage = data.errors;
								} else if(data.idno){
									bootbox.alert("<?php
											if(isModeIn([MODE_CREATE])==='true'){
											 	echo getCurrentModuleName().' has been registered successfully';
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
    </div>
			<div class="col-md-3 col-sm-12" style="
    text-align: center;
    background: #b76767;
    padding-bottom: 10px;
				">
				<div style="color:white;font-weight:bold">Display Photo</div>
					
					<a title="Proceed to photos" href="?module=acct&sub=imgs">
					<img class="img-account-thumb" src="{{account.photo}}"/>
</a>
				</div>
				</div>
				<?php if(isModeIn([MODE_DELETE,MODE_UPDATE,MODE_CREATE])==='false'){?>
	<!-- <a class="btn btn-default btn-sm btn-edit" title="View Attendance" href="modules/monitoring/calendar.php?accountID={{account.idno}}">
					<span class="glyphicon glyphicon-calendar"></span> View Attendance</a> -->
          <?php 
          if ($result = $myCon->query("SELECT * FROM enrolledstudent a where accountidno = $id")) {

            while($row = $result->fetch_assoc()) {
              $student = $row;
            }
            $result->close();
          }
            if(isset($student)){?>
          	<a class="btn btn-default btn-sm btn-edit" title="Student Detail" href="?module=stdreg&id=<?php echo $student['idno'] ?>">
          					<span class="glyphicon glyphicon-user"></span>Student Details</a>
          					<?php }?>
					<?php }?>
<div style="clear:both"/>
</form>
</div>

<?php }?>

