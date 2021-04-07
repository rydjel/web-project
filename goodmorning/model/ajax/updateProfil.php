<?php
require("../frontend.php");
$db = dbConnect();
$profil=$_POST['profil'];
$idPT=$_POST['PT'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
$quote=strpos($profil,"\"");
if ($profil=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ Profil ne doit être vide.</div>';
    $result="KO";
}
elseif (strpos($profil,"\"")!==false or strpos($profil,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
else {
       $fieldsArray = array('détails' =>$profil,'ID_PT' =>$idPT );
       $nbSuccess=0;
       $nbFailure=0;
        foreach ($fieldsArray as $key => $value) {
            if (checkProfilFieldUpdated($key,$value,$id) and updateProfil($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkProfilFieldUpdated($key,$value,$id) and !updateProfil($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise à jour du Profil effectuée(s) avec <strong>Success!</strong> .</div>';
            $result="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur de Mise à jour du Profil !</div>';
            $result="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour de profil effectuée .</div>';
            $result="OK";
        }
}   
echo $result.":".$message;