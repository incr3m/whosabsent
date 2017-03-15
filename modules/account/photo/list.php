<?php


function initPage(){
	
$objectId = $_SESSION['objectId'];
$pageName = "User #".getUser($objectId)['usn'];

	setPageHeader('Account Photo');
	addPageSubHeader($pageName);

	setPageControllerName('listCtrl');
	hideMainSearch();
	setReturnPageUrl('?module='.$_GET['module'].'&id='.$_SESSION['objectId']);
	
}

function getPageContents(){

$objectId = $_SESSION['objectId'];
$pageName = "User #".getUser($objectId)['usn'];
$subPageName = "Photos";



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

<!-- <div class="panel panel-success">
  <div class="panel-heading">Upload</div>
  <div class="panel-body">
    <input id="input-dim-2" name="inputdim2[]" type="file" multiple class="file-loading" accept="image/*">
    <script>
    $("#input-dim-2").fileinput({
        uploadUrl: "modules/account/photo/photo.php",
        allowedFileExtensions: ["jpg", "png", "gif"],
        maxImageWidth: 500,
        maxImageHeight: 500
    });
    $('#input-dim-2').on('filebatchuploadcomplete', function(event, files, extra) {

    	console.log(extra);
        console.log('File batch upload complete');
        bootbox.alert("<?php echo getCurrentModuleName(); ?> has been uploaded successfully.", function() {
                        location.reload();
                      });
    });
    
    </script>
  </div>
</div> -->
<div >
<h4><?php echo $subPageName; ?></h4>
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
	<tr>
  <td>
    <a href="#" ng-click="sortType = 'index'; sortReverse = !sortReverse">
      Index
      <span ng-show="sortType == 'index' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'index' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td style="width:145px">
    <a  href="#" ng-click="sortType = 'filename'; sortReverse = !sortReverse">
      Photo
      <span ng-show="sortType == 'filename' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'filename' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td style="text-align:center">Action</td>
  </tr>
</thead>
  <tr class="clickable-row" ng-repeat="x in list | orderBy:sortType:sortReverse | filter:searchList">
    <td>{{x.fileindex}}</td>
    <td><img class="img-account-thumb" ng-src="{{x.photo}}"/></td>
    <td>
      <center>
            <br/>
            <div class="btn btn-success btn-sm" ng-click="unsetAsPrimary(x)" ng-show="x.isprimary === 'YES'">
               Unset Primary Photo
            </div>  
            <div class="btn btn-primary btn-sm" ng-click="setAsPrimary(x)" ng-show="!(x.isprimary === 'YES')">
              <span class="glyphicon glyphicon-ok"></span>
               Set as Primary
            </div>  
            <br/>
            <br/>
            <div class="btn btn-danger btn-sm" ng-click="delete(x)" ng-hide="x.isprimary === 'YES'">
              <span class="glyphicon glyphicon-remove-sign"></span>
               Delete
            </div>  
      </center>
    </td>
  </tr>
</table>
</div>

<script>

var app = angular.module('myApp', []);
reloadApp = function(){
app.controller('listCtrl', function ($scope, $http){

                $scope.itemSelected = function(id){
                  
                  window.location = "?module=<?php echo getCurrentModule(); ?>&id="+id;
                };
                $scope.setAsPrimary = function(photo){ 
                  bootbox.confirm("Set photo at index "+photo.fileindex+" as primary?", function(result) {
                    if(result){
                      
                       $http({
                            method  : 'POST',
                            url     : 'modules/account/photo/photo.php',
                                data    : {idno:photo.idno,mode:'setprimary'}, //forms user object
                                headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                            })
                          .success(function(data) {
                            
                            bootbox.alert("Photo index "+photo.fileindex+" is now the primary photo.", function() {
                                location.reload();
                              });
                            
                          });
                    }
                    
                  }); 
                }
                $scope.unsetAsPrimary = function(photo){ 
                    bootbox.confirm("Unset photo at index "+photo.fileindex+" as primary?", function(result) {
                      if(result){
                        
                         $http({
                              method  : 'POST',
                              url     : 'modules/account/photo/photo.php',
                                  data    : {idno:photo.idno,mode:'unsetprimary'}, //forms user object
                                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                              })
                            .success(function(data) {
                              
                              bootbox.alert("Photo index "+photo.fileindex+" has been removed as primary photo.", function() {
                                  location.reload();
                                });
                              
                            });
                      }
                      
                    }); 
                  }
                $scope.delete = function(photo){ 

                  bootbox.confirm("Remove photo at index "+photo.fileindex+" ?", function(result) {
                    if(result){
                      
                       $http({
                            method  : 'POST',
                            url     : 'modules/account/photo/photo.php',
                                data    : {idno:photo.idno,mode:'delete'}, //forms user object
                                headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                            })
                          .success(function(data) {
                            console.log('data');
                            console.log(data);
                            if(data.referenceno){
                              $http({
                                method: 'GET',
                                url: data.referenceno
                              }).then(function successCallback(response) {
                                  bootbox.alert("Photo index "+photo.fileindex+" has been removed successfully.", function() {
                                    location.reload();
                                  });
                                }, function errorCallback(response) {
                                  bootbox.alert("Something happened!", function() {
                                  });
                                });
                              
                            }
                            else{
                              bootbox.alert("Something happened!", function() {
                                location.reload();
                              });
                            }
                            
                            
                          });
                    }
                    
                  }); 

                }

                $http({
                  method  : 'POST',
                  url     : 'modules/account/photo/photo.php',
                  data    : {}, //forms user object
                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                })
                .success(function(data) {
                  if (data.list) {
                      
                      $scope.list = data.list;
                    } 
                  });
            });
              
}

reloadApp();
</script>


<?php 
}?>