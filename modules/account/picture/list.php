<?php

$pageKey = 'imgs';
$pageName = 'Students';

if(isset($_GET['id'])){
  $recId = $_GET['id'];

  registerSubmodule(array(
    'key' =>'default',
    'name' => 'Details',
    'includepage' => 'modules/studentreg/properties.php'));

  registerSubmodule(array(
    'key' =>'imgs',
    'name' => 'Images',
    'includepage' => 'modules/account/picture/list.php'));


 if($submodule = getRequestedSubmodule()){
    if($pageKey === $submodule['key']){
    }
    else{
      include $submodule['includepage'];
      exit;  
    }
  }
}  

loadPropertiesPageControls();

 ?>

<div ng-app="myApp" ng-controller="listCtrl">


<h1><?php echo $pageName; ?></h1>

<?php// echo loadPageSubmoduleTab(); ?>

<table class="table table-hover">
<thead>
	<td>#</td><td>Name</td><td>Date Enrolled</td><td>Status</td>
</thead>
  <tr class="clickable-row" ng-repeat="x in list" ng-click="itemSelected(x.idno)">
    <td>{{x.idno}}</td>
    <td>{{x.name}}</td>
    <td>{{x.dateenrolled}}</td>
    <td>{{x.status}}</td>

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
                  url     : 'modules/studentreg/studentreg.php',
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