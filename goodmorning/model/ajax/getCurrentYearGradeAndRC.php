<?php
require("../frontend.php");
$db = dbConnect();
$siteRegion=getSiteRegion($_POST["siteID"]);
$siteRegion=$siteRegion->fetch();
$values=currentYearGradeAndRC($siteRegion["Region"],$_POST["role"]);
$data=$values->fetch();
$donnees=array();
$donnees[0]=$data['Grade'];
$donnees[1]=$data['RateCard'];
echo json_encode($donnees);


