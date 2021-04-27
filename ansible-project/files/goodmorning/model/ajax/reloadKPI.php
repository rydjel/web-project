<?php
require("../frontend.php");
$idExtend=explode("-",$_POST['idExtend']);
$idKpi=$idExtend[1];
$KPI=getPnlKpiDetails($idKpi);
$KPI=$KPI->fetch();
$reload=$KPI['id_pnlkpitype'].":".$KPI['id_mois'].":".$KPI['budget'].":".$KPI['forecast'];
echo $reload;

