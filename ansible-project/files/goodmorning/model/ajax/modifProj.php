<?php
require("../frontend.php");
//$db = dbConnect();
$pu=$_POST['pu'];
$codeProjet=$_POST['codeProjet'];
$titreProjet=$_POST['titreProjet'];
$Commercial=$_POST['Commercial'];
$rfa=$_POST['rfa'];
$client=$_POST['client'];
$typeProjet=$_POST['typeProjet'];
$VolJourVendu=$_POST['VolJourVendu'];
$BudgetVendu=$_POST['BudgetVendu'];
if ($_POST['codeGen']=='true') {
    $codeGen=1;
}else {
    $codeGen=0;
}
$idProjExtend=explode("-",$_POST['idExtend']);
$idProj=$idProjExtend[1];

//Vérif Champs vides
if ($codeProjet=="" or $titreProjet=="" or $Commercial=="" or $VolJourVendu=="" or $BudgetVendu=="" or $rfa=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    les champs "Code Projet", "Titre Projet", "Commercial", "Volume Jour vendu", "Budget Vendu" et "RFA" sont <strong>obligatoires<strong>. </div>';
}
elseif (strpos($codeProjet,"\"")!==false or strpos($titreProjet,"\"")!==false or strpos($Commercial,"\"")!==false
        or strpos($codeProjet,":")!==false or strpos($titreProjet,":")!==false or strpos($Commercial,":")!==false) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les caractères double-quote et deux-points sont interdits. </div>';
}
elseif (!is_numeric($VolJourVendu) or $VolJourVendu<0 or !is_numeric($BudgetVendu) or $BudgetVendu<0 or !is_numeric($rfa) or $rfa <0 ) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les éléments suivants doivent contenir des nombres positifs ou nuls : "Volume de Jours vendus","Budget Vendu", "RFA" . </div>';
}
elseif (checkFieldProjectUpdated('Code',$codeProjet,$idProj) and existProject($codeProjet)) { // Cas où Projet existant
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong>
    Projet déjà existant. </div>';
}
else {

    $nbSuccess=0;
    $nbFailure=0;

    $fieldsArray = array('ID_PU' =>$pu,'Code' =>$codeProjet,'Titre' =>$titreProjet,'Commercial' =>$Commercial,'RFA' =>$rfa,'ID_Client' =>$client
    ,'TypeProjet' =>$typeProjet,'VolJourVendu' =>$VolJourVendu,'budget' =>$BudgetVendu,'codeGenerique' =>$codeGen);
    foreach ($fieldsArray as $key => $value) {
        if (checkFieldProjectUpdated($key,$value,$idProj) and updateProject($key,$value,$idProj)) {
            $nbSuccess+=1;
        }
        elseif (checkFieldProjectUpdated($key,$value,$idProj) and !updateProject($key,$value,$idProj)) {
            $nbFailure+=1;
        }
    } 
    if ($nbFailure==0 and $nbSuccess!=0 ) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
    }
    elseif ($nbFailure!=0 ) {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
    }elseif ($nbFailure==0 and $nbSuccess==0) {
        $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour effectuée .</div>';
    }

}
echo $message;