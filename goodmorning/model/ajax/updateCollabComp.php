<?php
require("../frontend.php");
$db = dbConnect();
$title=$_POST['title'];
$level=$_POST['level'];

$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if ($title=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ Titre ne doit être vide.</div>';
    $success="KO";
}
elseif (strpos($title,"\"")!==false or strpos($title,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits.</div>';
    $success="KO";
}
elseif (checkCollabCompetenceFieldUpdated('Titre',$title,$id) and existsCollabCompetence($id,$title)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Competence déjà existante. </div>';
    $success="KO";
}
else {
       $fieldsArray = array('Titre' =>$title,'Niveau' =>$level);
       $nbSuccess=0;
       $nbFailure=0;
        foreach ($fieldsArray as $key => $value) {
            if (checkCollabCompetenceFieldUpdated($key,$value,$id) and updateCollabCompetence($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkCollabCompetenceFieldUpdated($key,$value,$id) and !updateCollabCompetence($key,$value,$id)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour de la compétence  effectuée avec <strong>Success!</strong> .</div>';
            $success="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour de la compétence !</div>';
            $success="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour de compétence effectuée .</div>';
            $success="OK";
        }
}   
echo  $success.":".$message;