<?php
require("../frontend.php");
$puName=$_POST['pu'];
$region=$_POST['region'];
$mu=$_POST['mu'];
$entite=$_POST['entite'];
if ($entite=="") {
    $entite="NULL";
}
 
// Insertion en base + Message d'info du retour de requête
if (strpos($puName,"\"")!==false or strpos($puName,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif (existPU($puName)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> PU déjà existant. </div>';
}
elseif ($puName=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Nom PU" vide.</div>';
}
else {

    if(createPU($puName,$region,$mu,$entite)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> PU rajoutée avec <strong>Success!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau PU.</div>';
    }
}


$puRows=getPU(); // Access to the list of PUs
$entities=getEntities(); // Access to the List of entities
$entList=array();
if ($entities) {
    while ($data=$entities->fetch()) {
        $entList[]=array('Details'=>$data['ID_entite'].'-'.$data['nom']);
    }
}

$liste='';

while ($data=$puRows->fetch()) {
    $PU_ID="PU-".$data['ID'];
    $regionID="region-".$data['ID'];
    $muID="mu-".$data['ID'];
    $entiteID="entite-".$data['ID'];

    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['Nom'].'"
        id="'.$PU_ID.'" disabled>
    </td>
    <td>
    <input type="checkbox" id="'.$regionID.'" name="regionPU"';
    if ($data['Region']==1) {
        $liste.='checked';
    }
    $liste.=' disabled>
    </td>
    <td>
    <input type="checkbox" id="'.$muID.'" name="regionPU"';
    if ($data['MU']==1) {
        $liste.='checked';
    }
    $liste.=' disabled>
    </td>
    <td>
    <select class="form-control" id='.$entiteID.' disabled>
    <option></option>';
    foreach ($entList as $k) {
        $entDetails=explode("-",$k['Details']);
        $liste.='<option value='.$entDetails[0].'';
            if ($data['ID_entite']==$entDetails[0]) {
                $liste.=' selected';
            }
        $liste.='>'.$entDetails[1].'</option>';
    }
    $liste.='</select>
    </td>
    <td>
        <button type="button" id="edit-'.$data['ID'].'" onclick="allowPUModif(this.id);">
        <span class="glyphicon glyphicon-edit" ></span> Editer</button>
        <button type="button" id="validation-'.$data['ID'].'" disabled
        onclick="puUpdateValidation(\''.$PU_ID.'\',\''.$regionID.'\',this.id,\''.$muID.'\',\''.$entiteID.'\');">
        <span class="glyphicon glyphicon-ok" ></span> Valider</button>
        <button type="button" id="annuler-'.$data['ID'].'" 
        onclick="cancelPUModif(\''.$PU_ID.'\',\''.$regionID.'\',this.id,\'validation-'.$data['ID'].'\',\''.$muID.'\',\''.$entiteID.'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
        </td>
    </tr>';
}

echo $message.":".$liste;

































