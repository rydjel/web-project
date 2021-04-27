<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idCertif=$idExtend[1];
$certif=getCertifDetails($idCertif);
$certif=$certif->fetch();
$reload=$certif['Titre'];
echo $reload;

