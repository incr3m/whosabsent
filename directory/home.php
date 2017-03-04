<?php 

function initPage(){

	//$pageName = "User #".getUser($objectId)['usn'];

	setPageHeader('HOME');
	addPageSubHeader('Dashboard');

	setPageControllerName('accountsCtrl');
	hideMainSearch();
}

function getPageContents(){?>
<div class="jumbotron">
  <h2>Welcome <?php $curUser = getCurrentUser(); echo $curUser['name'];?></h2>
  <p><span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span>  Please select a module from directory to get started.</p>
  <p></p>

</div>
<?php if(isRoleIn([ROLE_STUDENT,ROLE_TEACHER])==='false'){ ?>	
	<div class="jumbotron">
	  <h2>Mobile Face Recognition Device</h2>
	  <p>Click on download servers below to get the app <br>
	  <span class="glyphicon glyphicon-download" aria-hidden="true" style="margin-left:20px"></span><a href="http://www.mediafire.com/download/qwzxjeilfbrmmts/Mobile+Face+Recognition_2.0.apk" style="color:blue" target="_blank"> Mediafire</a></p>
	  <p></p>
	
</div>
<?php }?>

<span style="font-size:larger">Recent User Activities</span><h4>(Recent 10 logs)</h4>

<div class="alert alert-info" style="display:none">
    <p>Sort Type: {{ sortType }}</p>
    <p>Sort Reverse: {{ sortReverse }}</p>
    <p>Search Query: {{ searchList }}</p>
  </div>

<form>
    <div class="form-group">
      <div class="input-group">
        <div class="input-group-addon"><i class="fa fa-search"></i></div>

        <input type="text" class="form-control" placeholder="Filter list" ng-model="searchList">

      </div>      
    </div>
  </form>

<table class="table table-hover table-bordered table-striped">
<thead>	
  
  <td>
    <a href="#" ng-click="sortType = 'logdate'; sortReverse = !sortReverse">
      Log Date
      <span ng-show="sortType == 'logdate' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'logdate' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'name'; sortReverse = !sortReverse">
      User
      <span ng-show="sortType == 'name' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'name' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>

  <td>
    <a href="#" ng-click="sortType = 'message'; sortReverse = !sortReverse">
      Message
      <span ng-show="sortType == 'message' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'message' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  
</thead>
  <tr class="clickable-row" ng-repeat="x in activities | orderBy:sortType:sortReverse | filter:searchList" >
    <td>{{ x.logdate }}</td>
    <td>{{ x.name }}</td>
    <td>{{ x.message }}</td>

  </tr>
</table>

</div>

<script>

$(document).on("click", ".alert", function(e) {
            bootbox.alert("Hello world!", function() {
                console.log("Alert Callback");
            });
        });

var app = angular.module('myApp', []);
app.controller('accountsCtrl', function ($scope, $http){

                

                $http({
                  method  : 'POST',
                  url     : 'directory/activities.php',
                  data    : {mode:'list'}, //forms user object
                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                })
                .success(function(data) {
                	//alert(JSON.stringify(data));
                  if (data.activities) {
                      
                      $scope.activities = data.activities;
                    } 
                  });
            });
              
</script>

<?php }?>