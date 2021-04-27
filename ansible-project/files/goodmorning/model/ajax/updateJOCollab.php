<?php
require("../frontend.php");
$db = dbConnect();
$joCollab=$_POST['JOCollab'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (!is_numeric($joCollab) or $joCollab < 0) {
    $message='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Les jours ouvrables doivent être positifs ou nuls.</div>';
}
elseif ($joCollab=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Le champ "Jours Ouvrables Collab" est vide.</div>';
}
elseif (!checkJOCollabFieldUpdated('NbJours',$joCollab,$id)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Auncune modification effectuée sur les Jours Ouvrables Collab. </div>';
}
elseif (checkJOCollabFieldUpdated('NbJours',$joCollab,$id) and !updateJOCollab('NbJours',$joCollab,$id)) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Echec de mise à jour JO Collab. </div>';
}
else{
    $message='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Succès</strong> de la mise à jour JO Collab. </div>';
}
echo $message;

