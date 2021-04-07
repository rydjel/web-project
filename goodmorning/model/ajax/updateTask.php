<?php
require("../frontend.php");
$db = dbConnect();
$taskName=$_POST['taskName'];
$typeActivity=$_POST['typeActivity'];
$tace=$_POST['tace'];
if ($_POST['facturable']=='true') {
    $facturable=1;
}else {
    $facturable=0;
}
$idtaskExtend=explode("-",$_POST['idtaskExtend']);
$idTask=$idtaskExtend[1];
$idActivityExtend=explode("-",$_POST['idActivityExtend']);
$idActivity=$idActivityExtend[1];

if ($taskName=="" or $typeActivity=="" or $tace=="") {
    $message='<div class="alert   alert-danger alert-dismissable"> <<button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> <strong>Erreur !<strong> Champs Tâche, type-Activité et impact-TACE ne doivent pas être vides.</div>';
    $result="KO";
}
elseif (strpos($taskName,"\"")!==false or strpos($typeActivity,"\"")!==false or strpos($tace,"\"")!==false
        or strpos($taskName,":")!==false or strpos($typeActivity,":")!==false or strpos($tace,":")!==false ) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les champs ne supportent pas les double-quote et deux-points. </div>';
    $result="KO";
}
elseif (checkTaskFieldUpdated('Nom_Tache',$taskName,$idTask) and existTask($idTask,$taskName)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> Tâche déjà existante. </div>';
    $result="KO";
}
else { 
       $nbSuccess=0;
       $nbFailure=0;
        // Check if the Task Name has been updated
        /* if (checkTaskFieldUpdated('Nom_Tache',$taskName,$idTask) and updateTask('Nom_Tache',$taskName,$idTask)) {
            $nbSuccess+=1;
        }
        elseif (checkTaskFieldUpdated('Nom_Tache',$taskName,$idTask) and !updateTask('Nom_Tache',$taskName,$idTask)) {
            $nbFailure+=1;
        } */
        $fieldsArray = array('Nom_Tache' =>$taskName,'ID_TypeActivite' =>$typeActivity);
        foreach ($fieldsArray as $key => $value) {
            if (checkTaskFieldUpdated($key,$value,$idTask) and updateTask($key,$value,$idTask)) {
                $nbSuccess+=1;
            }
            elseif (checkTaskFieldUpdated($key,$value,$idTask) and !updateTask($key,$value,$idTask)) {
                $nbFailure+=1;
            }
        } 
        if ($nbFailure==0 and $nbSuccess!=0 ) {
            $message='<div class="alert   alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Mise(s) à jour effectuée(s) avec <strong>Success!</strong> .</div>';
            $result="OK";
        }
        elseif ($nbFailure!=0 ) {
            $message='<div class="alert   alert-danger alert-dismissable"> <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button>'.$nbFailure.' Erreur(s) de Mise à jour !</div>';
            $result="KO";
        }elseif ($nbFailure==0 and $nbSuccess==0) {
            $message='<div class="alert   alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert" aria-label="close">&times;</button> Aucune Mise à jour effectuée .</div>';
            $result="OK";
        }
}   
echo $result.":".$message;