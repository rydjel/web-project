<?php
require("../frontend.php");
$code=$_POST['code'];
$role=$_POST['role'];
$grade=$_POST['grade'];
$region=$_POST['region'];
$ratecard=$_POST['ratecard'];
$year=$_POST['year'];

$inRegion= array('IDF' =>'0','Région'=>'1');
 
// Insertion en base + Message d'info du retour de requête
if (strpos($code,"\"")!==false or strpos($code,":")!==false or strpos($role,"\"")!==false or strpos($role,":")!==false ) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> 
    <strong>Erreur !<strong> les caractères double-quote et deux-points sont interdits.</div>';
}
elseif ($ratecard<0) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
    data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> la valeur de la RateCard (ADRC) est négative.</div>';
}
elseif (!($year>1900 and $year<2100)) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
    data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> l\'année saisie est invalide.</div>';
}
elseif (existRateCard($code,$role,$grade,$inRegion[$region],$year)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" id="closeMessage" onclick="closeAlert();" class="close" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Code Rate Card déjà existant. </div>';
}
elseif ($code=="" or $role=="" or $ratecard=="" or $year=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
    data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champs Role, code, ADRC et Année sont obligatoires.</div>';
}
else {
    if(createRateCard($code,$role,$grade,$region,$ratecard,$year)) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;
        </button> La Rate Card de code "'.$code.'" a été rajoutée avec <strong>Success!</strong> .</div>';
    }else {
        $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Erreur de création de la nouvelle Rate Card.</div>';
    }
}

$liste='';
$year=date('Y'); // Initialize the current year
$rateCards=getRateCards($year); // Get all current Year rateCards

while ($data=$rateCards->fetch()) {
    //--------- Identifiants
    $regionID="region-".$data['ID'];
    $roleID="role-".$data['ID'];
    $codeID="code-".$data['ID'];
    $gradeID="grade-".$data['ID'];
    $rateCardID="rateCard-".$data['ID'];
    $ctb50ID="ctb50-".$data['ID'];
    $ctb45ID="ctb45-".$data['ID'];
    $ctb40ID="ctb40-".$data['ID'];
    //-------- Contrib
    $ctb50=$data['RateCard']/((100-50)/100);
    $ctb45=$data['RateCard']/((100-45)/100);
    $ctb40=$data['RateCard']/((100-40)/100);
     //-------- Convert to 2 digit float format
     $ctb50=number_format((float)$ctb50, 2, '.', '');
     $ctb45=number_format((float)$ctb45, 2, '.', '');
     $ctb40=number_format((float)$ctb40, 2, '.', '');

    $liste.='<tr>
                <td>
                    <select id="'.$regionID.'" disabled> 
                        <option value="1" ';
    if ($data['Region']=="1") {
        $liste.='selected';
    }
    $liste.='>Région</option><option value ="0" ';
    if ($data['Region']=="0") {
        $liste.='selected';
    }
    $liste.='>IDF</option>
                </select>
            </td>
            <td><input class="inputrole" type="text" value="'.$data['Role'].'" id="'.$roleID.'" disabled></td>
            <td><input class="inputOther" type="text" value="'.$data['Code'].'" id="'.$codeID.'" disabled></td>
            <td>
                <select id="'.$gradeID.'" name="grade" disabled>
                    <option value="A" ';
    if ($data['Grade']=='A') {
        $liste.='selected';
    }
    $liste.='>A</option>
    <option value="B" ';
    if ($data['Grade']=='B') {
        $liste.='selected';
    }
    $liste.='>B</option>
    <option value="C" ';
    if ($data['Grade']=='C') {
        $liste.='selected';
    }
    $liste.='>C</option>
    <option value="D" ';
    if ($data['Grade']=='D') {
        $liste.='selected';
    }
    $liste.='>D</option>
    <option value="E" ';
    if ($data['Grade']=='E') {
        $liste.='selected';
    }
    $liste.='>E</option>
    <option value="F" ';
    if ($data['Grade']=='F') {
        $liste.='selected';
    }
    $liste.='>F</option>
    </select>
        </td>
        <td><input class="inputOther" type="number" value="'.$data['RateCard'].'" id="'.$rateCardID.'" 
            onchange="ctbvalues(this.value,\''.$ctb50ID.'\',\''.$ctb45ID.'\',\''.$ctb40ID.'\');" disabled ></td>
        <td><input class="inputOther" type="text" value="'.$ctb50.'" id="'.$ctb50ID.'" disabled></td>
        <td><input class="inputOther" type="text" value="'.$ctb45.'" id="'.$ctb45ID.'" disabled></td>
        <td><input class="inputOther" type="text" value="'.$ctb40.'" id="'.$ctb40ID.'" disabled></td>
        <td>
            <button type="button" id="edit-'.$data['ID'].'" onclick="allowRCModif(this.id);">
            <span class="glyphicon glyphicon-edit" ></span> Editer</button>
            <button type="button" id="validation-'.$data['ID'].'" disabled
            onclick="RCUpdateValidation(\''.$regionID.'\',\''.$roleID.'\',\''.$codeID.'\',
            \''.$gradeID.'\',\''.$rateCardID.'\',this.id,\'select\');">
            <span class="glyphicon glyphicon-ok"></span> Valider</button>
            <button type="button" id="annuler-'.$data['ID'].'" 
            onclick="cancelRCModif(\''.$regionID.'\',\''.$roleID.'\',\''.$codeID.'\',
            \''.$gradeID.'\',\''.$rateCardID.'\',this.id,\'validation-'.$data['ID'].'\',
            \''.$ctb50ID.'\',\''.$ctb45ID.'\',\''.$ctb40ID.'\');">
            <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
        </td>
    </tr>';
}

echo $message.":".$liste.":".$year;



































