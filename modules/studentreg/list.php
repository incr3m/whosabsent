<?php

function initPage(){
	$pageName = ATTR_USER_NAME.'s';
	setPageHeader(strtoupper($pageName));
	addPageSubHeader(ATTR_USER_NAME.' List');

	setPageControllerName('listCtrl');
}

function getPageContents(){




if(isset($_GET['id'])){
  $recId = $_GET['id'];
  $_SESSION['objectId'] = $recId;

  registerSubmodule(array(
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
  }  

}
else{
  unset($_SESSION['objectId']);
}


 ?>


<table class="table table-hover table-bordered table-striped">
<thead>
  <td>
    <a href="#" ng-click="sortType = 'usn'; sortReverse = !sortReverse">
      USN
      <span ng-show="sortType == 'usn' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'usn' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'name'; sortReverse = !sortReverse">
      Name
      <span ng-show="sortType == 'name' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'name' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'dateenrolled'; sortReverse = !sortReverse">
      Date Registered
      <span ng-show="sortType == 'dateenrolled' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'dateenrolled' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'status'; sortReverse = !sortReverse">
      Status
      <span ng-show="sortType == 'status' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'status' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
</thead>
  <tr class="clickable-row" ng-repeat="x in list | orderBy:sortType:sortReverse | filter:searchList" ng-click="itemSelected(x.idno)">
    <td>{{x.usn}}</td>
    <td>{{x.name}}</td>
    <td>{{x.dateenrolled}}</td>
    <td>{{x.status}}</td>

  </tr>
</table>

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

<?php }?>