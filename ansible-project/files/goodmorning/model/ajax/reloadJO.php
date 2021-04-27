<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idJO=$idExtend[1];
$JO=getJODetails($idJO);
$JO=$JO->fetch();
$reload=$JO['NbJours'];
echo $reload;
