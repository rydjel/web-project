<?php
require("../frontend.php");
//$db = dbConnect();
$taskName=$_POST['taskName'];
$typeActivity=$_POST['typeActivity'];
$tace=$_POST['tace'];
$idProj=getProjectIDbyCode($_POST['codeProjet']);
$idProj=$idProj->fetch();
if ($_POST['facturable']=='true') {
    $facturable=1;
}else {
    $facturable=0;
}
$codeGen=$_POST['codeGen'];
$yearGen=$_POST['yearGen'];

//Vérifier le type de PU en accédant à la valeur de son MU (0 ou 1)
$projectPUMUVal=getProjPUMUValue($idProj['ID']);
$projectPUMUVal=$projectPUMUVal->fetch();

//Vérification que le champ Tâche n'est pas vide
if ($taskName=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    le champs "Tâche" est <strong>obligatoire<strong>. </div>';
    //$donnees=array($message,"KO");
    $result="KO";
}
elseif (strpos($taskName,"\"")!==false or strpos($taskName,":")!==false) {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    Les champs ne supportent pas les double-quote et deux-points. </div>';
    $result="KO";
}
elseif (existTask($idProj['ID'],$taskName)) {
    $message='<div class="alert  alert-warning alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Warning!</strong> 
    La tâche est déjà existante pour le projet en cours. </div>';
    $result="KO";
    //$donnees=array($message,"KO");
}
elseif ($codeGen==1 and $yearGen=="") {
    $message='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> <strong>Erreur!</strong> 
    La création d\'une nouvelle tâche d\'un projet avec code générique impose le choix de l\'année ! </div>';
    $result="KO";
}
else {
    $message1='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de création de l\'activité. </div>';
    //$message2='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Echec de création de la tâche. </div>';
    //Création de l'activité
    //$idActivity=getActivityTypeID($typeActivity,$tace,$facturable);
    //$idActivity=$idActivity->fetch();
    //$message1='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Succès de création de l\'activité. </div>';
    // Création de la tâche
    $idActivity=$typeActivity;// 
    $idNewTask=newTask($idProj['ID'],$taskName,$idActivity);
    $message1='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> succes de création de la tâche. </div>';
    // Imputations en cas de projet Interne pour  l'année en cours
    if ($codeGen==1) {
        $message2='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Erreur de création des imputations. </div>';
        $message3='<div class="alert  alert-danger alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Erreur de création des affectations. </div>';
        // Vérification si MU=1
        if ($projectPUMUVal['MU']==1) {
            $listeCollabs=getCollabs();
            if ($listeCollabs) { // Check if request returns elements
                while ($data=$listeCollabs->fetch()) { // Pars all collabs
                    $db=dbConnect();
                    $year=$yearGen;
                       for ($i=1; $i <=12 ; $i++) { // Imputation Annuelle 
                        insertMonthlyAffectation($db,$year,$i,$data['ID'],$idNewTask,0,0);
                     }
                    // Affectation Step
                    if ($facturable==0) {
                        $tjmValue=0;
                    }
                    else {
                        $RCVal=getCollabRCValue($data['ID']);
                        $RCVal=$RCVal->fetch();
                        $tjmValue=$RCVal['RateCard']/((100-40)/100);
                        $tjmValue=number_format((float)$tjmValue, 2, '.', '');

                    }
                    insertTJM($data['ID'],$idNewTask,$year,1,$year,12,$tjmValue,0,0,0,0,0,0,0,'SO',0,'SO',1,'named'); 
                }
            }
        }
        else {
                $listeCollabs=getProjPUCollabList($idProj['ID']);
                if ($listeCollabs) { // Check if request returns elements
                    while ($data=$listeCollabs->fetch()) { // Pars all collabs
                        $db=dbConnect();
                        $year=$yearGen;
                        for ($i=1; $i <=12 ; $i++) { // Imputation Annuelle 
                            insertMonthlyAffectation($db,$year,$i,$data['ID'],$idNewTask,0,0);
                        }
                        // Affectation Step
                        if ($facturable==0) {
                            $tjmValue=0;
                        }
                        else {
                            $RCVal=getCollabRCValue($data['ID']);
                            $RCVal=$RCVal->fetch();
                            $tjmValue=$RCVal['RateCard']/((100-40)/100);
                            $tjmValue=number_format((float)$tjmValue, 2, '.', '');

                        }   
                        insertTJM($data['ID'],$idNewTask,$year,1,$year,12,$tjmValue,0,0,0,0,0,0,0,'SO',0,'SO',1,'named');
                    }
                }
        }
/*         $listeCollabs=getCollabs();
        if ($listeCollabs) { // Check if request returns elements
            while ($data=$listeCollabs->fetch()) { // Pars all collabs
                $db=dbConnect();

                for ($year=date('Y'); $year<=date('Y')+5 ; $year++) {  // 5 prochaines années

                   for ($i=1; $i <=12 ; $i++) { 
                    insertMonthlyAffectation($db,$year,$i,$data['ID'],$idNewTask,0,0);
                   }

                }

            }
        } */
        $message2='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Succès de création  des imputations. </div>'; 
        $message3='<div class="alert  alert-success alert-dismissable" > <button type="button" class="close" id="closeMessage" onclick="closeAlert();" data-dismiss="alert">&times;</button> Succès de création des affectations. </div>';
    }
    else {
        $message2="";
        $message3="";
    }

    $message=$message1.$message2.$message3;
    //$donnees=array($message,"OK",$idNewTask,$idActivity['ID']);
    $result="OK";
}
//echo json_encode($donnees);

