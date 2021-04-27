<?php
require("../frontend.php");
$activityName=$_POST['at'];
$impactTACE=$_POST['tace'];
$facturable=$_POST['facturable'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($activityName,"\"")!==false or strpos($activityName,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif (existActivityType($activityName)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Type Activité déjà existant. </div>';
}
elseif ($activityName=="" or $impactTACE=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Type Activité" et "Impact TACE" sont obligatoires.</div>';
}
else {
    if(createActivityType($activityName,$impactTACE,$facturable)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Type Activité rajoutée avec <strong>Success!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau Type Activité.</div>';
    }
}


$ATRows=getActivityTypes(); // Get All Acctivity types

$liste='';

while ($data=$ATRows->fetch()) {
    $AT_ID="AT-".$data['ID'];
    $impactTACEID="impactTACE-".$data['ID'];
    $facturableID="facturable-".$data['ID'];

    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['Nom_typeActivite'].'"
        id="'.$AT_ID.'" disabled>
    </td>
    <td>
        <select id="'.$impactTACEID.'" class="form-control" disabled>
            <option value="positif" ';
        if ($data['Impact_TACE']=="positif") {
            $liste.='selected';
        }
        $liste.='>positif</option> <option value="aucun" ';
        if ($data['Impact_TACE']=="aucun") {
            $liste.='selected';
        }
        $liste.='>aucun</option> <option value="négatif" ';
        if ($data['Impact_TACE']=="négatif") {
            $liste.='selected';
        }
        $liste.='>négatif</option>
        </select>
    </td>
    <td>
    <input type="checkbox" id="'.$facturableID.'" name="facturable" ';
    if ($data['Facturable']==1) {
        $liste.='checked';
    }
    $liste.=' disabled>
    </td>
    <td>
        <button type="button" id="edit-'.$data['ID'].'" onclick="allowATModif(this.id);">
        <span class="glyphicon glyphicon-edit" ></span> Editer</button>
        <button type="button" id="validation-'.$data['ID'].'" disabled
        onclick="ATUpdateValidation(\''.$AT_ID.'\',\''.$impactTACEID.'\',\''.$facturableID.'\',this.id);">
        <span class="glyphicon glyphicon-ok" ></span> Valider</button>
        <button type="button" id="annuler-'.$data['ID'].'" 
        onclick="cancelATModif(\''.$AT_ID.'\',\''.$impactTACEID.'\',\''.$facturableID.'\',this.id,\'validation-'.$data['ID'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
    </td>
</tr>';

}

echo $message.":".$liste;


////// Notes --> Enlever le point-virgule à la ligne 39 et tester.
































