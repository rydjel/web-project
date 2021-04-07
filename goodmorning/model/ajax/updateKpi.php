<?php
require("../frontend.php");
$db = dbConnect();
$idkpiType=$_POST['idkpiType'];
$idMonth=$_POST['idMonth'];
$budget=$_POST['budget'];
$forecast=$_POST['forecast'];

$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($budget,"\"")!==false or strpos($budget,":")!==false or strpos($forecast,"\"")!==false or strpos($forecast,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
elseif ($idkpiType=="" or $idMonth=="" or $budget=="" or $forecast=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> Les Champs ne doivent pas être vides.</div>';
    $result="KO";
}
elseif ((checkPnlKpiFieldUpdated('id_pnlkpitype',$idkpiType,$id) or(checkPnlKpiFieldUpdated('id_mois',$idMonth,$id)) and existPnlKpi($idkpiType,$idMonth))) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> KPI déjà existant. </div>';
    $result="KO";
}
else {
       $fieldsArray = array('id_pnlkpitype' =>$idkpiType,'id_mois' =>$idMonth,'budget' =>$budget,'forecast' =>$forecast);
       $nbSuccess=0;
       $nbFailure=0;

        foreach ($fieldsArray as $key => $value) {
            if (checkPnlKpiFieldUpdated($key,$value,$id) and updatePnlKpi($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkPnlKpiFieldUpdated($key,$value,$id) and !updatePnlKpi($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
            $result="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
            $result="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour effectuée .</div>';
            $result="OK";
        }
}   
echo $result.":".$message;