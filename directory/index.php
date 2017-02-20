

 <?php 
 
 $userType = getCurrentUserType();
$page = '';
	if(isset($_GET['module'])){
		switch($_GET['module']){
			case 'acct':
				$_SESSION['moduleName'] = 'Account';
				if(isset($_GET['sub'])&&isset($_SESSION['objectId'])){
					switch($_GET['sub']){
						case 'imgs':
							$_SESSION['moduleName'] = 'Account Photos';
							$page = 'modules/account/photo/list.php';
							break;
					}
				}
				else{
					
					if(isset($_GET['id'])){
						$recId = $_GET['id'];
						$_SESSION['objectId'] = $recId;
					
						$page='modules/account/properties.php';
					}
					else{
						unset($_SESSION['objectId']);
						$page = 'modules/account/list.php';
					}
						
				}
	
				break;
				/*case 'tchreg':
				 $_SESSION['moduleName'] = 'T';
				if(isset($_GET['sub'])&&isset($_SESSION['objectId'])){
				switch($_GET['sub']){
				case 'sched':
				include 'modules/teacherreg/subject/list.php';
				break;
				case 'imgs':
				break;
				}
				}
				else{
				include 'modules/teacherreg/list.php';
				}
	
				break;*/
			case 'stdreg':
				$_SESSION['moduleName'] = ATTR_USER_NAME;
				if(isset($_GET['sub'])&&isset($_SESSION['objectId'])){
					switch($_GET['sub']){
						case 'sched':
							if(isset($_GET['id'])){
								//$recId = $_GET['id'];
								//$_SESSION['objectId'] = $recId;
									
								$page = 'modules/studentreg/subject/properties.php';
							}
							else{
								//unset($_SESSION['objectId']);
								$_SESSION['moduleName'] = ATTR_USER_NAME.' Schedule';
								$page = 'modules/studentreg/subject/list.php';
							}
							
							break;
						case 'imgs':
							$_SESSION['moduleName'] = ATTR_USER_NAME.' Photo';
							break;
					}
				}
				else{
					if(isset($_GET['id'])){
						$recId = $_GET['id'];
						$_SESSION['objectId'] = $recId;
							
						$page='modules/studentreg/properties.php';
					}
					else{
						unset($_SESSION['objectId']);
						$page = 'modules/studentreg/list.php';
					}
						
					
				}
				break;
			case 'monitoring':
				unset($_SESSION['objectId']);
				$page = 'modules/monitoring/list.php';
				break;
		}
	}
	else{
		if(isset($_GET['home'])){
			$page = 'directory/home.php';
		}
		else if (isset($_GET['about'])){
			$page = 'directory/about.php';
		}
	}

	include $page;
	initPage();

 ?>
<div class="left-menu" style="position: fixed">
	<div class="logo">
		<img style="height:100px" src="img/photos/icon175x175.png" />
		<div style="font-size: 11pt;padding-top: 10px" >Attendance Monitoring System using Mobile Face Recognition</div>
	</div>
	<div id="main-nav" class="accordion">
     	<div class="section ">
			<input type="radio" name="accordion-1" id="section-0" value="toggle"
				href="?home" />
			 <label for="section-0" class="clickable"><i
				class="fa fa-home"></i><span>Home</span></label>
			<div class="content"></div>
		</div>
        <?php if($userType ==ROLE_ADMIN){?>
        <div class="section ">
			<input type="radio" name="accordion-1" id="section-1" value="toggle"
				href="?module=acct" /> <label for="section-1" class="clickable"><i
				class="fa fa-user"></i><span>Accounts</span></label>
			<div id="mod-acct" class="content"></div>
		</div>
        <?php } ?>

        <?php if($userType ==false){?>
        <div class="section">
			<input type="radio" name="accordion-1" id="section-2" value="toggle"
				href="?module=tchreg" /> <label for="section-2" class="clickable"><i
				class="fa fa-file-text-o"></i><span>Teacher Registration</span></label>
			<div id="mod-tchreg" class="content"></div>
		</div>
        <?php } ?>
        <?php if($userType ==ROLE_ADMIN || $userType ==ROLE_TEACHER){?>
        <div class="section">
			<input type="radio" name="accordion-1" id="section-3" value="toggle"
				href="?module=stdreg" /> <label for="section-3" class="clickable"><i
				class="fa fa-file-text-o"></i><span><?php echo ATTR_USER_NAME; ?> Registration</span></label>
			<div id="mod-stdreg" class="content"></div>
		</div>
        <?php } ?>
    	<div class="section">
			<input type="radio" name="accordion-1" id="section-4" value="toggle" 
			href="?module=monitoring" />
			<label for="section-4" class="clickable"><i
				class="fa fa-calendar-check-o"></i><span>Attendance Monitoring</span></label>
			<div class="content"></div>
		</div>
		<!-- <div class="section">
			<input type="radio" name="accordion-1" id="section-5" value="toggle" />
			<label for="section-5" class="clickable"><i
				class="fa fa-question"></i><span>Help</span></label>
			<div class="content"></div>
		</div> -->
	</div>
	<div id="nav-footer">
		<a title="Log-out" id="logoutBtn"><div style="float:right;padding:5px"><i class="fa fa-sign-out"></i></div></a>
		<a title="My Account" id="myacctBtn" href="?module=acct&id=<?php $curUser = getCurrentUser();echo $curUser['idno']; ?>&"><div style="float:right;padding:5px;margin-right:5px;"><i class="fa fa-gear"></i></div></a>
		<div style="margin-left: 10px">
			<div style="font-weight: bold"><?php $curUser = getCurrentUser(); echo $curUser['name'];?></div>
			<div style="font-size: smaller">
              <?php echo getCurrentUserType();?> </div>
		</div>
	</div>
