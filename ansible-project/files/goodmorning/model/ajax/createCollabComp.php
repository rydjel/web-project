<?php
require("../frontend.php");
//$db = dbConnect();
$ggid=$_POST['ggid'];
$title=$_POST['title'];
$level=$_POST['level'];
$idCollab=getCollabID($ggid);
$idCollab=$idCollab->fetch();
$pos=strpos($title,"\"");

//Vérification que le champ Tâche n'est pas vide
if ($title=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    le champs "Titre" est <strong>obligatoire<strong>. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (strpos($title,"\"") !==false or strpos($title,":") !==false ) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits.</div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (existsCollabCompBefCreation($idCollab['ID'],$title)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
    La compétence est déjà existante pour le Collaborateur. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
else {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de création de la compétence. </div>';
    // Création de la compétence
    $idNewComp=insertCollabCompetence($idCollab['ID'],$title,$level);
    $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de création de la compétence. </div>';
    //$donnees=array($message,"OK",$idNewComp);
    $result="OK";
}
//echo json_encode($donnees);

$liste='';
$collabComp=getCollabCompetences($idCollab['ID']); // get List of collab competences

while ($data=$collabComp->fetch()) {
    $compTitleID='compTitle-'.$data['ID'];
    $compLevelID='compLevel-'.$data['ID'];

    $liste.='<tr>
    <td><input type="text" id="'.$compTitleID.'" class="form-control" value="'.$data['Titre'].'" disabled></td>
    <td>
        <select id="'.$compLevelID.'" class="form-control" disabled>
            <option value="Académique" ';
            if ($data['Niveau']=="Académique") {
                $liste.='selected';
            }
            $liste.='>Académique</option>
            <option value="Confirmé" ';
            if ($data['Niveau']=="Confirmé") {
                $liste.='selected';
            }
            $liste.='>Confirmé</option>
            <option value="Expert" ';
            if ($data['Niveau']=="Expert") {
                $liste.='selected';
            }
            $liste.='>Expert</option>
            <option value="Guru" ';
            if ($data['Niveau']=="Guru") {
                $liste.='selected';
            }
            $liste.='>Guru</option></select>
            </td>
            <td>
                <button type="button" id="compEdit-'.$data['ID'].'" onclick="allowCompModif(this.id);">
                <span class="glyphicon glyphicon-edit" ></span> Editer</button>
                <button type="button" id="compValidation-'.$data['ID'].'" disabled
                onclick="compUpdateValidation(\''.$compTitleID.'\',\''.$compLevelID.'\',this.id);">
                <span class="glyphicon glyphicon-ok" ></span> Valider</button>
                <button type="button" id="annulerCompModif-'.$data['ID'].'" 
                onclick="cancelCompModif(\''.$compTitleID.'\',\''.$compLevelID.'\',this.id,\'compValidation-'.$data['ID'].'\');">
                <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
            </td>
        </tr>';


}

echo $message.":".$result.":".$liste;