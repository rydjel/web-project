<?php
require("../frontend.php");
$db = dbConnect();
$task=$_POST['task'];
$at=$_POST['activityT'];
$idExtend=explode("-",$_POST['idExtend']);
$id=$idExtend[1];
if (strpos($task,"\"")!==false or strpos($task,":")!==false) {
    $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" 
    data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Caractères double-quote et deux-points sont interdits</div>';
    $result="KO";
}
elseif ($task=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <a href="#" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</a> Le champ Tache est vide.</div>';
    $result="KO";
}
elseif (!checkDTFieldUpdated('nomTache',$task,$id) and !checkDTFieldUpdated('ID_TypeActivite',$at,$id)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Auncune modification effectuée. </div>';
    $result="OK";
}
elseif (checkDTFieldUpdated('nomTache',$task,$id) and existDT($task)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Tâche déjà existant. </div>';
    $result="KO";
}
else {
    if (checkDTFieldUpdated('nomTache',$task,$id) and updateDT('nomTache',$task,$id) ) {
        $maj=true;
    }
    if (checkDTFieldUpdated('ID_TypeActivite',$at,$id) and updateDT('ID_TypeActivite',$at,$id) ) {
        $maj=true;
    }
    if ($maj) {
        $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
        $result="OK";
    }
}
echo $result.":".$message;