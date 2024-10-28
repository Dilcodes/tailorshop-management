<?php

require_once '../others/class/comm_functions.php';
$app = new setting();

/* Getting file name */
$filename = $_FILES['file']['name'];

/* Location */
$nextOrderNo = $app->get_next_autoincrement_ID("order_summery");
$newName = $nextOrderNo;
$extension = pathinfo($filename, PATHINFO_EXTENSION); // jpg
$basename = $newName . "." . $extension; // 25.jpg

$_SESSION['sample_img'] = $basename;

$location = "../others/upload_sample_image/" . $basename;

$uploadOk = 1;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION);

/* Valid Extensions */
$valid_extensions = array("jpg", "jpeg", "png");
/* Check file extension */
if (!in_array(strtolower($imageFileType), $valid_extensions)) {
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo 0;
} else {
    /* Upload file */
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
//        $q1 = "INSERT INTO `tailor_item_image_details` "
//                . "(`tailorID`, `itm_img`) "
//                . "VALUES "
//                . "('{$_SESSION['tailor_id']}', '{$basename}');";
//        $app->basic_command_query($q1);
        echo $location;
    } else {
        echo 0;
    }
}