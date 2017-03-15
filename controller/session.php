<?php
session_start();
if(isset($_POST['userIdToken'])){
  $_SESSION['userId'] = $_POST['userIdToken'];
}
header("access-control-allow-origin: *");

include 'constants.php';
include 'models.php';
include 'utils.php';

$subModules = array();
date_default_timezone_set('UTC');

if(isset($_GET['test'])){

	$myCon = createSQLCon();



	if ($result = $myCon->query("select count(*) as count from account")) {

	    while($row = $result->fetch_assoc()) {
	      $result->close();
	      echo $row['count'];
	      exit;
	    }
	    
  	}
	
}

function registerSubmodule($submodule){
	$GLOBALS['subModules'][$submodule['key']] = $submodule;

}


function getRequestedSubmodule(){
	if(isset($_GET['sub'])){
	    $sub = $_GET['sub'];
	    foreach ($GLOBALS['subModules'] as $value) {
	    	if($value['key'] === $sub){
	    		return $value;
	    	}
	    }
	  }
	  else if(!empty($GLOBALS['subModules']['default'])){
	  	return $GLOBALS['subModules']['default'];
	  }
	  else{
	  	print_r($GLOBALS['subModules']);
	  }
}

function getPageSubmodules(){
	return $subModules;
}

function isModeIn($modes){

	if(is_array($modes)){
		foreach ($modes as $variable) {
			if(isset($_SESSION['mode'])){
				if($_SESSION['mode'] == $variable)
					return 'true';
			}
		}
	}
	
	return 'false';
}

function isRoleIn($roles){
	$role = getCurrentUserType();
	if(is_array($roles)){
		foreach ($roles as $variable) {
			
			if($role == $variable)
				return 'true';
		
		}
	}
	
	return 'false';
}


function getPage(){
	

	if(!isset($_SESSION['userId']))
		$_SESSION['page'] = PAGE_LOGIN;

	
	if(isset($_GET['mode'])){
		$_SESSION['mode'] = $_GET['mode'];
	}
	else{
		$_SESSION['mode'] = MODE_VIEW;
	}

	
	

	if (isset($_SESSION['page'])){
	
		switch($_SESSION['page']){
			case PAGE_LOGIN:
				$extra = 'login/index.php';
				return $extra;			
			BREAK;
			case PAGE_DIRECTORY:
				$extra = 'directory/index.php';
				return $extra;			
			BREAK;
			default:
        $extra = 'directory/index.php';
				return $extra;			
		}
		
	}
	
}

function setPageHeader($headerName){
	$GLOBALS['pageHeader'] =$headerName;
}

function getPageHeader(){
	if(!empty($GLOBALS['pageHeader'])){
		return $GLOBALS['pageHeader'];
	}
}

function addPageSubHeader($subHeader){
	
	if(empty($GLOBALS['pageSubHeader'])){
		$GLOBALS['pageSubHeader'] = array();	
	}
	
	array_push($GLOBALS['pageSubHeader'],$subHeader);
}

function getPageSubHeaders(){
	if(!empty($GLOBALS['pageSubHeader'])){
		return $GLOBALS['pageSubHeader'];
	}
	
}

function setPageControllerName($controllerName){
	$GLOBALS['pageControllerName'] =$controllerName;
}

function getPageControllerName(){
	if(!empty($GLOBALS['pageControllerName'])){
		return $GLOBALS['pageControllerName'];
	}
}

function hideMainSearch(){
	$GLOBALS['hideMainSearch'] = true;
}

function hideControls(){
	$GLOBALS['hideControls'] = true;
}

function setReturnPageUrl($url){
	$GLOBALS['returnPageUrl'] = $url;
}

?>