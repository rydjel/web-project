<?php
require("../frontend.php");
$idkpiType=$_POST['idkpiType'];
$idMonth=$_POST['idMonth'];
$budget=$_POST['budget'];
$forecast=$_POST['forecast'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($budget,"\"")!==false or strpos($budget,":")!==false or strpos($forecast,"\"")!==false or strpos($forecast,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
    data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits</div>';
}
elseif (existPnlKpi($idkpiType,$idMonth)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;
    </button> <strong>Warning!</strong> Kpi déjà existant. </div>';
}elseif ($idkpiType=="" or $idMonth=="" or $budget=="" or $forecast=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
    </button> <strong>Erreur !<strong> Tous les champs sont obligatoires.</div>';
}
elseif (!createPnlKpi($idkpiType,$idMonth,$budget,$forecast)) {
    $message='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
    </button> <strong>Erreur</strong> de rajout du KPI.</div>';
}
else{
    $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
    </button> KPI rajouté avec <strong>Succès!</strong> .</div>';
}


$kpiList=getPnlKPI();
$kpiTypesList=getPnlKPIType();

$kpiTypes=array();
while ($data=$kpiTypesList->fetch()) {
    $kpiTypes[$data['id_pnlkpitype']]=$data['type'];
}

$monthList=getMonths();
$months=array();
while ($data=$monthList->fetch()) {
    $months[$data['ID']]=$data['nom_mois'];
}


$liste='';

while ($data=$kpiList->fetch()) {
    $kpiTypeID="kpi-".$data['id_pnlkpi'];
    $monthID="month-".$data['id_pnlkpi'];
    $budgetID="budget-".$data['id_pnlkpi'];
    $forecastID="forecast-".$data['id_pnlkpi'];

    $liste.='<tr>
    <td>
        <select id="'.$kpiTypeID.'" class="form-control" disabled>';
            foreach($kpiTypes as $key => $value)
            {
                $liste.='<option value='.$key.'';
                if ($key==$data['id_pnlkpitype']) {
                    $liste.=' selected';
                }
                $liste.='> '.$value.' </option>';
            }
    $liste.='
        </select>
    </td>';
    $liste.='
    <td>
        <select id="'.$monthID.'" class="form-control" disabled>';
            foreach($months as $key => $value)
            {
                $liste.='<option value='.$key.'';
                if ($key==$data['id_mois']) {
                    $liste.=' selected';
                }
                $liste.='> '.$value.' </option>';
            }
    $liste.='
        </select>
    </td>
    <td>
        <input type="number" min="0" step="any" class="form-control" value="'.$data['budget'].'" id="'.$budgetID.'" disabled>
    </td>
    <td>
        <input type="number" min="0" step="any" class="form-control" value="'.$data['forecast'].'" id="'.$forecastID.'" disabled>
    </td>
    <td>
        <button type="button" id="edit-'.$data['id_pnlkpi'].'" onclick="allowPnlKpiModif(this.id);">
        <span class="glyphicon glyphicon-edit" ></span> Editer</button>
        <button type="button" id="validation-'.$data['id_pnlkpi'].'" disabled
        onclick="pnlKpiUpdateValidation(\''.$kpiTypeID.'\',\''.$monthID.'\',\''.$budgetID.'\',\''.$forecastID.'\',this.id);">
        <span class="glyphicon glyphicon-ok" ></span> Valider</button>
        <button type="button" id="annuler-'.$data['id_pnlkpi'].'"
        onclick="cancelPnlKpiModif(\''.$kpiTypeID.'\',\''.$monthID.'\',\''.$budgetID.'\',\''.$forecastID.'\',this.id,
        \'validation-'.$data['id_pnlkpi'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
    </td>
</tr>';
}

echo $message.":".$liste;



































