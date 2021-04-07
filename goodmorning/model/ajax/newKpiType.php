<?php
require("../frontend.php");
$kpiType=$_POST['kpiType'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($kpiType,"\"")!==false or strpos($kpiType,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif (existPnlKPIType($kpiType)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> 
    <strong>Warning!</strong> Type de KPI déjà existant. </div>';
}
elseif ($kpiType=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> Champ vide.</div>';
}
else {
    if(createPnlKPIType($kpiType)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Type de KPI rajouté avec <strong>Succès!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création du nouveau type de KPI.</div>';
    }
}


$kpiTypesList=getPnlKPIType(); // Access to the list of all kpi types

$liste='';

while ($data=$kpiTypesList->fetch()) {
    $kpiType_ID="kpiType-".$data['id_pnlkpitype'];
    
    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['type'].'"
        id="'.$kpiType_ID.'" disabled>
    </td>
    <td>
        <button type="button" id="edit-'.$data['id_pnlkpitype'].'" onclick="allowKpiTypeModif(this.id);">
        <span class="glyphicon glyphicon-edit"></span> Editer</button>
        <button type="button" id="validation-'.$data['id_pnlkpitype'].'" disabled
        onclick="kpiTypeUpdateValidation(\''.$kpiType_ID.'\',this.id);">
        <span class="glyphicon glyphicon-ok"></span> Valider</button>
        <button type="button" id="annuler-'.$data['id_pnlkpitype'].'" 
        onclick="cancelKpiTypeModif(\''.$kpiType_ID.'\',this.id,\'validation-'.$data['id_pnlkpitype'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
    </td>
    </tr>';
}



echo $message.":".$liste;


////// Notes --> Enlever le point-virgule à la ligne 39 et tester.
































