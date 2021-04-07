<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idPT=$idExtend[1];
$PT=getPTDetails($idPT);
$PT=$PT->fetch();
$reload=$PT['intitule'];
echo $reload;

