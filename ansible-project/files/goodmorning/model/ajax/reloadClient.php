<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idClient=$idExtend[1];
$client=getClientDetails($idClient);
$client=$client->fetch();
$reload=$client['NomClient'].":".$client['nomMU'];
echo $reload;

