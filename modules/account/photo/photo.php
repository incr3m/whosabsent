<?php


include '../../../controller/session.php';
// require '../../../utils/cloudinary/Cloudinary.php';
// require '../../../utils/cloudinary/Uploader.php';
// require '../../../utils/cloudinary/Api.php';

$errors = "";
$data = array();
$list = array();
// Getting posted data and decodeing json
if(!isset($_SESSION['objectId'])&&!isset($_POST["newphotoidno"])){
	exit;
}
 $myCon = createSQLCon();

if(isset($_POST["newphotoidno"])){
        $index = 0;
          if ($result = $myCon->query("select coalesce(max(idno),0) as lastindex from accountphoto")) {
        
            while($row = $result->fetch_assoc()) {
              $index = $row["lastindex"];
            }
            $result->close();
          }
    
    	   $index = $index+1;

        $useridno = $_POST["newphotoidno"];
  			$filename = $_POST["filename"];
        $faceid = $_POST["faceId"];
        $isprimary = 'NO';
        if(isset($_POST["isprimary"])){
          $q = "update accountphoto set 
          				isprimary = 'NO'
          				 where accountidno = $useridno";		
          if ($result = $myCon->query($q) or die($myCon->error)) {
          }
          $isprimary = 'YES';
        }
  			
  			$q = "INSERT INTO accountphoto (accountidno,filename,fileindex,isprimary,referenceno) 
  				values ($useridno,'$filename',$index,'$isprimary','$faceid')";	
  
  			if ($result = $myCon->query($q) or die($myCon->error)) {
  
  				if($result === TRUE){
  					
  					$myCon->close();
  					$extra['proc'] = 'success';
  					$data['extra'] = $extra;
  					echo json_encode($data);
  					exit;	
  					
  				}
  				else{
  					$errors = 'Error occurred while saving new record.';
  				}
  				/* free result set */
  				$myCon->close();
  			}
  			else{
  				$errors .= 'Record already exist.';
  			}
  exit;
}

$_POST = json_decode(file_get_contents('php://input'), true);


  $objId = $_SESSION['objectId'];

 

if(isset($_FILES["inputdim2"])){
   $index = 0;
  if ($result = $myCon->query("select coalesce(max(idno),0) as lastindex from accountphoto")) {

    while($row = $result->fetch_assoc()) {
      $index = $row["lastindex"];
    }

    
    $result->close();
  }
  
  	$index = $index+1;
	$errors = "";
	$target_dir = '../../../'.PHOTO_DIR;
	$target_file = $target_dir . basename($_FILES["inputdim2"]["name"][0]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$target_file_new = $target_dir . "/".$objId."_".$index."_".$imageFileType;
	$uploadOk = 1;

	if (file_exists($target_file)) {
	    $errors = $errors." Sorry, file already exists.";
	    $uploadOk = 0;
	}// Check file size
	if ($_FILES["inputdim2"]["size"][0] > 500000) {
	    $errors = $errors." Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	if ($uploadOk == 0) {
	    $data['error']= "$errors. Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["inputdim2"]["tmp_name"][0], $target_file_new)) {
	    	
			
			$useridno = $_SESSION['objectId'];
			$filename = basename($target_file_new);
			
			$q = "INSERT INTO accountphoto (accountidno,filename,fileindex) 
				values ($useridno,'$filename',$index)";	

			if ($result = $myCon->query($q) or die($myCon->error)) {

				if($result === TRUE){
					
					$ch = curl_init(APIPATH.'/upload?userId='.$useridno.'&id='.urlencode($filename).'&imPath='.urlencode(SERVPATH.PHOTO_DIR.'/'.$filename));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HEADER, false);
					
					$result = curl_exec($ch);
					
					$myCon->close();
					$extra['proc'] = 'success';
					$extra['api'] = $result;
					$data['extra'] = $extra;
					echo json_encode($data);
					exit;	
					
				}
				else{
					$errors = 'Error occurred while saving new record.';
				}
				/* free result set */
				$myCon->close();
			}
			else{
				$errors .= 'Record already exist.';
			}

	    } else {
	        $data['error']= "Sorry, there was an error uploading your file.";
	    }
	}

}
else if(isset($_POST["idno"])){
	$id = $_POST["idno"];
	$mode = $_POST["mode"];
	$objId = $_SESSION['objectId'];
	$filename = '';
  $referenceno = '';
	if ($result = $myCon->query("select filename,coalesce(referenceno,'none') as referenceno from accountphoto 
			where idno = $id")) {
	
		while($row = $result->fetch_assoc()) {
			$filename = $row["filename"];
			$referenceno = $row["referenceno"];
		}
	
		$result->close();
	}
	
	if($mode =='delete'){
		$q = "delete from accountphoto where idno = $id";	
	}
	else if($mode =='setprimary'){
		$q = "update accountphoto set 
				isprimary = case when idno = $id then 'YES' else 'NO' end 
				 where accountidno = $objId";		
	}
	else if($mode =='unsetprimary'){
		$q = "update accountphoto set
		isprimary = 'NO' 
		where accountidno = $objId";
	}
  // $ch = curl_init(APIPATH.'/deleteFace/'.$referenceno);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_HEADER, false);
	// 	
	// $result = curl_exec($ch);
	// echo json_encode($result);
  // exit;
	if ($result = $myCon->query($q) or die($myCon->error)) {

		if($result === TRUE){
			if($mode=='delete'){
				// $ch = curl_init(APIPATH.'/deleteFace/'.$referenceno);
				// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				// curl_setopt($ch, CURLOPT_HEADER, false);
				// 	
				// $result = curl_exec($ch);
				// echo json_encode($result);
				$ret = array();
        $ret['referenceno'] = APIPATH.'/deleteFace/'.$referenceno;
				echo json_encode($ret);
			}
			$myCon->close();	
			exit;	
		}
		else{
			$errors = 'Error occurred while saving new account.';
		}

		/* free result set */
		$myCon->close();

	}
}
else{


   $myCon = createSQLCon();

   $objId = $_SESSION['objectId'];

  if ($result = $myCon->query("SELECT *,concat('".BUCKETPATH."',a.filename) as photo FROM accountphoto a where accountidno = $objId order by fileindex")) {

    while($row = $result->fetch_assoc()) {
      $list[] = $row;
    }

    /* free result set */
    $result->close();
  }


$data['list'] = $list;

}
// response back.
echo json_encode($data);
//echo 'test2';
?>	