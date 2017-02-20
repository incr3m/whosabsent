<?php

$pageName = 'Teachers';

if(isset($_GET['id'])){
  $recId = $_GET['id'];
  $_SESSION['objectId'] = $recId;

  registerSubmodule(array(
    'key' =>'default',
    'name' => 'Details',
    'includepage' => 'modules/teacherreg/properties.php'));



 if($submodule = getRequestedSubmodule()){
    include $submodule['includepage'];
    return;
  }  

}
else{
  unset($_SESSION['objectId']);
}

loadPropertiesPageControls();

 ?>

<div ng-app="myApp" ng-controller="listCtrl"> 
<h1><?php echo $pageName; ?></h1>


<table class="table table-hover">
<thead>
	<td>#</td><td>Name</td><td>Date Employed</td><td>Department</td>
</thead>
  <tr class="clickable-row" ng-repeat="x in list" ng-click="itemSelected(x.idno)">
    <td>{{x.idno}}</td>
    <td>{{x.name}}</td>
    <td>{{x.dateemployed}}</td>
    <td>{{x.department}}</td>

  </tr>
</table>

</div>

<script>
var app = angular.module('myApp', []);
app.controller('listCtrl', function ($scope, $http){

                $scope.itemSelected = function(id){
                  
                  window.location = "?module=<?php echo $_GET['module']; ?>&id="+id;
                };

                $http({
                  method  : 'POST',
                  url     : 'modules/teacherreg/teacherreg.php',
                  data    : {}, //forms user object
                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                })
                .success(function(data) {
                	
                  if (data.list) {
                      
                      $scope.list = data.list;
                    } 
                  });
            });
              
</script>