<?php

$objectId = $_SESSION['objectId'];
$pageName = "Teacher#$objectId Schedule";



if(isset($_GET['id'])){
  $recId = $_GET['id'];
  

 /* registerSubmodule(array(
    'key' =>'default',
    'name' => 'Details',
    'includepage' => 'modules/studentreg/properties.php'));

  registerSubmodule(array(
    'key' =>'imgs',
    'name' => 'Images',
    'includepage' => 'modules/account/picture/list.php'));


 if($submodule = getRequestedSubmodule()){
    include $submodule['includepage'];
    return;
  }  */
    include 'modules/teacherreg/subject/properties.php';
    return;

}


loadPropertiesPageControls();

 ?>

<div ng-app="myApp" ng-controller="listCtrl">


<h3><?php echo $pageName; ?></h3>


<table class="table table-hover">
<thead>
	<td>#</td><td>Section Code</td><td>Subject</td><td>Day</td><td>Start Time</td><td>End Time</td>
</thead>
  <tr class="clickable-row" ng-repeat="x in list" ng-click="itemSelected(x.idno)">
    <td>{{x.idno}}</td>
    <td>{{x.sectioncode}}</td>
    <td>{{x.subjectcode}}</td>
    <td>{{x.day}}</td>
    <td>{{x.starttime}}</td>
    <td>{{x.endtime}}</td>

  </tr>
</table>

</div>

<script>
var app = angular.module('myApp', []);
app.controller('listCtrl', function ($scope, $http){

                $scope.itemSelected = function(id){
                  
                  window.location = "?module=<?php echo getCurrentModule(); ?>&id="+id;
                };

                $http({
                  method  : 'POST',
                  url     : 'modules/teacherreg/subject/schedule.php',
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