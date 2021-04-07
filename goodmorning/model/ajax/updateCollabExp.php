<?php
require("../frontend.php");
$db = dbConnect();
$debut=$_POST['debut'];
$fin=$_POST['fin'];
$details=$_POST['details'];

// Traitement du cas ou date de fin non indiquée (A voir)
if ($fin=="") {
    $fin="0000-00-00";
}

$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if ($debut=="" or $details=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champs "Date début", "Date Fin" et "Détails" ne doivent être vide.</div>';
    $result="KO";
}
elseif ($fin!="" and $fin!="0000-00-00"  and strtotime($fin)<strtotime($debut)) { // A voir
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    la date de début est postérieure à la date de fin! </div>';
    $result="KO";
}
elseif (strtotime("now")<strtotime($debut)) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    la date de début est postérieure à la date du jour. </div>';
    $result="KO";
}
elseif (strpos($details,"\"")!==false or strpos($details,":")!==false ) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
else {
       $fieldsArray = array('Date_Debut' =>$debut,'Date_Fin' =>$fin,'Details' =>$details);
       $nbSuccess=0;
       $nbFailure=0;
        foreach ($fieldsArray as $key => $value) {
            if (checkCollabExperienceFieldUpdated($key,$value,$id) and updateCollabExperience($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkCollabExperienceFieldUpdated($key,$value,$id) and !updateCollabExperience($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour de l\'expérience  effectuée avec <strong>Success!</strong> .</div>';
            $result="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour de l\'expérience !</div>';
            $result="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour d\'expérience effectuée .</div>';
            $result="OK";
        }
}   
echo $result.":".$message;