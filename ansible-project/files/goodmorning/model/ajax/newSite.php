<?php
require("../frontend.php");
$siteName=$_POST['site'];
$region=$_POST['region'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($siteName,"\"")!==false or strpos($siteName,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif (existSite($siteName)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Site déjà existant. </div>';
}
elseif ($siteName=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Nom Site" vide.</div>';
}
else {

    if(createSite($siteName,$region)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Site rajouté avec <strong>Success!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau Site.</div>';
    }
}


$sitesRows=getSites(); // Access to the list of PUs

$liste='';

while ($data=$sitesRows->fetch()) {
    $site_ID="site-".$data['ID'];
    $regionID="region-".$data['ID'];

    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['Nom'].'"
        id="'.$site_ID.'" disabled>
    </td>
    <td>
    <input type="checkbox" id="'.$regionID.'" name="regionPU"';
    if ($data['Region']==1) {
        $liste.='checked';
    }
    $liste.=' disabled>
    </td>
    <td>
        <button type="button" id="edit-'.$data['ID'].'" onclick="allowSiteModif(this.id);">
        <span class="glyphicon glyphicon-edit" ></span> Editer</button>
        <button type="button" id="validation-'.$data['ID'].'" disabled
        onclick="siteUpdateValidation(\''.$site_ID.'\',\''.$regionID.'\',this.id);">
        <span class="glyphicon glyphicon-ok" ></span> Valider</button>
        <button type="button" id="annuler-'.$data['ID'].'" 
        onclick="cancelSiteModif(\''.$site_ID.'\',\''.$regionID.'\',this.id,\'validation-'.$data['ID'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
        </td>
    </tr>';
}

echo $message.":".$liste;

