$taskList=projectTaskList($idProj['ID']); // Liste des taches
$listActivityTypes=getActivityTypes(); //get the list of activities types
$arrayAT=array();
while ($data=$listActivityTypes->fetch()) {
    $arrayAT[$data['ID']]=$data['Nom_typeActivite'];
}
$liste='';

while ($data=$taskList->fetch()) {
    $id1="task-".$data['taskID'];
    $id2="activity-".$data['taskID'];
    $id3="TACE-".$data['taskID'];
    $id4="Fact-".$data['taskID'];

    $liste.='<tr>
    <td><input type="text" class="form-control" value="'.$data['Nom_Tache'].'" id="task-'.$data['taskID'].'" disabled ></td>
    <td>
        <select id="'.$id2.'" class="form-control" name="typeActivite" onchange="getTACEandFact(this.id,\''.$id3.'\',\''.$id4.'\');" disabled>';
    foreach ($arrayAT as $key => $value) {
        $liste.='<option value="'.$key.'" ';
        if ($key==$data['typeActivityID']) {
            $liste.='selected';
        }
        $liste.='>
        '.$value.'</option>';
    }
    $liste.='</select>
    </td>
    <td><input type="text"  class="form-control" value="'.$data['Impact_TACE'].'" id="TACE-'.$data['taskID'].'" disabled></td>
    <td><input type="checkbox" class="form-control" ';
    if ($data['Facturable']==1) {
        $liste.='checked ';
    }
    $liste.='
    id="Fact-'.$data['taskID'].'" disabled></td>
    <td>
    <button type="button" id="edit-'.$data['taskID'].'" onclick="allowTaskModif(this.id,\''.$id1.'\');">
    <span class="glyphicon glyphicon-edit" ></span> Editer</button>
    <button type="button" id="validation-'.$data['taskID'].'" disabled
     onclick="taskUpdateValidation(\''.$id1.'\',\''.$id2.'\',\''.$id3.'\',\''.$id4.'\',this.id);">
    <span class="glyphicon glyphicon-ok"></span>Valider</button>
    <button type="button" id="annulation-'.$data['taskID'].'" disabled
     onclick="cancelTaskModif(\''.$id1.'\',\''.$id2.'\',\''.$id3.'\',\''.$id4.'\',this.id,\'validation-'.$data['taskID'].'\');">
    <span class="glyphicon glyphicon-refresh"></span> Rafraichir/Annuler</button> 
    </td>
</tr>';
    
}

echo $message.":".$result.":".$liste;