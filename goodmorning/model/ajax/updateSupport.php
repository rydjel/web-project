<?php
require("../frontend.php");
$db = dbConnect();
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($nom,"\"")!==false or strpos($nom,":")!==false or strpos($prenom,"\"")!==false or strpos($prenom,":")!==false ) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $result="KO";
}
elseif ($nom=="" or $prenom=="" ) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>
     <strong>Erreur !<strong> Champs Nom et Prénom ne doivent pas être vides.</div>';
     $result="KO";
}
elseif ((checkSupportFieldUpdated('nom',$nom,$id) and existSupport($nom,$prenom)) or (checkSupportFieldUpdated('prenom',$prenom,$id) and existSupport($nom,$prenom)) ) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
    <strong>Warning!</strong> Support déjà existant. </div>';
    $result="KO";
}
else {
       $fieldsArray = array('nom' =>$nom,'prenom' =>$prenom);
       $nbSuccess=0;
       $nbFailure=0;

        foreach ($fieldsArray as $key => $value) {
            if (checkSupportFieldUpdated($key,$value,$id) and updateSupport($key,$value,$id)) {
                $nbSuccess+=1;
            }
            elseif (checkSupportFieldUpdated($key,$value,$id) and !updateSupport($key,$value,$id)) {
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