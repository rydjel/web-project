<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idExp=$idExtend[1];
$exp=getExpDetails($idExp);
$exp=$exp->fetch();
$reload=$exp['Date_Debut'].":".$exp['Date_Fin'].":".$exp['Details'];
echo $reload;

