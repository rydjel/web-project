<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idMU=$idExtend[1];
$MU=getMUDetails($idMU);
$MU=$MU->fetch();
$reload=$MU['Nom'];
echo $reload;

