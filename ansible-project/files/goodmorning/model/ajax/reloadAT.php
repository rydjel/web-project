<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idAT=$idExtend[1];
$AT=getATDetails($idAT);
$AT=$AT->fetch();
$reload=$AT['Nom_typeActivite'].":".$AT['Impact_TACE'].":".$AT['Facturable'];
echo $reload;

