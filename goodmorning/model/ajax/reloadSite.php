<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idSite=$idExtend[1];
$site=getSiteDetails($idSite);
$site=$site->fetch();
$reload=$site['Nom'].":".$site['Region'];
echo $reload;

