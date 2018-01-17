<?php
	$target_dir = "upload/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists
	// if (file_exists($target_file)) {
	//     echo "Sorry, file already exists.";
	//     $uploadOk = 0;
	// }
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			getOcrResult(getFileUploadResponse(__DIR__."/".$target_file));
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}
	//Function to upload the file in server and get filename as response
	function getFileUploadResponse($path){
		$cFile = NULL;
		if (function_exists('curl_file_create')) { // php 5.5+
		  $cFile = curl_file_create($path);
		} else { // 
		  $cFile = '@' . realpath($path);
		}
		$post = array('sampleFile'=> $cFile);
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,"http://113.11.120.208/upload");
		//curl_setopt($ch, CURLOPT_URL,"http://puthi-ocr.com/upload");
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result=curl_exec ($ch);

		curl_close ($ch);

		return $result;
	}

	//function to get ocr response 
	function getOcrResult($responseFromUpload){

		$curl = curl_init();

		curl_setopt_array($curl, array(
				CURLOPT_URL => "http://113.11.120.208/do_ocr?src=".$responseFromUpload,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_CUSTOMREQUEST => "GET",
			)
		);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		$arr =json_decode($response, true);


		echo $arr["response"];
		}

	}

?>