<?php
require("../frontend.php");
//$db = dbConnect();
$ggid=$_POST['ggid'];
$title=$_POST['title'];
$idCollab=getCollabID($ggid);
$idCollab=$idCollab->fetch();
$quote=strpos($title,"\"");


//Vérification que le champ Tâche n'est pas vide
if ($title=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    le champs "Titre" est <strong>obligatoire<strong>. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (strpos($title,"\"")!==false or strpos($title,":")!==false ) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits.</div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (existsCollabCertifBefCreation($idCollab['ID'],$title)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
    La certification est déjà existante pour le Collaborateur. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
else {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de création de la certification. </div>';
    // Création de la tâche
    $idNewCertif=insertCollabCertif($idCollab['ID'],$title);
    $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de création de la certification. </div>';
    //$donnees=array($message,"OK",$idNewCertif);
    $result="OK";
}

//echo json_encode($donnees);


$collabCertif=getCollabCertifications($idCollab['ID']); // Access to all the collab certifications
$liste='';
if ($collabCertif) {
    while ($data=$collabCertif->fetch()) {
        $certifTitleID='certifTitle-'.$data['ID'];
        $liste.='<tr>
        <td>
            <input type="text" id="'.$certifTitleID.'" class="form-control" value="'.$data['Titre'].'" disabled>
        </td>
        <td>
            <button type="button" id="certifEdit-'.$data['ID'].'" onclick="allowCertifModif(this.id);">
            <span class="glyphicon glyphicon-edit" ></span> Editer</button>
            <button type="button" id="certifValidation-'.$data['ID'].'" disabled
            onclick="certifUpdateValidation(\''.$certifTitleID.'\',this.id);">
            <span class="glyphicon glyphicon-ok" ></span> Valider</button>
            <button type="button" id="annulerCertifModif-'.$data['ID'].'"
            onclick="cancelCertifModif(\''.$certifTitleID.'\',this.id,\'certifValidation-'.$data['ID'].'\');">
            <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button>  
        </td>
    </tr>';
    }
}



echo $message.":".$result.":".$liste;