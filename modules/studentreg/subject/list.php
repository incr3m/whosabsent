<?php
function initPage(){
	$objectId = $_SESSION['objectId'];
	$pageName = "User #".getCurrentUser()['username'];
	setPageHeader(strtoupper($pageName));
	addPageSubHeader('Schedule List');

	setPageControllerName('listCtrl');
}

function getPageContents(){
$objectId = $_SESSION['objectId'];
$pageName = "User #".getCurrentUser()['username'];
$subPageName = "Schedule";



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
    include 'modules/studentreg/subject/properties.php';
    return;

}


 ?>



<table class="table table-hover table-bordered table-striped">
<thead>
  <td>
    <a href="#" ng-click="sortType = 'sectioncode'; sortReverse = !sortReverse">
      Section
      <span ng-show="sortType == 'sectioncode' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'sectioncode' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'subjectcode'; sortReverse = !sortReverse">
      Subject
      <span ng-show="sortType == 'subjectcode' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'subjectcode' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'day'; sortReverse = !sortReverse">
      Day
      <span ng-show="sortType == 'day' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'day' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'starttime'; sortReverse = !sortReverse">
      Start Time
      <span ng-show="sortType == 'starttime' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'starttime' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'endtime'; sortReverse = !sortReverse">
      End Time
      <span ng-show="sortType == 'endtime' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'endtime' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
</thead>
  <tr class="clickable-row" ng-repeat="x in list | orderBy:sortType:sortReverse | filter:searchList" ng-click="itemSelected(x.idno)">
    <td>{{x.sectioncode}}</td>
    <td>{{x.subjectcode}}</td>
    <td>{{x.day}}</td>
    <td>{{x.starttime}}</td>
    <td>{{x.endtime}}</td>

  </tr>
</table>


<script>
var app = angular.module('myApp', []);
app.controller('listCtrl', function ($scope, $http){

                $scope.itemSelected = function(id){
                  
                  window.location = "?module=<?php echo getCurrentModule(); ?>&id="+id;
                };

                $http({
                  method  : 'POST',
                  url     : 'modules/studentreg/subject/schedule.php',
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