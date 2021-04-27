<?php
require("../frontend.php");
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($nom,"\"")!==false or strpos($nom,":")!==false or strpos($prenom,"\"")!==false or strpos($prenom,":")!==false ) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif ($nom=="" or $prenom=="" ) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>
     <strong>Erreur !<strong> Champs Nom et Prénom ne doivent pas être vides.</div>';
}
elseif (existSupport($nom,$prenom)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
    <strong>Warning!</strong> Support déjà existant. </div>';
}
else {
    if(createSupport($nom,$prenom)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button> Support rajouté avec <strong>Success!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button> Erreur de création du nouveau Support.</div>';
    }
}

$supportTeam=getSupports(); // Access to the new list of supports

$liste='';
while ($data=$supportTeam->fetch()) {

    $nomSupport_ID="nomSupport-".$data['ID'];
    $prenomSupport_ID="prenomSupport-".$data['ID'];
    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['nom'].'";
        id="'.$nomSupport_ID.'" disabled>
    </td>
    <td>
        <input type="text" class="form-control" value="'.$data['prenom'].'"
        id="'.$prenomSupport_ID.'" disabled>
    </td>
    <td>
        <button type="button" id="edit-'.$data['ID'].'" onclick="allowSupportModif(this.id);">
        <span class="glyphicon glyphicon-edit"></span> Editer</button>
        <button type="button" id="validation-'.$data['ID'].'" disabled
        onclick="supportUpdateValidation(\''.$nomSupport_ID.'\',\''.$prenomSupport_ID.'\',this.id);">
        <span class="glyphicon glyphicon-ok" ></span> Valider</button>
        <button type="button" id="annuler-'.$data['ID'].'" 
        onclick="cancelSupportModif(\''.$nomSupport_ID.'\',\''.$prenomSupport_ID.'\',this.id,\'validation-'.$data['ID'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
    </td>
</tr>';
}

echo $message.":".$liste;


////// Notes --> Enlever le point-virgule à la ligne 39 et tester.
































