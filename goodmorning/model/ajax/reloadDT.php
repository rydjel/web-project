<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idDT=$idExtend[1];
$DT=getDTDetails($idDT);
$DT=$DT->fetch();
$reload=$DT['nomTache'].":".$DT['ID_TypeActivite'];
echo $reload;

