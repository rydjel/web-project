<?php
require("../frontend.php");
$db = dbConnect();
$PT=$_POST['PT'];
/* if ($_POST['region']=='true') {
    $region=1;
}
else {
    $region=0;
} */
/* $dateDebut=$_POST['dateDebut'];
$dateFin=$_POST['dateFin'];
if ($dateFin=="") {
    $dateFin="0000-00-00";
  } */
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($PT,"\"")!==false or strpos($PT,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
elseif ($PT=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ Titre ne doit pas être vide.</div>';
    $result="KO";
}
elseif (checkPTFieldUpdated('intitule',$PT,$id) and existPT($PT)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Intitulé déjà existant. </div>';
    $result="KO";
}
else {
       $fieldsArray = array('intitule' =>$PT);
       $nbSuccess=0;
       $nbFailure=0;

        foreach ($fieldsArray as $key => $value) {
            if (checkPTFieldUpdated($key,$value,$id) and updatePT($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkPTFieldUpdated($key,$value,$id) and !updatePT($key,$value,$id)) {
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