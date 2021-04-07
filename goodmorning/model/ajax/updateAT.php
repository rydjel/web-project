<?php
require("../frontend.php");
$db = dbConnect();
$at=$_POST['at'];
$impactTACE=$_POST['impactTACE'];
if ($_POST['facturable']=='true') {
    $facturable=1;
}
else {
    $facturable=0;
}
/* if ($_POST['initialisation']=='true') {
    $initialisation=1;
}
else {
    $initialisation=0;
} */

//$dateDebut=$_POST['dateDebut'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($at,"\"")!==false or strpos($at,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
elseif ($at=="") {
    $message='<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" id="closeMessage" onclick="closeAlert();" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Erreur !</strong> Champ Type Activité ne doit être vide.</div>';
    $result="KO";
}
elseif (checkATFieldUpdated('Nom_typeActivite',$at,$id) and existActivityType($at)) {
    $message='<div class="alert  alert-warning alert-dismissible"> <button type="button" class="close" onclick="closeAlert();" data-dismiss="alert" aria-label="Close">&times;</button> <strong>Warning!</strong> Type Activité déjà existant. </div>';
    $result="KO";
}
else {
       $fieldsArray = array('Nom_typeActivite' =>$at,'Impact_TACE' =>$impactTACE,'Facturable' =>$facturable);
       $nbSuccess=0;
       $nbFailure=0;
        foreach ($fieldsArray as $key => $value) {
            if (checkATFieldUpdated($key,$value,$id) and updateActivityType($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkATFieldUpdated($key,$value,$id) and !updateActivityType($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissible"> <button type="button" class="close" onclick="closeAlert();" data-dismiss="alert" aria-label="Close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
            $result="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissible"> <button type="button"" class="close" onclick="closeAlert();" data-dismiss="alert" aria-label="Close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
            $result="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissible"> <button type="button" class="close"  onclick="closeAlert();" data-dismiss="alert" aria-label="Close">&times;</button> Aucune Mise à jour effectuée .</div>';
            $result="OK";
        }
}   
echo $result.":".$message;