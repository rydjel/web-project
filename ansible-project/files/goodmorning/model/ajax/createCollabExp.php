<?php
require("../frontend.php");
//$db = dbConnect();
$ggid=$_POST['ggid'];
$debutExp=$_POST['debutExp'];
$finExp=$_POST['finExp'];
$expDetails=$_POST['expDetails'];
$idCollab=getCollabID($ggid);
$idCollab=$idCollab->fetch();
$quote=strpos($expDetails,"\"");

//Vérification que le champ Tâche n'est pas vide
if ($expDetails=="" or $debutExp=="" or $finExp=="" ) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    le champs "Détails", "Date de début" et "Date de Fin" sont <strong>obligatoires</strong>. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif ($finExp!="" and strtotime($finExp)<strtotime($debutExp)) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    la date de début est postérieure à la date de fin! </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (strtotime("now")<strtotime($debutExp)) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    la date de début est postérieure à la date du jour. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (strpos($expDetails,"\"")!==false or strpos($expDetails,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (existsCollabExperience($idCollab['ID'],$debutExp,$finExp,$expDetails)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
    L\'expérience est déjà existante pour le Collaborateur. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
else {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec d\'insertion de l\'expérience. </div>';
    // Création de la tâche
    $idNewExp=insertCollabExperience($idCollab['ID'],$debutExp,$finExp,$expDetails);
    $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes d\'insertion de la nouvelle expérience. </div>';
    //$donnees=array($message,"OK",$idNewExp);
    $result="OK";
}
//echo json_encode($donnees);

$liste='';
$collabExp=getCollabExperiences($idCollab['ID']);
if ($collabExp) {
    while ($data=$collabExp->fetch()) {
        $dateDebutExpID='debutExp-'.$data['ID'];
        $dateFinExpID='finExp-'.$data['ID'];
        $detailsExpID='detailExp-'.$data['ID'];
        $liste.='<tr>
        <td><input type="date" id="'.$dateDebutExpID.'" class="form-control" value="'.$data['Date_Debut'].'" disabled></td>
        <td><input type="date" id="'.$dateFinExpID.'" class="form-control" value="'.$data['Date_Fin'].'" disabled></td>
        <td>
            <textarea class="form-control" rows="3" id="'.$detailsExpID.'" disabled>'.$data['Details'].'</textarea>
        </td>
        <td>
            <button type="button" id="expEdit-'.$data['ID'].'" onclick="allowExpModif(this.id);">
            <span class="glyphicon glyphicon-edit"></span>Editer</button>
            <button type="button" id="expValidation-'.$data['ID'].'" disabled
            onclick="expUpdateValidation(\''.$dateDebutExpID.'\',\''.$dateFinExpID.'\',\''.$detailsExpID.'\',this.id);">
            <span class="glyphicon glyphicon-ok" ></span> Valider</button>
            <button type="button" id="annulerExpModif-'.$data['ID'].'" 
            onclick="cancelExpModif(\''.$dateDebutExpID.'\',\''.$dateFinExpID.'\',\''.$detailsExpID.'\',this.id,\'expValidation-'.$data['ID'].'\');">
            <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button> 
        </td>
    </tr>';
    }
}


echo $message.":".$result.":".$liste;