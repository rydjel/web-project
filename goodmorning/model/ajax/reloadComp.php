<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idComp=$idExtend[1];
$comp=getCompDetails($idComp);
$comp=$comp->fetch();
$reload=$comp['Titre'].":".$comp['Niveau'];
echo $reload;

