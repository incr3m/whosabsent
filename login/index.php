<?php include 'directory/nav.php';?>

<div class="container">
<div class="blend-pink-yellow-dark" style="overflow:hidden;position:absolute;top:0px;left:0px;right:0px;bottom:0px">
    <img src="resources/amapic.jpg" style="width:100%;min-width:1300px"/>
    
</div>
  <!-- columns should be the immediate child of a .row -->

  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <center>
        <!-- <img src="https://upload.wikimedia.org/wikipedia/en/c/c8/AMA_University_logo.png"/>-->

      </center>
      <div class="panel panel-danger" style="margin-top:50px">
        <div class="panel-heading"><h4>Login</h4></div>
        <div class="panel-body" ng-app="postApp" ng-controller="postController">
          <form name="userForm" ng-submit="submitForm()">
          
            <div class="form-group">
              <label>User ID</label>
              <input type="text" name="username" class="form-control" ng-model="user.username">
              <span ng-show="errorUserName">{{errorUserName}}</span>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control" ng-model="user.password">
              <span ng-show="errorPassword">{{errorPassword}}</span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <script>
              // Defining angularjs application.
              var postApp = angular.module('postApp', []);
              // Controller function and passing $http service and $scope var.
              postApp.controller('postController', function($scope, $http) {
                // create a blank object to handle form data.
                $scope.user = {};
                // calling our submit function.
                $scope.submitForm = function() {
                  // Posting data to php file
                  $http({
                    method  : 'POST',
                    url     : 'login/submit.php',
                    data    : $scope.user, //forms user object
                    headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                  })
                  .success(function(data) {
                    
                    if (data.errors) {
                        // Showing errors.
                        $scope.errorUserName = data.errors.username;
                        $scope.errorPassword = data.errors.password;
                      } else {
                        //$scope.message = data.message;
                        //location.reload();
                        window.location = '?home';
                      } 
                    });
                };
              });
            </script>


  </form>
  </div>
</div>


</div>
</div>

</div>
