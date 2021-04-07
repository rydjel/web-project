<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idRC=$idExtend[1];
$RC=getRCDetails($idRC);
$RC=$RC->fetch();
$reload=$RC['Region'].":".$RC['Role'].":".$RC['Code'].":".$RC['Grade'].":".$RC['RateCard'];
echo $reload;

