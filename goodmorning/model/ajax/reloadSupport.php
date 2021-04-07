<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idSupport=$idExtend[1];
$support=getSupportDetails($idSupport);
$support=$support->fetch();
$reload=$support['nom'].":".$support['prenom'];
echo $reload;

