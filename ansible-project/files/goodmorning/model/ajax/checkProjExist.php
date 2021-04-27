<?php
require("../frontend.php");
$db = dbConnect();

$code=$_POST['projCode'];

if (existProject($code)) {
    $exist=1;
} else {
    $exist=0;
}

echo $exist;