<?php
require("../frontend.php");
$db = dbConnect();
$pu=$_POST['pu'];
if ($_POST['region']=='true') {
    $region=1;
}
else {
    $region=0;
}
if ($_POST['mu']=='true') {
    $mu=1;
}
else {
    $mu=0;
}
$entite=$_POST['entite'];
if ($entite=="") {
    $entite="NULL";
}
//$dateDebut=$_POST['dateDebut'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];

//get the Entity value in database for check
$entityIndB=getPUEntID($id);
$entityIndB=$entityIndB->fetch();
$message='';

if (strpos($pu,"\"")!==false or strpos($pu,":")!==false) {
    $message.='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
elseif ($pu=="") {
    $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ PU ne doit être vide.</div>';
    $result="KO";
}
elseif (checkPUFieldUpdated('Nom',$pu,$id) and existPU($pu)) {
    $message.='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> PU déjà existant. </div>';
    $result="KO";
}

else {
        if ($entite=="NULL" and $entityIndB['ID_entite']==null) {
            $fieldsArray = array('Nom' =>$pu,'Region' =>$region,'MU' =>$mu);
        }
        else {
            $fieldsArray = array('Nom' =>$pu,'Region' =>$region,'MU' =>$mu,'ID_entite' =>$entite);
        }
       //$fieldsArray = array('Nom' =>$pu,'Region' =>$region,'MU' =>$mu,'ID_entite' =>$entite);
       $nbSuccess=0;
       $nbFailure=0;
        foreach ($fieldsArray as $key => $value) {
            if (checkPUFieldUpdated($key,$value,$id) and updatePU($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkPUFieldUpdated($key,$value,$id) and !updatePU($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
            $result="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
            $result="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message.='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour effectuée .</div>';
            $result="OK";
        }
}   
echo $result.":".$message;