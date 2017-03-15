<?php

function initPage(){
	$pageName = 'Log List';
	setPageHeader(strtoupper($pageName));
	addPageSubHeader('Attentance Monitoring');
	hideControls();
	setPageControllerName('listCtrl');
}

function getPageContents(){



// $jsonData = json_decode(file_get_contents('./modules/studentreg/studentreg.php'));
$myCon = createSQLCon();
$list = array();
$subj = array();
$sect = array();
  if ($result = $myCon->query("SELECT b.idno,a.idno as accountidno,a.usn,concat(lastname,', ',firstname,' ',middlename) as name,b.status,b.dateenrolled FROM account a, enrolledstudent b where a.idno = b.accountidno order by b.dateenrolled desc")) {

    while($row = $result->fetch_assoc()) {
       $list[] = $row;
      // print $row['accountidno'];
    }

    /* free result set */
    $result->close();
  }

  if ($result = $myCon->query("SELECT * FROM section ORDER BY idno")) {
  
      while($row = $result->fetch_assoc()) {
         $sect[] = $row;
        // print $row['accountidno'];
      }
  
      /* free result set */
      $result->close();
    }

    if ($result = $myCon->query("SELECT * FROM subjectunit ORDER BY idno")) {
    
        while($row = $result->fetch_assoc()) {
           $subj[] = $row;
          // print $row['accountidno'];
        }
    
        /* free result set */
        $result->close();
      }


if(isset($_GET['id'])){

}
else{
  unset($_SESSION['objectId']);
}

 ?>

 <div class="row">
      <div class="col-md-4 columns form-group">
       <label>Student</label>
       <select id="fstudent" class="u-full-width form-control ng-pristine ng-invalid ng-invalid-required ng-touched" required="">
        <option value="" selected>Please Select</option>
        <?php 
          foreach ($list as &$value) {
              echo '<option value="'.$value['accountidno'].'">'.$value['name'].'</option>';
          }
          // for ($i=0; $i < $list; $i++) { 
          //   echo '<option value="'.$list[$i]['accountidno'].'">'.$list[$i]['name'].'</option>';
          // }
        ?>
       </select>
      </div>
      <div class="col-md-4 columns form-group">
      </div>
 </div>
 <div class="row">
      <div class="col-md-4 columns form-group">
       <label>Subject</label>
       <select id="fsubject" class="u-full-width form-control ng-pristine ng-invalid ng-invalid-required ng-touched" required="">
        <option value="" selected>Please Select</option>
        <?php 
          foreach ($subj as &$value) {
              echo '<option value="'.$value['idno'].'">'.$value['code'].'</option>';
          }
          // for ($i=0; $i < $list; $i++) { 
          //   echo '<option value="'.$list[$i]['accountidno'].'">'.$list[$i]['name'].'</option>';
          // }
        ?>
       </select>
      </div>
      <div class="col-md-4 columns form-group">
        <label>Section</label>
              <select id="fsection" class="u-full-width form-control ng-pristine ng-invalid ng-invalid-required ng-touched" required="">
               <option value="" selected>Please Select</option>
                <?php 
                 foreach ($sect as &$value) {
                     echo '<option value="'.$value['idno'].'">'.$value['code'].'</option>';
                 }
                 // for ($i=0; $i < $list; $i++) { 
                 //   echo '<option value="'.$list[$i]['accountidno'].'">'.$list[$i]['name'].'</option>';
                 // }
               ?>
              </select>
      </div>
 </div>
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
 </div>
 <div class="row">
  <div class="col-md-2 columns form-group"><button style="margin-top:25px" id="filterbtn" class="btn btn-primary form-control">Filter</button></div>
</div>
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
</thead>
  <tr title="Open calendar" class="clickable-row" ng-repeat="x in list | orderBy:sortType:sortReverse | filter:searchList" ng-click="itemSelected(x.accountidno)">
    <td>{{x.usn}}</td>
    <td>{{x.name}}</td>
    <td>{{x.section}}</td>
    <td>{{x.subject}}</td>
    <td>{{x.logindate | date:'medium'}}</td>
    <td>{{x.logoutdate | date:'medium'}}</td>

  </tr>
</table>

<script>

				        $(function(){

					        $('#filterbtn').on('click',function(){
					        	var startdate = encodeURI($('#startdate').val());
					        	var enddate = encodeURI($('#enddate').val());
					        	var fstudent = ($('#fstudent').val());
					        	var fsubject = ($('#fsubject').val());
					        	var fsection = ($('#fsection').val());
					        	var err = '';
								if(enddate&&startdate=='')
									err += 'Start Date is required.';
								if(startdate&&enddate=='')
									err +=  (' End Date is required.');

								if(!(err=='')){
									alert(err);
								}
								else{
      
                      var q =  '';
                      if(startdate&&enddate)
                        q+= '&startdate='+startdate+'&enddate='+enddate;
                      if(fstudent){
                        q+= '&student='+fstudent;
                      }
                      if(fsubject){
                        q+= '&subject='+fsubject;
                      }
                      if(fsection){
                        q+= '&section='+fsection;
                      }
                      window.location.search = "?module=monitoring"+q;
								} 
			                	 
					        });
					        <?php 
                    if(isset($_GET['startdate'])){
                      					echo "$('#startdate').val('".$_GET['startdate']."');";								
    								}
                    if(isset($_GET['enddate'])){
                      					echo "$('#enddate').val('".$_GET['enddate']."');";								
    								}
                    if(isset($_GET['student'])){
                      					echo "$('#fstudent').val('".$_GET['student']."');";								
    								}
                    if(isset($_GET['subject'])){
                      					echo "$('#fsubject').val('".$_GET['subject']."');";								
    								}
                    if(isset($_GET['section'])){
                      					echo "$('#fsection').val('".$_GET['section']."');";								
    								}
                  ?>
				        });
var app = angular.module('myApp', []);
app.controller('listCtrl', function ($scope, $http){

                $http({
                  method  : 'POST',
                  url     : 'modules/monitoring/monitoring.php?q=1<?php if(isset($_GET['startdate'])){
                  					echo '&startdate='.$_GET['startdate'];								
								}if(isset($_GET['enddate'])){
                  					echo '&enddate='.$_GET['enddate'];								
								}if(isset($_GET['subject'])){
                  					echo '&subject='.$_GET['subject'];								
								}if(isset($_GET['section'])){
                  					echo '&section='.$_GET['section'];								
								}if(isset($_GET['student'])){
                  					echo '&student='.$_GET['student'];								
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