<?php
require("../frontend.php");
//$db = dbConnect();
$details=$_POST['details'];
$idCollab=$_POST['idCollab'];
$idPT=$_POST['idPT'];



//Vérification que le champ Tâche n'est pas vide
if ($details=="" or $idPT=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Tous les champs sont <strong>obligatoires<strong>. </div>';
    $success="KO";
}
elseif (strpos($details,"\"")!==false or strpos($details,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
    $success="KO";
}
elseif (!createProfil($idCollab,$details,$idPT)) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Echec</strong> 
    lors du rajout du profil. </div>';
    $success="KO";
}
else{
    $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Succes</strong> 
    de rajout du nouveau profil. </div>';
    $success="OK";
}

$profil=getprofil($idCollab); // Access to the collab's profil
$PTList=getProfilTitles(); // get the list of Profile Titles
$newProf='';

$data=$profil->fetch();
if ($data==true) {
    $profilDetailID="profilDetail-".$data['ID'];
    $profilTitleID="profilTitle-".$data['ID'];
    $newProf.='<div class="row">
                    <div class="col-sm-7">
                        <label for="'.$profilTitleID.'">Titre</label>
                        <select id="'.$profilTitleID.'" class="form-control col-sm-7" name="PTChoice" disabled>';
    while ($data2=$PTList->fetch()) {
        $newProf.='<option value="'.$data2['ID'].'"';
        if ($data2['ID']==$data['ID_PT']) {
            $newProf.=' selected';
        }
    $newProf.='>'.$data2['intitule'].'</option>';
    }
    $newProf.='</select></div></div>
    <div class="row">
        <div class="col-sm-7">
            <label for="'.$profilDetailID.'">Profil</label>';

    $newProf.='<textarea class="form-control" rows="2" title="Profil" id="'.$profilDetailID.'" disabled>'.$data['détails'].'</textarea>
            <br>
            <button type="button" id="profilEdit" onclick="allowProfilModif(\''.$profilDetailID.'\',\''.$profilTitleID.'\',\'profilValidation-'.$data['ID'].'\');">
            <span class="glyphicon glyphicon-edit" ></span> Editer</button>
            <button type="button" id="profilValidation-'.$data['ID'].'" disabled
            onclick="profilUpdateValidation(\''.$profilDetailID.'\',this.id,\''.$profilTitleID.'\');">
            <span class="glyphicon glyphicon-ok" ></span> Valider</button>
            <button type="button" id="annulerProfilModif-'.$data['ID'].'" 
            onclick="cancelProfilModif(\''.$profilDetailID.'\',this.id,\'profilValidation-'.$data['ID'].'\',\''.$profilTitleID.'\');">
            <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
        </div>
    </div>';
}

echo ($message.":".$success.":".$newProf);

