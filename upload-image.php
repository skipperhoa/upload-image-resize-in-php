<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
require_once './resize-image.php';
if(isset($_FILES['UrlImage'])){

    $dirname = __DIR__."/uploads/";
    $size320x200 = $dirname."size320x200";
    $size420x300 = $dirname."size420x300";

    $errors = array();
    $name = $_FILES['UrlImage']['name'];
    $type = $_FILES['UrlImage']['type'];
    $size = $_FILES['UrlImage']['size'];
    $tmp_name = $_FILES['UrlImage']['tmp_name'];
    $maxsize    = 2097152;
    $array_type = array("image/jpeg","image/png","image/jpg","image/gif");
    if(($size >= $maxsize) || ($size == 0)) {
        $errors[] = 'File too large. File must be less than 2 megabytes.';
    }

    if((!in_array($type, $array_type)) && (!empty($type))) {
        $errors[] = 'Invalid file type. JPG, GIF and PNG types are accepted.';
    }

    if(count($errors) === 0) {

        if (!file_exists($dirname)) {
            mkdir($dirname, 0777);
        }
        /**Resize */
        if (!file_exists($size320x200)) {
            mkdir($size320x200, 0777);
        }
        if (!file_exists($size420x300)) {
            mkdir($size420x300, 0777);
        }
        $target_file = $dirname . basename($name);
        move_uploaded_file($tmp_name,  $target_file);
        //resize320x200
        ImageResize(320,200,$size320x200,$target_file,$type,$name);
         //resize320x200
        ImageResize(420,300,$size420x300,$target_file,$type,$name);
    
        echo json_encode(array("success"=>1,"message"=>"Upload successfuly!","data"=>"ok"));
    } else {
        echo json_encode(array("success"=>-1,"message"=>json_encode($errors)));
    }
}
else{
    echo json_encode(array("success"=>0));
}


?>