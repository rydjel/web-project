<?php
require("../frontend.php");
$collab=$_POST['collab'];
$message='';
// Insertion en base + Message d'info du retour de requête
if ($collab=="") {
    $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>
     <strong>Erreur !<strong> Champ Collaborateur ne doit pas être vide.</div>';
}
else {
    if(createManager($collab)) {
        $message.='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button> Manager rajouté avec <strong>Success!</strong>.</div>';
    }else {
        $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button> Erreur de création du nouveau Manager.</div>';
    }
}

$managingTeam=getManagers(); // Access to the list of Managers
$liste='';
while ($data=$managingTeam->fetch()) {
    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['nomPU'].'" disabled>
    </td>
    <td>
        <input type="text" class="form-control" value="'.$data['nomSite'].'" disabled>
    </td>
    <td>
        <input type="text" class="form-control" value="'.$data['GGID'].'" disabled>
    </td>
    <td>
        <input type="text" class="form-control" value="'.$data['Nom'].'" disabled>
    </td>
    <td>
        <input type="text" class="form-control" value="'.$data['Prénom'].'" disabled>
    </td>
    <td>
        <button type="button" id="delete-'.$data['idCollab'].'" onclick="deleteManagerPermission(this.id,\'deleteManagerModal\');">
        <span class="glyphicon glyphicon-remove" ></span> Supprimer</button>
    </td>
</tr>';
}


echo $message.":".$liste;



































