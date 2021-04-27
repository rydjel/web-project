<?php
require("../frontend.php");
$db = dbConnect();
$certif=$_POST['certif'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if ($certif=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ Certif ne doit être vide.</div>';
    $result="KO";
}
elseif (strpos($certif,"\"")!==false or strpos($certif,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
elseif (checkCollabCertifFieldUpdated('Titre',$certif,$id) and existsCollabCertification($id,$certif)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Certification déjà existante. </div>';
    $result="KO";
}
else {
       $fieldsArray = array('Titre' =>$certif);
       $nbSuccess=0;
       $nbFailure=0;
        foreach ($fieldsArray as $key => $value) {
            if (checkCollabCertifFieldUpdated($key,$value,$id) and updateCollabCertif($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkCollabCertifFieldUpdated($key,$value,$id) and !updateCollabCertif($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour de la certification  effectuée avec <strong>Success!</strong> .</div>';
            $result="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour de certification !</div>';
            $result="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour de certification effectuée .</div>';
            $result="OK";
        }
}   
echo $result.":".$message;