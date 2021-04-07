<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idTask=$idExtend[1];
$task=getTaskDetails($idTask);
$task=$task->fetch();
$reload=$task['Nom_Tache'].":".$task['typeActivityID'].":".$task['Impact_TACE'].":".$task['Facturable'];
echo $reload;

