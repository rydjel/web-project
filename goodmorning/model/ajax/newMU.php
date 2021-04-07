<?php
require("../frontend.php");
$muName=$_POST['mu'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($muName,"\"")!==false or strpos($muName,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif (existMU($muName)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
    <strong>Warning!</strong> MU déjà existant. </div>';
}
elseif ($muName=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> Champ "Nom MU" vide.</div>';
}
else {
    if(createMU($muName)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> MU rajoutée avec <strong>Success!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau MU.</div>';
    }
}


$muRows=getMarketUnits(); // Access to the list of all marketUnits

$liste='';

while ($data=$muRows->fetch()) {
    $MU_ID="PU-".$data['ID'];
    
    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['Nom'].'"
        id="'.$MU_ID.'" disabled>
    </td>
    <td>
        <button type="button" id="edit-'.$data['ID'].'" onclick="allowMUModif(this.id);">
        <span class="glyphicon glyphicon-edit"></span> Editer</button>
        <button type="button" id="validation-'.$data['ID'].'" disabled
        onclick="muUpdateValidation(\''.$MU_ID.'\',this.id);">
        <span class="glyphicon glyphicon-ok"></span> Valider</button>
        <button type="button" id="annuler-'.$data['ID'].'" 
        onclick="cancelMUModif(\''.$MU_ID.'\',this.id,\'.validation-'.$data['ID'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
    </td>
    </tr>';
}



echo $message.":".$liste;


////// Notes --> Enlever le point-virgule à la ligne 39 et tester.
































