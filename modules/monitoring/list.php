<?php

function initPage(){
	$pageName = 'Log List';
	setPageHeader(strtoupper($pageName));
	addPageSubHeader('Attentance Monitoring');
	hideControls();
	setPageControllerName('listCtrl');
}

function getPageContents(){




if(isset($_GET['id'])){

}
else{
  unset($_SESSION['objectId']);
}


 ?>

 <div class="row">
 <div class="col-md-4 columns form-group">
						<label>Start Date</label>
						<div class='input-group date' id='datetimepicker1'>
		                    <input type='text' id="startdate" class="u-full-width form-control">
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
				                	//$('#datetimepicker1 input').trigger('input');
				                	/* var startdate = encodeURI($('#startdate').val());
				                	//alert(startdate);
				                	window.location.search += '&startdate='+startdate; */
				                });
				            });
				        </script>
					</div>
					<div class="col-md-4 columns form-group">
						<label>End Date</label>
						<div class='input-group date' id='datetimepicker2'>
		                    <input type='text' id="enddate" class="u-full-width form-control">
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
						<script type="text/javascript">
				            $(function () {
				            	var dateNow = new Date();
				                $('#datetimepicker2').datetimepicker({
				                	format: 'YYYY-MM-DD',
				                	
				                }).on('dp.change',function(){
				                	//$('#datetimepicker1 input').trigger('input');
				                	/* var startdate = encodeURI($('#enddate').val());
				                	//alert(startdate);
				                	window.location.search += '&startdate='+startdate; */
				                	//window.location.search += '&endDate='+number; 
				                });
				            });
				        </script>
					</div>
					<div class="col-md-2 columns form-group"><button style="margin-top:25px" id="filterbtn" class="form-control">Filter</button></div>
 </div>

<table class="table table-hover table-bordered table-striped">
<thead>
<td style="width:145px">
  
      Photo
    
  </td>
  <td>
    <a href="#" ng-click="sortType = 'idno'; sortReverse = !sortReverse">
      No
      <span ng-show="sortType == 'idno' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'idno' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
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
    <a href="#" ng-click="sortType = 'section'; sortReverse = !sortReverse">
      Section
      <span ng-show="sortType == 'section' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'section' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'subject'; sortReverse = !sortReverse">
      Subject
      <span ng-show="sortType == 'subject' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'subject' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'logindate'; sortReverse = !sortReverse">
      Login Date
      <span ng-show="sortType == 'logindate' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'logindate' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'logoutdate'; sortReverse = !sortReverse">
      Logout Date
      <span ng-show="sortType == 'logoutdate' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'logoutdate' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
  <td>
    <a href="#" ng-click="sortType = 'remarks'; sortReverse = !sortReverse">
      Remarks
      <span ng-show="sortType == 'remarks' && sortReverse" class="fa fa-caret-down"></span>
      <span ng-show="sortType == 'remarks' && !sortReverse" class="fa fa-caret-up"></span>
    </a>
  </td>
</thead>
  <tr title="Open calendar" class="clickable-row" ng-repeat="x in list | orderBy:sortType:sortReverse | filter:searchList" ng-click="itemSelected(x.accountidno)">
    <td><img class="img-account-thumb" src="<?php echo BUCKETPATH;?>{{x.photo}}"/></td>
    <td>{{x.idno}}</td>
    <td>{{x.usn}}</td>
    <td>{{x.name}}</td>
    <td>{{x.section}}</td>
    <td>{{x.subject}}</td>
    <td>{{x.logindate}}</td>
    <td>{{x.logoutdate}}</td>
    <td>{{x.remarks}}</td>

  </tr>
</table>

<script>

				        $(function(){

					        $('#filterbtn').on('click',function(){
					        	var startdate = encodeURI($('#startdate').val());
					        	var enddate = encodeURI($('#enddate').val());
					        	var err = '';
								if(startdate=='')
									err += 'Start Date is required.';
								if(enddate=='')
									err +=  (' End Date is required.');

								if(!(err=='')){
									alert(err);
								}
								else{
					        		window.location.search += '&startdate='+startdate+'&enddate='+enddate;
								} 
			                	 
					        });
					        <?php if(isset($_GET['startdate'])){
                  					echo "$('#startdate').val('".$_GET['startdate']."');";								
								}if(isset($_GET['enddate'])){
                  					echo "$('#enddate').val('".$_GET['enddate']."');";								
								}?>
				        });
var app = angular.module('myApp', []);
app.controller('listCtrl', function ($scope, $http){

                $http({
                  method  : 'POST',
                  url     : 'modules/monitoring/monitoring.php?q=1<?php if(isset($_GET['startdate'])){
                  					echo '&startdate='.$_GET['startdate'];								
								}if(isset($_GET['enddate'])){
                  					echo '&enddate='.$_GET['enddate'];								
								}?>',
                  data    : {}, //forms user object
                  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
                })
                .success(function(data) {
                  if (data.list) {
                      
                      $scope.list = data.list;
                    } 
                  });

                $scope.itemSelected = function(id){
                    
                    window.location = "modules/monitoring/calendar.php?accountID="+id;
                  };
            });
              
</script>

<?php }?>