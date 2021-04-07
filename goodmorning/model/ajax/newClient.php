<?php
require("../frontend.php");
$client=$_POST['client'];
$marketUnit=$_POST['marketUnit'];
 
// Insertion en base + Message d'info du retour de requête
if (strpos($client,"\"")!==false or strpos($client,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
    data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits</div>';
}
elseif (existClient($client)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Client déjà existant. </div>';
}elseif ($client=="" or $marketUnit=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champ "Client" et "Market Unit" sont obligatoires.</div>';
}
elseif (!createClient($client,$marketUnit)) {
    $message='<div class="alert   alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur</strong> de rajout du client.</div>';
}
else{
    $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Client rajouté avec <strong>Success!</strong> .</div>';
}


$listMU=getMarketUnits(); // List Market Units
$MUnits=array();
while ($data=$listMU->fetch()) {
    $MUnits[]=array('Nom'=>$data['Nom']);
}
$clientsRows=getClientRowsFields(); //get all clients Rows


$liste='';

while ($data=$clientsRows->fetch()) {
    $clientfieldID="testCli-".$data['ID'];
    $marketUnitID="marketUnit-".$data['ID'];
    $liste.='<tr>
    <td>
        <input type="text" class="form-control" value="'.$data['NomClient'].'"
        id="'.$clientfieldID.'" disabled>
    </td>
    <td>
        <select id="'.$marketUnitID.'" class="form-control" disabled>';
            foreach($MUnits as $k)
            {
                $liste.='<option value="'.$k['Nom'].'"';
                if ($k['Nom']==$data['nomMU']) {
                    $liste.='selected';
                }
                $liste.='> '.$k['Nom'].' </option>';
            }
    $liste.='
        </select>
    </td>
    <td>
        <button type="button" id="edit-'.$data['ID'].'" onclick="allowClientModif(this.id);">
        <span class="glyphicon glyphicon-edit" ></span> Editer</button>
        <button type="button" id="validation-'.$data['ID'].'" disabled
        onclick="clientUpdateValidation(\''.$clientfieldID.'\',\''.$marketUnitID.'\',this.id);">
        <span class="glyphicon glyphicon-ok" ></span> Valider</button>
        <button type="button" id="annuler-'.$data['ID'].'"
        onclick="cancelClientModif(\''.$clientfieldID.'\',\''.$marketUnitID.'\',this.id,
        \'validation-'.$data['ID'].'\');">
        <span class="glyphicon glyphicon-refresh" ></span> Rafraichir/Annuler</button> 
    </td>
</tr>';
}

echo $message.":".$liste;



































