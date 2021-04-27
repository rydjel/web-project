<?php
require("../frontend.php");
$PTName=$_POST['PT'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($PTName,"\"")!==false or strpos($PTName,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif (existPT($PTName)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
    <strong>Warning!</strong> Titre déjà existant. </div>';
}
elseif ($PTName=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> Champ "Titre" vide.</div>';
}
else {
    if(createPT($PTName)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Titre rajoutée avec <strong>Success!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau Titre.</div>';
    }
}


$PTRows=getProfilTitles(); // Access to the list of all marketUnits

$liste='';

while ($data=$PTRows->fetch()) {
    $PT_ID="PT-".$data['ID'];
    
    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['intitule'].'"
        id="'.$PT_ID.'" disabled>
    </td>
    <td>
        <button type="button" id="edit-'.$data['ID'].'" onclick="allowPTModif(this.id);">
        <span class="glyphicon glyphicon-edit"></span> Editer</button>
        <button type="button" id="validation-'.$data['ID'].'" disabled
        onclick="PTUpdateValidation(\''.$PT_ID.'\',this.id);">
        <span class="glyphicon glyphicon-ok"></span> Valider</button>
        <button type="button" id="annuler-'.$data['ID'].'" 
        onclick="cancelPTModif(\''.$PT_ID.'\',this.id,\'.validation-'.$data['ID'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
    </td>
    </tr>';
}



echo $message.":".$liste;


////// Notes --> Enlever le point-virgule à la ligne 39 et tester.
































