<?php

function initPage(){
	setPageHeader('ACCOUNTS');
	addPageSubHeader('Account List');
	
	setPageControllerName('accountsCtrl');
}

function getPageContents(){
	




 ?>

 





<table class="table table-hover table-bordered table-striped">
<thead>	
  <td style="width:145px">
  
      Photo
    
  </td>
  <td>
    <a href="#" ng-click="sortType = 'username'; sortReverse = !sortReverse">
      User ID
      <span ng-show="sortType == 'username' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'username' && !sortReverse" class="fa fa-caret-up"></span>
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
    <a href="#" ng-click="sortType = 'dateadded'; sortReverse = !sortReverse">
      Date Added
      <span ng-show="sortType == 'dateadded' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'dateadded' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'roles'; sortReverse = !sortReverse">
      Role
      <span ng-show="sortType == 'roles' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'roles' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
</thead>
  <tr class="clickable-row" ng-repeat="x in accounts | orderBy:sortType:sortReverse | filter:searchList" ng-click="itemSelected(x.idno)">
    <td><img class="img-account-thumb" src="{{x.photo}}"/></td>
    <td>{{ x.username }}</td>
    <td>{{ x.name }}</td>
    <td>{{ x.dateadded }}</td>
    <td>{{ x.roles }}</td>

  </tr>
</table>


<script>

$(document).on("click", ".alert", function(e) {
            bootbox.alert("Hello world!", function() {
                console.log("Alert Callback");
            });
        });

var app = angular.module('myApp', []);
app.controller('accountsCtrl', function ($scope, $http){

                $scope.itemSelected = function(id){
                  
                  window.location = "?module=acct&id="+id;
                };

                $http({
                  method  : 'POST',
                  url     : 'modules/account/account.php',
                  data    : {}, //forms user object
                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                })
                .success(function(data) {
                	
                  if (data.accounts) {
                      
                      $scope.accounts = data.accounts;
                    } 
                  });
            });
              
</script>


<?php 
}?>