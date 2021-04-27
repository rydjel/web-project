<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idTJM=$idExtend[1];
$TJM=getTJMbyID($idTJM);
$TJM=$TJM->fetch();
$reload=$TJM['Valeur'].":".$TJM['BudgetInit'].":".$TJM['BudgetComp'].":".$TJM['VolJourInit']
.":".$TJM['VolJourComp'].":".$TJM['FraisInit'].":".$TJM['FraisComp'].":".$TJM['AutresCouts']
.":".$TJM['Annee_Debut'].":".$TJM['Mois_Debut'].":".$TJM['Annee_Fin'].":".$TJM['Mois_Fin']
.":".$TJM['ISOW'].":".$TJM['SOW_ID'].":".$TJM['ODM'].":".$TJM['FOP'].":".$TJM['coverage'];
echo $reload;