</div>

<!-- <div id="detail-pnl" class="col-md-10 columns col-md-10 columns"> -->

<div id="detail-pnl">
	<div id="page-header" style="background:url('resources/testbanner4.png');background-size:100%">
		<div id="page-title"><h1><?php echo getPageHeader();?></h1>
		<?php 
		$flagFirst = false;
		foreach (getPageSubHeaders() as $subHeader){
			echo '<h4 ';
			if($flagFirst==false){
				echo 'class="first"';
			}
			echo'>'.$subHeader.'</h4>';
			$flagFirst=true;
		}
		
		?>
		</div>
	</div>
	<div>
	<div ng-app="myApp" ng-controller="<?php echo getPageControllerName();?>">
	<?php 
		loadPropertiesPageControls();
	?>
	<div style="padding: 20px;background:#FFE6E6">
     <?php 
          
     echo getPageContents();

     ?>
     </div>
	</div>

   </div>
</div>
</div>

<script>
 
<?php if(isset($_GET['module'])&&isset($_SESSION['objectId'])&&$_GET['module']==='acct') {?>
	
	  
		
      $('#mod-acct').append(
            $("<ul><li id='sub-default' href='?module=acct&id=<?php echo $_SESSION['objectId']; ?>'><i class='fa fa-list-alt'></i>Account Details</li><li id='sub-imgs' href='?module=acct&sub=imgs'><i class='fa fa-photo'></i>Photos</li></ul>"));
  <?php }?>

 <?php if(isset($_GET['module'])&&isset($_SESSION['objectId'])&&$_GET['module']==='stdreg') {?>
 	          
      $('#mod-stdreg').append(
            $("<ul><li id='sub-default' href='?module=stdreg&id=<?php echo $_SESSION['objectId']; ?>'><i class='fa fa-list-alt'></i><?php echo ATTR_USER_NAME; ?> Details</li><li id='sub-sched' href='?module=stdreg&sub=sched'><i class='fa fa-calendar'></i>Schedule</li></ul>"));
  <?php }?>

  <?php if(isset($_GET['module'])&&isset($_SESSION['objectId'])&&$_GET['module']==='tchreg') {?>
  	  $('#mod-tchreg').parent('.section').children('input').attr('checked','checked');        
      $('#mod-tchreg').append(
            $("<ul><li id='sub-default' href='?module=tchreg&id=<?php echo $_SESSION['objectId']; ?>'><i class='fa fa-list-alt'></i>Teacher Details</li><li href='?module=tchreg&sub=sched'>Schedule</li><li>Photos</li></ul>"));
  <?php }?>
  	<?php if(isset($_GET['module'])){
  		$module =  $_GET['module'];
  		echo "$('#mod-$module').parent('.section').children('input').attr('checked','checked');";
  	} 
	?>
    <?php if(isset($_GET['sub'])){
        $subname =  $_GET['sub'];
        echo "$('#sub-$subname').addClass('selected-item');";
     }else if (isset($_GET['id'])){
        echo "$('#sub-default').addClass('selected-item');";
     } ?>

     
     $('#main-nav .clickable').click(function(){
         location.href = $(this).parent().children('input').attr('href');
     });

     $('#main-nav li').click(function(){
         location.href = $(this).attr('href');
     });

     $(document).on("click", "#logoutBtn", function(e) {
         bootbox.confirm("Are you sure you want to log-out?", function(result) {
           if(result){
             window.location = 'login/logout.php';
           }
         }); 
     });
 </script>