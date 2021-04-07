<?php
require("../frontend.php");
$manager=$_POST['manager'];
 
// Insertion en base + Message d'info du retour de requête
if (deleteManager($manager)) {
    $message='<div class="alert   alert-success alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>
     Succès de suppression de la liste des managers.</div>';
     $listTeamCollab=getManagerCollabList($manager); // liste des collabs dont il est le CM
     if ($listTeamCollab) {
         while ($data=$listTeamCollab->fetch()) {
            if (updateCollab('ID_Manager',"",$data['ID'])) {
                $message.='<div class="alert   alert-success alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>
                Le collaborateur '.$data['Nom'].' '.$data['Prénom'].' ne possède plus de Manager.</div>';
            }
            else {
                $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>
                Le collaborateur '.$data['Nom'].' '.$data['Prénom'].' possède un  Manager qui ne l\'est plus! . </div>';
            } 
         }
     }
}
else {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
    </button> Erreur de suppression de la liste des managers.</div>';

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



































