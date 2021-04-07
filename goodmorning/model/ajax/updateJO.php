<?php
require("../frontend.php");
$db = dbConnect();
$jo=$_POST['JO'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
$message='';
if ($jo=="") {
    $message.='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Le champ "Jours Ouvrables" est vide.</div>';
    $result="KO";
}
elseif (!is_numeric($jo) or $jo < 0) {
    $message.='<div class="alert   alert-danger alert-dismissable"> 
    <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Le champ "Jours Ouvrables" doit être un nombre positif ou nul.</div>';
    $result="KO";
}
elseif (!checkJOFieldUpdated('NbJours',$jo,$id)) {
    $message.='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Auncune modification effectuée. </div>';
    $result="OK";
}
elseif (checkJOFieldUpdated('NbJours',$jo,$id) and !updateJO('NbJours',$jo,$id)) {
    $message.='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Echec de mise à jour. </div>';
    $result="KO";
}
else{
    $message.='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Succès</strong> de la mise à jour. </div>';
    $result="OK";
}
echo $result.":".$message;

