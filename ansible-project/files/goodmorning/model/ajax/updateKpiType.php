<?php
require("../frontend.php");
$db = dbConnect();
$kpiType=$_POST['kpiType'];

$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($kpiType,"\"")!==false or strpos($kpiType,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
elseif ($kpiType=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ ne doit pas être vide.</div>';
    $result="KO";
}
elseif (checkPnlKPITypeFieldUpdated('type',$kpiType,$id) and existPnlKPIType($kpiType)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> type de KPI déjà existant. </div>';
    $result="KO";
}
else {
       $fieldsArray = array('type' =>$kpiType);
       $nbSuccess=0;
       $nbFailure=0;

        foreach ($fieldsArray as $key => $value) {
            if (checkPnlKPITypeFieldUpdated($key,$value,$id) and updatePnlKPIType($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkPnlKPITypeFieldUpdated($key,$value,$id) and !updatePnlKPIType($key,$value,$id)) {
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