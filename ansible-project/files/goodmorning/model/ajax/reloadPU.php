<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idPU=$idExtend[1];
$PU=getPUDetails($idPU);
$PU=$PU->fetch();
$reload=$PU['Nom'].":".$PU['Region'].":".$PU['MU'].":".$PU['ID_entite'];
echo $reload;

