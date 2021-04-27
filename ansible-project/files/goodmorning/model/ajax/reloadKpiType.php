<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idKpiType=$idExtend[1];
$kpiTypeDetails=getPnlKPITypeDetails($idKpiType);
$kpiTypeDetails=$kpiTypeDetails->fetch();
$reload=$kpiTypeDetails['type'];
echo $reload;

